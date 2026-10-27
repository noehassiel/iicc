import { gsap } from "gsap";
import { CustomEase } from "gsap/CustomEase";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { SplitText } from "gsap/SplitText";

gsap.registerPlugin(CustomEase, ScrollTrigger, SplitText);

CustomEase.create("hero-section-01-text", "0.1, 0, 0, 1");

/**
 * Cinematic full-screen home hero. Media and copy come from the Banner model.
 * Pass `{ lenis }` to reuse an existing smooth-scroll instance; none is created here.
 */
export function cinematicMediaHero(scope = document, { lenis = null } = {}) {
  const root = scope.querySelector("[data-hero-section-01]");
  if (!root) return;

  root.heroSection01Cleanup?.();

  const next = scope.querySelector("[data-hero-next]");
  const media = [...root.querySelectorAll(".media > .item")];
  const thumbs = [...root.querySelectorAll(".thumbs button")];
  const thumbGroup = root.querySelector(".thumbs");
  const initialVisual = media[0]?.firstElementChild;
  const videos = media
    .map((item, index) => ({
      index,
      video: item.firstElementChild?.matches("video")
        ? item.firstElementChild
        : null,
    }))
    .filter(({ video }) => video);
  const loader = root.querySelector(".loader");
  const panels = loader?.querySelectorAll(".panel");
  const progressTrack = loader?.querySelector(".progress");
  const line = loader?.querySelector(".line");
  const count = loader?.querySelector(".count");
  const slideTexts = media.map((_, index) => [
    ...root.querySelectorAll(`[data-hero-text="${index}"]`),
  ]);
  const splitTargets = [...root.querySelectorAll("[data-split]")];
  const title = slideTexts[0]?.find((el) => el.matches(".headline"))?.querySelector("[data-split]");
  const copy = slideTexts[0]?.find((el) => el.matches("p"));
  const navItems = root.querySelectorAll('[data-hero-text="0"] [data-hero-nav] > *');
  const siteHeader = document.querySelector(".navigation-01-header");
  const siteHeaderItems = siteHeader
    ? [...siteHeader.querySelectorAll(".header-content > :not(nav), .nav-list > li")]
    : [];

  if (
    !next ||
    !initialVisual ||
    !loader ||
    panels?.length !== 2 ||
    !progressTrack ||
    !line ||
    !count ||
    !title ||
    !thumbGroup ||
    media.length !== thumbs.length
  ) {
    return;
  }

  const settings = {
    breakpoint: 700,
    desktopParallaxY: 30,
    media: {
      duration: 2.35,
      ease: "expo.out",
      handoffWindow: 1,
    },
  };

  lenis?.on("scroll", ScrollTrigger.update);

  const controller = new AbortController();
  const responsive = gsap.matchMedia();
  let nextTween;
  let introTimeline;
  let switchTimeline;
  const splits = new Map();
  let textSwapCall;
  let visibilityTrigger;
  let activeIndex = 0;
  let pendingIndex = null;
  let switching = false;
  let ready = false;
  let heroVisible = next.getBoundingClientRect().top > 0;

  const syncVideoPlayback = () => {
    videos.forEach(({ index, video: itemVideo }) => {
      const shouldPlay =
        heroVisible && !document.hidden && index === activeIndex;

      if (shouldPlay) itemVideo.play().catch(() => {});
      else itemVideo.pause();
    });
  };

  videos.forEach(({ index, video: itemVideo }) => {
    itemVideo.autoplay = index === 0;
    itemVideo.defaultMuted = true;
    itemVideo.muted = true;
    itemVideo.loop = true;
    itemVideo.playsInline = true;
    if (!itemVideo.hasAttribute("preload")) {
      itemVideo.preload = index === 0 ? "auto" : "metadata";
    }
    itemVideo.toggleAttribute("autoplay", index === 0);
    itemVideo.setAttribute("muted", "");
    itemVideo.setAttribute("loop", "");
    itemVideo.setAttribute("playsinline", "");
  });

  document.addEventListener("visibilitychange", syncVideoPlayback, {
    signal: controller.signal,
  });

  delete root.dataset.heroIntroDone;
  gsap.set(loader, { display: "" });
  gsap.set(panels, { yPercent: 0 });
  gsap.set(progressTrack, { "--track-opacity": 1 });
  gsap.set(line, { scaleX: 0, transformOrigin: "center" });
  gsap.set(count, { autoAlpha: 1 });
  gsap.set(thumbGroup, {
    "--background-alpha": 0,
    "--blur": "0px",
  });
  count.textContent = "0%";

  media.forEach((item, index) => {
    const visual = item.firstElementChild;
    const isActive = index === 0;

    item.classList.toggle("active", index === 0);
    gsap.set(item, {
      zIndex: isActive ? 1 : 0,
      clipPath: isActive ? "inset(0)" : "inset(0 0 0 100%)",
    });
    gsap.set(visual, {
      xPercent: 0,
      scale: isActive ? 1.4 : 1,
    });
  });

  thumbs.forEach((thumb, index) => {
    thumb.classList.toggle("active", index === 0);
    thumb.setAttribute("aria-pressed", String(index === 0));
  });

  responsive.add(`(min-width: ${settings.breakpoint + 1}px)`, () => {
    gsap.to(root, {
      yPercent: settings.desktopParallaxY,
      ease: "power1.in",
      scrollTrigger: {
        trigger: root,
        endTrigger: next,
        start: "top top",
        end: "top top",
        scrub: true,
      },
    });
  });

  nextTween = gsap.fromTo(
    next,
    {
      borderRadius: () =>
        innerWidth <= settings.breakpoint
          ? "18px 18px 0 0"
          : "24px 24px 0 0",
    },
    {
      borderRadius: 0,
      ease: "none",
      scrollTrigger: {
        trigger: next,
        start: "top bottom",
        end: "top top",
        scrub: true,
        invalidateOnRefresh: true,
      },
    },
  );

  visibilityTrigger = ScrollTrigger.create({
    trigger: next,
    start: "top top",
    onEnter: () => {
      heroVisible = false;
      syncVideoPlayback();
    },
    onLeaveBack: () => {
      heroVisible = true;
      syncVideoPlayback();
    },
  });

  syncVideoPlayback();

  const switchMedia = (index) => {
    const outgoingIndex = activeIndex;
    const outgoing = media[outgoingIndex];
    const incoming = media[index];
    const outgoingMedia = outgoing.firstElementChild;
    const incomingMedia = incoming.firstElementChild;
    const outgoingVideo = outgoing.querySelector("video");
    const incomingVideo = incoming.querySelector("video");

    switching = true;
    pendingIndex = null;

    thumbs[outgoingIndex].classList.remove("active");
    thumbs[outgoingIndex].setAttribute("aria-pressed", "false");
    thumbs[index].classList.add("active");
    thumbs[index].setAttribute("aria-pressed", "true");
    activeIndex = index;
    swapText(outgoingIndex, index);

    if (heroVisible && !document.hidden) {
      incomingVideo?.play().catch(() => {});
    }

    gsap.set(outgoing, { zIndex: 1, clipPath: "inset(0)" });
    gsap.set(incoming, {
      zIndex: 2,
      clipPath: "inset(0 0 0 100%)",
    });
    gsap.set(outgoingMedia, { xPercent: 0, scale: 1 });
    gsap.set(incomingMedia, { xPercent: 10, scale: 1.2 });

    switchTimeline = gsap
      .timeline({
        defaults: {
          duration: settings.media.duration,
          ease: settings.media.ease,
        },
        onComplete: () => {
          outgoing.classList.remove("active");
          incoming.classList.add("active");

          gsap.set(outgoing, {
            zIndex: 0,
            clipPath: "inset(0 0 0 100%)",
          });
          gsap.set(incoming, { zIndex: 1, clipPath: "inset(0)" });
          gsap.set([outgoingMedia, incomingMedia], {
            xPercent: 0,
            scale: 1,
          });

          outgoingVideo?.pause();
          syncVideoPlayback();
          switching = false;
          switchTimeline = null;

          const queuedIndex = pendingIndex;
          pendingIndex = null;
          if (queuedIndex !== null && queuedIndex !== activeIndex) {
            switchMedia(queuedIndex);
          }
        },
      })
      .to(outgoingMedia, { xPercent: -10 }, 0)
      .to(incoming, { clipPath: "inset(0 0 0 0%)" }, 0)
      .to(incomingMedia, { xPercent: 0, scale: 1 }, 0);
  };

  thumbs.forEach((thumb, index) => {
    thumb.addEventListener(
      "click",
      () => {
        if (!ready) return;

        if (switching) {
          const remaining =
            switchTimeline.duration() - switchTimeline.time();

          if (
            index !== activeIndex &&
            remaining <= settings.media.handoffWindow
          ) {
            pendingIndex = index;
            switchTimeline.progress(1);
          }
          return;
        }

        if (index !== activeIndex) switchMedia(index);
      },
      { signal: controller.signal },
    );
  });

  // Every banner's title and subtitle is split once; each keeps its own reveal tween.
  splitTargets.forEach((el) => {
    const state = { reveal: null, started: false };

    state.split = SplitText.create(el, {
      type: "words, chars",
      wordsClass: "split-word",
      charsClass: "split-char",
      autoSplit: true,
      onSplit(self) {
        state.chars = self.chars;
        state.reveal = gsap.fromTo(
          self.chars,
          { yPercent: -100, y: "-0.25em" },
          {
            yPercent: 0,
            y: 0,
            duration: 0.75,
            stagger: 0.005,
            ease: "hero-section-01-text",
            paused: !state.started,
          },
        );

        return state.reveal;
      },
    });

    splits.set(el, state);
  });

  const reveal = (el) => {
    const state = el && splits.get(el);
    if (!state) return;

    state.started = true;
    state.reveal.restart();
  };

  const setCurrent = (index, current) => {
    slideTexts[index]?.forEach((el) => {
      el.classList.toggle("is-current", current);
      el.toggleAttribute("aria-hidden", !current);
    });
  };

  slideTexts.forEach((_, index) => setCurrent(index, index === 0));

  const swapText = (outgoingIndex, incomingIndex) => {
    textSwapCall?.kill();

    const outgoingTargets = slideTexts[outgoingIndex].flatMap((el) =>
      el.matches("[data-split]") ? [el] : [...el.querySelectorAll("[data-split]")],
    );
    const outgoingChars = outgoingTargets.flatMap((el) => splits.get(el)?.chars ?? []);
    const outgoingCta = slideTexts[outgoingIndex].flatMap((el) => [...el.querySelectorAll("[data-hero-nav] > *")]);

    outgoingTargets.forEach((el) => splits.get(el)?.reveal.pause());
    gsap.to(outgoingChars, { yPercent: 100, y: "0.25em", duration: 0.45, stagger: 0.003, ease: "power2.in" });
    gsap.to(outgoingCta, { yPercent: 120, duration: 0.45, ease: "power2.in" });

    textSwapCall = gsap.delayedCall(0.5, () => {
      textSwapCall = null;
      if (activeIndex !== incomingIndex) return;

      slideTexts.forEach((_, index) => setCurrent(index, index === incomingIndex));
      slideTexts[incomingIndex].forEach((el) => {
        const targets = el.matches("[data-split]") ? [el] : [...el.querySelectorAll("[data-split]")];
        targets.forEach(reveal);
        gsap.fromTo(
          el.querySelectorAll("[data-hero-nav] > *"),
          { yPercent: -120 },
          { yPercent: 0, duration: 0.75, delay: 0.25, ease: "hero-section-01-text" },
        );
      });
    });
  };

  const progress = { value: 0 };

  introTimeline = gsap.timeline();

  introTimeline
    .to(progress, {
      value: 100,
      duration: 1.5,
      ease: "expo.out",
      onUpdate: () => {
        count.textContent = `${Math.round(progress.value)}%`;
      },
    })
    .to(line, { scaleX: 1, duration: 1.5, ease: "expo.out" }, 0)
    .addLabel("reveal")
    .to(count, { autoAlpha: 0, duration: 0.35, ease: "power1.out" }, "reveal")
    .to(
      line,
      {
        scaleX: 0,
        transformOrigin: "right center",
        duration: 1.5,
        ease: "power4.inOut",
      },
      "reveal",
    )
    .to(
      progressTrack,
      {
        "--track-opacity": 0,
        duration: 1.5,
        ease: "power1.out",
      },
      "reveal",
    )
    .to(panels[0], { yPercent: -100, duration: 1.5, ease: "power4.inOut" }, "reveal")
    .to(panels[1], { yPercent: 100, duration: 1.5, ease: "power4.inOut" }, "reveal")
    .to(initialVisual, { scale: 1, duration: 1.5, ease: "power4.out" }, "reveal+=0.5")
    .from(
      navItems,
      {
        yPercent: -120,
        duration: 0.75,
        stagger: 0.08,
        ease: "hero-section-01-text",
      },
      "reveal+=0.95",
    )
    .call(
      () => {
        reveal(title);
      },
      [],
      "reveal+=0.7",
    )
    .call(
      () => {
        reveal(copy);
      },
      [],
      "reveal+=0.4",
    )
    .from(
      thumbs,
      {
        yPercent: -120,
        duration: 0.75,
        stagger: 0.1,
        ease: "hero-section-01-text",
      },
      "reveal+=0.8",
    )
    .to(
      thumbGroup,
      {
        "--background-alpha": 0.314,
        "--blur": "10px",
        duration: 0.6,
        ease: "power2.out",
      },
      "reveal+=0.8",
    )
    .fromTo(
      siteHeader,
      { autoAlpha: 0, y: 0, yPercent: -60, scale: 0.96, filter: "blur(8px)" },
      {
        autoAlpha: 1,
        y: 0,
        yPercent: 0,
        scale: 1,
        filter: "blur(0px)",
        duration: 1.1,
        ease: "power3.out",
      },
      "reveal+=0.3",
    )
    .from(
      siteHeaderItems,
      {
        autoAlpha: 0,
        yPercent: -80,
        duration: 0.8,
        stagger: 0.07,
        ease: "power3.out",
      },
      "reveal+=0.5",
    )
    .call(
      () => {
        root.dataset.heroIntroDone = "";
        gsap.set(siteHeader, { clearProps: "opacity,visibility,transform,filter" });
        gsap.set(siteHeaderItems, { clearProps: "opacity,visibility,transform" });
      },
      [],
      "reveal+=2.2",
    )
    .set(loader, { display: "none" }, "reveal+=1.5")
    .call(
      () => {
        ready = true;
      },
      [],
      "reveal+=1.5",
    );

  root.heroSection01Cleanup = () => {
    controller.abort();
    videos.forEach(({ video: itemVideo }) => itemVideo.pause());
    lenis?.off("scroll", ScrollTrigger.update);
    switchTimeline?.kill();
    introTimeline?.kill();
    root.dataset.heroIntroDone = "";
    gsap.set(siteHeader, { clearProps: "opacity,visibility,transform,filter" });
    gsap.set(siteHeaderItems, { clearProps: "opacity,visibility,transform" });
    nextTween?.scrollTrigger?.kill();
    nextTween?.kill();
    visibilityTrigger?.kill();
    responsive.revert();
    textSwapCall?.kill();
    splits.forEach((state) => state.split.revert());
    gsap.killTweensOf([root, next, ...root.querySelectorAll("*")]);
    delete root.heroSection01Cleanup;
  };

  return root.heroSection01Cleanup;
}
