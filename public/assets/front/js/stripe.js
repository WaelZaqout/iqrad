// resources/js/investments.js

let selectedProjectId = null;
let minInvestment = 0;
let annualRate = 0;

/* ==============================
   فتح مودال الاستثمار
============================== */
window.openInvestModal = function (button) {
    selectedProjectId = button.dataset.id;
    minInvestment = parseFloat(button.dataset.min);
    annualRate = parseFloat(button.dataset.rate);

    document.getElementById('modalProjectName').textContent =
        button.dataset.title;

    document.getElementById('modalMinInvest').textContent =
        minInvestment.toLocaleString();

    const input = document.getElementById('investAmountModal');
    input.min = minInvestment;
    input.value = minInvestment;

    calculateReturn();
    openModal('investModal');
};

/* ==============================
   حساب العائد الشهري
============================== */
window.calculateReturn = function () {
    const input = document.getElementById('investAmountModal');
    let amount = parseFloat(input.value);

    if (!amount || amount < minInvestment) {
        amount = minInvestment;
        input.value = minInvestment;
    }

    const monthlyReturn = (amount * (annualRate / 100)) / 12;

    document.getElementById('expectedReturnModal').value =
        monthlyReturn.toFixed(2) + ' ' + window.sarMonthText;
};

/* ==============================
   فتح / إغلاق مودال
============================== */
window.openModal = function (id) {
    const modal = document.getElementById(id);
    modal.style.display = 'flex';
    setTimeout(() => modal.classList.add('open'), 10);
};

window.closeModal = function (id) {
    const modal = document.getElementById(id);
    modal.classList.remove('open');
    setTimeout(() => modal.style.display = 'none', 300);
};

/* ==============================
   حفظ الاستثمار + Stripe
============================== */
window.redirectToStripe = function () {
    const amount = parseFloat(
        document.getElementById("investAmountModal").value
    );

    if (!amount || amount < minInvestment) {
        alert("مبلغ الاستثمار يجب أن يكون على الأقل " + minInvestment);
        return;
    }

    fetch("/investments/store", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": window.csrfToken
        },
        body: JSON.stringify({
            project_id: selectedProjectId,
            amount: amount
        })
    })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                window.location.href =
                    "/checkout-stripe/" + res.investment_id;
            } else {
                alert("حدث خطأ أثناء حفظ الاستثمار");
            }
        })
        .catch(() => {
            alert("مشكلة في الاتصال بالسيرفر");
        });
};


document.querySelectorAll('.quick-amount').forEach(btn => {
    btn.addEventListener('click', function () {
        let amount = parseInt(this.dataset.amount);
        document.getElementById('investAmount').value = amount;
        calculateReturn();

        document.querySelectorAll('.quick-amount')
            .forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});
document.querySelector('.btn-invest').addEventListener('click', function (e) {
    e.target.disabled = true;
});
