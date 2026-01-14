@extends('admin.master')
@section('content')
@section('title', 'تفاصيل المستثمر')


<div class="container">

    <h3 class="mb-4">تفاصيل المستثمر: {{ $investor->name }}</h3>

    {{-- ===== بيانات أساسية ===== --}}
    <div class="card p-3 mb-4">
        <h5>البيانات الأساسية</h5>
        <hr>
        <p><strong>الاسم:</strong> {{ $investor->name }}</p>
        <p><strong>البريد الإلكتروني:</strong> {{ $investor->email }}</p>
        <p><strong>رقم الهاتف:</strong> {{ $investor->phone ?? '—' }}</p>
        <p><strong>الحالة:</strong>
            @if ($investor->status == 'active')
                <span class="badge bg-success">موافق عليه</span>
            @elseif ($investor->status == 'inactive')
                <span class="badge bg-warning">معلق</span>
            @else
                <span class="badge bg-danger">مرفوض</span>
            @endif
        </p>
        <p><strong> موعد التسجيل:</strong>
            {{ $investor->created_at ? \Illuminate\Support\Carbon::parse($investor->created_at)->format('Y-m-d H:i') : '—' }}
        </p>
    </div>


    {{-- ===== الاستثمارات ===== --}}
    <div class="card p-3 mb-4">
        <h5>المشاريع التي استثمر فيها</h5>
        <hr>

        {{-- إذا وُجدت معاملة محددة، اعرض تفاصيلها أولاً --}}
        @if(isset($transaction) && $transaction)
            <div class="mb-3">
                <h6>تفاصيل المعاملة المختارة</h6>
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="padding:8px; width:30%; font-weight:600;">المشروع</td>
                        <td style="padding:8px;">{{ $projectTitle ?? ($transaction->project->title ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px; font-weight:600;">المبلغ</td>
                        <td style="padding:8px;">{{ number_format($amount ?? $transaction->amount, 2) }} {{ $currency ?? 'ر.س' }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px; font-weight:600;">معرّف العملية</td>
                        <td style="padding:8px;">{{ $transactionId ?? $transaction->id }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px; font-weight:600;">تاريخ الدفع</td>
                        <td style="padding:8px;">{{ isset($transaction->paid_at) ? \Illuminate\Support\Carbon::parse($transaction->paid_at)->format('Y-m-d H:i') : (isset($created_at) ? (is_string($created_at) ? \Illuminate\Support\Carbon::parse($created_at)->format('Y-m-d H:i') : $created_at) : '-') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px; font-weight:600;">طريقة الدفع</td>
                        <td style="padding:8px;">{{ $paymentMethod ?? ($transaction->method ?? 'Stripe') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px; font-weight:600;">الحالة</td>
                        <td style="padding:8px;">{{ $status ?? $transaction->status ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        @endif

        @if ($investor->investments->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المشروع</th>
                        <th>المبلغ</th>
                        <th>الحالة</th>
                        <th>تاريخ الدفع</th>
                        <th>معرّف العملية</th>
                        <th>طريقة الدفع</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($investor->investments as $i => $inv)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ optional($inv->project)->title ?? '-' }}</td>
                            <td>{{ number_format($inv->amount, 2) }} {{ $currency ?? 'ر.س' }}</td>
                            <td>
                                @if($inv->status == 'paid')
                                    <span class="badge bg-success">مدفوع</span>
                                @elseif($inv->status == 'pending')
                                    <span class="badge bg-warning">قيد الانتظار</span>
                                @else
                                    <span class="badge bg-secondary">{{ $inv->status }}</span>
                                @endif
                            </td>
                            <td>{{ $inv->paid_at ? \Illuminate\Support\Carbon::parse($inv->paid_at)->format('Y-m-d H:i') : '-' }}</td>
                            <td>{{ $inv->id }}</td>
                            <td>{{ $inv->method ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="mt-3"><strong>إجمالي الاستثمار:</strong>
                <span class="text-primary fw-bold">{{ number_format($totalInvested, 2) }} {{ $currency ?? 'ر.س' }}</span>
            </p>
        @else
            <p class="text-muted">لم يقم بأي استثمار حتى الآن.</p>
        @endif
    </div>


    {{-- ===== الأرباح والأموال العالقة ===== --}}
    <div class="card p-3 mb-4">
        <h5>الأموال العالقة / المحوّلة</h5>
        <hr>

        <p><strong>الأموال التي تم تحويلها للمقترضين:</strong>
            <span class="fw-bold">
                {{ number_format($investor->investments->sum('transferred_amount') ?? 0) }}$
            </span>
        </p>

        <p><strong>الأرباح المستحقة ولم تُسحب بعد:</strong>
            <span class="fw-bold text-success">{{ number_format($pendingProfits) }}$</span>
        </p>
    </div>


    {{-- ===== نشاط المستثمر ===== --}}
    <div class="card p-3 mb-4">
        <h5>نشاط المستثمر</h5>
        <hr>

        <h6 class="mb-2">آخر عمليات الإيداع والسحب</h6>

        @if ($investor->transactions->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>النوع</th>
                        <th>المبلغ</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($investor->transactions->take(10) as $tx)
                        <tr>
                            <td>
                                @if ($tx->type == 'deposit')
                                    <span class="badge bg-success">إيداع</span>
                                @elseif ($tx->type == 'withdraw')
                                    <span class="badge bg-danger">سحب</span>
                                @else
                                    <span class="badge bg-info">تحويل</span>
                                @endif
                            </td>
                            <td>{{ number_format($tx->amount) }}$</td>
                            <td>{{ $tx->created_at ? \Illuminate\Support\Carbon::parse($tx->created_at)->format('Y-m-d H:i') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">لا يوجد نشاط مالي حتى الآن.</p>
        @endif
    </div>

    <a href="{{ route('investors.index') }}" class="btn btn-secondary mt-3">الرجوع</a>

</div>
@endsection
