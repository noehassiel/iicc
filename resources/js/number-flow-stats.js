import 'number-flow';

/**
 * Animates each [data-number-flow-stat] from 0 to its data-value once it enters the viewport.
 * NumberFlow (c) 2024 Maxwell Barvian, MIT License.
 */
export function numberFlowStats(scope = document) {
  scope.querySelectorAll('[data-number-flow-stat]').forEach((root) => {
    root.__numberFlowStatCleanup?.();

    const flow = root.querySelector('[data-stat-number]');
    if (!flow) return;

    flow.format = { maximumFractionDigits: 0 };
    flow.numberSuffix = '+';
    flow.trend = 1;
    flow.spinTiming = { duration: 2200, easing: 'cubic-bezier(0.16, 1, 0.3, 1)' };
    flow.transformTiming = { duration: 2200, easing: 'cubic-bezier(0.16, 1, 0.3, 1)' };
    flow.animated = false;
    flow.update(0);
    flow.animated = true;

    let observer;
    const reveal = () => flow.update(Number(root.dataset.value));

    if ('IntersectionObserver' in window) {
      observer = new IntersectionObserver(
        ([entry]) => {
          if (!entry?.isIntersecting) return;
          reveal();
          observer.disconnect();
        },
        { threshold: 0.5 },
      );
      observer.observe(root);
    } else {
      reveal();
    }

    root.__numberFlowStatCleanup = () => {
      observer?.disconnect();
      flow.animated = false;
      delete root.__numberFlowStatCleanup;
    };
  });
}
