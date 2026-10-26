import * as THREE from "three";
import { gsap } from "gsap";

/**
 * Two-pass WebGL cylindrical carousel. Dispatches a bubbling `carousel:select`
 * event ({ detail: { index } }) when a card is clicked/tapped or Enter is pressed.
 */
export function cylindricalCarousel(scope = document) {
  const root = scope.matches?.("[data-cylindrical-carousel]")
    ? scope
    : scope.querySelector("[data-cylindrical-carousel]");
  if (!root) return;
  root.carouselCleanup?.();

  const canvas = root.querySelector("[data-canvas]");
  const gesture = root.querySelector("[data-gesture]");
  const announcement = root.querySelector("[data-announcement]");
  const cards = JSON.parse(root.dataset.cards || "[]");
  if (!cards.length) return;
  root.querySelector("[data-error]").hidden = true;
  const list = root.querySelector("[data-card-list]");
  list.replaceChildren(...cards.map(card => {
    const item = document.createElement("li");
    item.textContent = `${card.title.replaceAll("\n", " ")}. ${card.description.replaceAll("\n", " ")}`;
    return item;
  }));

  const mobile = /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent)
    || (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 1);
  let pitch = 1;
  let cardWidth = 1;
  const curvature = mobile ? 0.852 : 0.705;
  const abort = new AbortController();
  const { signal } = abort;
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 1000);
  camera.position.set(0, 0, 5);
  camera.lookAt(0, 0, 0);
  const viewHeight = 2 * Math.tan(THREE.MathUtils.degToRad(45) / 2) * 5;
  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
  } catch (error) {
    root.querySelector("[data-error]").textContent = root.dataset.errorStart || "The carousel could not start in this browser.";
    root.querySelector("[data-error]").hidden = false;
    console.warn("Unable to initialize the cylindrical carousel.", error);
    return;
  }
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  renderer.setClearColor(0x000000, 0);

  const target = new THREE.WebGLRenderTarget(1, 1, {
    type: THREE.HalfFloatType,
    depthBuffer: true,
    samples: mobile ? 0 : 2,
  });
  const distortion = new THREE.ShaderMaterial({
    uniforms: { image: { value: target.texture }, curvature: { value: 1 } },
    vertexShader: `
      varying vec2 vUv;
      void main() {
        vUv = uv;
        gl_Position = vec4(position.xy, 0.0, 1.0);
      }
    `,
    fragmentShader: `
      uniform sampler2D image;
      uniform float curvature;
      varying vec2 vUv;
      void main() {
        float edge = pow(abs(vUv.x - 0.5) * 2.0, 2.0);
        vec2 sampleUv = vUv;
        sampleUv.y = mix(vUv.y, (vUv.y - 0.5) * curvature + 0.5, edge);
        gl_FragColor = texture2D(image, sampleUv);
        #include <colorspace_fragment>
      }
    `,
    blending: THREE.NoBlending,
    depthTest: false,
    depthWrite: false,
    toneMapped: false,
  });
  const finalScene = new THREE.Scene();
  const finalCamera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);
  const finalPlane = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), distortion);
  finalPlane.frustumCulled = false;
  finalScene.add(finalPlane);
  const geometry = new THREE.PlaneGeometry(1, 1.25);
  const glowGeometry = new THREE.PlaneGeometry(1.36, 1.61);
  let glowTexture = null;
  let hovered = -1;
  const textures = [];
  const slides = [];
  const entrance = gsap.timeline({ paused: true });
  let width = 1;
  let viewWidth = viewHeight;
  let offset = 0;
  let targetOffset = 0;
  let pointer = null;
  let dragX = 0;
  let dragY = 0;
  let dragMoved = false;
  let dragOffset = 0;
  let frame = 0;
  let lastTime = 0;
  let ready = false;
  let visible = false;
  let destroyed = false;
  let activeIndex = -1;
  const wrap = (value, length) => ((value % length) + length) % length;

  const faceWidth = 1024;
  const faceHeight = 1280;

  function drawTexture(entry, index) {
    const style = getComputedStyle(root);
    const { context, image, texture } = entry;
    const card = cards[index];
    context.clearRect(0, 0, faceWidth, faceHeight);
    context.save();
    context.beginPath();
    context.roundRect(0, 0, faceWidth, faceHeight, 40);
    context.clip();
    context.fillStyle = card.background;
    context.fillRect(0, 0, faceWidth, faceHeight);
    if (image?.naturalWidth) {
      const scale = Math.max(faceWidth / image.naturalWidth, faceHeight / image.naturalHeight);
      const sourceWidth = faceWidth / scale;
      const sourceHeight = faceHeight / scale;
      const [x, y] = card.position || [.5, .5];
      context.drawImage(image,
        (image.naturalWidth - sourceWidth) * x, (image.naturalHeight - sourceHeight) * y,
        sourceWidth, sourceHeight, 0, 0, faceWidth, faceHeight);
      context.fillStyle = card.overlay || "transparent";
      context.fillRect(0, 0, faceWidth, faceHeight);
    }
    context.fillStyle = card.color;
    context.textAlign = "center";
    context.textBaseline = "middle";
    const lines = card.title.split("\n");
    const description = card.description.split("\n");
    let titleSize = 110;
    context.font = `${style.fontStyle} ${style.fontWeight} ${titleSize}px ${style.fontFamily}`;
    const longest = Math.max(...lines.map(line => context.measureText(line).width));
    if (longest > 850) titleSize *= 850 / longest;
    const leading = titleSize * 1.07;
    const bodySize = 35;
    const bodyLeading = 46;
    const gap = 54;
    const blockHeight = lines.length * leading + gap + description.length * bodyLeading;
    const top = (faceHeight - blockHeight) / 2;
    context.font = `${style.fontStyle} ${style.fontWeight} ${titleSize}px ${style.fontFamily}`;
    lines.forEach((line, row) => context.fillText(line, faceWidth / 2, top + leading * (row + .5)));
    context.font = `${style.fontStyle} ${style.fontWeight} ${bodySize}px ${style.fontFamily}`;
    description.forEach((line, row) => context.fillText(line, faceWidth / 2, top + lines.length * leading + gap + bodyLeading * (row + .5)));
    context.restore();
    texture.needsUpdate = true;
  }

  function layout() {
    const span = slides.length * pitch;
    slides.forEach((slide, index) => {
      slide.position.x = wrap(index * pitch + offset + span / 2, span) - span / 2;
    });
    const index = wrap(Math.round(-targetOffset / pitch), cards.length);
    if (index !== activeIndex) {
      activeIndex = index;
      announcement.textContent = `${index + 1} / ${cards.length}: ${cards[index].title.replaceAll("\n", " ")}. ${cards[index].description.replaceAll("\n", " ")}`;
    }
  }

  /** Soft brand-orange halo drawn once and shared by every card's glow plane. */
  function createGlowTexture() {
    const glow = document.createElement("canvas");
    glow.width = 544;
    glow.height = 644;
    const context = glow.getContext("2d");
    const color = getComputedStyle(root).getPropertyValue("--carousel-glow").trim() || "#f0a35c";
    context.shadowColor = color;
    context.shadowBlur = 56;
    context.fillStyle = color;
    context.beginPath();
    context.roundRect(72, 72, 400, 500, 24);
    context.fill();
    const texture = new THREE.CanvasTexture(glow);
    texture.colorSpace = THREE.SRGBColorSpace;
    return texture;
  }

  function setHovered(next) {
    if (next === hovered) return;
    [hovered, next].forEach((index, isNext) => {
      const slide = slides[index];
      if (!slide) return;
      gsap.to(slide.children[0].position, { z: isNext ? .12 : 0, duration: .5, ease: "power3.out", overwrite: "auto" });
      gsap.to(slide.children[1].material, { opacity: isNext ? .85 : 0, duration: .5, ease: "power2.out", overwrite: "auto" });
    });
    hovered = next;
    if (next === -1) delete root.dataset.hovering;
    else root.dataset.hovering = "";
  }

  function populate() {
    const count = Math.max(1, Math.ceil((2 * viewWidth) / (cards.length * pitch))) * cards.length;
    while (slides.length < count) {
      const material = new THREE.MeshBasicMaterial({
        map: textures[slides.length % cards.length].texture,
        transparent: true,
        toneMapped: false,
      });
      const slide = new THREE.Group();
      slide.add(new THREE.Mesh(geometry, material));
      const glow = new THREE.Mesh(glowGeometry, new THREE.MeshBasicMaterial({
        map: glowTexture,
        transparent: true,
        opacity: 0,
        depthWrite: false,
        toneMapped: false,
      }));
      glow.position.z = -.01;
      glow.renderOrder = -1;
      slide.add(glow);
      scene.add(slide);
      slides.push(slide);
    }
    slides.forEach(slide => slide.scale.set(cardWidth, cardWidth, 1));
    layout();
  }

  function resize() {
    width = Math.max(1, root.clientWidth);
    const height = Math.max(1, root.clientHeight);
    const ratio = Math.min(window.devicePixelRatio || 1, 2);
    viewWidth = viewHeight * width / height;
    // Centers at ±2 pitches land exactly on the desktop viewport edges.
    const intervals = width >= 1100 ? 4 : width >= 700 ? 2 : 1.4;
    const nextPitch = viewWidth / intervals;
    offset = offset / pitch * nextPitch;
    targetOffset = targetOffset / pitch * nextPitch;
    dragOffset = dragOffset / pitch * nextPitch;
    pitch = nextPitch;
    // Reserve room for the distorted edge cards and the two controls.
    const availableHeight = Math.max(160, height - 208);
    cardWidth = Math.min(pitch * .9, availableHeight / height * viewHeight * curvature / 1.25);
    const edgeHeight = cardWidth * 1.25 / viewHeight * height / curvature;
    root.style.setProperty("--controls-top", `${height / 2 + edgeHeight / 2 + 24}px`);
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setPixelRatio(ratio);
    renderer.setSize(width, height, false);
    target.setSize(Math.round(width * ratio), Math.round(height * ratio));
    if (ready) populate();
  }

  function render(time) {
    frame = 0;
    if (destroyed || !ready || !visible || document.hidden) return;
    const delta = Math.min(lastTime ? time - lastTime : 16.6667, 100);
    lastTime = time;
    offset += (targetOffset - offset) * (1 - Math.pow(1 - 0.102, delta / 16.6667));
    layout();
    renderer.setRenderTarget(target);
    renderer.render(scene, camera);
    renderer.setRenderTarget(null);
    renderer.render(finalScene, finalCamera);
    frame = requestAnimationFrame(render);
  }

  function updateVisibility() {
    if (destroyed || !ready) return;
    if (visible && !document.hidden) {
      entrance.play();
      if (!frame) {
        lastTime = 0;
        frame = requestAnimationFrame(render);
      }
    } else {
      entrance.pause();
      cancelAnimationFrame(frame);
      frame = 0;
    }
  }

  function step(direction) {
    if (!ready) return;
    targetOffset = Math.round(targetOffset / pitch) * pitch - direction * pitch;
  }

  function select(index) {
    root.dispatchEvent(new CustomEvent("carousel:select", { bubbles: true, detail: { index } }));
  }

  /** Maps a pointer position to the slide under it (x only; the shader warps y, not x). */
  function slideAt(clientX) {
    const bounds = root.getBoundingClientRect();
    const x = ((clientX - bounds.left) / width - .5) * viewWidth;
    return slides.findIndex(slide => Math.abs(slide.position.x - x) <= cardWidth / 2);
  }

  function cardAt(clientX) {
    const hit = slideAt(clientX);
    return hit === -1 ? null : hit % cards.length;
  }

  function endDrag(event) {
    if (pointer !== event.pointerId) return;
    if (gesture.hasPointerCapture(pointer)) gesture.releasePointerCapture(pointer);
    pointer = null;
    delete root.dataset.dragging;
    targetOffset = Math.round(targetOffset / pitch) * pitch;
    if (event.type === "pointerup" && !dragMoved) {
      targetOffset = dragOffset;
      const index = cardAt(event.clientX);
      if (index !== null) select(index);
    }
  }

  root.querySelector("[data-next]").addEventListener("click", () => step(1), { signal });
  root.querySelector("[data-previous]").addEventListener("click", () => step(-1), { signal });
  root.addEventListener("keydown", (event) => {
    if (event.target === root && event.key === "Enter" && ready) {
      event.preventDefault();
      select(activeIndex);
      return;
    }
    if (event.key !== "ArrowLeft" && event.key !== "ArrowRight") return;
    event.preventDefault();
    step(event.key === "ArrowRight" ? 1 : -1);
  }, { signal });
  gesture.addEventListener("pointerdown", (event) => {
    if (!ready || pointer !== null || (event.button !== 0 && event.button !== -1)) return;
    pointer = event.pointerId;
    dragX = event.clientX;
    dragY = event.clientY;
    dragMoved = false;
    dragOffset = targetOffset;
    gesture.setPointerCapture(pointer);
    root.dataset.dragging = "";
    setHovered(-1);
    root.focus({ preventScroll: true });
  }, { signal });
  gesture.addEventListener("pointermove", (event) => {
    if (pointer === null && event.pointerType === "mouse" && ready) setHovered(slideAt(event.clientX));
    if (event.pointerId !== pointer) return;
    if (Math.hypot(event.clientX - dragX, event.clientY - dragY) > 6) dragMoved = true;
    targetOffset = dragOffset + (event.clientX - dragX) / width * viewWidth;
  }, { signal });
  gesture.addEventListener("pointerleave", () => setHovered(-1), { signal });
  gesture.addEventListener("pointerup", endDrag, { signal });
  gesture.addEventListener("pointercancel", endDrag, { signal });
  gesture.addEventListener("lostpointercapture", endDrag, { signal });
  gesture.addEventListener("wheel", (event) => {
    if (!ready) return;
    const delta = event.shiftKey ? event.deltaY : event.deltaX;
    if (Math.abs(delta) <= Math.abs(event.shiftKey ? 0 : event.deltaY)) return;
    event.preventDefault();
    targetOffset -= delta * 0.003;
  }, { signal, passive: false });

  const resizeObserver = new ResizeObserver(resize);
  resizeObserver.observe(root);
  const visibilityObserver = new IntersectionObserver(([entry]) => {
    visible = entry.isIntersecting;
    updateVisibility();
  }, { threshold: 0.01 });
  visibilityObserver.observe(root);
  const themeObserver = new MutationObserver(() => textures.forEach(drawTexture));
  themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ["data-theme"] });
  document.addEventListener("visibilitychange", updateVisibility, { signal });
  window.addEventListener("resize", resize, { signal, passive: true });

  async function initialize() {
    const images = await Promise.all(cards.map(({ src }) => src ? new Promise((resolve, reject) => {
      const image = new Image();
      image.crossOrigin = "anonymous";
      image.decoding = "async";
      image.onload = () => resolve(image);
      image.onerror = () => reject(new Error("A carousel image could not load."));
      image.src = src;
    }) : Promise.resolve(null)));
    await document.fonts.ready;
    if (destroyed) return;
    images.forEach((image, index) => {
      const face = document.createElement("canvas");
      face.width = faceWidth;
      face.height = faceHeight;
      const texture = new THREE.CanvasTexture(face);
      texture.colorSpace = THREE.SRGBColorSpace;
      texture.generateMipmaps = false;
      texture.minFilter = THREE.LinearFilter;
      texture.magFilter = THREE.LinearFilter;
      const entry = { image, texture, context: face.getContext("2d") };
      textures.push(entry);
      drawTexture(entry, index);
    });
    glowTexture = createGlowTexture();
    ready = true;
    resize();
    const entered = new Set();
    for (const position of [-3, -2, -1, 0, 1, 2, 3]) {
      const index = wrap(position, slides.length);
      if (entered.has(index)) continue;
      entered.add(index);
      const mesh = slides[index].children[0];
      const at = Math.abs(position) * 0.1;
      entrance.fromTo(mesh.position, { y: mobile ? -0.65 : -0.85 }, { y: 0, duration: 1.24, ease: "power4.out" }, at);
      entrance.fromTo(mesh.scale, { x: 0.75, y: 0.85 }, { x: 1, y: 1, duration: 0.76, ease: "power3.out" }, at);
      entrance.fromTo(mesh.material, { opacity: 0 }, { opacity: 1, duration: 0.76, ease: "power2.out" }, at);
    }
    entrance.to(distortion.uniforms.curvature, { value: curvature, duration: 1.48, ease: "expo.out" }, 0);
    root.dataset.ready = "";
    updateVisibility();
  }

  function cleanup() {
    if (destroyed) return;
    destroyed = true;
    abort.abort();
    cancelAnimationFrame(frame);
    entrance.kill();
    resizeObserver.disconnect();
    visibilityObserver.disconnect();
    themeObserver.disconnect();
    slides.forEach((slide) => {
      gsap.killTweensOf([slide.children[0].position, slide.children[1].material]);
      slide.children.forEach((mesh) => mesh.material.dispose());
    });
    glowTexture?.dispose();
    glowGeometry.dispose();
    textures.forEach(({ texture }) => texture.dispose());
    geometry.dispose();
    finalPlane.geometry.dispose();
    distortion.dispose();
    target.dispose();
    renderer.dispose();
    delete root.dataset.ready;
    delete root.dataset.dragging;
    delete root.dataset.hovering;
    delete root.carouselCleanup;
  }

  root.carouselCleanup = cleanup;
  window.addEventListener("pagehide", cleanup, { once: true, signal });
  initialize().catch(error => {
    if (destroyed) return;
    cleanup();
    root.querySelector("[data-error]").textContent = root.dataset.errorContent || "The carousel's content could not load.";
    root.querySelector("[data-error]").hidden = false;
    console.warn("Unable to prepare the cylindrical carousel.", error);
  });
  return cleanup;
}
