<div class="nav-wrapper">
    <nav class="top-navbar">
        <div class="navbar-container">
            <ul class="navbar-nav">

                {{-- القسم الرئيسي --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-home me-1"></i> {{ __('admin.home') }}
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="">{{ __('admin.home') }}</a></li>
                        <li><a class="dropdown-item" href="">{{ __('admin.analytics') }}</a></li>
                    </ul>
                </li>
                {{-- المشاريع --}}
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-newspaper me-1"></i> {{ __('admin.project_management') }}
                    </a>
                    <ul class="dropdown-menu shadow {{ app()->getLocale() === 'ar' ? 'text-end' : '' }}">
                        <li><a class="dropdown-item" href="{{ route('categories.index') }}">{{ __('admin.categories') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('projects.index') }}">{{ __('admin.projects') }}</a></li>
                        <li><a class="dropdown-item" href="#">{{__('admin.clients')}}</a></li>
                    </ul>
                </li>


                {{-- المستخدمين --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-users me-1"></i> {{ __('admin.user_management') }}
                    </a>
                    <ul class="dropdown-menu shadow {{ app()->getLocale() === 'ar' ? 'text-end' : '' }}">
                       <li><a class="dropdown-item" href="{{ route('investors.index') }}">{{ __('admin.investors') }}</a>
                        </li>
                        <li><a class="dropdown-item" href="">{{ __('admin.borrowers') }}</a>
                        </li>
                    </ul>
                </li>
                {{-- الاستثمارات والأرباح --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-users me-1"></i> {{ __('admin.investments_profits') }}
                    </a>
                    <ul class="dropdown-menu shadow {{ app()->getLocale() === 'ar' ? 'text-end' : '' }}">
                        <li><a class="dropdown-item" href="">{{ __('admin.manage_investments') }}</a>
                        </li>
                        <li><a class="dropdown-item" href="">{{ __('admin.profits') }}</a>
                        </li>
                    </ul>
                </li>
                {{-- المعاملات المالية --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-users me-1"></i> {{ __('admin.financial_transactions') }}
                    </a>
                    <ul class="dropdown-menu shadow {{ app()->getLocale() === 'ar' ? 'text-end' : '' }}">
                        <li><a class="dropdown-item" href=""> {{ __('admin.transfers') }}</a>
                        </li>
                        <li><a class="dropdown-item" href=""> {{ __('admin.repayment_management') }}</a>
                        </li>
                    </ul>
                </li>
                {{--  الرسائل --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-envelope me-1"></i> {{ __('admin.support_messages') }}
                    </a>
                    <ul class="dropdown-menu shadow {{ app()->getLocale() === 'ar' ? 'text-end' : '' }}">
                        <li><a class="dropdown-item" href="{{ route('support.index') }}"> {{ __('admin.contact_messages') }}</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('reviews.index') }}"> {{ __('admin.investor_reviews') }}</a></li>
                    </ul>
                </li>

                {{-- الإعدادات --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cogs me-1"></i> {{ __('admin.settings_reports') }}
                    </a>
                    <ul class="dropdown-menu shadow {{ app()->getLocale() === 'ar' ? 'text-end' : '' }}">
                        <li><a class="dropdown-item" href="#">{{ __('admin.advanced_settings') }}</a></li>
                        <li><a class="dropdown-item" href="#"> {{ __('admin.reports_analytics') }}</a></li>
                        <li><a class="dropdown-item" href="#"> {{ __('admin.activity_log') }}</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</div>
