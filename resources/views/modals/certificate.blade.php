<div class="modal fade" id="certificate_modal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-title p-1" style="font-size: 24px">Create Certificate</div>
            </div>
            <div class="modal-body">
                <form id="certificate_form" autocomplete="off">

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary mr-1" data-bs-dismiss="modal">CANCEL</button>
                <button class="btn btn-primary ml-1 mr-1" id="btn_add_doctor">ADD PHYSICIAN</button>
                <button class="btn btn-warning ml-1 mr-1" id="btn_add_diagnosis">ADD DIAGNOSIS</button>
                <button class="btn btn-success ml-1" id="btn_save">SAVE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="diagnosis_modal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-title p-1" style="font-size: 24px">Enter diagnosis</div>
            </div>
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <textarea type="text" class="form-control" id="diagnosis" style="height: 300px"></textarea>
                    <label>Enter here</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary mr-1" data-bs-dismiss="modal">CANCEL</button>
                <button class="btn btn-success ml-1" id="btn_save_diagnosis">SAVE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="doctor_modal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-title p-1" style="font-size: 24px">Select physician</div>
            </div>
            <div class="modal-body w-100">
                <select class="js-example-basic-single w-100" name="doctor"  id="select_doctor">

                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary mr-1" data-bs-dismiss="modal">CANCEL</button>
                <button class="btn btn-success ml-1" id="btn_set_doctor">SET</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="report_modal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-title p-1" style="font-size: 24px">Generate Report</div>
            </div>
            <div class="modal-body">
                <div class="ms-1">
                    <input name="datefilter" class="form-control" placeholder="Select daterange" id="filter_date" readonly/>
                </div>
                <hr />
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>PATIENT</th>
                                <th>DOCUMENT REQUESTED</th>
                                <th>CHARGE SLIP</th>
                                <th>OR NO.</th>
                                <th>REQUESTED BY</th>
                                <th>RELATIONSHIP</th>
                                <th>DATE REQUESTED</th>
                                <th>REGISTRY NO.</th>
                                <th>DATE FINISHED</th>
                            </tr>
                        </thead>
                        <tbody id="report_list">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary mr-1" data-bs-dismiss="modal">CANCEL</button>
                <button class="btn btn-success mr-1 ml-1" id="btn_generate_report">GENERATE</button>
                <button class="btn btn-danger ml-1" id="btn_download_report">DOWNLOAD</button>
            </div>
        </div>
    </div>
</div>

