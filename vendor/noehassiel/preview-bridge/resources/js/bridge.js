// noehassiel/preview-bridge: tells the portal which page the client is on while they review the preview.
(function () {
    var portal = document.currentScript && document.currentScript.dataset.portal;

    // Only talk when framed by the portal; opened on its own, the site behaves as usual
    if (!portal || window.parent === window) return;

    var last = null;

    function report() {
        var path = location.pathname + location.search + location.hash;
        if (path === last) return;
        last = path;
        window.parent.postMessage({ type: 'nh:navigate', path: path, title: document.title }, portal);
    }

    // Catch client-side navigation too (Livewire navigate, Inertia, plain pushState)
    ['pushState', 'replaceState'].forEach(function (method) {
        var original = history[method];
        history[method] = function () {
            var result = original.apply(this, arguments);
            report();
            return result;
        };
    });

    window.addEventListener('popstate', report);
    window.addEventListener('hashchange', report);
    document.addEventListener('livewire:navigated', report);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', report);
    } else {
        report();
    }
})();
