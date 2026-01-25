// resources/js/auth.js

document.addEventListener("DOMContentLoaded", () => {
    const authModal = document.getElementById("authModal");
    if (!authModal) return;

    const modalContent = authModal.querySelector(".modal-content");

    window.closeAuthModal = function () {
        authModal.style.display = "none";
        authModal.setAttribute("aria-hidden", "true");
    };

    authModal.addEventListener("click", e => {
        if (!modalContent.contains(e.target)) closeAuthModal();
    });

    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");

    function showTab(tab) {
        loginForm.style.display = tab === 'login' ? 'block' : 'none';
        registerForm.style.display = tab === 'register' ? 'block' : 'none';
    }

    document.querySelectorAll(".open-auth").forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();
            authModal.style.display = "flex";
            showTab(btn.dataset.tab || 'register');
        });
    });
});
