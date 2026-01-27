document.addEventListener("DOMContentLoaded", () => {
    const authModal = document.getElementById("authModal");
    if (!authModal) return;

    const modalContent = authModal.querySelector(".modal-content");
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const tabButtons = document.querySelectorAll(".tab-btn");

    function showTab(tab) {
        loginForm.style.display = tab === 'login' ? 'block' : 'none';
        registerForm.style.display = tab === 'register' ? 'block' : 'none';

        tabButtons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.tab === tab);
        });
    }

    window.closeAuthModal = function () {
        authModal.style.display = "none";
        authModal.setAttribute("aria-hidden", "true");
    };

    authModal.addEventListener("click", e => {
        if (!modalContent.contains(e.target)) closeAuthModal();
    });

    // فتح المودال من الخارج
    document.querySelectorAll(".open-auth").forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();
            authModal.style.display = "flex";
            showTab(btn.dataset.tab || 'login');
        });
    });

    // أزرار التبويب العلوية
    tabButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            showTab(btn.dataset.tab);
        });
    });

    // الروابط داخل الفورم
    document.getElementById("toRegister")?.addEventListener("click", e => {
        e.preventDefault();
        showTab('register');
    });

    document.getElementById("toLogin")?.addEventListener("click", e => {
        e.preventDefault();
        showTab('login');
    });

    // الوضع الافتراضي
    showTab('login');
});
