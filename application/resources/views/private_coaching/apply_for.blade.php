@extends('layouts.private_coaching_auth_layout')
@section('content')

<style>
    .option-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 14px !important;
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }
    .option-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.09);
    }
    .option-card.disabled {
        opacity: 0.6;
        pointer-events: none;
        cursor: not-allowed;
        background: #f8fafc;
    }
    .category-icon-box {
        width: 72px;
        height: 72px;
        border-radius: 50% !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        transition: transform 0.25s ease;
    }
    .option-card:hover .category-icon-box {
        transform: scale(1.08);
    }
    .category-icon-box i {
        color: #ffffff !important;
        font-size: 28px !important;
        line-height: 1 !important;
    }
    .category-icon-box.icon-academy {
        background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
    }
    .category-icon-box.icon-association {
        background: linear-gradient(135deg, #16a34a, #15803d) !important;
    }
    .category-icon-box.icon-gym {
        background: linear-gradient(135deg, #dc2626, #b91c1c) !important;
    }
    .category-icon-box.icon-swimming {
        background: linear-gradient(135deg, #0284c7, #0369a1) !important;
    }
</style>

<div class="container-fluid pagecontentbody">
    <div class="tab-content">
        <div class="pagebody removebg-color">
            <div class="pageheader d-flex justify-content-between align-items-center flex-wrap" id="menu-margin" style="padding: 14px 0; margin-bottom: 22px; border-bottom: 1px solid #e2e8f0;">
                <div>
                    <h4 class="mb-1 text-dark fw-bold" style="font-size: 1.25rem;">
                        <i class="fa fa-th-large text-primary me-2"></i> Apply For Registration / पंजीकरण हेतु आवेदन करें
                    </h4>
                    <small class="text-muted">Select the institution category for which you want to submit your online registration.</small>
                </div>
                <div class="mt-2 mt-md-0">
                    <a class="btn btn-outline-success btn-sm rounded-pill px-3 shadow-sm" href="{{ route('private_coaching_dashboard') }}" style="font-weight: 600;">
                        <i class="fa fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                </div>
            </div>

            <div class="row g-4 py-2">

                {{-- Temporarily commented out: Coaching Academies and Sports Associations
                Card: Academies
                <div class="col-md-3 col-sm-6">
                    <div class="card option-card shadow-sm h-100 {{ $applied['academies'] ? 'disabled' : '' }}">
                        @unless($applied['academies']) <a href="{{ route('private_coaching_academies') }}" class="text-decoration-none text-dark h-100 d-flex flex-column"> @endunless
                        <div class="card-body text-center p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="category-icon-box icon-academy">
                                    <i class="fa fa-graduation-cap"></i>
                                </div>
                                <h5 class="card-title fw-bold text-dark mb-2">Coaching Academies</h5>
                                <p class="text-muted small mb-3">
                                    Apply for private coaching academy recognition and operational license.
                                </p>
                            </div>
                            <div>
                                @if($applied['academies'])
                                    <span class="badge bg-secondary rounded-pill px-3 py-2"><i class="fa fa-check me-1"></i> Already Applied</span>
                                @else
                                    <span class="btn btn-primary btn-sm rounded-pill px-4">Apply Now <i class="fa fa-arrow-right ms-1"></i></span>
                                @endif
                            </div>
                        </div>
                        @unless($applied['academies']) </a> @endunless
                    </div>
                </div>

                Card: Associations
                <div class="col-md-3 col-sm-6">
                    <div class="card option-card shadow-sm h-100 {{ $applied['associations'] ? 'disabled' : '' }}">
                        @unless($applied['associations']) <a href="{{ route('private_coaching_application_form') }}" class="text-decoration-none text-dark h-100 d-flex flex-column"> @endunless
                        <div class="card-body text-center p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="category-icon-box icon-association">
                                    <i class="fa fa-users"></i>
                                </div>
                                <h5 class="card-title fw-bold text-dark mb-2">Sports Associations</h5>
                                <p class="text-muted small mb-3">
                                    Register and affiliate your state/district sports association with the department.
                                </p>
                            </div>
                            <div>
                                @if($applied['associations'])
                                    <span class="badge bg-secondary rounded-pill px-3 py-2"><i class="fa fa-check me-1"></i> Already Applied</span>
                                @else
                                    <span class="btn btn-success btn-sm rounded-pill px-4">Apply Now <i class="fa fa-arrow-right ms-1"></i></span>
                                @endif
                            </div>
                        </div>
                        @unless($applied['associations']) </a> @endunless
                    </div>
                </div>
                --}}

                {{-- Card: Gyms --}}
                <div class="col-md-6 col-sm-6">
                    <div class="card option-card shadow-sm h-100 {{ $applied['gyms'] ? 'disabled' : '' }}">
                        @unless($applied['gyms']) <a href="{{ route('private_coaching_gyms') }}" class="text-decoration-none text-dark h-100 d-flex flex-column"> @endunless
                        <div class="card-body text-center p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="category-icon-box icon-gym">
                                    <i class="fa fa-heartbeat"></i>
                                </div>
                                <h5 class="card-title fw-bold text-dark mb-2">Gyms & Fitness Centers</h5>
                                <p class="text-muted small mb-3">
                                    Submit online application for private gym safety certification and registration.
                                </p>
                            </div>
                            <div>
                                @if($applied['gyms'])
                                    <span class="badge bg-secondary rounded-pill px-3 py-2"><i class="fa fa-check me-1"></i> Already Applied</span>
                                @else
                                    <span class="btn btn-danger btn-sm rounded-pill px-4">Apply Now <i class="fa fa-arrow-right ms-1"></i></span>
                                @endif
                            </div>
                        </div>
                        @unless($applied['gyms']) </a> @endunless
                    </div>
                </div>

                {{-- Card: Swimming Pools --}}
                <div class="col-md-6 col-sm-6">
                    <div class="card option-card shadow-sm h-100 {{ $applied['swimming'] ? 'disabled' : '' }}">
                        @unless($applied['swimming']) <a href="{{ route('private_coaching_swimming_pool') }}" class="text-decoration-none text-dark h-100 d-flex flex-column"> @endunless
                        <div class="card-body text-center p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="category-icon-box icon-swimming">
                                    <i class="fa fa-life-ring"></i>
                                </div>
                                <h5 class="card-title fw-bold text-dark mb-2">Swimming Pools</h5>
                                <p class="text-muted small mb-3">
                                    Apply for swimming pool inspection, safety guidelines clearance, and registration.
                                </p>
                            </div>
                            <div>
                                @if($applied['swimming'])
                                    <span class="badge bg-secondary rounded-pill px-3 py-2"><i class="fa fa-check me-1"></i> Already Applied</span>
                                @else
                                    <span class="btn btn-info text-white btn-sm rounded-pill px-4">Apply Now <i class="fa fa-arrow-right ms-1"></i></span>
                                @endif
                            </div>
                        </div>
                        @unless($applied['swimming']) </a> @endunless
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
