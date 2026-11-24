@php
$upLogo = asset('assets_admin/images/logo.png');
@endphp

<!-- ==========================================================================
     KHEL SATHI OFFICIAL GOVERNMENT PORTAL - ULTRA-SMOOTH GLOBAL LOADER
     Department of Sports, Government of Uttar Pradesh
     Features: Top Slim Progress Bar + Sleek Floating Capsule + Debounce Smoothing
     ========================================================================== -->
@if(!defined('KS_GLOBAL_LOADER_INCLUDED'))
@php define('KS_GLOBAL_LOADER_INCLUDED', true); @endphp
<style id="ksGlobalLoaderStyles">
    /* 1. Ultra-Slim Dynamic Top Glowing Progress Bar */
    #ksTopProgressBar {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 0% !important;
        height: 3.5px !important;
        background: linear-gradient(90deg, #f97316 0%, #ec4899 50%, #2563eb 100%) !important;
        box-shadow: 0 0 10px rgba(236, 72, 153, 0.7), 0 0 4px rgba(249, 115, 22, 0.8) !important;
        z-index: 999999999 !important;
        opacity: 0;
        pointer-events: none !important;
        transition: width 0.28s cubic-bezier(0.1, 0.9, 0.2, 1), opacity 0.22s ease !important;
        border-radius: 0 3px 3px 0 !important;
    }

    #ksTopProgressBar.active {
        opacity: 1 !important;
    }

    /* 2. Standalone Modern Overlay (No layout shifting or scrollbar locking) */
    .ks-loader-overlay {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: rgba(15, 23, 42, 0.28) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        z-index: 99999999 !important;
        display: none !important;
        align-items: center !important;
        justify-content: center !important;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.2s ease;
        margin: 0 !important;
        padding: 16px !important;
        box-sizing: border-box !important;
        pointer-events: auto !important;
        cursor: pointer !important;
    }

    .ks-loader-overlay.active {
        display: flex !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    /* 3. Ultra-Sleek Modern Floating Capsule (Pill Design) */
    .ks-global-loader-card {
        cursor: default !important;
        background: rgba(255, 255, 255, 0.96) !important;
        backdrop-filter: blur(20px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
        border: 1px solid rgba(226, 232, 240, 0.95) !important;
        border-radius: 50px !important;
        box-shadow: 0 16px 40px -10px rgba(15, 23, 42, 0.18),
                    0 0 0 1px rgba(255, 255, 255, 0.8) inset !important;
        padding: 9px 24px 9px 12px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 14px !important;
        position: relative !important;
        box-sizing: border-box !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        animation: ks-pill-pop 0.24s cubic-bezier(0.16, 1, 0.3, 1) !important;
        margin: 0 auto !important;
        user-select: none !important;
        max-width: 90vw !important;
    }

    @keyframes ks-pill-pop {
        0% { opacity: 0; transform: scale(0.92) translateY(6px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* 4. Emblem + Orbital Dual-Ring Spinner */
    .ks-loader-emblem-wrap {
        width: 40px !important;
        height: 40px !important;
        position: relative !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0 !important;
    }

    .ks-spinner-ring.outer {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        border-radius: 50% !important;
        border: 2.5px solid transparent !important;
        border-top-color: #f97316 !important;  /* UP Saffron */
        border-right-color: #ec4899 !important; /* Brand Rose/Pink */
        border-bottom-color: #2563eb !important; /* Royal Blue */
        animation: ks-spin 1.1s cubic-bezier(0.5, 0.1, 0.4, 0.9) infinite !important;
        box-sizing: border-box !important;
    }

    @keyframes ks-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .ks-emblem-circle {
        width: 28px !important;
        height: 28px !important;
        background: #ffffff !important;
        border-radius: 50% !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 2 !important;
        overflow: hidden !important;
        padding: 3px !important;
        box-sizing: border-box !important;
    }

    .ks-emblem-img {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain !important;
        display: block !important;
    }

    /* 5. Typography Column */
    .ks-loader-content {
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        justify-content: center !important;
        line-height: 1.25 !important;
    }

    .ks-loader-title {
        font-size: 11px !important;
        font-weight: 800 !important;
        letter-spacing: 0.8px !important;
        color: #0f172a !important;
        text-transform: uppercase !important;
        margin-bottom: 2px !important;
    }

    .ks-loader-status {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #475569 !important;
        letter-spacing: 0.15px !important;
    }

    .ks-status-dot {
        width: 6.5px !important;
        height: 6.5px !important;
        border-radius: 50% !important;
        background: #ec4899 !important;
        display: inline-block !important;
        animation: ks-dot-pulse 1.3s ease-in-out infinite !important;
        flex-shrink: 0 !important;
    }

    @keyframes ks-dot-pulse {
        0% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.7); }
        70% { transform: scale(1.15); box-shadow: 0 0 0 5px rgba(236, 72, 153, 0); }
        100% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(236, 72, 153, 0); }
    }

    /* 6. Page Content Transition Smoothing (Target only the inner body, NEVER .contentwraper so fixed sidebar remains pristine!) */
    .pagecontentbody {
        animation: ksContentFadeIn 0.22s ease-out !important;
    }

    @keyframes ksContentFadeIn {
        0% {
            opacity: 0.92;
        }
        100% {
            opacity: 1;
        }
    }

    /* 7. Subtle Table Inline Loading State (Never blocks the screen!) */
    .ks-table-loading {
        opacity: 0.55 !important;
        pointer-events: none !important;
        transition: opacity 0.2s ease !important;
    }

    /* ==========================================================================
       8. PERMANENT DESTRUCTION OF LEGACY LOADER & BLOCKUI OVERRIDES
       ========================================================================== */
    .blockUI.blockMsg.blockPage {
        display: none !important;
        border: none !important;
        background: transparent !important;
        background-color: transparent !important;
        width: 0 !important;
        height: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .blockUI.blockOverlay {
        display: none !important;
        opacity: 0 !important;
        width: 0 !important;
        height: 0 !important;
    }

    .blockUI img[src*="busy.gif"],
    img[src*="busy.gif"] {
        display: none !important;
        visibility: hidden !important;
        width: 0 !important;
        height: 0 !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }

    .blockUI.blockMsg.blockPage > h1 {
        display: none !important;
    }

    /* ==========================================================================
       9. PERMANENT REMOVAL OF DATATABLES PROCESSING POPUP / DOTTED WHEEL
       ========================================================================== */
    div.dataTables_wrapper div.dataTables_processing,
    .dataTables_processing.card,
    .dataTables_processing,
    .dataTables_wrapper .dataTables_processing {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
        width: 0 !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        z-index: -9999 !important;
    }
</style>

<!-- Dynamic Top Glowing Progress Bar -->
<div id="ksTopProgressBar" aria-hidden="true"></div>

<!-- Standalone Global Loader Overlay (Universal Floating Capsule) -->
<div class="ks-loader-overlay" id="ksGlobalLoaderOverlay" aria-live="assertive" aria-busy="true">
    <div class="ks-global-loader-card">
        <div class="ks-loader-emblem-wrap">
            <div class="ks-spinner-ring outer"></div>
            <div class="ks-emblem-circle">
                <img src="{{ $upLogo }}" alt="Government of Uttar Pradesh" class="ks-emblem-img" />
            </div>
        </div>

        <div class="ks-loader-content">
            <div class="ks-loader-title">KHEL SATHI PORTAL</div>
            <div class="ks-loader-status">
                <span class="ks-status-dot"></span>
                <span class="ks-status-text" id="ksGlobalLoaderText">Processing, please wait...</span>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        window.khelSathiLogoUrl = "{{ $upLogo }}";

        // ======================================================================
        // 1. TOP PROGRESS BAR ENGINE (YouTube / Stripe / Linear Style)
        // ======================================================================
        var topBarEl = document.getElementById('ksTopProgressBar');
        var topProgressTimer = null;
        var topProgressVal = 0;

        window.startKsTopProgress = function() {
            if (!topBarEl) topBarEl = document.getElementById('ksTopProgressBar');
            if (!topBarEl) return;

            clearInterval(topProgressTimer);
            topBarEl.classList.add('active');
            topProgressVal = 25;
            topBarEl.style.width = topProgressVal + '%';

            topProgressTimer = setInterval(function() {
                if (topProgressVal < 85) {
                    topProgressVal += Math.random() * 8 + 3;
                    topBarEl.style.width = topProgressVal + '%';
                }
            }, 250);
        };

        window.finishKsTopProgress = function() {
            if (!topBarEl) topBarEl = document.getElementById('ksTopProgressBar');
            if (!topBarEl) return;

            clearInterval(topProgressTimer);
            topBarEl.style.width = '100%';
            setTimeout(function() {
                topBarEl.classList.remove('active');
                setTimeout(function() {
                    topBarEl.style.width = '0%';
                }, 200);
            }, 180);
        };

        // ======================================================================
        // 2. GLOBAL LOADER CONTROLLER WITH DEBOUNCE (ELIMINATES ALL JERKING)
        // ======================================================================
        var loaderDebounceTimer = null;
        var loaderSafetyTimer = null;
        var isModalActive = false;

        // Helper: Generate HTML if needed by plugins/blockUI
        window.getKsGlobalLoaderHtml = function(statusText) {
            var logo = window.khelSathiLogoUrl;
            var status = statusText || 'Processing, please wait...';
            return '<div class="ks-global-loader-card">' +
                '<div class="ks-loader-emblem-wrap">' +
                    '<div class="ks-spinner-ring outer"></div>' +
                    '<div class="ks-emblem-circle">' +
                        '<img src="' + logo + '" alt="Government of Uttar Pradesh" class="ks-emblem-img" />' +
                    '</div>' +
                '</div>' +
                '<div class="ks-loader-content">' +
                    '<div class="ks-loader-title">KHEL SATHI PORTAL</div>' +
                    '<div class="ks-loader-status">' +
                        '<span class="ks-status-dot"></span>' +
                        '<span class="ks-status-text">' + status + '</span>' +
                    '</div>' +
                '</div>' +
            '</div>';
        };

        // Show Global Loader (Top bar instantly, capsule pill debounced after 140ms)
        window.showGlobalLoader = function(customStatus) {
            // Immediate top glowing progress feedback
            window.startKsTopProgress();

            clearTimeout(loaderDebounceTimer);
            clearTimeout(loaderSafetyTimer);

            var status = customStatus || 'Processing, please wait...';
            var txtEl = document.getElementById('ksGlobalLoaderText');
            if (txtEl) {
                txtEl.textContent = status;
            }

            // Debounce: Only show floating modal capsule if action takes > 140ms
            // This completely eliminates flashing and jerking on quick actions!
            loaderDebounceTimer = setTimeout(function() {
                var overlay = document.getElementById('ksGlobalLoaderOverlay');
                if (overlay) {
                    overlay.classList.add('active');
                    isModalActive = true;
                }
            }, 140);

            // Safety timeout: Auto-dismiss after 4.5s so user is NEVER stuck or trapped
            loaderSafetyTimer = setTimeout(function() {
                window.hideGlobalLoader();
            }, 4500);
        };

        // Hide Global Loader
        var isHidingLoader = false;
        window.hideGlobalLoader = function() {
            if (isHidingLoader) return;
            isHidingLoader = true;
            try {
                clearTimeout(loaderDebounceTimer);
                clearTimeout(loaderSafetyTimer);
                window.finishKsTopProgress();

                var overlay = document.getElementById('ksGlobalLoaderOverlay');
                if (overlay) {
                    overlay.classList.remove('active');
                    isModalActive = false;
                }

                if (typeof $ !== 'undefined' && typeof $.unblockUI !== 'undefined') {
                    try {
                        if ($.unblockUI.__ks_orig) {
                            $.unblockUI.__ks_orig.call($);
                        } else if (!$.unblockUI.__ks_intercepted) {
                            $.unblockUI();
                        }
                    } catch(e) {}
                }
            } finally {
                isHidingLoader = false;
            }
        };

        // Intercept $.blockUI to prevent blocking overlays during user actions (create, update, delete, forward, query, etc.)
        function installKsBlockUIInterceptor() {
            if (typeof $ === 'undefined' || typeof $.blockUI === 'undefined') {
                return false;
            }
            if ($.blockUI.__ks_intercepted) {
                return true;
            }

            var _origBlock = $.blockUI;
            $.blockUI = function(opts) {
                opts = opts || {};

                // DO NOT SHOW MODAL OVERLAY ON ACTIONS!
                // Only start subtle non-blocking top progress bar
                window.startKsTopProgress();

                // Silently neutralize BlockUI internal DOM rendering (kill legacy grey box and busy.gif)
                opts.message = '<div style="display:none!important;"></div>';
                opts.css = { display: 'none' };
                opts.overlayCSS = { display: 'none' };

                return _origBlock.call($, opts);
            };
            $.blockUI.__ks_intercepted = true;

            var _origUnblock = $.unblockUI;
            var isUnblocking = false;
            $.unblockUI = function(opts) {
                if (!isUnblocking) {
                    isUnblocking = true;
                    try {
                        window.finishKsTopProgress();
                        window.hideGlobalLoader();
                    } finally {
                        isUnblocking = false;
                    }
                }
                return _origUnblock.call($, opts || {});
            };
            $.unblockUI.__ks_orig = _origUnblock;
            $.unblockUI.__ks_intercepted = true;

            return true;
        }

        // Try installing interceptor immediately
        if (!installKsBlockUIInterceptor()) {
            var attempts = 0;
            var interval = setInterval(function() {
                attempts++;
                if (installKsBlockUIInterceptor() || attempts > 50) {
                    clearInterval(interval);
                }
            }, 50);

            if (typeof $ !== 'undefined') {
                $(document).ready(function() {
                    installKsBlockUIInterceptor();
                });
            }
        }

        // ======================================================================
        // 3. TARGETED HOOKS: VIEWING, FILTRATION & PAGE CHANGING ONLY
        //    (STRICTLY EXCLUDES CREATE, UPDATE, DELETE, MODALS, & MUTATION ACTIONS)
        // ======================================================================

        // 1. Hook into Link Clicks: VIEWING & PAGE CHANGING (Pagination) ONLY
        document.addEventListener('click', function(e) {
            var link = e.target.closest('a');
            if (!link) return;

            var href = link.getAttribute('href');
            if (!href) return;

            // Skip internal hash links, javascript, downloads, target="_blank", bootstrap modals/toggles
            if (href === '#' || href.indexOf('javascript:') === 0 || href.indexOf('#') === 0) return;
            if (link.target === '_blank' || link.hasAttribute('download')) return;
            if (link.hasAttribute('data-bs-toggle') || link.hasAttribute('data-toggle')) return;
            if (link.getAttribute('data-bs-target') || link.getAttribute('data-target')) return;
            if (link.classList.contains('dropdown-toggle')) return;
            if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;

            var lowerHref = href.toLowerCase();
            var onclickAttr = (link.getAttribute('onclick') || '').toLowerCase();
            var linkText = (link.textContent || link.getAttribute('title') || '').trim();
            var lowerText = linkText.toLowerCase();

            // STRICT EXCLUSION: ACTIONS (Create, Update, Delete, Edit, Save, Forward, Approve, Reject, Status Toggle, Modals)
            // The global loader must NEVER obstruct any user action!
            var isAction = (
                lowerHref.includes('/delete') ||
                lowerHref.includes('/destroy') ||
                lowerHref.includes('/remove') ||
                lowerHref.includes('/edit') ||
                lowerHref.includes('/update') ||
                lowerHref.includes('/create') ||
                lowerHref.includes('/store') ||
                lowerHref.includes('/toggle') ||
                lowerHref.includes('/status') ||
                lowerHref.includes('/approve') ||
                lowerHref.includes('/reject') ||
                lowerHref.includes('/forward') ||
                lowerHref.includes('/action') ||
                onclickAttr.includes('delete') ||
                onclickAttr.includes('destroy') ||
                onclickAttr.includes('remove') ||
                onclickAttr.includes('forward') ||
                onclickAttr.includes('confirm') ||
                onclickAttr.includes('modal') ||
                onclickAttr.includes('swal') ||
                onclickAttr.includes('status') ||
                link.classList.contains('btn-danger') ||
                link.classList.contains('btn-warning') ||
                link.classList.contains('delete-btn') ||
                link.classList.contains('action-btn') ||
                link.closest('.modal')
            );

            if (isAction) {
                return;
            }

            // CASE 1: PAGE CHANGING (Pagination: .pagination, .page-link, .paginate_button, ?page=)
            var isPagination = (
                link.closest('.pagination') ||
                link.closest('.page-item') ||
                link.classList.contains('page-link') ||
                link.closest('.paginate_button') ||
                link.closest('.dataTables_paginate') ||
                lowerHref.includes('page=')
            );

            if (isPagination) {
                window.showGlobalLoader('Changing page, please wait...');
                return;
            }

            // CASE 2: VIEWING & NAVIGATION (Sidebar, view buttons, previews, reports, back buttons, same-origin pages)
            var fullUrl = link.href;
            if (fullUrl && (fullUrl.indexOf(window.location.origin) === 0 || fullUrl.indexOf('/') === 0)) {
                var status = 'Loading page, please wait...';
                if (lowerText.includes('report')) {
                    status = 'Loading report, please wait...';
                } else if (lowerHref.includes('/preview') || lowerText.includes('preview') || link.querySelector('.fa-eye')) {
                    status = 'Loading preview, please wait...';
                } else if (lowerText.includes('view') || lowerText.includes('detail')) {
                    status = 'Loading details, please wait...';
                } else if (lowerText.includes('back')) {
                    status = 'Going back, please wait...';
                } else if (linkText.length > 2 && linkText.length < 35 && !linkText.includes('{')) {
                    status = 'Loading ' + linkText.replace(/\s+/g, ' ') + ', please wait...';
                }

                window.showGlobalLoader(status);
            }
        }, true);

        // 2. Hook into Form Submissions: FILTRATION & SEARCH ONLY (NEVER ON CREATE, UPDATE, DELETE)
        document.addEventListener('submit', function(e) {
            var form = e.target;
            if (!form) return;

            // If browser HTML5 validation fails, abort
            if (form.checkValidity && !form.checkValidity()) {
                return;
            }
            if (form.target === '_blank') return;

            // STRICT RULE 1: STRICTLY IGNORE ACTIONS (POST, PUT, DELETE, PATCH)
            // Actions like create, update, delete, save, forward, approve, reject use POST/PUT/DELETE
            var method = (form.getAttribute('method') || 'get').toLowerCase();
            if (method !== 'get') {
                return;
            }

            // STRICT RULE 2: STRICTLY IGNORE FORMS INSIDE MODALS
            if (form.closest('.modal') || form.closest('.modal-content') || form.id === 'preregister') {
                return;
            }

            // STRICT RULE 3: STRICTLY IGNORE FORMS WITH ACTION URLS
            var action = (form.getAttribute('action') || '').toLowerCase();
            if (/delete|destroy|remove|update|edit|create|store|save|forward|query|status|approve|reject|pay/.test(action)) {
                return;
            }

            // STRICT RULE 4: ONLY TRIGGER ON FILTRATION / SEARCH FORMS
            var submitBtn = form.querySelector('[type="submit"]:focus') || form.querySelector('button[type="submit"]') || form.querySelector('[type="submit"]');
            var btnText = submitBtn ? (submitBtn.textContent || submitBtn.value || '').trim().toLowerCase() : '';

            var hasFilterInputs = form.querySelector('select[name="status"], select[name="fee_status"], select[name="division_id"], select[name="district_id"], input[name="from_date"], input[name="to_date"], input[name="search"], input[name="table_search"], select[name="category"], select[name="payment_status"], select[name="application_status"]');

            var formId = (form.id || '').toLowerCase();
            var formClass = (form.className || '').toLowerCase();

            var isFilter = (hasFilterInputs || formId.includes('filter') || formId.includes('search') || formClass.includes('filter') || btnText.includes('filter') || btnText.includes('search') || (method === 'get' && btnText.includes('submit')));

            if (isFilter) {
                window.showGlobalLoader('Filtering & loading data, please wait...');
            }
        }, true);

        // 3. DataTables & AJAX Integration + Auto Dismiss on Modals
        if (typeof $ !== 'undefined') {
            $(document).ready(function() {
                // DataTables page change
                $(document).on('page.dt', function() {
                    window.showGlobalLoader('Changing page, please wait...');
                });
                $(document).on('draw.dt', function() {
                    window.hideGlobalLoader();
                });

                // Auto hide loader whenever ANY ajax request finishes or errors
                $(document).ajaxComplete(function() {
                    window.hideGlobalLoader();
                });
                $(document).ajaxError(function() {
                    window.hideGlobalLoader();
                });

                // Immediately dismiss loader if any Bootstrap modal is opened
                $(document).on('show.bs.modal shown.bs.modal', function() {
                    window.hideGlobalLoader();
                });
            });
        }

        // 4. Fail-Safe Dismissals: Click backdrop or press Escape to dismiss
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                window.hideGlobalLoader();
            }
        });

        var overlayEl = document.getElementById('ksGlobalLoaderOverlay');
        if (overlayEl) {
            overlayEl.addEventListener('click', function(e) {
                // If user clicks the backdrop, dismiss immediately
                if (e.target === overlayEl || !e.target.closest('.ks-global-loader-card')) {
                    window.hideGlobalLoader();
                }
            });
        }

        // 5. Page Lifecycle: Always ensure loader is dismissed once page is ready
        window.addEventListener('DOMContentLoaded', function() {
            window.hideGlobalLoader();
        });
        window.addEventListener('load', function() {
            window.hideGlobalLoader();
        });
        window.addEventListener('pageshow', function() {
            window.hideGlobalLoader();
        });

    })();
</script>
@endif
