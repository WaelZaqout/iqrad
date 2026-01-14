@extends('admin.master')

@section('content')
    <div class="container" dir="rtl">
        <h1 class="mb-4">لوحة تحكم رئيسية — أرشفة مالية قوية</h1>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">إجمالي عدد المشاريع</h5>
                        <p class="card-text h3">{{ $totalProjects ?? '0' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">حالة المشاريع</h5>
                        <p class="card-text">مقبولة: <strong>{{ $acceptedProjects ?? '0' }}</strong></p>
                        <p class="card-text">منتظرة: <strong>{{ $pendingProjects ?? '0' }}</strong></p>
                        <p class="card-text">مرفوضة: <strong>{{ $rejectedProjects ?? '0' }}</strong></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">إجمالي المستثمرين</h5>
                        <p class="card-text h3">{{ $totalInvestors ?? '0' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">إجمالي المقترضين</h5>
                        <p class="card-text h3">{{ $totalBorrowers ?? '0' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">إجمالي مبلغ الاستثمارات في النظام</h5>
                        <p class="card-text h3">{{ number_format($totalInvestmentAmount ?? 0, 2) }} {{ $currency ?? 'ر.س' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">إجمالي الأرباح السنوية المتوقعة</h5>
                        <p class="card-text h3">{{ number_format($expectedAnnualProfit ?? 0, 2) }} {{ $currency ?? 'ر.س' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">مؤشر المشاريع في آخر 30 يوم</h5>
                        <canvas id="projectsChart" height="160"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title">مؤشر الاستثمارات في آخر 30 يوم</h5>
                        <canvas id="investmentsChart" height="160"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- بيانات ورسائل توضيحية: Controller يجب أن يمرر المتغيرات التالية للعرض --}}
        {{-- $projectsLast30 => مصفوفة بالأعداد اليومية (مثال: [0,1,2,...]) --}}
        {{-- $investmentsLast30 => مصفوفة بالمبالغ اليومية --}}

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function() {
                const projectsData = {!! json_encode($projectsLast30 ?? array_fill(0, 30, 0)) !!};
                const investmentsData = {!! json_encode($investmentsLast30 ?? array_fill(0, 30, 0)) !!};

                // labels: last 30 days
                const labels = (function() {
                    const d = new Date();
                    const out = [];
                    for (let i = 29; i >= 0; i--) {
                        const dt = new Date(d.getFullYear(), d.getMonth(), d.getDate() - i);
                        out.push((dt.getMonth() + 1) + '/' + dt.getDate());
                    }
                    return out;
                })();

                const ctxP = document.getElementById('projectsChart').getContext('2d');
                new Chart(ctxP, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'عدد المشاريع',
                            data: projectsData,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                const ctxI = document.getElementById('investmentsChart').getContext('2d');
                new Chart(ctxI, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'مبالغ الاستثمارات',
                            data: investmentsData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            })();
        </script>
    @endpush
@endsection
