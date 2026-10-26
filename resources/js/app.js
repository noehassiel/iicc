import Swup from 'swup';
import SwupHeadPlugin from '@swup/head-plugin';
import { button06 } from './button-06';
import { navigation01 } from './navigation-01';
import { testimonial05 } from './testimonial-05';
import { stackedServiceCards } from './stacked-scroll-panel-2';
import { numberFlowStats } from './number-flow-stats';
import { cinematicMediaHero } from './hero-section-01';

const swup = new Swup({
    animateHistoryBrowsing: true,
    containers: ['#swup'],
    plugins: [new SwupHeadPlugin()],
});

/**
 * One-time setup for persistent UI outside #swup (header, footer).
 */
function setupOnce() {
    navigation01();
    button06();
}

/**
 * Setup for elements inside #swup; runs on first load and after every swap.
 */
function initSwappedContent(scope = document.querySelector('#swup') ?? document) {
    button06(scope);
    testimonial05(scope);
    stackedServiceCards(scope);
    numberFlowStats(scope);
    const hero = scope.querySelector('[data-hero-section-01]');
    if (hero) {
        // SplitText measures lines, so wait for the web fonts.
        (document.fonts?.ready ?? Promise.resolve()).then(() => hero.isConnected && cinematicMediaHero(scope));
    }
    const carousels = scope.querySelectorAll('[data-cylindrical-carousel]');
    if (carousels.length) {
        // Three.js is heavy; only load it on pages that have a carousel.
        import('./cylindrical-carousel').then(({ cylindricalCarousel }) => carousels.forEach((root) => root.isConnected && cylindricalCarousel(root)));
    }
}

document.addEventListener('DOMContentLoaded', () => {
    setupOnce();
    initSwappedContent();
});

swup.hooks.before('content:replace', () => {
    document.querySelectorAll('#swup [data-hero-section-01]').forEach((root) => root.heroSection01Cleanup?.());
    document.querySelectorAll('#swup [data-testimonials]').forEach((root) => root.testimonialCleanup?.());
    document.querySelectorAll('#swup [data-stacked-scroll-panel-2]').forEach((root) => root.__stackedServiceCardsCleanup?.());
    document.querySelectorAll('#swup [data-number-flow-stat]').forEach((root) => root.__numberFlowStatCleanup?.());
    document.querySelectorAll('#swup [data-cylindrical-carousel]').forEach((root) => root.carouselCleanup?.());
});

swup.hooks.on('content:replace', () => {
    initSwappedContent();
});
