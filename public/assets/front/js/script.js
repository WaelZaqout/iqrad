// === Existing JavaScript from your file ===
// Preloader
window.addEventListener('load', function () {
    const preloader = document.getElementById('preloader');
    setTimeout(() => {
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }, 2000);
});

// Dark Mode Toggle
const darkModeToggle = document.getElementById('darkModeToggle');
const body = document.body;
if (localStorage.getItem('darkMode') === 'enabled') {
    body.classList.add('dark-mode');
}
darkModeToggle.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', 'enabled');
    } else {
        localStorage.setItem('darkMode', 'disabled');
    }
});

// Sticky header on scroll
const header = document.getElementById('header');
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Scroll to top button
const scrollTopBtn = document.getElementById('scrollTop');
window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
        scrollTopBtn.classList.add('show');
    } else {
        scrollTopBtn.classList.remove('show');
    }
});
scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Profile dropdown toggle
const userProfile = document.getElementById('userProfile');
const profileDropdown = document.getElementById('profileDropdown');
userProfile.addEventListener('click', (e) => {
    e.stopPropagation();
    profileDropdown.classList.toggle('show');
});
document.addEventListener('click', (e) => {
    if (!userProfile.contains(e.target)) {
        profileDropdown.classList.remove('show');
    }
});

// NOTE: FAQ handling moved to the bottom IIFE which also adds accessibility attributes

// Mock real-time funding updates
function updateFundingProgress() {
    const progressBars = document.querySelectorAll('.progress-fill');
    progressBars.forEach(bar => {
        const currentWidth = parseFloat(bar.style.width);
        if (currentWidth < 100) {
            const newWidth = Math.min(currentWidth + 0.05, 100);
            bar.style.width = newWidth + '%';
        }
    });
}
setInterval(updateFundingProgress, 3000);


// Payment modal
function openPaymentModal(projectId) {
    document.getElementById('paymentModal').style.display = 'flex';
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
}

// Process payment


// Apply project modal
const applyBtns = document.querySelectorAll('#applyProjectBtn, #applyProjectBtn2');
applyBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('applyModal').style.display = 'flex';
    });
});

function closeApplyModal() {
    document.getElementById('applyModal').style.display = 'none';
}

// User type modal
window.addEventListener('load', function () {
    if (!localStorage.getItem('userType')) {
        document.getElementById('userTypeModal').style.display = 'block';
    }
});

function selectUserType(type) {
    localStorage.setItem('userType', type);
    closeUserTypeModal();
}

function closeUserTypeModal() {
    document.getElementById('userTypeModal').style.display = 'none';
}

// Chat widget
function toggleChat() {
    const chatWindow = document.getElementById('chatWindow');
    if (chatWindow.style.display === 'none' || chatWindow.style.display === '') {
        chatWindow.style.display = 'block';
    } else {
        chatWindow.style.display = 'none';
    }
}

function openChatWidget() {
    const chatWidget = document.getElementById('chatWidget');
    chatWidget.classList.add('show');
    setTimeout(() => {
        document.getElementById('chatBody').classList.add('show');
    }, 300);
}

document.getElementById('chatWidgetBtn').addEventListener('click', openChatWidget);

function toggleChatBody() {
    const chatBody = document.getElementById('chatBody');
    chatBody.classList.toggle('show');
}

function selectChatOption(option) {
    let message = '';
    switch (option) {
        case 'invest':
            message = 'رائع! يمكنك البدء بالاستثمار من خلال النقر على زر "ابدأ الاستثمار الآن" في الأعلى.';
            break;
        case 'loan':
            message = 'ممتاز! يمكنك التقديم على قرض من خلال النقر على زر "قدّم مشروعك" في القسم الرئيسي.';
            break;
        case 'help':
            message = 'يمكنك زيارة مركز المساعدة في القائمة العلوية للحصول على الدعم الكامل.';
            break;
    }
    alert(message);
}

// Show chat widget after 5 seconds
setTimeout(openChatWidget, 5000);

// Testimonials slider
let currentSlide = 0;
const slider = document.getElementById('testimonialsSlider');
const dots = document.querySelectorAll('.carousel-dot');
const totalSlides = 3;
function goToSlide(slideIndex) {
    currentSlide = slideIndex;
    slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}
function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    goToSlide(currentSlide);
}
setInterval(nextSlide, 5000);
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        goToSlide(index);
    });
});

