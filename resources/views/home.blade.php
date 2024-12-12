@extends('master')
@section('content')
    <div class="col-12">
        <div class="d-flex justify-content-end mb-2">
            <div class="me-1">
                <select class="form-control" id="filter_type">
                    <option value="">Search type</option>
                    <option value="aksyon_agad">AKSYON AGAD</option>
                    <option value="maipp">PRESIGNED - ER/OPD</option>
                    <option value="ordinary">ORDINARY MEDCERT - ER/OPD</option>
                    <option value="maipp_inpatient">PRESIGNED - INPATIENT</option>
                    <option value="ordinary_inpatient">ORDINARY MEDCERT - INPATIENT</option>
                    <option value="medico_legal">MEDICO LEGAL</option>
                    <option value="coc">COC</option>
                    <option value="medical_abstract">MEDICAL ABSTRACT</option>
                    <option value="dental">DENTAL</option>
                    <option value="common">OTHER RECORDS</option>
                </select>
            </div>
            <div>
                <input class="form-control" placeholder="Search patient" id="filter_patient"/>
            </div>
            <div class="ms-2 me-1">
                <input type="date" class="form-control" placeholder="Search date issued" id="filter_date_issued"/>
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

    @include('modals.certificate')
@stop
@section('js')
    @include('js.home')
@stop
