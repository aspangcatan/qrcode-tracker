@extends('master')
@section('content')
    <div class="page-head">
        <div>
            <p class="eyebrow">Health Information Management</p>
            <h1>Certificates</h1>
            <p class="page-sub">Medical certificates and records requested at the window. Edit, print with QR, or tag for release.</p>
        </div>
        <div class="page-actions">
            <button class="btn btn-light" id="btn_add_report">
                <i class="bi bi-file-earmark-spreadsheet"></i> Generate Report
            </button>
            <button class="btn btn-primary" id="btn_add_certificate">
                <i class="bi bi-plus-lg"></i> Create Certificate
            </button>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 {{ config('app.queue_enabled') ? 'col-xxl-9' : '' }}">
            <div class="card list-card">
                <div class="toolbar">
                    <div class="input-icon flex-grow-1">
                        <i class="bi bi-search"></i>
                        <input class="form-control" placeholder="Search patient" id="filter_patient"/>
                    </div>
                    <div class="input-icon">
                        <i class="bi bi-hash"></i>
                        <input class="form-control" placeholder="Certificate No." id="filter_certificate_no"/>
                    </div>
                    <div class="input-icon">
                        <i class="bi bi-circle-half"></i>
                        <select class="form-select" id="filter_status">
                            <option value="">All statuses</option>
                            <option>PENDING</option>
                            <option>FOR RELEASE</option>
                            <option>RELEASED</option>
                            <option>CANCELLED</option>
                        </select>
                    </div>
                    <div class="input-icon">
                        <i class="bi bi-file-earmark-text"></i>
                        <select class="form-select" id="filter_type">
                            <option value="">All types</option>
                            <option value="aksyon_agad">AKSYON AGAD</option>
                            <option value="aksyon_agad_inpatient">AKSYON AGAD - INPATIENT</option>
                            <option value="maipp">PRESIGNED - ER/OPD</option>
                            <option value="maipp_opd">PRESIGNED - OPD</option>
                            <option value="ordinary">ORDINARY MEDCERT - ER/OPD</option>
                            <option value="maipp_inpatient">PRESIGNED - INPATIENT</option>
                            <option value="ordinary_inpatient">ORDINARY MEDCERT - INPATIENT</option>
                            <option value="ordinary_inpatient_filing">MEDICAL CERT INPATIENT - FILING CASES</option>
                            <option value="medico_legal">MEDICO LEGAL</option>
                            <option value="coc">COC</option>
                            <option value="medical_abstract">MEDICAL ABSTRACT</option>
                            <option value="dental_presigned">PRESIGNED - DENTAL</option>
                            <option value="dental">DENTAL</option>
                            <option value="common">OTHER RECORDS</option>
                        </select>
                    </div>
                    <div class="input-icon">
                        <i class="bi bi-calendar3"></i>
                        <input type="text" class="form-control" placeholder="Date requested" id="filter_date_issued"/>
                    </div>
                    <button class="btn btn-primary" id="btn_search">
                        <i class="bi bi-funnel"></i> Apply
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover m-0 data-table">
                        <thead>
                        <tr>
                            <th colspan="3">Actions</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Patient</th>
                            <th>Health Record No.</th>
                            <th>Certificate No.</th>
                            <th class="text-center">Date Requested</th>
                            <th class="text-center">Date Created</th>
                            <th class="text-center">Date Issued</th>
                            <th>Prepared by</th>
                            <th>Released/Cancelled by</th>
                        </tr>
                        </thead>
                        <tbody id="certificate_lists">

                        </tbody>
                        <tfoot class="d-none"></tfoot>
                    </table>
                </div>

                {{-- js/home drives these by id: it fills #page_items_count and toggles #btn_prev / #btn_next. --}}
                <div class="card-footer" id="pagination_container">
                    <div class="pager">
                        <span class="pager-label">Showing <strong id="page_items_count"></strong></span>
                        <div class="pager-buttons">
                            <button class="btn btn-sm btn-light d-none" id="btn_prev" title="Previous page">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button class="btn btn-sm btn-light" id="btn_next" title="Next page">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(config('app.queue_enabled'))
        <div class="col-12 col-xxl-3 order-first order-xxl-last">
            <div class="card queue-card queue-sticky">
                <div class="card-header">
                    <div class="queue-window">
                        <span class="info-label">Window</span>
                        <strong class="d-none" id="window_serving">{{ session("window_no", "-") }}</strong>
                        <strong id="window_label">{{ session("window_label", "-") }}</strong>
                    </div>
                    <button class="btn btn-ghost" id="btn_settings" title="Window settings">
                        <i class="bi bi-sliders"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="now-serving">
                        <span class="info-label">Now serving</span>
                        <div id="number_serving">
                            @if($ticket_no && isset($ticket_no->ticket_no))
                                {{ $ticket_no->ticket_no }}
                            @endif
                        </div>
                    </div>
                    <div class="queue-actions">
                        <button class="btn btn-primary" id="btn_next_ticket" onclick="next()">
                            <i class="bi bi-skip-forward-fill"></i> Next
                        </button>
                        <button class="btn btn-warning" id="btn_next_ticket_senior" onclick="nextSenior()">
                            <i class="bi bi-person-wheelchair"></i> Next senior
                        </button>
                        <button class="btn btn-danger" id="btn_notify" onclick="notify()">
                            <i class="bi bi-megaphone"></i> Notify
                        </button>
                    </div>

                    {{-- Filter --}}
                    <hr class="queue-divider">
                    <div class="row g-2 mb-2">
                        <div class="col-6 col-xxl-12">
                            <label for="date_from" class="form-label">From</label>
                            <input type="date" id="date_from" class="form-control form-control-sm">
                        </div>
                        <div class="col-6 col-xxl-12">
                            <label for="date_to" class="form-label">To</label>
                            <input type="date" id="date_to" class="form-control form-control-sm">
                        </div>
                    </div>

                    {{-- Hidden status filter (if needed in future) --}}
                    <div class="mb-2 d-none">
                        <label for="status_filter" class="form-label small">Status</label>
                        <select id="status_filter" class="form-select form-select-sm">
                            <option value="">ALL</option>
                            <option value="PENDING">PENDING</option>
                            <option value="FOR RELEASE">FOR RELEASE</option>
                            <option value="RELEASED">RELEASED</option>
                            <option value="CANCELLED">CANCELLED</option>
                        </select>
                    </div>

                    <button class="btn btn-outline-primary btn-sm w-100" id="filter_dashboard">
                        <i class="bi bi-funnel"></i> Filter
                    </button>

                    {{-- Display Total Served --}}
                    <div class="served-tile">
                        <span class="served-icon"><i class="bi bi-people"></i></span>
                        <div>
                            <span class="info-label">Total served</span>
                            <p id="served_count">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @include('modals.certificate')
@stop
@section('js')
    @include('js.home')
@stop
