<!-- My Projects Section -->
<h3 class="section-title">مشاريعي</h3>

<div class="project-cards-container">
    @foreach ($projects as $project)
        <!-- Project 1 -->
        <div class="project-card">
            <div class="project-card-header">
                <div class="project-info">
                    <div class="project-tags">
                        <span class="project-tag tag-new">
                            <i class="fas fa-bolt"></i> جديد
                        </span>
                    </div>
                    <h4 class="project-title"> {{ $project->title }}</h4>
                    <p class="project-date"><i class="fas fa-calendar me-2"></i> تاريخ التقديم:
                        {{ $project->created_at->format('d M Y') }}</p>
                </div>

                <span class="status-badge {{ $project->status_badge['class'] }}">
                    {{ $project->status_badge['label'] }}
                </span>

            </div>

            <div class="project-details">
                <div class="detail-item">
                    <span class="detail-label">نوع القطاع</span>
                    <span class="sector-badge">{{ $project->category->name }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">المبلغ المطلوب</span>
                    <span class="detail-value">{{ $project->funding_goal }}</span>
                </div>
                {{-- <div class="detail-item">
                <span class="detail-label">الضمان</span>
                <span class="sector-badge">شخصي</span>
            </div> --}}
                <div class="detail-item">
                    <span class="detail-label">مدة السداد</span>
                    <span class="detail-value"> {{ $project->term_months }}شهر</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">الحد الأدنى للاستثمار</span>
                    <span class="detail-value">{{ number_format($project->min_investment) }} ريال</span>
                </div>
            </div>

            @php
                $percentage =
                    $project->funding_goal > 0 ? round(($project->funded_amount / $project->funding_goal) * 100) : 0;
            @endphp

            <div class="progress-wrapper">
                <div class="progress-header">
                    <span class="progress-percentage">نسبة التمويل: {{ $percentage }}%</span>
                    <span class="progress-amount">{{ number_format($project->funded_amount) }} من
                        {{ number_format($project->funding_goal) }} ريال</span>
                </div>

                <div class="progress-bar-container" role="progressbar" aria-valuenow="{{ $percentage }}"
                    aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar-fill" data-percentage="{{ $percentage }}"></div>
                </div>
            </div>


            <div class="project-card-footer">
                <a href="{{ route('details', $project->id) }}" class="btn btn-outline-secondary px-3 py-2">
                    <i class="fas fa-eye me-1"></i> تفاصيل
                </a>
                <!-- زر تعديل المشروع -->
                <button onclick="editProject(this)" data-id="{{ $project->id }}" data-title="{{ $project->title }}"
                    data-category_id="{{ $project->category_id }}" data-funding_goal="{{ $project->funding_goal }}"
                    data-term_months="{{ $project->term_months }}" data-interest_rate="{{ $project->interest_rate }}"
                    data-min_investment="{{ $project->min_investment }}" data-summary="{{ $project->summary }}"
                    data-description="{{ $project->description }}" data-bs-toggle="modal"
                    data-bs-target="#fundingModal">تعديل</button>
            </div>
        </div>
    @endforeach

</div>


<!-- Support Chat Section -->
<h3 class="section-title">{{ __('auth.chat') }}</h3>
<div
    style="background: white; border-radius: 24px; padding: 2rem; box-shadow: var(--card-shadow); border: 1px solid #f1f5f9;">
    <div class="d-flex align-items-center mb-4">
        <div class="avatar me-3" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">اد</div>
        <div>
            <h5 class="mb-0" style="color: #0f172a;">{{ __('auth.support_team') }}</h5>
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
                <strong>{{ __('auth.system') }} </strong>
                <small class="text-muted">10:30</small>
            </div>
            <p class="mb-0">{{ __('auth.welcome_message') }}</p>
        </div>
        <div class="chat-message message-received">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong>{{ __('auth.support') }} </strong>
                <small class="text-muted">10:30</small>
            </div>
            <p class="mb-0"> {{ __('auth.support_greeting') }}</p>
        </div>
        <div class="chat-message message-sent">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong>{{ __('auth.you') }}</strong>
                <small class="text-white-50">10:32</small>
            </div>
            <p class="mb-0"> {{ __('auth.support_greeting') }}</p>
        </div>
        <div class="chat-message message-received">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong>{{ __('auth.support') }} </strong>
                <small class="text-muted">10:33</small>
            </div>
            <p class="mb-0">{{ __('auth.project_status_response') }}</p>
        </div>
    </div>
    <div class="input-group">
        <input type="text" class="form-control py-3" placeholder=" {{ __('auth.type_your_message') }}">
        <button class="btn btn-outline-secondary py-3 px-3" title="  {{ __('auth.attach_file') }}">
            <i class="fas fa-paperclip"></i>
        </button>
        <button class="btn btn-primary py-3 px-4">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="helpModalLabel">دليل تقديم المشروع</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 36px; height: 36px;">1</div>
                            <div>
                                <h6 class="mb-1">املأ نموذج المشروع</h6>
                                <p class="text-muted small mb-0">أدخل جميع تفاصيل مشروعك بدقة</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 36px; height: 36px;">2</div>
                            <div>
                                <h6 class="mb-1">ارفع المستندات المطلوبة</h6>
                                <p class="text-muted small mb-0">السجل التجاري، خطة العمل، وثائق الضمان</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 36px; height: 36px;">3</div>
                            <div>
                                <h6 class="mb-1">انتظر المراجعة</h6>
                                <p class="text-muted small mb-0">سيتم مراجعة طلبك خلال 48 ساعة عمل</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 36px; height: 36px;">4</div>
                            <div>
                                <h6 class="mb-1">ابدأ مرحلة التمويل</h6>
                                <p class="text-muted small mb-0">سيتم عرض مشروعك للمستثمرين</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">فهمت!</button>
            </div>
        </div>
    </div>
</div>

<!-- Funding Modal -->
<div class="modal fade" id="fundingModal" tabindex="-1" aria-labelledby="fundingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fundingModalLabel">نموذج طلب التمويل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>خطأ في النموذج:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                <form id="projectForm" method="post" action="{{ route('projects.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <!-- title -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">🏷️ اسم المشروع</label>
                        <input type="text"
                            class="form-control form-control-lg @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- category + funding_goal -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label fw-bold">🏭 نوع القطاع</label>
                            <select class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id" required>
                                <option value="">اختر القطاع</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="funding_goal" class="form-label fw-bold">💰 المبلغ المطلوب (ريال)</label>
                            <input type="number"
                                class="form-control form-control-lg @error('funding_goal') is-invalid @enderror"
                                id="funding_goal" name="funding_goal" min="1000"
                                value="{{ old('funding_goal') }}" required>
                            @error('funding_goal')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- term + interest -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="term_months" class="form-label fw-bold">⏳ مدة السداد (أشهر)</label>
                            <select class="form-select form-select-lg @error('term_months') is-invalid @enderror"
                                id="term_months" name="term_months" required>
                                <option value="">اختر المدة</option>
                                <option value="6" {{ old('term_months') == 6 ? 'selected' : '' }}>6 أشهر</option>
                                <option value="12" {{ old('term_months') == 12 ? 'selected' : '' }}>12 شهر
                                </option>
                                <option value="18" {{ old('term_months') == 18 ? 'selected' : '' }}>18 شهر
                                </option>
                                <option value="24" {{ old('term_months') == 24 ? 'selected' : '' }}>24 شهر
                                </option>
                                <option value="36" {{ old('term_months') == 36 ? 'selected' : '' }}>36 شهر
                                </option>
                            </select>
                            @error('term_months')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="col-md-4">
                            <label for="interest_rate" class="form-label fw-bold">📊 نسبة الفائدة (%)</label>
                            <input type="number" step="0.01"
                                class="form-control form-control-lg @error('interest_rate') is-invalid @enderror"
                                id="interest_rate" name="interest_rate" placeholder="مثال: 12" min="1"
                                max="50" value="{{ old('interest_rate') }}" required>
                            @error('interest_rate')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="min_investment" class="form-label fw-bold">📊 الحد الادنى للاستثمار
                                (ريال)</label>
                            <input type="number" step="0.01"
                                class="form-control form-control-lg @error('min_investment') is-invalid @enderror"
                                id="min_investment" name="min_investment" placeholder="مثال: 12" min="1000"
                                max="5000000" value="{{ old('min_investment') }}" required>
                            @error('min_investment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                    <!-- summary -->
                    <div class="mb-4">
                        <label for="summary" class="form-label fw-bold">🖋️ وصف مختصر للمشروع</label>
                        <textarea class="form-control form-control-lg @error('summary') is-invalid @enderror" id="summary" name="summary"
                            rows="3" required>{{ old('summary') }}</textarea>
                        @error('summary')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">📄 وصف تفصيلي (اختياري)</label>
                        <textarea class="form-control form-control-lg @error('description') is-invalid @enderror" id="description"
                            name="description" rows="5">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="mb-4">
                        <label for="projectImage" class="form-label fw-bold">🖼️ رفع صورة المشروع (اختياري)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                            id="projectImage" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gallery -->
                    <div class="mb-4">
                        <label for="projectGallery" class="form-label fw-bold">🖼️ رفع صور المشروع (اختياري)</label>
                        <input type="file" class="form-control @error('gallery') is-invalid @enderror"
                            id="projectGallery" name="gallery[]" multiple accept="image/*">
                        @error('gallery.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100" id="submitBtn">إرسال طلب
                        التمويل</button>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body py-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                <h3 class="mb-3">نجاح!</h3>
                <p class="text-muted fs-5"></p>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-primary btn-lg px-5" data-bs-dismiss="modal">حسنًا</button>
            </div>
        </div>
    </div>
</div>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();

            // وضع الرسالة من الـ session
            document.getElementById('successModal').querySelector('h3').innerText = 'نجاح!';
            document.getElementById('successModal').querySelector('p').innerText = '{{ session('success') }}';
        });
    </script>
@endif

<script>
    function createProject() {
        // إعادة ضبط الحقول
        const form = document.getElementById('projectForm');
        form.reset();
        form.action = "{{ route('projects.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('fundingModalLabel').innerText = 'نموذج طلب التمويل';
        document.getElementById('submitBtn').innerText = 'إرسال طلب التمويل';
        // ضبط رسالة النجاح
        document.getElementById('successModal').querySelector('h3').innerText = 'تم إرسال مشروعك بنجاح!';
        document.getElementById('successModal').querySelector('p').innerText =
            'سيتم مراجعة طلبك خلال 48 ساعة، وستصلك إشعارات بالتحديثات.';
    }

    function editProject(button) {
        const form = document.getElementById('projectForm');
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const category_id = button.getAttribute('data-category_id');
        const funding_goal = button.getAttribute('data-funding_goal');
        const term_months = button.getAttribute('data-term_months');
        const interest_rate = button.getAttribute('data-interest_rate');
        const min_investment = button.getAttribute('data-min_investment');
        const summary = button.getAttribute('data-summary');
        const description = button.getAttribute('data-description');

        // ملء الحقول
        document.getElementById('title').value = title;
        document.getElementById('category_id').value = category_id;
        document.getElementById('funding_goal').value = funding_goal;
        document.getElementById('term_months').value = term_months;
        document.getElementById('interest_rate').value = interest_rate;
        document.getElementById('min_investment').value = min_investment;
        document.getElementById('summary').value = summary;
        document.getElementById('description').value = description;

        // تغيير action للفورم ليصبح PUT
        form.action = `/projects/${id}`;
        document.getElementById('formMethod').value = 'PUT';

        // تغيير نصوص المودال
        document.getElementById('fundingModalLabel').innerText = 'تعديل طلب التمويل';
        document.getElementById('submitBtn').innerText = 'تعديل المشروع';

        // ضبط رسالة النجاح الخاصة بالتعديل
        document.getElementById('successModal').querySelector('h3').innerText = 'تم تعديل المشروع بنجاح!';
        document.getElementById('successModal').querySelector('p').innerText =
            'تم تعديل المشروع بنجاح! بانتظار الموافقة.';
    }
</script>
