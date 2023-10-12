@extends('master')
@section('content')
    <div class="col-12">
        <div class="d-flex justify-content-end mb-2">
            <div>
                <input class="form-control" placeholder="Filter patient" id="filter_patient"/>
            </div>
            <div class="ms-2 me-1">
                <input type="date" class="form-control" placeholder="Filter date issued" id="filter_date_issued"/>
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
                    <button class="btn btn-success me-3" id="btn_add">
                        Create QR
                        <i class="bi bi-plus-lg ms-2"></i>
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center m-0" style="border-spacing: 10px;">
                        <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Hospital No.</th>
                            <th>Certificate No.</th>
                            <th>Date Issued</th>
                            <th>Date Created</th>
                            <th colspan="3" style="width:12%"></th>
                        </tr>
                        </thead>
                        <tbody id="qr_list">

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
