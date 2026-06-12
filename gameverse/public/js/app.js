(function () {
    var toggle = document.querySelector('[data-menu-toggle]');
    var nav = document.querySelector('[data-main-nav]');

    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var isOpen = nav.classList.toggle('is-open');
            toggle.classList.toggle('is-open', isOpen);
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    var currentPath = window.location.pathname.replace(/\/$/, '') || '/';
    document.querySelectorAll('.main-nav a').forEach(function (link) {
        var linkPath = new URL(link.href).pathname.replace(/\/$/, '') || '/';
        if (linkPath === currentPath || (linkPath !== '/' && currentPath.indexOf(linkPath) === 0)) {
            link.classList.add('is-active');
        }
    });
}());
