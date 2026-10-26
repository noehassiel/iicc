import { gsap } from "gsap";
import { SplitText } from "gsap/SplitText";

gsap.registerPlugin(SplitText);

export function testimonial05(scope = document) {
  const motion = {
    autoplayMs: 4000,
    travel: 110,
    hiddenAvatarScale: 0.72,
    ease: {
      progressFill: "none",
      out: "expo.out",
      in: "expo.out",
    },
    quote: {
      outDuration: 1.5,
      inDuration: 1.5,
      inDelay: 0.3,
      stagger: 0.055,
    },
    person: {
      outDuration: 1.3,
      inDuration: 1.3,
      stagger: 0.06,
      outDelay: 0,
      inDelay: 0.3,
    },
    avatar: {
      outDuration: 1.3,
      inDuration: 1.3,
      outDelay: 0,
      inDelay: 0.3,
    },
    progress: {
      outDuration: 0.52,
      restartDelay: 0.53,
    },
    unlockBeforeEnd: 0.7,
  };

  const roots = scope.querySelectorAll("[data-testimonials]");

  roots.forEach((root) => {
    root.testimonialCleanup?.();

    const slides = [...root.querySelectorAll("[data-slide]")];
    const previousButton = root.querySelector("[data-previous]");
    const nextButton = root.querySelector("[data-next]");
    const progress = root.querySelector("[data-progress]");

    if (slides.length < 2 || !previousButton || !nextButton || !progress) {
      return;
    }

    const autoplay = Number(root.dataset.autoplay) || motion.autoplayMs;
    const controller = new AbortController();

    let activeIndex = 0;
    let progressTween;
    let transition;
    let splitSlides = [];
    let destroyed = false;

    const normalizeIndex = (index) => (index + slides.length) % slides.length;

    const profileLines = (slideData) =>
      slideData.person.flatMap((split) => split.lines);

    const updateAccessibility = () => {
      slides.forEach((slide, index) => {
        slide.setAttribute("aria-hidden", String(index !== activeIndex));
      });
    };

    const startProgress = () => {
      progressTween?.kill();
      gsap.set(progress, { scaleX: 0, autoAlpha: 1 });

      progressTween = gsap.to(progress, {
        scaleX: 1,
        duration: autoplay / 1000,
        ease: motion.ease.progressFill,
        onComplete: () => requestMove(1),
      });
    };

    const goTo = (requestedIndex) => {
      if (!splitSlides.length) return;

      const nextIndex = normalizeIndex(requestedIndex);
      if (nextIndex === activeIndex) return;

      progressTween?.kill();

      const outgoingIndex = activeIndex;
      const outgoing = splitSlides[outgoingIndex];
      const incoming = splitSlides[nextIndex];
      const outgoingSlide = slides[outgoingIndex];
      const incomingSlide = slides[nextIndex];
      const outgoingPerson = profileLines(outgoing);
      const incomingPerson = profileLines(incoming);

      activeIndex = nextIndex;
      updateAccessibility();

      gsap.set(outgoingSlide, { autoAlpha: 1, zIndex: 1 });
      gsap.set(incomingSlide, { autoAlpha: 1, zIndex: 2 });
      gsap.set(incoming.quote.lines, { yPercent: motion.travel });
      gsap.set(incomingPerson, { yPercent: motion.travel });
      gsap.set(incoming.avatar, {
        clipPath: "circle(0% at 50% 50%)",
        scale: motion.hiddenAvatarScale,
      });

      transition = gsap
        .timeline({
          onComplete: () => {
            gsap.set(outgoingSlide, { autoAlpha: 0, zIndex: 0 });
            gsap.set(outgoing.quote.lines, { yPercent: motion.travel });
            gsap.set(outgoingPerson, { yPercent: motion.travel });
            gsap.set(outgoing.avatar, {
              clipPath: "circle(0% at 50% 50%)",
              scale: motion.hiddenAvatarScale,
            });

            slides.forEach((slide, index) => {
              slide.classList.toggle("is-active", index === activeIndex);
            });

            transition = null;
          },
        })
        .addLabel("out", 0)
        .to(
          outgoing.quote.lines,
          {
            yPercent: -motion.travel,
            duration: motion.quote.outDuration,
            stagger: motion.quote.stagger,
            ease: motion.ease.out,
          },
          "out",
        )
        .to(
          outgoingPerson,
          {
            yPercent: -motion.travel,
            duration: motion.person.outDuration,
            stagger: motion.person.stagger,
            ease: motion.ease.out,
          },
          `out+=${motion.person.outDelay}`,
        )
        .to(
          outgoing.avatar,
          {
            clipPath: "circle(0% at 50% 50%)",
            scale: motion.hiddenAvatarScale,
            duration: motion.avatar.outDuration,
            ease: motion.ease.out,
          },
          `out+=${motion.avatar.outDelay}`,
        )
        .addLabel("in", motion.quote.inDelay)
        .to(
          progress,
          {
            autoAlpha: 0,
            duration: motion.progress.outDuration,
            ease: motion.ease.out,
          },
          "out",
        )
        .to(
          incoming.quote.lines,
          {
            yPercent: 0,
            duration: motion.quote.inDuration,
            stagger: motion.quote.stagger,
            ease: motion.ease.in,
          },
          "in",
        )
        .to(
          incoming.avatar,
          {
            clipPath: "circle(50% at 50% 50%)",
            scale: 1,
            duration: motion.avatar.inDuration,
            ease: motion.ease.in,
          },
          `in+=${motion.avatar.inDelay}`,
        )
        .to(
          incomingPerson,
          {
            yPercent: 0,
            duration: motion.person.inDuration,
            stagger: motion.person.stagger,
            ease: motion.ease.in,
          },
          `in+=${motion.person.inDelay}`,
        )
        .call(startProgress, [], `in+=${motion.progress.restartDelay}`);
    };

    const requestMove = (direction) => {
      if (!splitSlides.length) return;

      if (transition?.isActive()) {
        const remaining = transition.duration() - transition.time();
        if (remaining > motion.unlockBeforeEnd) return;

        transition.progress(1);
      }

      goTo(activeIndex + direction);
    };

    const prepare = () => {
      const createSplit = (element, slideIndex) =>
        SplitText.create(element, {
          type: "lines",
          mask: "lines",
          linesClass: "split-line",
          autoSplit: true,
          onSplit(instance) {
            return gsap.set(instance.lines, {
              yPercent: slideIndex === activeIndex ? 0 : motion.travel,
            });
          },
        });

      splitSlides = slides.map((slide, index) => ({
        quote: createSplit(slide.querySelector("[data-quote]"), index),
        person: [...slide.querySelectorAll("[data-person-line]")].map((line) =>
          createSplit(line, index),
        ),
        avatar: slide.querySelector("[data-avatar]"),
      }));

      slides.forEach((slide, index) => {
        gsap.set(slide, {
          autoAlpha: index === activeIndex ? 1 : 0,
          zIndex: index === activeIndex ? 1 : 0,
        });

        gsap.set(splitSlides[index].avatar, {
          clipPath:
            index === activeIndex
              ? "circle(50% at 50% 50%)"
              : "circle(0% at 50% 50%)",
          scale: index === activeIndex ? 1 : motion.hiddenAvatarScale,
        });
      });

      updateAccessibility();
      startProgress();
    };

    previousButton.addEventListener("click", () => requestMove(-1), {
      signal: controller.signal,
    });

    nextButton.addEventListener("click", () => requestMove(1), {
      signal: controller.signal,
    });

    (document.fonts?.ready ?? Promise.resolve()).then(() => {
      if (!destroyed) prepare();
    });

    root.testimonialCleanup = () => {
      destroyed = true;
      controller.abort();
      progressTween?.kill();
      transition?.kill();

      splitSlides.forEach((slide) => {
        slide.quote.revert();
        slide.person.forEach((split) => split.revert());
      });

      slides.forEach((slide, index) => {
        slide.classList.toggle("is-active", index === activeIndex);
      });

      gsap.set(slides, { clearProps: "opacity,visibility,zIndex" });
      gsap.set(
        splitSlides.map((slide) => slide.avatar),
        { clearProps: "clipPath,transform" },
      );
      gsap.set(progress, {
        clearProps: "transform,opacity,visibility",
      });

      delete root.testimonialCleanup;
    };
  });
}
