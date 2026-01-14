<!-- Investment Opportunities Section -->
<h3 class="section-title">{{ __('auth.investment_opportunities') }}</h3>

<div class="investment-cards-container">
    @foreach ($projects as $project)
        <!-- Investment Opportunity 1 -->
        <div class="investment-card">
            <div class="project-tags">
                <span class="status-badge {{ $project->status_badge['class'] }}">
                    {{ $project->status_badge['label'] }}
                </span>
            </div>
            <div class="project-header">
                <h4 class="project-title">{{ $project->title }}</h4>
                <span class="sector-badge">{{ $project->category->name }}</span>
            </div>
            <div class="return-percentage">{{ $project->interest_rate }} %</div>
            <div class="project-details">
                <div class="detail-item">
                    <span class="detail-label">{{ __('auth.duration') }}</span>
                    <span class="detail-value"> {{ $project->term_months }} {{ __('auth.month') }} </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">{{ __('auth.minimum') }}</span>
                    <span class="detail-value">{{ number_format($project->min_investment) }}
                        {{ __('auth.riyal') }}</span>
                </div>
            </div>

            @php
                $percentage =
                    $project->funding_goal > 0 ? round(($project->funded_amount / $project->funding_goal) * 100) : 0;
                $isCompleted = $project->funded_amount >= $project->funding_goal;
            @endphp

            <div class="progress-wrapper">
                <div class="progress-header">
                    <span class="progress-percentage">{{ __('auth.funding_percentage') }}: {{ $percentage }}%</span>
                    <span class="progress-amount">{{ number_format($project->funded_amount) }} {{ __('auth.from') }}
                        {{ number_format($project->funding_goal) }} {{ __('auth.riyal') }}</span>
                </div>

                <div class="progress-bar-container" role="progressbar" aria-valuenow="{{ $percentage }}"
                    aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar-fill" data-percentage="{{ $percentage }}"></div>
                </div>
            </div>

            <div class="investment-card-footer">

                <a href="{{ route('details', $project->id) }}" class="btn btn-details">
                    <i class="fas fa-eye me-1"></i> {{ __('auth.details') }}
                </a>

                @if (!$isCompleted)
                    <button class="btn btn-invest"
                        onclick="event.stopPropagation(); openInvestModal({{ $project->id }}, '{{ $project->title }}', {{ $project->min_investment }}, {{ $project->interest_rate }})">
                        <i class="fas fa-hand-holding-usd me-1"></i> {{ __('auth.invest_now') }}
                    </button>
                @else
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-check me-1"></i> {{ __('auth.investment_completed') }}
                    </button>
                @endif
            </div>
        </div>
    @endforeach

</div>

