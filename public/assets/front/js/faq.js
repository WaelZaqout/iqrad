window.toggleFaq = function (element) {
    const answer = element.querySelector('.faq-answer');
    const toggle = element.querySelector('.faq-toggle');

    const isOpen = answer.style.display === 'block';

    answer.style.display = isOpen ? 'none' : 'block';
    toggle.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
};
