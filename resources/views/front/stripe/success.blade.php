@extends('front.master')

@section('content')
    <main class="container" style="padding: 48px 0;">
        <div class="success-page" dir="rtl" style="text-align: center;">
            <div class="icon" style="font-size:64px; color:var(--success); margin-bottom:16px;">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>{{ __('auth.success_title') }}</h1>
            <p style="color:var(--gray-600); margin-bottom:24px;">{{ __('auth.success_message') }}</p>

            <div class="card" style="max-width:900px; margin: 0 auto 24px; text-align:right;">
                <div class="card-body">
                    <h3 class="card-title">{{ __('auth.transaction_details') }}</h3>
                    <table style="width:100%; border-collapse:collapse;">
                        <tr>
                            <td style="padding:8px; width:35%; font-weight:600;">{{ __('auth.investor_name') }}</td>
                            <td style="padding:8px;">{{ $investorName ?? (Auth::check() ? Auth::user()->name : '-') }}</td>
                        </tr>
                        <tr style="background:transparent;">
                            <td style="padding:8px; font-weight:600;">{{ __('auth.project') }}</td>
                            <td style="padding:8px;">{{ $projectTitle ?? ($transaction->project->title ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px; font-weight:600;">{{ __('auth.amount') }}</td>
                            <td style="padding:8px;">{{ number_format($amount ?? ($transaction->amount ?? 0), 2) }}
                                {{ $currency ?? ($transaction->currency ?? 'ر.س') }}</td>
                        </tr>
                        <tr style="background:transparent;">
                            <td style="padding:8px; font-weight:600;">{{ __('auth.transaction_id') }}</td>
                            <td style="padding:8px;">{{ $transactionId ?? ($transaction->id ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px; font-weight:600;">{{ __('auth.payment_date') }}</td>
                            <td style="padding:8px;">
                                {{ isset($transaction->created_at) ? $transaction->created_at->format('Y-m-d H:i') : (isset($created_at) ? $created_at : '-') }}
                            </td>
                        </tr>
                        <tr style="background:transparent;">
                            <td style="padding:8px; font-weight:600;">{{ __('auth.payment_method') }}</td>
                            <td style="padding:8px;">{{ $paymentMethod ?? ($transaction->method ?? 'Stripe') }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px; font-weight:600;">{{ __('auth.status') }}</td>
                            <td style="padding:8px; color:var(--success);">
                                {{ $status ?? ($transaction->status ?? __('auth.successful')) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap; margin-top:32px;">
                <a href="{{ url('/dashboard') }}" class="btn btn-primary"
                    style="padding:12px 28px; font-size:16px; border-radius:8px; background:var(--primary); color:white; text-decoration:none; font-weight:600; transition:all 0.3s ease; box-shadow:0 2px 8px rgba(0,0,0,0.1);"
                    onmouseover="this.style.background='var(--primary)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.2)';"
                    onmouseout="this.style.background='var(--primary)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)';">
                    {{ __('auth.dashboard') }}
                </a>
                @if (isset($transactionId) || isset($transaction->id))
                    <a href="{{ url('/investments/receipt/' . ($transactionId ?? $transaction->id)) }}"
                        class="btn btn-outline"
                        style="padding:12px 28px; font-size:16px; border-radius:8px; background:white; color:var(--primary); border:2px solid var(--primary); text-decoration:none; font-weight:600; transition:all 0.3s ease;"
                        onmouseover="this.style.background='var(--primary)'; this.style.color='white'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.2)';"
                        onmouseout="this.style.background='white'; this.style.color='var(--primary)'; this.style.boxShadow='none';">
                        {{ __('auth.download_receipt') }}
                    </a>
                @endif
                <a href="{{ url('/') }}" class="btn btn-outline"
                    style="padding:12px 28px; font-size:16px; border-radius:8px; background:white; color:var(--primary); border:2px solid var(--primary); text-decoration:none; font-weight:600; transition:all 0.3s ease;"
                    onmouseover="this.style.background='var(--primary)'; this.style.color='white'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.2)';"
                    onmouseout="this.style.background='white'; this.style.color='var(--primary)'; this.style.boxShadow='none';">
                    {{ __('auth.browse_projects') }}
                </a>
            </div>

            <p style="color:var(--gray-600); margin-top:20px; font-size:0.95rem;">{{ __('auth.contact_message') }}
                <a href="mailto:{{ __('auth.support_email') }}">{{ __('auth.support_email') }}</a> {{ __('auth.or') }}
                <a href="/help">{{ __('auth.help_center') }}</a>.
            </p>
        </div>
    </main>
@endsection
