@php
$currAdmin = Auth::guard('admin')->user();
$displayName = !empty($currAdmin->name) ? $currAdmin->name : ($currAdmin->username ?? 'Admin');
$defaultLogo = asset('assets_admin/images/logo.png');
$hasCustomAvatar = $currAdmin && !empty($currAdmin->profile_image) && file_exists(public_path($currAdmin->profile_image));
$avatarSrc = $hasCustomAvatar ? asset($currAdmin->profile_image) : $defaultLogo;
$isDsoSoRso = $currAdmin && in_array((int)$currAdmin->admin_role, [2, 9]);
$roleName = ucfirst(str_replace('_', ' ', $currAdmin->username ?? 'Admin'));
@endphp

<style>
    /* ==========================================================================
       ZENITH-STYLE UNIFIED FULL-HEIGHT SIDEBAR & TOPNAV
       ========================================================================== */

    /* 1. Full-Height Unified Left Sidebar Column */
    .menusidebar {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        bottom: 0 !important;
        height: 100vh !important;
        background: #ffffff !important;
        border-right: 1px solid #e2e8f0 !important;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.03) !important;
        z-index: 1040 !important;
        display: flex !important;
        flex-direction: column !important;
        overflow: visible !important;
        box-sizing: border-box !important;
        transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1), left 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        text-align: left !important;
    }

    /* Expanded Sidebar State (280px for generous breathing room) */
    .menusidebar.menusidebar-width {
        width: 280px !important;
        max-width: 280px !important;
    }

    /* Collapsed Sidebar State (72px Rail) */
    @media (min-width: 768px) {
        .menusidebar:not(.menusidebar-width) {
            width: 72px !important;
            max-width: 72px !important;
        }
    }

    /* 2. Floating Edge Collapse Toggle (Shifted outward with generous clearance) */
    .sidebar-edge-toggle {
        position: absolute !important;
        right: -14px !important;
        top: 20px !important;
        width: 28px !important;
        height: 28px !important;
        border-radius: 50% !important;
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        color: #475569 !important;
        z-index: 1050 !important;
        padding: 0 !important;
        transition: all 0.2s ease !important;
        outline: none !important;
        text-decoration: none !important;
    }

    .sidebar-edge-toggle:hover {
        color: #0f172a !important;
        background: #f8fafc !important;
        border-color: #94a3b8 !important;
        transform: scale(1.12) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }

    .menusidebar.menusidebar-width .toggle-icon-expand {
        display: none !important;
    }
    .menusidebar.menusidebar-width .toggle-icon-collapse {
        display: block !important;
    }

    .menusidebar:not(.menusidebar-width) .toggle-icon-collapse {
        display: none !important;
    }
    .menusidebar:not(.menusidebar-width) .toggle-icon-expand {
        display: block !important;
    }

    @media (max-width: 767.98px) {
        .sidebar-edge-toggle {
            display: none !important;
        }
    }

    /* 3. Sidebar Brand Header (Top of the Column) */
    .sidebar-brand-header {
        height: 68px !important;
        padding: 0 34px 0 16px !important;
        display: flex !important;
        align-items: center !important;
        border-bottom: 1px solid #f1f5f9 !important;
        flex-shrink: 0 !important;
        background: #ffffff !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }

    .sidebar-brand-link {
        display: flex !important;
        align-items: center !important;
        text-decoration: none !important;
        color: inherit !important;
        width: 100% !important;
        user-select: none !important;
    }

    .sidebar-brand-logo {
        width: 44px !important;
        height: 44px !important;
        object-fit: contain !important;
        display: block !important;
        flex-shrink: 0 !important;
    }

    .sidebar-brand-divider {
        width: 2px !important;
        height: 36px !important;
        margin: 0 12px !important;
        background: linear-gradient(180deg, #1e40af 0%, #7c3aed 100%) !important;
        border-radius: 2px !important;
        flex-shrink: 0 !important;
    }

    .sidebar-brand-text {
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        line-height: 1.15 !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        white-space: nowrap !important;
        overflow: hidden !important;
    }

    .sidebar-brand-title {
        font-size: 15px !important;
        font-weight: 900 !important;
        letter-spacing: 0.3px !important;
        color: #000000 !important;
        text-transform: uppercase !important;
        line-height: 1.15 !important;
    }

    .sidebar-brand-dept {
        font-size: 12.5px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        line-height: 1.2 !important;
    }

    .sidebar-brand-gov {
        font-size: 10.5px !important;
        font-weight: 500 !important;
        color: #475569 !important;
        line-height: 1.2 !important;
    }

    /* Collapsed Brand Header */
    @media (min-width: 768px) {
        .menusidebar:not(.menusidebar-width) .sidebar-brand-header {
            width: 72px !important;
            padding: 0 !important;
            justify-content: center !important;
        }

        .menusidebar:not(.menusidebar-width) .sidebar-brand-link {
            justify-content: center !important;
        }

        .menusidebar:not(.menusidebar-width) .sidebar-brand-divider,
        .menusidebar:not(.menusidebar-width) .sidebar-brand-text {
            display: none !important;
        }

        .menusidebar:not(.menusidebar-width) .sidebar-brand-logo {
            width: 38px !important;
            height: 38px !important;
            margin: 0 auto !important;
        }
    }

    /* 4. Middle Section: Scrollable Menu Items */
    .menusidebar .menuscrollwrap {
        flex: 1 1 auto !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        height: auto !important;
        width: 100% !important;
        min-height: 0 !important;
        padding: 8px 0 !important;
    }

    .menuscrollwrap::-webkit-scrollbar {
        width: 4px;
    }
    .menuscrollwrap::-webkit-scrollbar-track {
        background: transparent;
    }
    .menuscrollwrap::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 4px;
    }
    .menuscrollwrap::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }

    .menuscrollwrap .nano-content > span[style*="color: #d64d92"],
    .menuscrollwrap .nano-content > span[style*="color:#d64d92"],
    .menuscrollwrap .nano-content > span:first-child:not(.navsidebar) {
        display: none !important;
    }

    /* Sidebar Navigation List */
    .menusidebar .navsidebar {
        margin: 0 !important;
        padding: 0 !important;
        list-style: none !important;
    }

    /* Expanded Menu Items */
    .menusidebar.menusidebar-width .navsidebar > li.menu_item > a {
        display: flex !important;
        align-items: center !important;
        padding: 9px 12px !important;
        margin: 2px 12px !important;
        border-radius: 8px !important;
        color: #475569 !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        transition: all 0.15s ease !important;
        position: relative !important;
    }

    .menusidebar.menusidebar-width .navsidebar > li.menu_item > a:hover {
        background: #fdf2f8 !important;
        color: #dc4c8f !important;
    }

    .menusidebar.menusidebar-width .navsidebar > li.menu_item > a.active {
        background: rgba(220, 76, 143, 0.1) !important;
        color: #dc4c8f !important;
        font-weight: 700 !important;
    }

    .menusidebar.menusidebar-width .navsidebar > li > a i.icon,
    .menusidebar.menusidebar-width .navsidebar > li > a i {
        font-size: 17px !important;
        width: 22px !important;
        color: #dc4c8f !important;
        margin: 0 !important;
        position: static !important;
        flex-shrink: 0 !important;
    }

    .menusidebar.menusidebar-width .navsidebar > li > a span:not(.fa-caret-down) {
        flex: 1 !important;
        margin-left: 10px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .menusidebar.menusidebar-width .navsidebar > li > a span.fa-caret-down {
        position: static !important;
        margin-left: auto !important;
        font-size: 11px !important;
        color: #94a3b8 !important;
    }

    /* Submenu in expanded state */
    .menusidebar.menusidebar-width .sub-menu {
        padding-left: 0 !important;
        list-style: none !important;
        background: #fafafa !important;
        margin: 2px 12px !important;
        border-radius: 8px !important;
    }

    .menusidebar.menusidebar-width .sub-menu li a {
        display: flex !important;
        align-items: center !important;
        padding: 7px 12px 7px 36px !important;
        font-size: 12.5px !important;
        color: #475569 !important;
        text-decoration: none !important;
        border-radius: 6px !important;
        transition: all 0.15s ease !important;
    }

    .menusidebar.menusidebar-width .sub-menu li a:hover {
        color: #dc4c8f !important;
        background: rgba(220, 76, 143, 0.08) !important;
    }

    .menusidebar.menusidebar-width .sub-menu li a.active {
        color: #dc4c8f !important;
        font-weight: 700 !important;
        background: rgba(220, 76, 143, 0.12) !important;
    }

    /* Collapsed Menu Items (72px Rail - Clean, Balanced Size, Proper Vertical Gap & Middle Alignment) */
    @media (min-width: 768px) {
        .menusidebar:not(.menusidebar-width) .navsidebar {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            padding: 4px 0 !important;
        }

        .menusidebar:not(.menusidebar-width) .navsidebar > li.menu_item {
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            position: relative !important;
            margin: 0 0 6px 0 !important;
            padding: 0 !important;
        }

        .menusidebar:not(.menusidebar-width) .navsidebar > li > a {
            width: 38px !important;
            height: 38px !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: relative !important;
            margin: 0 auto !important;
            padding: 0 !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .menusidebar:not(.menusidebar-width) .navsidebar > li > a:hover {
            background-color: #fdf2f8 !important;
            transform: scale(1.08) !important;
        }

        .menusidebar:not(.menusidebar-width) .navsidebar > li > a.active {
            background: rgba(220, 76, 143, 0.14) !important;
            box-shadow: 0 1px 3px rgba(220, 76, 143, 0.15) !important;
        }

        .menusidebar:not(.menusidebar-width) .navsidebar > li > a span {
            display: none !important;
        }

        .menusidebar:not(.menusidebar-width) .navsidebar > li > a i.icon,
        .menusidebar:not(.menusidebar-width) .navsidebar > li > a i {
            position: static !important;
            font-size: 16px !important;
            color: #dc4c8f !important;
            margin: 0 !important;
            line-height: 1 !important;
            display: inline-block !important;
        }

        .menusidebar:not(.menusidebar-width) .sub-menu {
            display: none !important;
        }
    }

    /* 5. Bottom Section: Unified User Profile & Logout */
    .sidebar-footer-user {
        flex-shrink: 0 !important;
        margin-top: auto !important;
        border-top: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        height: 48px !important;
        min-height: 48px !important;
        max-height: 48px !important;
        padding: 0 12px !important;
        z-index: 1025 !important;
        box-sizing: border-box !important;
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: center !important;
    }

    .sidebar-user-card {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 8px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .sidebar-user-info-link {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        text-decoration: none !important;
        color: inherit !important;
        min-width: 0 !important;
        flex: 1 !important;
        padding: 2px 4px !important;
        border-radius: 6px !important;
        transition: background 0.15s ease !important;
        box-sizing: border-box !important;
    }

    .sidebar-user-info-link:hover {
        background: #f8fafc !important;
    }

    .sidebar-user-avatar {
        width: 32px !important;
        height: 32px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        border: 1px solid #e2e8f0 !important;
        flex-shrink: 0 !important;
        background: #ffffff !important;
        padding: 1px !important;
        box-sizing: border-box !important;
    }

    .sidebar-user-details {
        display: flex !important;
        flex-direction: column !important;
        min-width: 0 !important;
        line-height: 1.2 !important;
    }

    .sidebar-user-name {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #1e293b !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .sidebar-user-role {
        font-size: 10.5px !important;
        color: #64748b !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .sidebar-user-logout-btn {
        width: 32px !important;
        height: 32px !important;
        border-radius: 6px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: #64748b !important;
        text-decoration: none !important;
        transition: all 0.15s ease !important;
        flex-shrink: 0 !important;
        background: transparent !important;
        box-sizing: border-box !important;
    }

    .sidebar-user-logout-btn:hover {
        color: #dc2626 !important;
        background: #fef2f2 !important;
        transform: translateY(-1px) !important;
    }

    /* Collapsed User Footer (72px Rail) - ONLY LOGOUT, NO ADMIN AVATAR/LOGO, PERFECTLY FLUSH BOUNDARY */
    @media (min-width: 768px) {
        .menusidebar:not(.menusidebar-width) .sidebar-footer-user {
            width: 100% !important;
            max-width: 100% !important;
            height: 48px !important;
            min-height: 48px !important;
            max-height: 48px !important;
            padding: 0 !important;
            margin: 0 !important;
            border-top: 1px solid #e2e8f0 !important;
            border-right: none !important;
            border-bottom: none !important;
            border-left: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
        }

        .menusidebar:not(.menusidebar-width) .sidebar-user-card {
            display: none !important;
        }

        .menusidebar:not(.menusidebar-width) .sidebar-collapsed-user-wrap {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            box-sizing: border-box !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
        }

        .menusidebar.menusidebar-width .sidebar-collapsed-user-wrap {
            display: none !important;
        }

        .sidebar-collapsed-logout-btn {
            width: 36px !important;
            height: 36px !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #dc2626 !important;
            background: #fef2f2 !important;
            border: 1px solid #fee2e2 !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
            margin: 0 auto !important;
            box-sizing: border-box !important;
            flex-shrink: 0 !important;
        }

        .sidebar-collapsed-logout-btn:hover {
            color: #b91c1c !important;
            background: #fee2e2 !important;
            border-color: #fecaca !important;
            transform: scale(1.06) !important;
            box-shadow: 0 3px 8px rgba(220, 38, 38, 0.15) !important;
        }

        .sidebar-collapsed-logout-btn svg {
            color: #dc2626 !important;
        }
    }

    /* Hide legacy logoutbutton class */
    .menusidebar .logoutbutton {
        display: none !important;
    }

    /* ==========================================================================
       6. TOPNAV HEADER (Sits to the right of the Sidebar Column)
       ========================================================================== */
    .header {
        position: fixed !important;
        top: 0 !important;
        right: 0 !important;
        height: 68px !important;
        min-height: 68px !important;
        background: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        border-bottom: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.03) !important;
        z-index: 1030 !important;
        padding: 0 20px !important;
        margin: 0 !important;
        transition: left 0.25s cubic-bezier(0.4, 0, 0.2, 1), width 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    /* When Sidebar is Expanded: Header starts at 280px */
    .header.menuheader-width {
        left: 280px !important;
        width: calc(100% - 280px) !important;
    }

    /* When Sidebar is Collapsed on Desktop: Header starts at 72px */
    @media (min-width: 768px) {
        .header:not(.menuheader-width) {
            left: 72px !important;
            width: calc(100% - 72px) !important;
        }
    }

    /* Mobile Header (<768px) */
    @media (max-width: 767.98px) {
        .header {
            left: 0 !important;
            width: 100% !important;
            padding: 0 14px !important;
        }

        .menusidebar:not(.menusidebar-width) {
            left: -290px !important;
            width: 280px !important;
        }

        .menusidebar.menusidebar-width {
            left: 0 !important;
            width: 280px !important;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.25) !important;
        }
    }

    /* Mobile Menu Toggle Button (shown only on small screens) */
    .mobile-menu-toggle {
        display: none !important;
        color: #475569;
        font-size: 20px;
        line-height: 1;
        padding: 6px;
        cursor: pointer;
        text-decoration: none !important;
        margin-right: 12px;
    }

    @media (max-width: 767.98px) {
        .mobile-menu-toggle {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
        }
    }

    /* 7. Content Wrapper Offset */
    .contentwraper {
        padding-top: 76px !important;
        padding-bottom: 60px !important;
        transition: margin-left 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .contentwraper.menumarginleft {
        margin-left: 280px !important;
    }

    @media (min-width: 768px) {
        .contentwraper:not(.menumarginleft) {
            margin-left: 72px !important;
        }
    }

    @media (max-width: 767.98px) {
        .contentwraper {
            margin-left: 0 !important;
        }
    }

    /* ==========================================================================
       8. FOOTER POSITIONING & VISIBILITY (Always visible, perfectly aligned)
       ========================================================================== */
    footer {
        position: fixed !important;
        bottom: 0 !important;
        right: 0 !important;
        height: 48px !important;
        min-height: 48px !important;
        max-height: 48px !important;
        background: #ffffff !important;
        border-top: 1px solid #e2e8f0 !important;
        box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.03) !important;
        z-index: 1030 !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 24px !important;
        margin: 0 !important;
        box-sizing: border-box !important;
        transition: left 0.25s cubic-bezier(0.4, 0, 0.2, 1), width 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    /* When Sidebar is Expanded: Footer starts at 280px */
    .contentwraper.menumarginleft footer,
    footer.menufooter-width {
        left: 280px !important;
        width: calc(100% - 280px) !important;
    }

    /* When Sidebar is Collapsed on Desktop: Footer starts at 72px */
    @media (min-width: 768px) {
        .contentwraper:not(.menumarginleft) footer,
        footer:not(.menufooter-width) {
            left: 72px !important;
            width: calc(100% - 72px) !important;
        }
    }

    /* Mobile screens (< 768px) */
    @media (max-width: 767.98px) {
        .contentwraper footer,
        footer {
            left: 0 !important;
            width: 100% !important;
            padding: 0 16px !important;
        }
    }

    footer .row {
        width: 100% !important;
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
    }

    footer .foot-list {
        margin: 0 !important;
        padding: 0 !important;
        list-style: none !important;
        display: flex !important;
        align-items: center !important;
    }

    footer .foot-list li {
        color: #64748b !important;
        font-size: 12.5px !important;
        font-weight: 500 !important;
        padding: 0 !important;
        margin: 0 !important;
        line-height: 1 !important;
    }

    /* 9. TopNav User Profile Dropdown */
    .topbar-user-dropdown {
        position: relative;
    }

    .topbar-user-toggle {
        cursor: pointer;
        user-select: none;
        padding: 4px 8px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        text-decoration: none !important;
        transition: background-color 0.15s ease;
    }

    .topbar-user-toggle:hover {
        background-color: #f8fafc;
    }

    .topbar-user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 1px;
    }

    .topbar-user-name {
        color: #334155;
        font-size: 13.5px;
        font-weight: 600;
        letter-spacing: -0.2px;
        margin-left: 8px;
    }

    .topbar-chevron {
        color: #64748b;
        margin-left: 6px;
        transition: transform 0.2s ease;
    }

    .topbar-user-dropdown.show .topbar-chevron {
        transform: rotate(180deg);
    }

    .topbar-dropdown-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 195px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
        padding: 6px 0;
        z-index: 9999;
        display: none;
        opacity: 0;
        transform: translateY(-6px);
        transition: opacity 0.15s ease, transform 0.15s ease;
        white-space: nowrap;
    }

    .topbar-dropdown-menu.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .topbar-dropdown-item {
        display: flex;
        align-items: center;
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 500;
        color: #334155;
        text-decoration: none !important;
        transition: all 0.15s ease;
        border-left: 3px solid transparent;
    }

    .topbar-dropdown-item:hover {
        background-color: rgba(220, 76, 143, 0.06);
        color: #dc4c8f;
    }

    .topbar-dropdown-item.active {
        background-color: rgba(220, 76, 143, 0.1) !important;
        color: #dc4c8f !important;
        font-weight: 600 !important;
        border-left: 3px solid #dc4c8f !important;
    }

    .topbar-dropdown-item.text-danger {
        color: #dc2626 !important;
    }

    .topbar-dropdown-item.text-danger:hover {
        background-color: #fef2f2;
        color: #b91c1c !important;
    }

    .topbar-item-icon {
        width: 20px;
        display: inline-flex;
        align-items: center;
        color: #dc4c8f !important;
        margin-right: 8px;
    }

    .topbar-item-text {
        flex: 1;
    }

    /* 9. Floating Flyout Menu when Sidebar is Collapsed on Desktop */
    .sidebar-collapsed-flyout {
        position: fixed;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.15), 0 4px 10px -2px rgba(0, 0, 0, 0.05);
        z-index: 10050;
        min-width: 240px;
        max-width: 310px;
        overflow: hidden;
    }

    .sidebar-collapsed-flyout .flyout-header {
        padding: 10px 14px;
        background: #fdf2f8;
        border-bottom: 1px solid #fce7f3;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .sidebar-collapsed-flyout .flyout-header-title {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .sidebar-collapsed-flyout .flyout-header i,
    .sidebar-collapsed-flyout .flyout-header svg {
        color: #dc4c8f;
        font-size: 15px;
        flex-shrink: 0;
    }

    .sidebar-collapsed-flyout .flyout-badge {
        font-size: 10.5px;
        font-weight: 600;
        background: #fce7f3;
        color: #be185d;
        padding: 2px 7px;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .sidebar-collapsed-flyout .flyout-body {
        max-height: 340px;
        overflow-y: auto;
        padding: 4px 0;
    }

    .sidebar-collapsed-flyout .flyout-sub-item {
        display: flex;
        align-items: center;
        padding: 8px 14px;
        font-size: 12.5px;
        color: #475569;
        text-decoration: none !important;
        gap: 10px;
        transition: all 0.15s ease;
        border-left: 3px solid transparent;
    }

    .sidebar-collapsed-flyout .flyout-sub-item:hover {
        background: rgba(220, 76, 143, 0.08);
        color: #dc4c8f;
        font-weight: 600;
        padding-left: 17px;
    }

    .sidebar-collapsed-flyout .flyout-sub-item.active {
        background: rgba(220, 76, 143, 0.12) !important;
        color: #dc4c8f !important;
        font-weight: 700 !important;
        border-left: 3px solid #dc4c8f !important;
    }

    .sidebar-collapsed-flyout .flyout-sub-item i {
        font-size: 13px;
        color: #dc4c8f;
        width: 16px;
        text-align: center;
        flex-shrink: 0;
    }
</style>

<!-- ==========================================================================
     UNIFIED SIDEBAR (Full Height 100vh Single Column: Top Brand + Edge Toggle + Middle Modules + Bottom Logout)
     ========================================================================== -->
<aside class="menusidebar menusidebar-width" id="adminMainSidebar">
    <!-- 1. Floating Zenith Collapse Toggle Button (Shifted forward on border) -->
    <button type="button" class="sidebar-edge-toggle sidemenutoggle" id="sidebarEdgeToggle" title="Toggle Sidebar">
        <svg class="toggle-icon-collapse" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
        <svg class="toggle-icon-expand" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
    </button>

    <!-- 2. Brand Header at Top of Column (Logo + Text when expanded, Just Logo centered when collapsed) -->
    <div class="sidebar-brand-header">
        <a href="{{ url('admin/dashboard') }}" class="sidebar-brand-link" title="Khel Sathi Portal - Government of Uttar Pradesh">
            <img src="{{ asset('assets_admin/images/logo.png') }}" alt="UP Government Emblem" class="sidebar-brand-logo" />
            <div class="sidebar-brand-divider"></div>
            <div class="sidebar-brand-text">
                <span class="sidebar-brand-title">KHEL SATHI PORTAL</span>
                <span class="sidebar-brand-dept">Department of Sports</span>
                <span class="sidebar-brand-gov">Government of Uttar Pradesh</span>
            </div>
        </a>
    </div>

    <!-- 3. Middle Section: Scrollable Modules Navigation -->
    <div class="menuscrollwrap">
        <div class="nano-content f">
            <x-sidebar_left_menu />
        </div>
    </div>

    <!-- 4. Bottom Section: User Profile (Expanded) & ONLY Logout (Collapsed) -->
    @if ($currAdmin)
    <div class="sidebar-footer-user">
        <!-- Expanded View: Avatar + Name + Role + Logout Icon Button -->
        <div class="sidebar-user-card">
            <a href="{{ route('adminprofile') }}" class="sidebar-user-info-link" title="View Profile">
                <img src="{{ $avatarSrc }}" alt="{{ $displayName }}" class="sidebar-user-avatar" id="sidebar_user_avatar" />
                <div class="sidebar-user-details">
                    <span class="sidebar-user-name">{{ $displayName }}</span>
                    <span class="sidebar-user-role">{{ $roleName }}</span>
                </div>
            </a>
            <a href="{{ route('signOuts') }}" class="sidebar-user-logout-btn" title="Sign Out">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </a>
        </div>

        <!-- Collapsed View: ONLY Centered Logout Button (No avatar / login logo) -->
        <div class="sidebar-collapsed-user-wrap">
            <a href="{{ route('signOuts') }}" class="sidebar-collapsed-logout-btn" title="Sign Out">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </a>
        </div>
    </div>
    @endif
</aside>

<!-- ==========================================================================
     TOPNAV HEADER (Starts to the right of the Sidebar Column, clean without long text)
     ========================================================================== -->
<header class="header menuheader-width">
    <div class="container-fluid px-0 d-flex align-items-center justify-content-between h-100">
        <!-- Left: Mobile Menu Toggle only on screens <768px -->
        <div class="d-flex align-items-center">
            <a class="mobile-menu-toggle sidemenutoggle" href="javascript:void(0)" title="Toggle Navigation">
                <span class="icons icon-menu"></span>
            </a>
        </div>

        <!-- Right: Topbar User Profile Dropdown -->
        <div class="d-flex align-items-center">
            <div class="topbar-user-dropdown">
                <a href="javascript:void(0)" class="topbar-user-toggle" id="topbarUserDropdownToggle">
                    <img src="{{ $avatarSrc }}" alt="{{ $displayName }}" class="topbar-user-avatar" id="topbar_user_avatar">
                    <span class="topbar-user-name">{{ $displayName }}</span>
                    <svg class="topbar-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>

                <div class="topbar-dropdown-menu" id="topbarUserDropdownMenu">
                    @php
                    $isProfileActive = request()->routeIs('adminprofile') || request()->is('admin/profile*');
                    $isChangePwdActive = request()->routeIs('adminChangePassword') || request()->is('admin/change-password*');
                    @endphp
                    <!-- Profile / Profile & Settings -->
                    <a class="topbar-dropdown-item {{ $isProfileActive ? 'active' : '' }}" href="{{ route('adminprofile') }}">
                        <span class="topbar-item-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <span class="topbar-item-text">{{ $isDsoSoRso ? 'Profile & Settings' : 'Profile' }}</span>
                    </a>

                    <!-- Change Password -->
                    <a class="topbar-dropdown-item {{ $isChangePwdActive ? 'active' : '' }}" href="{{ route('adminChangePassword') }}">
                        <span class="topbar-item-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <span class="topbar-item-text">Change Password</span>
                    </a>

                    <a class="topbar-dropdown-item text-danger" href="{{ route('signOuts') }}">
                        <span class="topbar-item-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        </span>
                        <span class="topbar-item-text">Sign out</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    $(document).ready(function() {
        // Dropdown toggle
        $('#topbarUserDropdownToggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $dropdown = $(this).closest('.topbar-user-dropdown');
            var $menu = $('#topbarUserDropdownMenu');
            var isShown = $dropdown.hasClass('show');
            if (isShown) {
                $dropdown.removeClass('show');
                $menu.removeClass('show');
            } else {
                $dropdown.addClass('show');
                $menu.addClass('show');
            }
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.topbar-user-dropdown').length) {
                $('.topbar-user-dropdown').removeClass('show');
                $('#topbarUserDropdownMenu').removeClass('show');
            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                $('.topbar-user-dropdown').removeClass('show');
                $('#topbarUserDropdownMenu').removeClass('show');
            }
        });

        // Floating Flyout when Sidebar is Collapsed on Desktop
        var $flyout = $('<div id="sidebarCollapsedFlyout" class="sidebar-collapsed-flyout" style="display:none;"></div>').appendTo('body');
        var flyoutTimer = null;

        function showSidebarFlyout($li) {
            if ($(window).width() < 768 || $('.menusidebar').hasClass('menusidebar-width')) {
                return;
            }

            var title = $li.find('> a > span:not(.fa-caret-down)').text().trim() || $li.find('span:not(.fa-caret-down)').first().text().trim();
            var iconHtml = $li.find('> a > i').prop('outerHTML') || $li.find('i').first().prop('outerHTML') || '<i class="icon icon-grid"></i>';
            var targetId = $li.attr('data-bs-target') || $li.attr('data-target');
            var $submenu = targetId ? $(targetId) : $li.next('.sub-menu');

            var subItemsHtml = '';
            var count = 0;
            if ($submenu && $submenu.length) {
                $submenu.find('li').each(function() {
                    var $a = $(this).find('a');
                    var href = $a.attr('href') || '#';
                    var subIcon = $a.find('i').prop('outerHTML') || '<i class="fa fa-angle-right"></i>';
                    var subText = $a.find('span').text().trim();
                    var isActive = $a.hasClass('active') || (window.location.href.indexOf(href) !== -1 && href !== '#' && href !== 'javascript:void(0)');
                    subItemsHtml += '<a href="' + href + '" class="flyout-sub-item' + (isActive ? ' active' : '') + '">' + subIcon + '<span>' + subText + '</span></a>';
                    count++;
                });
            }

            // Direct standalone link (like Dashboard)
            if (!subItemsHtml && $li.find('a').attr('href') && $li.find('a').attr('href') !== 'javascript:void(0)') {
                var href = $li.find('a').attr('href');
                var isAct = $li.find('a').hasClass('active') || (window.location.href.indexOf(href) !== -1);
                subItemsHtml = '<a href="' + href + '" class="flyout-sub-item' + (isAct ? ' active' : '') + '">' + iconHtml + '<span>Open ' + title + '</span></a>';
                count = 1;
            }

            if (title) {
                clearTimeout(flyoutTimer);
                var rect = $li[0].getBoundingClientRect();
                var flyoutTop = rect.top;
                var windowHeight = $(window).height();

                var countBadge = count > 1 ? '<span class="flyout-badge">' + count + ' items</span>' : '';
                var html = '<div class="flyout-header"><div class="flyout-header-title">' + iconHtml + '<span>' + title + '</span></div>' + countBadge + '</div>';
                if (subItemsHtml) {
                    html += '<div class="flyout-body">' + subItemsHtml + '</div>';
                }

                $flyout.html(html).css({
                    top: Math.max(72, Math.min(flyoutTop, windowHeight - 320)),
                    left: 74
                }).stop(true, true).fadeIn(100);
            }
        }

        $(document).on('mouseenter', '.menusidebar:not(.menusidebar-width) .navsidebar > li.menu_item', function() {
            showSidebarFlyout($(this));
        });

        $(document).on('click', '.menusidebar:not(.menusidebar-width) .navsidebar > li.menu_item', function(e) {
            var $a = $(this).find('> a');
            var href = $a.attr('href');
            if (href && href !== 'javascript:void(0)' && href !== '#') {
                return;
            }
            e.preventDefault();
            e.stopPropagation();
            showSidebarFlyout($(this));
        });

        $(document).on('mouseleave', '.menusidebar:not(.menusidebar-width) .navsidebar > li.menu_item', function() {
            flyoutTimer = setTimeout(function() {
                if (!$flyout.is(':hover')) {
                    $flyout.fadeOut(100);
                }
            }, 160);
        });

        // Hover tooltip for Collapsed Logout Button
        $(document).on('mouseenter', '.sidebar-collapsed-logout-btn', function() {
            if ($('.menusidebar').hasClass('menusidebar-width')) return;
            clearTimeout(flyoutTimer);
            var rect = this.getBoundingClientRect();
            var html = '<div class="flyout-header" style="background:#fef2f2;border-bottom-color:#fee2e2;color:#dc2626;"><div class="flyout-header-title"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#dc2626;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg><span>Sign out</span></div></div>';
            $flyout.html(html).css({
                top: Math.max(72, rect.top - 4),
                left: 74
            }).stop(true, true).fadeIn(100);
        });

        $(document).on('mouseleave', '.sidebar-collapsed-logout-btn', function() {
            flyoutTimer = setTimeout(function() {
                if (!$flyout.is(':hover')) {
                    $flyout.fadeOut(100);
                }
            }, 150);
        });

        $flyout.on('mouseenter', function() {
            clearTimeout(flyoutTimer);
        }).on('mouseleave', function() {
            $flyout.fadeOut(100);
        });

        // Footer position sync
        function syncFooter() {
            var isExpanded = $('.menusidebar').hasClass('menusidebar-width');
            if ($(window).width() >= 768) {
                if (isExpanded) {
                    $('footer').addClass('menufooter-width');
                } else {
                    $('footer').removeClass('menufooter-width');
                }
            } else {
                $('footer').removeClass('menufooter-width');
            }
        }
        syncFooter();
        $(window).on('resize', syncFooter);

        // Hide flyout and sync footer when sidebar toggles
        $('.sidemenutoggle').on('click', function() {
            $flyout.hide();
            setTimeout(syncFooter, 30);
        });
    });
</script>