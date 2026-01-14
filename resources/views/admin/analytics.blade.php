 @extends('admin.master')

 @section('content')
     <style>
         * {
             margin: 0;
             padding: 0;
             box-sizing: border-box;
         }

         body {
             font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
             background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
             min-height: 100vh;
             padding: 20px;
         }

         .container {
             max-width: 1400px;
             margin: 0 auto;
         }

         .header {
             background: rgba(255, 255, 255, 0.95);
             backdrop-filter: blur(10px);
             border-radius: 20px;
             padding: 30px;
             margin-bottom: 30px;
             box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
         }

         .header h1 {
             color: #2d3748;
             font-size: 2.5rem;
             margin-bottom: 10px;
             text-align: center;
         }

         .header .date {
             text-align: center;
             color: #718096;
             font-size: 1.1rem;
         }

         .dashboard-grid {
             display: grid;
             grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
             gap: 25px;
             margin-bottom: 30px;
         }

         .card {
             background: rgba(255, 255, 255, 0.95);
             backdrop-filter: blur(10px);
             border-radius: 20px;
             padding: 25px;
             box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
             transition: all 0.3s ease;
             border: 1px solid rgba(255, 255, 255, 0.2);
         }

         .card:hover {
             transform: translateY(-5px);
             box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
         }

         .card-header {
             display: flex;
             align-items: center;
             margin-bottom: 20px;
             padding-bottom: 15px;
             border-bottom: 2px solid #e2e8f0;
         }

         .card-header i {
             font-size: 1.5rem;
             margin-left: 10px;
             padding: 10px;
             border-radius: 10px;
             background: linear-gradient(135deg, #667eea, #764ba2);
             color: white;
         }

         .card-header h3 {
             color: #2d3748;
             font-size: 1.3rem;
         }

         .stats-grid {
             display: grid;
             grid-template-columns: repeat(2, 1fr);
             gap: 15px;
         }

         .stat-item {
             text-align: center;
             padding: 15px;
             background: linear-gradient(135deg, #f7fafc, #edf2f7);
             border-radius: 12px;
             transition: all 0.3s ease;
         }

         .stat-item:hover {
             background: linear-gradient(135deg, #667eea, #764ba2);
             color: white;
             transform: scale(1.05);
         }

         .stat-number {
             font-size: 2rem;
             font-weight: bold;
             color: #2d3748;
             margin-bottom: 5px;
         }

         .stat-item:hover .stat-number {
             color: white;
         }

         .stat-label {
             font-size: 0.9rem;
             color: #718096;
         }

         .stat-item:hover .stat-label {
             color: rgba(255, 255, 255, 0.9);
         }

         .chart-container {
             position: relative;
             width: 100%;
             height: 300px;
             margin-top: 20px;
         }

         .table {
             width: 100%;
             margin-top: 20px;
             border-collapse: collapse;
         }

         .table th,
         .table td {
             padding: 12px;
             text-align: right;
             border-bottom: 1px solid #e2e8f0;
         }

         .table th {
             background: linear-gradient(135deg, #667eea, #764ba2);
             color: white;
             font-weight: 600;
         }

         .table tr:nth-child(even) {
             background: rgba(102, 126, 234, 0.05);
         }

         .table tr:hover {
             background: rgba(102, 126, 234, 0.1);
             transform: scale(1.02);
             transition: all 0.2s ease;
         }

         .progress-bar {
             width: 100%;
             height: 8px;
             background: #e2e8f0;
             border-radius: 4px;
             overflow: hidden;
             margin-top: 10px;
         }

         .progress-fill {
             height: 100%;
             background: linear-gradient(90deg, #667eea, #764ba2);
             border-radius: 4px;
             transition: width 0.3s ease;
         }

         .trend-up {
             color: #48bb78;
         }

         .trend-down {
             color: #f56565;
         }

         .heatmap {
             display: grid;
             grid-template-columns: repeat(24, 1fr);
             gap: 2px;
             margin-top: 15px;
         }

         .heatmap-cell {
             aspect-ratio: 1;
             border-radius: 2px;
             transition: all 0.2s ease;
         }

         .heatmap-cell:hover {
             transform: scale(1.2);
             z-index: 10;
         }

         .heat-low {
             background: #edf2f7;
         }

         .heat-medium {
             background: #90cdf4;
         }

         .heat-high {
             background: #4299e1;
         }

         .heat-very-high {
             background: #2b6cb0;
         }

         .alert {
             padding: 15px;
             border-radius: 10px;
             margin: 10px 0;
             border-right: 4px solid;
         }

         .alert-warning {
             background: #fef5e7;
             border-color: #f6ad55;
             color: #c05621;
         }

         .alert-error {
             background: #fed7d7;
             border-color: #f56565;
             color: #c53030;
         }

         .full-width {
             grid-column: 1 / -1;
         }

         @media (max-width: 768px) {
             .dashboard-grid {
                 grid-template-columns: 1fr;
             }

             .stats-grid {
                 grid-template-columns: 1fr;
             }

             .header h1 {
                 font-size: 2rem;
             }
         }
     </style>

     <body>
         <div class="container">
             <!-- Header -->
             <div class="header">
                 <h1><i class="fas fa-newspaper"></i> تحليلات واحصائيات الموقع الإخباري</h1>
                 <div class="date" id="currentDate"></div>
             </div>

             <!-- Dashboard Grid -->
             <div class="dashboard-grid">

                 <!-- 1. ملخص عام -->
                 <div class="card">
                     <div class="card-header">
                         <i class="fas fa-chart-line"></i>
                         <h3>ملخص عام</h3>
                     </div>
                     <div class="stats-grid">
                         <div class="stat-item">
                             <div class="stat-number">{{ $visitsToday }}</div>
                             <div class="stat-label">زوار اليوم</div>
                         </div>
                         <div class="stat-item">
                             <div class="stat-number">{{ $publishedPosts }}</div>
                             <div class="stat-label">مقالات اليوم</div>
                         </div>
                         <div class="stat-item">
                             <div class="stat-number">{{ $totalViews }}</div>
                             <div class="stat-label">مشاهدات اليوم</div>
                         </div>
                         <div class="stat-item">
                             <div class="stat-number">3:42</div>
                             <div class="stat-label">متوسط الجلسة</div>
                         </div>
                         <div class="stat-item">
                             <div class="stat-number">{{ $commentsCount }}</div>
                             <div class="stat-label">تعليقات جديدة</div>
                         </div>
                         <div class="stat-item">
                             <div class="stat-number">0</div>
                             <div class="stat-label">مسجات تواصل</div>
                         </div>

                     </div>
                 </div>

                 <!-- 2. إحصائيات الزوار -->
                 <div class="card">
                     <div class="card-header">
                         <i class="fas fa-users"></i>
                         <h3>إحصائيات الزوار</h3>
                     </div>
                     <div class="chart-container">
                         <canvas id="visitorsChart"></canvas>
                     </div>
                 </div>

                 <!-- 3. مصادر الزيارات -->
                 <div class="card">
                     <div class="card-header">
                         <i class="fas fa-share-alt"></i>
                         <h3>مصادر الزيارات</h3>
                     </div>
                     <div class="chart-container">
                         <canvas id="trafficSourcesChart"></canvas>
                     </div>
                 </div>

                 <!-- 4. الخريطة الحرارية -->
                 <div class="card">
                     <div class="card-header">
                         <i class="fas fa-fire"></i>
                         <h3>الخريطة الحرارية (24 ساعة)</h3>
                     </div>
                     <div class="heatmap" id="heatmap"></div>
                     <div style="margin-top: 10px; font-size: 0.8rem; color: #718096;">
                         <span class="heat-low"
                             style="display: inline-block; width: 12px; height: 12px; margin-left: 5px;"></span>منخفض
                         <span class="heat-medium"
                             style="display: inline-block; width: 12px; height: 12px; margin: 0 5px;"></span>متوسط
                         <span class="heat-high"
                             style="display: inline-block; width: 12px; height: 12px; margin: 0 5px;"></span>عالي
                         <span class="heat-very-high"
                             style="display: inline-block; width: 12px; height: 12px; margin: 0 5px;"></span>عالي جداً
                     </div>
                 </div>

                 <!-- 5. أداء الأخبار والمقالات -->
                 <div class="card full-width">
                     <div class="card-header">
                         <i class="fas fa-newspaper"></i>
                         <h3>أداء الأخبار والمقالات</h3>
                     </div>
                     <table class="table">
                         <thead>
                             <tr>
                                 <th>عنوان المقال</th>
                                 <th>المشاهدات</th>
                                 <th>التعليقات</th>
                                 <th>المشاركات</th>
                                 <th>وقت القراءة</th>
                                 <th>الكاتب</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td>أحدث التطورات في التكنولوجيا الذكية</td>
                                 <td>1,247</td>
                                 <td>23</td>
                                 <td>89</td>
                                 <td>4:32</td>
                                 <td>أحمد محمد</td>
                             </tr>
                             <tr>
                                 <td>تقرير شامل عن الاقتصاد العالمي</td>
                                 <td>934</td>
                                 <td>17</td>
                                 <td>56</td>
                                 <td>6:15</td>
                                 <td>فاطمة علي</td>
                             </tr>
                             <tr>
                                 <td>آخر أخبار الرياضة المحلية</td>
                                 <td>1,456</td>
                                 <td>31</td>
                                 <td>124</td>
                                 <td>3:22</td>
                                 <td>محمد سالم</td>
                             </tr>
                             <tr>
                                 <td>تحليل الأوضاع السياسية الراهنة</td>
                                 <td>2,134</td>
                                 <td>45</td>
                                 <td>178</td>
                                 <td>7:41</td>
                                 <td>سارة أحمد</td>
                             </tr>
                             <tr>
                                 <td>دليل شامل للصحة والتغذية</td>
                                 <td>876</td>
                                 <td>19</td>
                                 <td>67</td>
                                 <td>5:18</td>
                                 <td>د. خالد يوسف</td>
                             </tr>
                         </tbody>
                     </table>
                 </div>

                 <!-- 6. أداء المحررين -->
                 <div class="card">
                     <div class="card-header">
                         <i class="fas fa-pen"></i>
                         <h3>أداء المحررين</h3>
                     </div>
                     <div style="margin-top: 15px;">
                         <div style="margin-bottom: 15px;">
                             <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                 <span>أحمد محمد</span>
                                 <span>8 مقالات</span>
                             </div>
                             <div class="progress-bar">
                                 <div class="progress-fill" style="width: 80%;"></div>
                             </div>
                         </div>
                         <div style="margin-bottom: 15px;">
                             <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                 <span>فاطمة علي</span>
                                 <span>6 مقالات</span>
                             </div>
                             <div class="progress-bar">
                                 <div class="progress-fill" style="width: 60%;"></div>
                             </div>
                         </div>
                         <div style="margin-bottom: 15px;">
                             <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                 <span>محمد سالم</span>
                                 <span>10 مقالات</span>
                             </div>
                             <div class="progress-bar">
                                 <div class="progress-fill" style="width: 100%;"></div>
                             </div>
                         </div>
                         <div style="margin-bottom: 15px;">
                             <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                 <span>سارة أحمد</span>
                                 <span>4 مقالات</span>
                             </div>
                             <div class="progress-bar">
                                 <div class="progress-fill" style="width: 40%;"></div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <!-- 7. توزيع الزوار جغرافياً -->
                 <div class="card">
                     <div class="card-header">
                         <i class="fas fa-globe"></i>
                         <h3>توزيع الزوار جغرافياً</h3>
                     </div>
                     <div class="chart-container">
                         <canvas id="geographicChart"></canvas>
                     </div>
                 </div>

                 <!-- 8. أداء الإعلانات -->
                 <div class="card">
                     <div class="card-header">
                         <i class="fas fa-ad"></i>
                         <h3>أداء الإعلانات</h3>
                     </div>
                     <div class="stats-grid">
                         <div class="stat-item">
                             <div class="stat-number">45,678</div>
                             <div class="stat-label">ظهور الإعلانات</div>
                         </div>
                         <div class="stat-item">
                             <div class="stat-number">1,234</div>
                             <div class="stat-label">النقرات</div>
                         </div>
                         <div class="stat-item">
                             <div class="stat-number">2.7%</div>
                             <div class="stat-label">معدل النقر</div>
                         </div>
                         <div class="stat-item">
                             <div class="stat-number">$125.50</div>
                             <div class="stat-label">الأرباح اليوم</div>
                         </div>
                     </div>
                 </div>

                 <!-- 9. الأخطاء والتقارير -->
                 <div class="card full-width">
                     <div class="card-header">
                         <i class="fas fa-exclamation-triangle"></i>
                         <h3>الأخطاء والتقارير</h3>
                     </div>
                     <div class="alert alert-warning">
                         <i class="fas fa-exclamation-triangle"></i>
                         <strong>تحذير:</strong> تم العثور على 3 روابط مكسورة في المقالات المنشورة اليوم
                     </div>
                     <div class="alert alert-error">
                         <i class="fas fa-times-circle"></i>
                         <strong>خطأ:</strong> 15 محاولة وصول لصفحة 404 في آخر ساعة
                     </div>
                     <table class="table">
                         <thead>
                             <tr>
                                 <th>نوع المشكلة</th>
                                 <th>العدد</th>
                                 <th>آخر حدوث</th>
                                 <th>الحالة</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td>صفحات 404</td>
                                 <td>15</td>
                                 <td>منذ 5 دقائق</td>
                                 <td><span style="color: #f56565;">يحتاج إصلاح</span></td>
                             </tr>
                             <tr>
                                 <td>روابط مكسورة</td>
                                 <td>3</td>
                                 <td>منذ ساعة</td>
                                 <td><span style="color: #f6ad55;">قيد المراجعة</span></td>
                             </tr>
                             <tr>
                                 <td>تعليقات مرفوضة</td>
                                 <td>8</td>
                                 <td>منذ 30 دقيقة</td>
                                 <td><span style="color: #48bb78;">تم المعالجة</span></td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>

         <script>
             // تحديث التاريخ والوقت
             function updateDateTime() {
                 const now = new Date();
                 const options = {
                     weekday: 'long',
                     year: 'numeric',
                     month: 'long',
                     day: 'numeric',
                     hour: '2-digit',
                     minute: '2-digit'
                 };
                 document.getElementById('currentDate').textContent = now.toLocaleDateString('ar-SA', options);
             }
             updateDateTime();
             setInterval(updateDateTime, 60000);


             const dataFromLaravel = @json($visitsPerDay);
             const labels = dataFromLaravel.map(item => item.day);
             const counts = dataFromLaravel.map(item => item.count);

             const ctx = document.getElementById('visitorsChart').getContext('2d');
             new Chart(ctx, {
                 type: 'line',
                 data: {
                     labels: labels,
                     datasets: [{
                         label: 'عدد الزوار',
                         data: counts,
                         borderColor: 'rgb(75, 192, 192)',
                         tension: 0.3,
                         fill: true,
                         backgroundColor: 'rgba(75, 192, 192, 0.1)'
                     }]
                 },
                 options: {
                     responsive: true,
                     plugins: {
                         legend: {
                             position: 'top'
                         }
                     },
                     scales: {
                         y: {
                             beginAtZero: true
                         }
                     }
                 }
             });
         </script>
         <script>
             // رسم بياني للتوزيع الجغرافي
             const geoCtx = document.getElementById('geographicChart').getContext('2d');

             new Chart(geoCtx, {
                 type: 'bar',
                 data: {
                     labels: ['مصر', 'السعودية', 'الإمارات', 'الكويت', 'قطر'],
                     datasets: [{
                         label: 'عدد الزوار',
                         data: [850, 620, 380, 280, 190],
                         backgroundColor: [
                             '#667eea',
                             '#764ba2',
                             '#f093fb',
                             '#f5576c',
                             '#4facfe'
                         ]
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
                     scales: {
                         y: {
                             beginAtZero: true
                         }
                     }
                 }
             });

             // إنشاء خريطة حرارية تمثل كثافة الزوار على مدار 24 ساعة
             function createHeatmap() {
                 const heatmap = document.getElementById('heatmap');
                 const hours = 24;

                 // مسح العناصر السابقة إذا وُجدت (لإعادة إنشاء الخريطة)
                 heatmap.innerHTML = '';

                 for (let i = 0; i < hours; i++) {
                     const cell = document.createElement('div');
                     cell.className = 'heatmap-cell';

                     // توليد شدة عشوائية لمحاكاة البيانات
                     const intensity = Math.random();

                     if (intensity < 0.25) {
                         cell.classList.add('heat-low');
                     } else if (intensity < 0.5) {
                         cell.classList.add('heat-medium');
                     } else if (intensity < 0.75) {
                         cell.classList.add('heat-high');
                     } else {
                         cell.classList.add('heat-very-high');
                     }

                     const visitors = Math.round(intensity * 1000);
                     cell.title = `الساعة ${i}:00 - ${visitors} زائر`;
                     heatmap.appendChild(cell);
                 }
             }

             // إنشاء الخريطة الحرارية عند التحميل
             createHeatmap();

             // تحديث الخريطة الحرارية كل 30 ثانية (محاكاة تحديث)
             setInterval(() => {
                 console.log('تحديث الخريطة الحرارية...');
                 createHeatmap();
             }, 30000);
         </script>
     @endsection
