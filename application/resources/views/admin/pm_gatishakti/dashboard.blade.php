
@extends('layouts/admin_layout')

@section('content')

<style>
    .pm-dashboard {
        --pm-orange: #ed711c;
        --pm-orange-dark: #d9570c;
        --pm-border: #e9e2dc;
        --pm-text: #292c32;
        --pm-muted: #777d86;
    }

    .pm-dashboard .pm-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
        padding: 20px 24px;
        margin-bottom: 20px;
        background: linear-gradient(110deg, #fff 55%, #fff0e4);
        border: 1px solid #f3e1d4;
        border-radius: 12px;
    }

    .pm-dashboard .pm-heading {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .pm-dashboard .pm-heading-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: #fff0e4;
        color: var(--pm-orange);
        font-size: 22px;
    }

    .pm-dashboard .pm-title {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #78330e;
    }

    .pm-dashboard .pm-subtitle {
        margin: 5px 0 0;
        color: var(--pm-muted);
        font-size: 12px;
    }

    .pm-dashboard .pm-actions {
        display: flex;
        gap: 10px;
    }

    .pm-dashboard .pm-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 10px 18px;
        border: 1px solid #ead7c9;
        border-radius: 8px;
        background: #fff;
        color: #633516;
        font-size: 13px;
        font-weight: 600;
        transition: all .2s ease;
    }

    .pm-dashboard .pm-action-btn:hover {
        background: #fff3e9;
        border-color: var(--pm-orange);
        color: var(--pm-orange-dark);
    }

    .pm-dashboard .pm-filter-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(44, 36, 27, .05);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .pm-dashboard .pm-filter-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px 22px;
        border-bottom: 1px solid #f0eae5;
        font-size: 14px;
        font-weight: 700;
        color: #40352e;
    }

    .pm-dashboard .pm-filter-heading i {
        color: var(--pm-orange);
    }

    .pm-dashboard .pm-filter-body {
        padding: 24px 22px;
    }

    .pm-dashboard .pm-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #493c33;
        margin-bottom: 9px;
    }

    .pm-dashboard .pm-label i {
        color: var(--pm-orange);
        margin-right: 7px;
        width: 15px;
        text-align: center;
    }

    .pm-dashboard .pm-select {
        width: 100%;
        min-height: 44px;
        padding: 9px 12px;
        border: 1px solid #ded9d5;
        border-radius: 8px;
        background-color: #fff;
        color: var(--pm-text);
        font-size: 13px;
        transition: border-color .2s, box-shadow .2s;
    }

    .pm-dashboard .pm-select:focus {
        border-color: var(--pm-orange);
        box-shadow: 0 0 0 3px rgba(237, 113, 28, .12);
        outline: none;
    }

    .pm-dashboard .pm-filter-buttons {
        display: flex;
        align-items: flex-end;
        gap: 9px;
        height: 100%;
    }

    .pm-dashboard .pm-search-btn,
    .pm-dashboard .pm-reset-btn {
        min-height: 44px;
        border-radius: 8px;
        padding: 10px 17px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all .2s;
    }

    .pm-dashboard .pm-search-btn {
        border: 1px solid var(--pm-orange);
        background: linear-gradient(135deg, #f68a2c, #e96512);
        color: #fff;
    }

    .pm-dashboard .pm-search-btn:hover {
        background: var(--pm-orange-dark);
        color: #fff;
    }

    .pm-dashboard .pm-reset-btn {
        border: 1px solid #e6d9d0;
        background: #fff;
        color: #70462b;
        text-decoration: none;
    }

    .pm-dashboard .pm-reset-btn:hover {
        background: #fff3e9;
        color: var(--pm-orange-dark);
    }

    .pm-dashboard .pm-results-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(44, 36, 27, .04);
        overflow: hidden;
    }

    .pm-dashboard .pm-results-header {
        padding: 15px 22px;
        border-bottom: 1px solid #f0eae5;
        color: #40352e;
        font-size: 14px;
        font-weight: 700;
    }

    .pm-dashboard .pm-results-header i {
        color: var(--pm-orange);
        margin-right: 8px;
    }

    .pm-dashboard .pm-results-body {
        padding: 20px;
        min-height: 100px;
    }

    .pm-dashboard .nowraptd {
        white-space: nowrap;
    }

    .pm-dashboard .dn {
        display: none;
    }

    @media (max-width: 767px) {
        .pm-dashboard .pm-header {
            padding: 16px;
        }

        .pm-dashboard .pm-title {
            font-size: 18px;
        }

        .pm-dashboard .pm-actions {
            width: 100%;
        }

        .pm-dashboard .pm-action-btn {
            flex: 1;
        }

        .pm-dashboard .pm-filter-body {
            padding: 18px;
        }

        .pm-dashboard .pm-filter-buttons {
            margin-top: 5px;
        }

        .pm-dashboard .pm-search-btn,
        .pm-dashboard .pm-reset-btn {
            flex: 1;
        }
    }
