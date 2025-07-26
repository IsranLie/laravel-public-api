document.addEventListener("DOMContentLoaded", function () {
    // Scroll To Top
    const scrollBtn = document.getElementById("scroll-to-top");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            scrollBtn.classList.remove("hidden");
        } else {
            scrollBtn.classList.add("hidden");
        }
    });

    scrollBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });

    // ======= THEME TOGGLE (Desktop + Mobile) =======
    const root = document.documentElement;

    const toggleButtons = [
        {
            btn: document.getElementById("theme-toggle"),
            icon: document.getElementById("theme-toggle-icon"),
        },
        {
            btn: document.getElementById("theme-toggle-mobile"),
            icon: document.getElementById("theme-toggle-icon-mobile"),
        },
    ];

    function applyThemeIcon(isDark) {
        toggleButtons.forEach(({ icon }) => {
            if (!icon) return;
            icon.classList.toggle("ri-moon-line", !isDark);
            icon.classList.toggle("ri-sun-line", isDark);
        });
    }

    function setTheme(isDark) {
        if (isDark) {
            root.classList.add("dark");
            localStorage.setItem("theme", "dark");
        } else {
            root.classList.remove("dark");
            localStorage.setItem("theme", "light");
        }
        applyThemeIcon(isDark);
    }

    // init
    const initialDark = localStorage.getItem("theme") === "dark";
    setTheme(initialDark);

    toggleButtons.forEach(({ btn }) => {
        if (!btn) return;
        btn.addEventListener("click", () => {
            const nowDark = !root.classList.contains("dark");
            setTheme(nowDark);
        });
    });

    // ======= HAMBURGER / SIDEBAR =======
    const hamburger = document.getElementById("hamburger");
    const hamburgerIcon = document.getElementById("hamburger-icon");
    const mobileSidebar = document.getElementById("mobile-sidebar");
    const backdrop = document.getElementById("backdrop");

    function openSidebar() {
        mobileSidebar.classList.remove("translate-x-full");
        backdrop.classList.remove("hidden");
        document.body.classList.add("overflow-hidden");
        hamburger.setAttribute("aria-expanded", "true");
        hamburgerIcon.classList.replace("ri-menu-line", "ri-close-line");
    }

    function closeSidebar() {
        mobileSidebar.classList.add("translate-x-full");
        backdrop.classList.add("hidden");
        document.body.classList.remove("overflow-hidden");
        hamburger.setAttribute("aria-expanded", "false");
        hamburgerIcon.classList.replace("ri-close-line", "ri-menu-line");
    }

    if (hamburger) {
        hamburger.addEventListener("click", () => {
            const isOpen = hamburger.getAttribute("aria-expanded") === "true";
            isOpen ? closeSidebar() : openSidebar();
        });
    }

    if (backdrop) {
        backdrop.addEventListener("click", closeSidebar);
    }

    // Script Close Sidebar
    const closeSidebarBtn = document.getElementById("close-sidebar");
    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener("click", () => {
            mobileSidebar.classList.add("translate-x-full");
            backdrop.classList.add("hidden");
            hamburger.setAttribute("aria-expanded", "false");
            hamburgerIcon.classList.replace("ri-close-line", "ri-menu-line");
            document.body.classList.remove("overflow-hidden");
        });
    }

    // Tutup sidebar saat resize ke desktop
    window.addEventListener("resize", () => {
        if (window.innerWidth >= 768) {
            closeSidebar();
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const preloader = document.getElementById("preloader");
    if (preloader) {
        preloader.style.opacity = "0";
        setTimeout(() => (preloader.style.display = "none"), 300);
    }
});

document.querySelectorAll("a").forEach((a) => {
    a.addEventListener("click", () => {
        const preloader = document.getElementById("preloader");
        preloader.style.display = "flex";
        preloader.style.opacity = "1";
    });
});
