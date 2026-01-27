<!-- Investment Opportunities Section -->
<h3 class="section-title">{{ __('auth.investment_opportunities') }}</h3>
<!-- Projects Grid -->
<div id="projects-container" class="project-cards-container">
    <!-- Project 1 -->
    @include('front.partials.projects-cards', ['projects' => $projects])

    <div class="load-more-wrapper">
        <a href="{{ route('project') }}" class="load-more-btn">
            <i class="fas fa-layer-group"></i>
            {{ __('auth.more_projects') }}
        </a>
    </div>
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
                    <span class="text-success fs-4">{{ number_format($stats['receivedProfits']) }}
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
                    <span class="flex-grow-1">{{ __('auth.capital') }}: {{ number_format($stats['totalCapital']) }}
                        {{ __('auth.riyal') }}</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="me-3" style="width: 20px; height: 20px; background: #10b981; border-radius: 4px;">
                    </div>
                    <span class="flex-grow-1">{{ __('auth.received_profits') }}:
                        {{ number_format($stats['receivedProfits']) }}
                        {{ __('auth.riyal') }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3" style="width: 20px; height: 20px; background: #94a3b8; border-radius: 4px;">
                    </div>
                    <span class="flex-grow-1">{{ __('auth.expected_profits') }}: 12,800
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
                        <td>{{ $inv['title'] }}</td>

                        <td>{{ number_format($inv['amount']) }} {{ __('auth.riyal') }}</td>

                        <td>{{ number_format($inv['profit']) }} {{ __('auth.riyal') }}</td>
                        <td>
                            <span
                                class="badge
                                   @if ($inv['status'] === 'paid') bg-success
                               @elseif($inv['status'] === 'pending') bg-warning text-dark
                                  @else bg-danger @endif">

                                @if ($inv['status'] === 'paid')
                                    +{{ number_format($inv['profit']) }}
                                @elseif($inv['status'] === 'pending')
                                    -{{ number_format($inv['amount']) }}
                                @elseif($inv['status'] === 'refunded')
                                    +{{ number_format($inv['amount']) }}
                                @endif
                            </span>
                        </td>



                        <td>{{ $inv['date'] }}</td>
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
                        <td>{{ $inv['date'] }}</td>

                        <td>
                            @if ($inv['status'] === 'paid')
                                {{ __('auth.profit_transfer') }} "{{ $inv['title'] }}"
                            @elseif ($inv['status'] === 'pending')
                                {{ __('auth.investment_in_project') }} "{{ $inv['title'] }}"
                            @elseif ($inv['status'] === 'refunded')
                                {{ __('auth.refund_from_project') }} "{{ $inv['title'] }}"
                            @endif
                        </td>

                        <td
                            class="{{ in_array($inv['status'], ['paid', 'refunded']) ? 'text-success' : 'text-danger' }}">
                            @if ($inv['status'] === 'paid')
                                +{{ number_format($inv['profit']) }} {{ __('auth.riyal') }}
                            @elseif ($inv['status'] === 'pending')
                                -{{ number_format($inv['amount']) }} {{ __('auth.riyal') }}
                            @elseif ($inv['status'] === 'refunded')
                                +{{ number_format($inv['amount']) }} {{ __('auth.riyal') }}
                            @endif
                        </td>

                        <td>
                            <span
                                class="badge
        @if ($inv['status'] === 'paid') bg-success
        @elseif($inv['status'] === 'pending') bg-primary
        @else bg-danger @endif">
                                @if ($inv['status'] === 'paid')
                                    {{ __('auth.completed_success') }} ✅
                                @elseif($inv['status'] === 'pending')
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

<h3 class="section-title">الدعم والدردشة</h3>
<div
    style="background: white; border-radius: 24px; padding: 2rem; box-shadow: var(--card-shadow); border: 1px solid #f1f5f9;">
    <div class="d-flex align-items-center mb-4">
        <div class="avatar me-3" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">اد</div>
        <div>
            <h5 class="mb-0">الدعم الفني</h5>
            <small class="text-success"><i class="fas fa-circle me-1"></i> Online</small>
        </div>
    </div>

    <div
        style="min-height: 250px; max-height: 350px; overflow-y: auto; padding: 1.5rem; background: #f8fafc; border-radius: 18px; margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
        @if ($conversation)
            @foreach ($conversation->messages as $msg)
                <div class="chat-message {{ $msg->sender_id == auth()->id() ? 'message-sent' : 'message-received' }}">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong>{{ $msg->sender_id == auth()->id() ? 'أنت' : 'الدعم' }}</strong>
                        <small class="text-muted">{{ $msg->created_at->format('H:i') }}</small>
                    </div>
                    <p class="mb-0">{{ $msg->message }}</p>
                </div>
            @endforeach
        @else
            <p class="text-center text-muted">لم تبدأ أي محادثة بعد.</p>
        @endif
    </div>

    <form action="{{ route('support.sendMessage') }}" method="POST" class="input-group">
        @csrf
        <input type="hidden" name="conversation_id" value="{{ $conversation?->id }}">
        <input type="text" name="message" class="form-control py-3" placeholder="اكتب رسالتك هنا">
        <button class="btn btn-primary py-3 px-4"><i class="fas fa-paper-plane"></i></button>
    </form>
</div>

<!-- Invest Modal -->
<div id="investModal" class="modal-overlay">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-header">
            <h3 style="font-weight: 800; font-size: 1.5rem; color: var(--gray-900);">
                {{ __('auth.invest_project') }}</h3>
            <button class="close-modal" onclick="closeModal('investModal')"><i class="fas fa-times"></i></button>
        </div>
        <div
            style="background: var(--bg-light); padding: 1.25rem; border-radius: 1rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; border: 1px solid var(--border);">
            <div
                style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div>
                <div style="font-size: 0.85rem; color: var(--gray-500); font-weight: 600;">
                    {{ __('auth.project_name') }}</div>
                <div id="modalProjectName" style="font-weight: 800; font-size: 1.1rem; color: var(--gray-900);">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">{{ __('auth.investment_amount') }} <span id="modalMinInvest"
                    style="color:var(--primary)"></span> {{ __('auth.riyal') }})</label>
            <div style="position: relative;">
                <input type="number" id="investAmountModal" class="form-control" oninput="calculateReturn()"
                    style="padding-left: 3rem; font-weight: bold; font-size: 1.2rem;">
                <span
                    style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-weight: bold;">SAR</span>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">{{ __('auth.expected_monthly_return') }}</label>
            <input type="text" id="expectedReturnModal" class="form-control" readonly
                style="background: var(--gray-100); color: var(--primary-dark); font-weight: 800;">
        </div>
        <button onclick="redirectToStripe()" class="btn btn-primary" style="width: 100%; padding: 1.25rem;">
            <i class="fas fa-lock"></i> {{ __('auth.secure_payment') }}
        </button>
        <p style="text-align: center; font-size: 0.8rem; color: var(--gray-400); margin-top: 1rem;"><i
                class="fas fa-shield-alt"></i> {{ __('auth.transactions_secure') }}</p>
    </div>
</div>