<!-- Profit Summary Section -->
<h3 class="section-title">{{ __('auth.profit_summary') }}</h3>
<div class="profit-summary">
    <div class="row">
        <div class="col-lg-6">
            <div class="profit-chart-container">
                <canvas id="profitChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>{{ __('auth.net_profit_this_month') }}:</span>
                    <span class="text-success fs-4">{{ number_format($receivedProfits) }}
                        {{ __('auth.riyal') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span>{{ __('auth.highest_profit_project') }}:</span>
                    <span class="text-success">{{ __('auth.digital_education_platform') }} (+14%) 📈</span>
                </div>
                <h6 class="mb-3">{{ __('auth.capital_distribution') }}</h6>
                <div class="d-flex align-items-center mb-2">
                    <div class="me-3" style="width: 20px; height: 20px; background: #3b82f6; border-radius: 4px;">
                    </div>
                    <span class="flex-grow-1">{{ __('auth.capital') }}: {{ number_format($totalCapital) }}
                        {{ __('auth.riyal') }}</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="me-3" style="width: 20px; height: 20px; background: #10b981; border-radius: 4px;">
                    </div>
                    <span class="flex-grow-1">{{ __('auth.received_profits') }}: {{ number_format($receivedProfits) }}
                        {{ __('auth.riyal') }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3" style="width: 20px; height: 20px; background: #94a3b8; border-radius: 4px;">
                    </div>
                    <span class="flex-grow-1">{{ __('auth.expected_profits') }}: {{ number_format($expectedProfits) }}
                        {{ __('auth.riyal') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Investment Portfolio Section -->
<h3 class="section-title">{{ __('auth.investment_portfolio') }}</h3>
<div
    style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); height: 8px; border-radius: 4px; margin-bottom: 1.5rem; overflow: hidden;">
    <div style="height: 100%; background: linear-gradient(90deg, #1e40af, #10b981); width: 33%;"></div>
</div>
<div class="portfolio-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>{{ __('auth.project_name') }}</th>
                    <th>{{ __('auth.invested_amount') }}</th>
                    <th>{{ __('auth.earned_profits') }}</th>
                    <th>{{ __('auth.investment_status') }}</th>
                    <th>{{ __('auth.start_date') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($investments as $inv)
                    <tr>
                        <td>{{ $inv->project->title }}</td>
                        <td>{{ number_format($inv->amount) }} {{ __('auth.riyal') }}</td>
                        <td>{{ number_format(($inv->amount * $inv->project->interest_rate) / 100) }}
                            {{ __('auth.riyal') }}</td>
                        <td>
                            <span
                                class="badge
                        @if ($inv->status == 'paid') bg-success
                        @elseif($inv->status == 'pending') bg-warning text-dark
                        @else bg-danger @endif">
                                @if ($inv->status == 'paid')
                                    {{ __('auth.status_active') }}
                                @elseif($inv->status == 'pending')
                                    {{ __('auth.status_funding') }}
                                @else
                                    {{ __('auth.status_cancelled') }}
                                @endif
                            </span>
                        </td>
                        <td>{{ $inv->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="p-3 bg-light border-top">
        <div class="d-flex justify-content-end">
            <div class="fw-bold fs-5">{{ __('auth.total_current_profits') }}: <span class="text-success">3,450
                    {{ __('auth.riyal') }}</span> 💰</div>
        </div>
    </div>
</div>

<!-- Transaction History Section -->
<h3 class="section-title">{{ __('auth.transaction_history') }}</h3>
<div class="transaction-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>{{ __('auth.date') }}</th>
                    <th>{{ __('auth.transaction_type') }}</th>
                    <th>{{ __('auth.amount') }}</th>
                    <th>{{ __('auth.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($investments as $inv)
                    <tr>
                        <td>{{ $inv->created_at->format('d/m/Y') }}</td>

                        <td>
                            @if ($inv->status == 'paid')
                                {{ __('auth.profit_transfer') }} "{{ $inv->project->title }}"
                            @elseif($inv->status == 'pending')
                                {{ __('auth.investment_in_project') }} "{{ $inv->project->title }}"
                            @elseif($inv->status == 'refunded')
                                {{ __('auth.refund_from_project') }} "{{ $inv->project->title }}"
                            @endif
                        </td>

                        <td
                            class="{{ $inv->status == 'paid' || $inv->status == 'refunded' ? 'text-success' : 'text-danger' }}">
                            @if ($inv->status == 'paid')
                                +{{ number_format(($inv->amount * $inv->project->interest_rate) / 100) }}
                                {{ __('auth.riyal') }}
                            @elseif($inv->status == 'pending')
                                -{{ number_format($inv->amount) }} {{ __('auth.riyal') }}
                            @elseif($inv->status == 'refunded')
                                +{{ number_format($inv->amount) }} {{ __('auth.riyal') }}
                            @endif
                        </td>

                        <td>
                            <span
                                class="badge
                        @if ($inv->status == 'paid') bg-success
                        @elseif($inv->status == 'pending') bg-primary
                        @else bg-danger @endif">
                                @if ($inv->status == 'paid')
                                    {{ __('auth.completed_success') }} ✅
                                @elseif($inv->status == 'pending')
                                    {{ __('auth.successful') }} ✅
                                @else
                                    {{ __('auth.cancelled') }} ❌
                                @endif
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<!-- Support Chat Section -->
<h3 class="section-title">{{ __('auth.support_and_chat') }}</h3>
<div
    style="background: white; border-radius: 24px; padding: 2rem; box-shadow: var(--card-shadow); border: 1px solid #f1f5f9;">
    <div class="d-flex align-items-center mb-4">
        <div class="avatar me-3" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">اد</div>
        <div>
            <h5 class="mb-0" style="color: #0f172a;">{{ __('auth.financial_support_management') }}</h5>
            <small class="text-success"><i class="fas fa-circle me-1"></i> {{ __('auth.online_now') }}</small>
        </div>
        <div class="ms-auto">
            <button class="btn btn-primary px-4 py-2">
                <i class="fas fa-comment-dots me-2"></i> {{ __('auth.start_new_chat') }}
            </button>
        </div>
    </div>
    <div
        style="min-height: 250px; max-height: 350px; overflow-y: auto; padding: 1.5rem; background: #f8fafc; border-radius: 18px; margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
        <div class="chat-message message-received">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong>{{ __('auth.financial_support_management') }}</strong>
                <small class="text-muted">10:30</small>
            </div>
            <p class="mb-0">{{ __('auth.support_received_message') }}</p>
        </div>
        <div class="chat-message message-sent">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong>{{ __('auth.you') }}</strong>
                <small class="text-white-50">10:28</small>
            </div>
            <p class="mb-0">{{ __('auth.financial_support_inquiry') }}</p>
        </div>
        <div class="chat-message message-received">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong>{{ __('auth.financial_support_management') }}</strong>
                <small class="text-muted">09:15</small>
            </div>
            <p class="mb-0">{{ __('auth.project_status_response') }}</p>
        </div>
    </div>
    <div class="input-group">
        <input type="text" class="form-control py-3" placeholder="{{ __('auth.type_message') }}">
        <button class="btn btn-outline-secondary py-3 px-3" title="{{ __('auth.upload_file') }}">
            <i class="fas fa-paperclip"></i>
        </button>
        <button class="btn btn-primary py-3 px-4">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>
<!-- Payment Modal -->
<div id="investModal" class="modern-modal">
    <div class="modern-modal-content">
        <span class="close-btn" onclick="closeInvestModal()">&times;</span>

        <h2 class="modal-title">{{ __('auth.invest_in_project') }}</h2>

        <div class="modal-project-name d-flex align-items-center mb-4">
            <i class="fas fa-project-diagram me-3 text-primary fs-2"></i>
            <div>
                <h5 class="mb-1 text-muted">{{ __('auth.project_name') }}:</h5>
                <h4 id="projectName" class="mb-0 text-primary fw-bold"
                    style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);"></h4>
            </div>
        </div>

        <div class="form-group">
            <label>{{ __('auth.investment_amount_label') }} ({{ __('auth.minimum_amount') }} <span
                    id="minAmount"></span> {{ __('auth.riyal') }})</label>
            <input type="number" id="investAmount" min="1000" placeholder="1000" value="1000"
                oninput="calculateReturn()">
        </div>

        <div class="form-group">
            <label>{{ __('auth.expected_return_label') }}</label>
            <input type="text" id="expectedReturn" readonly>
        </div>

        <button class="primary-btn" onclick="redirectToStripe()">{{ __('auth.complete_payment') }}</button>
    </div>
</div>
<script>
    // Translation strings
    const translations = {
        monthlyReturn: @json(__('auth.monthly_return')),
        minimumInvestmentAlert: @json(__('auth.minimum_investment_alert')),
        riyal: @json(__('auth.riyal')),
        investmentError: @json(__('auth.investment_error')),
        serverError: @json(__('auth.server_error')),
        capital: @json(__('auth.capital')),
        receivedProfits: @json(__('auth.received_profits')),
        expectedProfits: @json(__('auth.expected_profits'))
    };

    let selectedProjectId = null;
    let projectReturn = 0;
    let minInvestment = 0;

    function openInvestModal(id, name, minAmount, annualReturn) {
        selectedProjectId = id;
        projectReturn = annualReturn;
        minInvestment = minAmount;

        document.getElementById("projectName").textContent = name;
        document.getElementById("minAmount").textContent = minAmount;

        document.getElementById("investAmount").min = minAmount;
        document.getElementById("investAmount").value = minAmount;

        calculateReturn();

        document.getElementById("investModal").style.display = "flex";
    }

    function closeInvestModal() {
        document.getElementById("investModal").style.display = "none";
    }

    function calculateReturn() {
        let amount = document.getElementById("investAmount").value;
        if (amount < minInvestment) {
            document.getElementById("investAmount").value = minInvestment;
            amount = minInvestment;
        }
        let annual = (amount * projectReturn) / 100;
        let monthly = annual / 12;

        document.getElementById("expectedReturn").value =
            monthly.toFixed(2) + " " + translations.monthlyReturn;
    }

    function redirectToStripe() {
        let amount = document.getElementById("investAmount").value;

        if (amount < minInvestment) {
            alert(translations.minimumInvestmentAlert + " " + minInvestment + " " + translations.riyal);
            return;
        }

        // 1️⃣ تسجيل الاستثمار في قاعدة البيانات قبل الدفع
        fetch("/investments/store", {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    project_id: selectedProjectId,
                    amount: amount
                })
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {

                    let investmentId = response.investment_id;

                    // 2️⃣ تحويل المستخدم لصفحة الدفع في Stripe
                    window.location.href = "/checkout-stripe/" + investmentId;

                } else {
                    alert(translations.investmentError);
                }
            })
            .catch(err => {
                console.error(err);
                alert(translations.serverError);
            });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('profitChart');
        if (ctx) {
            const profitChart = new Chart(ctx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: [translations.capital, translations.receivedProfits, translations
                        .expectedProfits
                    ],
                    datasets: [{
                        data: [250000, 37500, 12800],
                        backgroundColor: ['#3b82f6', '#10b981', '#94a3b8'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%',
                    animation: {
                        duration: 2000
                    }
                }
            });
        }
    });
</script>
<script>
    document.querySelector('.btn-invest').addEventListener('click', function(e) {
        e.target.disabled = true;
    });
</script>
