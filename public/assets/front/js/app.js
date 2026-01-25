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
