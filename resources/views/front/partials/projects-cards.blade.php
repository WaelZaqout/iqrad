@forelse ($projects as $project)
    <div class="project-card">
        <div class="project-thumbnail">
            @if (!empty($project->image))
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
            @else
                <div class="placeholder">
                    <i class="fas fa-briefcase fa-2x"></i>
                    <div style="font-weight:800;margin-top:6px;color:var(--primary)">
                        {{ $project->category->name }}
                    </div>
                </div>
            @endif

            <span class="status-badge {{ $project->status_badge['class'] }}">
                {{ $project->status_badge['label'] }}
            </span>
        </div>

        <div class="project-header">
            <h4 class="project-title">{{ $project->title }}</h4>
            <div class="project-purpose">
                <i class="fas fa-tag text-primary"></i>
                {{ $project->category->name }}
            </div>
        </div>

        <div class="project-details">
            <div class="project-info">
                <div class="info-item">
                    <div class="info-label">{{ __('auth.interest_rate') }}</div>
                    <div class="info-value" style="color: var(--primary)">
                        {{ $project->interest_rate }}%
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">{{ __('auth.duration') }}</div>
                    <div class="info-value">
                        {{ $project->term_months }} {{ __('auth.month') }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">{{ __('auth.min_investment') }}</div>
                    <div class="info-value">{{ $project->min_investment }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">{{ __('auth.funding_goal') }}</div>
                    <div class="info-value">{{ $project->funding_goal }}</div>
                </div>
            </div>

            <div class="progress-container-wrapper">
                <div class="progress-header">
                    <span>{{ __('auth.collected') }} {{ $project->percentage }}%</span>
                    <span>
                        {{ $project->funded_amount }} /
                        {{ $project->funding_goal }}
                        {{ __('auth.sar') }}
                    </span>
                </div>

                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $project->percentage }}%"></div>
                </div>
            </div>

            <div class="card-actions">
                <a href="{{ route('details', $project->id) }}" class="details-btn">
                    <i class="far fa-eye"></i> {{ __('auth.details') }}
                </a>
                @can('edit_project_before_approval', $project)
                    <button class="edit-btn" onclick="editProject(this)" data-id="{{ $project->id }}"
                        data-title_en="{{ $project->title_en }}" data-title_ar="{{ $project->title_ar }}"
                        data-category_id="{{ $project->category_id }}" data-funding_goal="{{ $project->funding_goal }}"
                        data-term_months="{{ $project->term_months }}" data-interest_rate="{{ $project->interest_rate }}"
                        data-min_investment="{{ $project->min_investment }}" data-summary_en="{{ $project->summary_en }}"
                        data-summary_ar="{{ $project->summary_ar }}" data-description_en="{{ $project->description_en }}"
                        data-description_ar="{{ $project->description_ar }}" data-bs-toggle="modal"
                        data-bs-target="#fundingModal">
                        <i class="fas fa-edit"></i> {{ __('auth.edit') }}
                    </button>
                @endcan
                @guest
                    <button class="invest-btn open-auth" data-tab="login">
                        <i class="fas fa-coins"></i>
                        {{ __('auth.login_to_invest') }}
                    </button>
                @else
                    @can('make_investment')
                        @if ($project->percentage >= 100 || $project->status === 'completed')
                            <button class="invest-btn completed" disabled>
                                <i class="fas fa-check-circle"></i>
                                {{ __('auth.completed') }}
                            </button>
                        @else
                            <button class="invest-btn" onclick="openInvestModal(this)" data-id="{{ $project->id }}"
                                data-title="{{ $project->title }}" data-min="{{ $project->min_investment }}"
                                data-rate="{{ $project->interest_rate }}">
                                <i class="fas fa-coins"></i>
                                {{ __('auth.invest_now') }}
                            </button>
                        @endif
                    @endcan
                @endguest
            </div>

        </div>
    </div>
@empty
    <div class="no-projects">
        <i class="fas fa-folder-open"></i>
        <h4>{{ __('auth.no_projects_found') }}</h4>
        <p>{{ __('auth.try_other_filters') }}</p>
    </div>
@endforelse
