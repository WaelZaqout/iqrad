<!-- My Projects Section -->
<h3 class="section-title">{{ __('auth.my_project') }}</h3>

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


<!-- Support Chat Section -->
<h3 class="section-title">{{ __('auth.chat') }}</h3>

<div
    style="background: white; border-radius: 24px; padding: 2rem; box-shadow: var(--card-shadow); border: 1px solid #f1f5f9;">
    <div class="d-flex align-items-center mb-4">
        <div class="avatar me-3" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">اد</div>
        <div>
            <h5 class="mb-0">{{ __('auth.support_and_help') }}</h5>
            <small class="text-success"><i class="fas fa-circle me-1"></i> Online</small>
        </div>
    </div>

    <div
        style="min-height: 250px; max-height: 350px; overflow-y: auto; padding: 1.5rem; background: #f8fafc; border-radius: 18px; margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
        @if ($conversation)
            @foreach ($conversation->messages as $msg)
                <div class="chat-message {{ $msg->sender_id == auth()->id() ? 'message-sent' : 'message-received' }}">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong>{{ $msg->sender_id == auth()->id() ? __('auth.you') : __('auth.support') }}</strong>
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="projectForm" method="post" action="{{ route('projects.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <!-- ========================== Title EN / AR ========================== -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title_en" class="form-label fw-bold">🏷️
                                {{ __('auth.project_name_en') }}</label>
                            <input type="text"
                                class="form-control form-control-lg @error('title_en') is-invalid @enderror"
                                id="title_en" name="title_en" value="{{ old('title_en') }}" required>
                            @error('title_en')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="title_ar" class="form-label fw-bold">🏷️
                                {{ __('auth.project_name_ar') }}</label>
                            <input type="text"
                                class="form-control form-control-lg @error('title_ar') is-invalid @enderror"
                                id="title_ar" name="title_ar" value="{{ old('title_ar') }}" required>
                            @error('title_ar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- ========================== Summary EN / AR ========================== -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="summary_en" class="form-label fw-bold">🖋️
                                {{ __('auth.summary_en') }}</label>
                            <textarea class="form-control @error('summary_en') is-invalid @enderror" id="summary_en" name="summary_en"
                                rows="3" required>{{ old('summary_en') }}</textarea>
                            @error('summary_en')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="summary_ar" class="form-label fw-bold">🖋️
                                {{ __('auth.summary_ar') }}</label>
                            <textarea class="form-control @error('summary_ar') is-invalid @enderror" id="summary_ar" name="summary_ar"
                                rows="3" required>{{ old('summary_ar') }}</textarea>
                            @error('summary_ar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- ========================== Description EN / AR ========================== -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="description_en" class="form-label fw-bold">📄
                                {{ __('auth.description_en') }}</label>
                            <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en"
                                name="description_en" rows="5">{{ old('description_en') }}</textarea>
                            @error('description_en')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="description_ar" class="form-label fw-bold">📄
                                {{ __('auth.description_ar') }}</label>
                            <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar"
                                name="description_ar" rows="5">{{ old('description_ar') }}</textarea>
                            @error('description_ar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- ========================== Category + Funding Goal ========================== -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label fw-bold">{{ __('auth.sector_label') }}</label>
                            <select class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id" required>
                                <option value="">{{ __('auth.select_sector') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="funding_goal"
                                class="form-label fw-bold">{{ __('auth.funding_amount') }}</label>
                            <input type="number"
                                class="form-control form-control-lg @error('funding_goal') is-invalid @enderror"
                                id="funding_goal" name="funding_goal" min="1000"
                                value="{{ old('funding_goal') }}" required>
                            @error('funding_goal')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- ========================== Term + Interest + Min Investment ========================== -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="term_months"
                                class="form-label fw-bold">{{ __('auth.repayment_term') }}</label>
                            <select class="form-select form-select-lg @error('term_months') is-invalid @enderror"
                                id="term_months" name="term_months" required>
                                <option value="">{{ __('auth.select_term') }}</option>
                                @for ($i = 6; $i <= 36; $i += 6)
                                    <option value="{{ $i }}"
                                        {{ old('term_months') == $i ? 'selected' : '' }}>{{ $i }}
                                        {{ __('auth.month') }}</option>
                                @endfor
                            </select>
                            @error('term_months')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="interest_rate" class="form-label fw-bold">📊 {{ __('auth.interest_rate') }}
                                (%)</label>
                            <input type="number" step="0.01"
                                class="form-control form-control-lg @error('interest_rate') is-invalid @enderror"
                                id="interest_rate" name="interest_rate" placeholder="{{ __('auth.example') }}: 12"
                                min="1" max="50" value="{{ old('interest_rate') }}" required>
                            @error('interest_rate')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="min_investment" class="form-label fw-bold">📊
                                {{ __('auth.minimum_investment') }} ({{ __('auth.sar') }})</label>
                            <input type="number" step="0.01"
                                class="form-control form-control-lg @error('min_investment') is-invalid @enderror"
                                id="min_investment" name="min_investment" min="1000" max="5000000"
                                value="{{ old('min_investment') }}" required>
                            @error('min_investment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- ========================== Image + Gallery ========================== -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="projectImage" class="form-label fw-bold">🖼️
                                {{ __('auth.project_image') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="projectImage" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="projectGallery" class="form-label fw-bold">🖼️
                                {{ __('auth.project_gallery') }}</label>
                            <input type="file" class="form-control @error('gallery') is-invalid @enderror"
                                id="projectGallery" name="gallery[]" multiple accept="image/*">
                            @error('gallery.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100" id="submitBtn">
                        {{ __('auth.submit_funding_request') }}
                    </button>
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
