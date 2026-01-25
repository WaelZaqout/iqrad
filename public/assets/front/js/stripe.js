// resources/js/investments.js

let selectedProjectId = null;
let minInvestment = 0;
let annualRate = 0;

window.openInvestModal = function (button) {
    selectedProjectId = button.dataset.id;
    minInvestment = parseFloat(button.dataset.min);
    annualRate = parseFloat(button.dataset.rate);

    document.getElementById('modalProjectName').textContent = button.dataset.title;
    document.getElementById('modalMinInvest').textContent = minInvestment.toLocaleString();

    const input = document.getElementById('investAmountModal');
    input.min = minInvestment;
    input.value = minInvestment;

    calculateReturn();
    openModal('investModal');
};

window.calculateReturn = function () {
    const input = document.getElementById('investAmountModal');
    let amount = parseFloat(input.value) || minInvestment;

    if (amount < minInvestment) amount = minInvestment;

    const monthly = (amount * (annualRate / 100)) / 12;
    document.getElementById('expectedReturnModal').value =
        monthly.toFixed(2) + ' ريال / شهر';
};

window.redirectToStripe = function () {
    const amount = parseFloat(document.getElementById("investAmountModal").value);

    if (!amount || amount < minInvestment) {
        alert(`الحد الأدنى ${minInvestment}`);
        return;
    }

    fetch('/investments/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            project_id: selectedProjectId,
            amount
        })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            window.location.href = `/checkout-stripe/${res.investment_id}`;
        }
    });
};
