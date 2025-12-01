@extends('master')
@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="d-flex justify-content-end mb-2">
                <div class="me-1">
                    <select class="form-control" id="filter_status">
                        <option value="">Search status</option>
                        <option>PENDING</option>
                        <option>FOR RELEASE</option>
                        <option>RELEASED</option>
                        <option>CANCELLED</option>
                    </select>
                </div>
                <div class="me-1">
                    <select class="form-control" id="filter_type">
                        <option value="">Search type</option>
                        <option value="aksyon_agad">AKSYON AGAD</option>
                        <option value="aksyon_agad_inpatient">AKSYON AGAD - INPATIENT</option>
                        <option value="maipp">PRESIGNED - ER/OPD</option>
                        <option value="maipp_opd">PRESIGNED - OPD</option>
                        <option value="ordinary">ORDINARY MEDCERT - ER/OPD</option>
                        <option value="maipp_inpatient">PRESIGNED - INPATIENT</option>
                        <option value="ordinary_inpatient">ORDINARY MEDCERT - INPATIENT</option>
                        <option value="medico_legal">MEDICO LEGAL</option>
                        <option value="coc">COC</option>
                        <option value="medical_abstract">MEDICAL ABSTRACT</option>
                        <option value="dental_presigned">PRESIGNED - DENTAL</option>
                        <option value="dental">DENTAL</option>
                        <option value="common">OTHER RECORDS</option>
                    </select>
                </div>
                <div>
                    <input class="form-control" placeholder="Search patient" id="filter_patient"/>
                </div>
                <div class="ms-2 me-1">
                    <input type="text" class="form-control" placeholder="Search date issued" id="filter_date_issued"/>
                </div>
                <div class="ms-1">
                    <button class="btn btn-success" id="btn_search">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title ms-3 mt-1">QR List</h5>
                        <div>
                            <button class="btn btn-danger me-3" id="btn_add_report">
                                Generate Report
                                <i class="bi bi-file-excel ms-2"></i>
                            </button>
                            <button class="btn btn-success me-3" id="btn_add_certificate">
                                Create Certificate
                                <i class="bi bi-plus-lg ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover text-center m-0" style="border-spacing: 10px;">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Patient</th>
                                <th>Health Record No.</th>
                                <th>Certificate No.</th>
                                <th>Date Requested</th>
                                <th>Date Created</th>
                                <th>Date Issued</th>
                                <th>Prepared by</th>
                                <th>Released/Cancelled by</th>
                                <th>Status</th>
                                <th colspan="5" style="width:12%"></th>
                            </tr>
                            </thead>
                            <tbody id="certificate_lists">

                            </tbody>
                            <tfoot class="d-none"></tfoot>

                        </table>
                    </div>

                </div>
                <div class="card-footer text-dark" id="pagination_container">
                    <div class="d-flex align-items-center justify-content-center">
                        <button class="btn btn-sm d-none" style="background: transparent !important;" id="btn_prev">
                            <i class="bi bi-caret-left"></i>
                        </button>
                        <div id="page_items_count"></div>
                        <button class="btn btn-sm" style="background: transparent !important;" id="btn_next">
                            <i class="bi bi-caret-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="text-primary fw-bold" style="font-size: 20px">
                            WINDOW:
                            <strong class="d-none" id="window_serving">{{ session("window_no", "-") }}</strong>
                            <strong id="window_label">{{ session("window_label", "-") }}</strong>
                        </div>
                        <button class="btn p-0" style="background: transparent" id="btn_settings">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="queue-control">
                        <h6 class="text-secondary">NOW SERVING</h6>
                        <div id="number_serving" class="display-6 fw-bold mb-3">
                            @if($ticket_no && isset($ticket_no->ticket_no))
                                {{ $ticket_no->ticket_no }}
                            @endif
                        </div>
                        <div class="d-grid gap-2 mb-2">
                            <button class="btn btn-primary" id="btn_next_ticket" onclick="next()">NEXT</button>
                            <button class="btn btn-warning" id="btn_next_ticket_senior" onclick="nextSenior()">NEXT SENIOR</button>
                            <button class="btn btn-danger" id="btn_notify" onclick="notify()">NOTIFY</button>
                        </div>
                    </div>

                    {{-- Filter --}}
                    <hr>
                    <div class="mb-2">
                        <label for="date_from" class="form-label">From</label>
                        <input type="date" id="date_from" class="form-control form-control-sm">
                    </div>
                    <div class="mb-2">
                        <label for="date_to" class="form-label">To</label>
                        <input type="date" id="date_to" class="form-control form-control-sm">
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

                    <div class="mb-2">
                        <button class="btn btn-outline-primary btn-sm w-100" id="filter_dashboard">
                            <i class="bi bi-funnel-fill me-1"></i>Filter
                        </button>
                    </div>

                    {{-- Display Total Served --}}
                    <div class="card border-0 shadow-sm mt-3" style="background-color: #E3F2FD;">
                        <div class="card-body p-2">
                            <h6 class="card-title text-primary mb-1">Total Served</h6>
                            <p class="card-text fs-5 fw-bold text-dark mb-0" id="served_count">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('modals.certificate')
@stop
@section('js')
    @include('js.home')
@stop