// Close modals when clicking outside
window.onclick = function (event) {
    const modals = ['projectModal', 'paymentModal', 'applyModal', 'userTypeModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
};

// Language switch
const langToggle = document.querySelector('.lang-toggle');
const langMenu = document.querySelector('.lang-menu');
const langOptions = document.querySelectorAll('.lang-option');
langToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    langMenu.classList.toggle('show');
});
document.addEventListener('click', (e) => {
    if (!langToggle.contains(e.target) && !langMenu.contains(e.target)) {
        langMenu.classList.remove('show');
    }
});
langOptions.forEach(option => {
    option.addEventListener('click', () => {
        langOptions.forEach(opt => opt.classList.remove('active'));
        option.classList.add('active');
        const lang = option.dataset.lang;
        document.documentElement.lang = lang;
        document.documentElement.dir = lang === 'ar' ? 'rtl' : 'ltr';
        langMenu.classList.remove('show');
    });
});

// Make project cards clickable for details
document.querySelectorAll('.project-card').forEach((card, index) => {
    card.addEventListener('click', (e) => {
        if (!e.target.classList.contains('invest-btn')) {
            openProjectDetails(projects[index].id);
        }
    });
});

// Mobile menu toggle
(function () {
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileClose = document.getElementById('mobileMenuClose');

    if (!mobileToggle || !mobileMenu) return;

    function openMenu() {
        mobileMenu.classList.add('show');
        mobileMenu.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        mobileMenu.classList.remove('show');
        mobileMenu.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    mobileToggle.addEventListener('click', openMenu);
    mobileClose && mobileClose.addEventListener('click', closeMenu);

    // Close when clicking outside content
    mobileMenu.addEventListener('click', (e) => {
        if (e.target === mobileMenu) closeMenu();
    });

    // Close when a link is clicked
    mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
})();

// Footer accordion for small screens
(function () {
    const mq = () => window.innerWidth <= 768;
    const titles = document.querySelectorAll('.footer-column .footer-title');
    if (!titles || titles.length === 0) return;

    function collapseAll() {
        titles.forEach(t => {
            const col = t.closest('.footer-column');
            if (col) col.classList.remove('active');
            t.setAttribute('aria-expanded', 'false');
        });
    }

    function onTitleToggle(e) {
        if (!mq()) return; // only operate on small screens
        const t = e.currentTarget;
        const col = t.closest('.footer-column');
        if (!col) return;
        const isActive = col.classList.contains('active');
        if (isActive) {
            col.classList.remove('active');
            t.setAttribute('aria-expanded', 'false');
        } else {
            col.classList.add('active');
            t.setAttribute('aria-expanded', 'true');
        }
    }

    titles.forEach(t => {
        t.setAttribute('role', 'button');
        t.setAttribute('tabindex', '0');
        t.setAttribute('aria-expanded', 'false');
        t.addEventListener('click', onTitleToggle);
        t.addEventListener('keydown', (ev) => {
            if (ev.key === 'Enter' || ev.key === ' ') {
                ev.preventDefault();
                onTitleToggle({ currentTarget: t });
            }
        });
    });

    // Collapse all on load for small screens
    if (mq()) collapseAll();

    // Re-collapse when resizing from large -> small
    window.addEventListener('resize', () => {
        if (mq()) collapseAll();
    });
})();

// FAQ toggle (desktop & mobile)
(function () {
    const faqQuestions = document.querySelectorAll('.faq-question');
    if (!faqQuestions || faqQuestions.length === 0) return;

    faqQuestions.forEach(q => {
        // ensure keyboard/focus accessibility
        q.setAttribute('role', 'button');
        q.setAttribute('tabindex', '0');
        q.setAttribute('aria-expanded', 'false');

        // find the corresponding answer (assumes structure: .faq-question followed by .faq-answer)
        const item = q.closest('.faq-item');
        const answer = item ? item.querySelector('.faq-answer') : null;
        if (answer) answer.setAttribute('aria-hidden', 'true');

        // click toggles open/close and updates ARIA
        q.addEventListener('click', () => {
            if (!item) return;
            item.classList.toggle('active');
            const isActive = item.classList.contains('active');
            q.setAttribute('aria-expanded', isActive ? 'true' : 'false');
            if (answer) answer.setAttribute('aria-hidden', isActive ? 'false' : 'true');
        });

        // make the chevron icon clickable too (if present)
        const chevron = q.querySelector('.faq-toggle');
        if (chevron) chevron.addEventListener('click', (ev) => { ev.stopPropagation(); q.click(); });

        // keyboard support
        q.addEventListener('keydown', (ev) => {
            if (ev.key === 'Enter' || ev.key === ' ') {
                ev.preventDefault();
                q.click();
            }
        });
    });
})();

// Auth modal handlers
(function () {
    const authModal = document.getElementById('authModal');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const tabLogin = document.getElementById('authTabLogin');
    const tabRegister = document.getElementById('authTabRegister');

    function showAuthTab(tab) {
        if (tab === 'register') {
            tabRegister.classList.add('active');
            tabLogin.classList.remove('active');
            registerForm.style.display = '';
            loginForm.style.display = 'none';
            registerForm.querySelector('input')?.focus();
        } else {
            tabLogin.classList.add('active');
            tabRegister.classList.remove('active');
            loginForm.style.display = '';
            registerForm.style.display = 'none';
            loginForm.querySelector('input')?.focus();
        }
    }

    window.openAuthModal = function (tab = 'register') {
        if (!authModal) return;
        authModal.style.display = 'flex';
        authModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        showAuthTab(tab);
    };

    window.closeAuthModal = function () {
        if (!authModal) return;
        authModal.style.display = 'none';
        authModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    // wire tab buttons
    tabLogin && tabLogin.addEventListener('click', () => showAuthTab('login'));
    tabRegister && tabRegister.addEventListener('click', () => showAuthTab('register'));

    // quick links inside forms
    const toRegister = document.getElementById('toRegister');
    const toLogin = document.getElementById('toLogin');
    toRegister && toRegister.addEventListener('click', (e) => { e.preventDefault(); showAuthTab('register'); });
    toLogin && toLogin.addEventListener('click', (e) => { e.preventDefault(); showAuthTab('login'); });

    // open links from header/mobile
    document.querySelectorAll('.open-auth').forEach(a => {
        a.addEventListener('click', (e) => {
            e.preventDefault();
            const tab = a.dataset.tab || 'register';
            openAuthModal(tab);
        });
    });

    // forms: simple stub handlers (prevent submit and close modal)
    // loginForm && loginForm.addEventListener('submit', (e) => {
    //     e.preventDefault();
    //     // TODO: connect real auth flow
    //     closeAuthModal();
    //     alert('تم تسجيل الدخول (محاكاة)');
    // });
    // registerForm && registerForm.addEventListener('submit', (e) => {
    //     e.preventDefault();
    //     // basic client-side validation
    //     const name = document.getElementById('regName')?.value.trim();
    //     const email = document.getElementById('regEmail')?.value.trim();
    //     const phone = document.getElementById('regPhone')?.value.trim();
    //     const pass = document.getElementById('regPassword')?.value || '';
    //     const pass2 = document.getElementById('regPassword2')?.value || '';

    //     if (!name) {
    //         alert('يرجى إدخال الاسم الكامل');
    //         document.getElementById('regName')?.focus();
    //         return;
    //     }
    //     if (!email) {
    //         alert('يرجى إدخال البريد الإلكتروني');
    //         document.getElementById('regEmail')?.focus();
    //         return;
    //     }
    //     if (!phone) {
    //         alert('يرجى إدخال رقم الجوال');
    //         document.getElementById('regPhone')?.focus();
    //         return;
    //     }
    //     if (pass.length < 6) {
    //         alert('يجب أن تتكون كلمة المرور من 6 أحرف على الأقل');
    //         document.getElementById('regPassword')?.focus();
    //         return;
    //     }
    //     if (pass !== pass2) {
    //         alert('كلمتا المرور غير متطابقتين');
    //         document.getElementById('regPassword2')?.focus();
    //         return;
    //     }

    //     // TODO: connect real registration flow & validation (e.g., API call, SMS verification)
    //     closeAuthModal();
    //     alert('تم إنشاء الحساب (محاكاة). سيتم إرسال رمز تحقق إلى: ' + phone);
    // });

    // close on Escape
    document.addEventListener('keydown', (ev) => {
        if (ev.key === 'Escape') closeAuthModal();
    });

    // close when clicking outside content
    authModal && authModal.addEventListener('click', (e) => {
        if (e.target === authModal) closeAuthModal();
    });
})();