</style>

<div class="container-fluid pagecontentbody pm-dashboard">
    <div class="tab-content">
        <div class="pagebody removebg-color">

            <!-- Dashboard Header -->
            <div class="pm-header" id="menu-margin">
                <div class="pm-heading">
                    <div class="pm-heading-icon">
                        <i class="fa fa-bar-chart"></i>
                    </div>

                    <div>
                        <h4 class="pm-title">
                            PM Gati Shakti Dashboard
                        </h4>
                        <p class="pm-subtitle">
                            Division, District & Stadium Overview
                        </p>
                    </div>
                </div>

                <div class="pm-actions">
                    <button type="button"
                        onclick="ExportToExcel('PM Gati Shakti')"
                        class="pm-action-btn">
                        <i class="fa fa-file-excel-o"
                            style="color:#16834a;"></i>
                        Excel
                    </button>

                    <button type="button"
                        onclick="PrintDoc()"
                        class="pm-action-btn">
                        <i class="fa fa-print"
                            style="color:#e96512;"></i>
                        प्रिंट
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="pm-filter-card">

                <div class="pm-filter-heading">
                    <i class="fa fa-sliders"></i>
                    Filter Dashboard
                </div>

                <div class="pm-filter-body">
                    <form method="GET"
                        action="{{ url()->current() }}">

                        <div class="row g-3 align-items-end">

                            <!-- Division -->
                            <div class="col-xl-3 col-md-6">
                                <label class="pm-label">
                                    <i class="fa fa-sitemap"></i>
                                    Division
                                </label>

                                <select name="division_id"
                                    class="pm-select">
                                    <option value="">
                                        All Divisions
                                    </option>

                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ request('division_id') == $division->id ? 'selected' : '' }}>
                                            {{ $division->division_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- District -->
                            <div class="col-xl-3 col-md-6">
                                <label class="pm-label">
                                    <i class="fa fa-map-marker"></i>
                                    District
                                </label>

                                <select name="district_id"
                                    class="pm-select">
                                    <option value="">
                                        All Districts
                                    </option>

                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}"
                                            {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                            {{ $district->city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Stadium -->
                            <div class="col-xl-3 col-md-6">
                                <label class="pm-label">
                                    <i class="fa fa-futbol-o"></i>
                                    Stadium
                                </label>

                                <select name="stadium_id"
                                    class="pm-select">
                                    <option value="">
                                        All Stadiums
                                    </option>

                                    @foreach($stadiums as $stadium)
                                        <option value="{{ $stadium->id }}"
                                            {{ request('stadium_id') == $stadium->id ? 'selected' : '' }}>
                                            {{ $stadium->studium_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Search and Reset -->
                            <div class="col-xl-3 col-md-6">
                                <div class="pm-filter-buttons">
                                    <button type="submit"
                                        class="pm-search-btn">
                                        <i class="fa fa-search"></i>
                                        Search
                                    </button>

                                    <a href="{{ url()->current() }}"
                                        class="pm-reset-btn">
                                        <i class="fa fa-refresh"></i>
                                        Reset
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- Dashboard Results -->
            <div class="pm-results-card">
                <div class="pm-results-header">
                    <i class="fa fa-table"></i>
                    Dashboard Report
                </div>

                <div class="pm-results-body" id="prodiv">
                    <!-- Your dashboard data goes here -->
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function PrintDoc() {
        var divToPrint = document.getElementById('prodiv');
        var newWin = window.open('', 'Print-Window');

        if (!newWin) return;

        newWin.document.open();
        newWin.document.write(
            '<html><head><title>PM Gati Shakti</title></head>' +
            '<body onload="window.print()">' +
            divToPrint.innerHTML +
            '</body></html>'
        );
        newWin.document.close();
    }

    function ExportToExcel(fileName) {
        var table = document.getElementById('prodiv');
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' +
            encodeURIComponent(html);

        var link = document.createElement('a');
        link.href = url;
        link.download = fileName + '.xls';

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>

@endsection
