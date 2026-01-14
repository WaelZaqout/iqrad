@extends('front.master')

@section('content')
    <main class="container" style="padding: 48px 0;">
        <div class="success-page" dir="rtl" style="text-align: center;">
            <div class="icon" style="font-size:64px; color:var(--success); margin-bottom:16px;">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>تمت عملية الدفع بنجاح</h1>
            <p style="color:var(--gray-600); margin-bottom:24px;">شكراً لاستثمارك — تم تسجيل معاملتك بنجاح.</p>

            <div class="card" style="max-width:900px; margin: 0 auto 24px; text-align:right;">
                <div class="card-body">
                    <h3 class="card-title">تفاصيل العملية</h3>
                    <table style="width:100%; border-collapse:collapse;">
                        <tr>
                            <td style="padding:8px; width:35%; font-weight:600;">اسم المستثمر</td>
                            <td style="padding:8px;">{{ $investorName ?? (Auth::check() ? Auth::user()->name : '-') }}</td>
                        </tr>
                        <tr style="background:transparent;">
                            <td style="padding:8px; font-weight:600;">المشروع</td>
                            <td style="padding:8px;">{{ $projectTitle ?? ($transaction->project->title ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px; font-weight:600;">المبلغ</td>
                            <td style="padding:8px;">{{ number_format($amount ?? ($transaction->amount ?? 0), 2) }}
                                {{ $currency ?? ($transaction->currency ?? 'ر.س') }}</td>
                        </tr>
                        <tr style="background:transparent;">
                            <td style="padding:8px; font-weight:600;">معرّف العملية</td>
                            <td style="padding:8px;">{{ $transactionId ?? ($transaction->id ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px; font-weight:600;">تاريخ الدفع</td>
                            <td style="padding:8px;">
                                {{ isset($transaction->created_at) ? $transaction->created_at->format('Y-m-d H:i') : (isset($created_at) ? $created_at : '-') }}
                            </td>
                        </tr>
                        <tr style="background:transparent;">
                            <td style="padding:8px; font-weight:600;">طريقة الدفع</td>
                            <td style="padding:8px;">{{ $paymentMethod ?? ($transaction->method ?? 'Stripe') }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px; font-weight:600;">الحالة</td>
                            <td style="padding:8px; color:var(--success);">
                                {{ $status ?? ($transaction->status ?? 'ناجحة') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">لوحة التحكم</a>
                @if (isset($transactionId) || isset($transaction->id))
                    <a href="{{ url('/investments/receipt/' . ($transactionId ?? $transaction->id)) }}"
                        class="btn btn-outline">تحميل الإيصال</a>
                @endif
                <a href="{{ url('/') }}" class="btn btn-outline">تابع تصفح المشاريع</a>
            </div>

            <p style="color:var(--gray-600); margin-top:20px; font-size:0.95rem;">إذا واجهت أي مشكلة، تواصل معنا عبر
                <a href="mailto:support@iqrad.example">support@iqrad.example</a> أو اطلع على
                <a href="/help">مركز المساعدة</a>.
            </p>
        </div>
    </main>
@endsection
