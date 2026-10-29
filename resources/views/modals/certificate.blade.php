{{-- Certificate dialogs; js/home drives them by id. --}}
<div class="modal fade" id="certificate_modal" tabindex="-1" aria-labelledby="certificate_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-heading">
                    <span class="modal-icon"><i class="bi bi-file-earmark-medical"></i></span>
                    <div>
                        <h5 class="modal-title" id="certificate_modal_title">Certificate</h5>
                        <p class="modal-sub">Fields marked <span class="req">*</span> are required.</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="certificate_form" autocomplete="off">

                </form>
            </div>
            <div class="modal-footer">
                {{-- js/home binds these; the form's own "Add" / "Choose" buttons click them. --}}
                <div class="d-none">
                    <button type="button" id="btn_add_doctor">Add physician</button>
                    <button type="button" class="list-field-btn d-none" id="btn_add_chief_complaint" data-field="chief_complaint">Chief complaint</button>
                    <button type="button" id="btn_add_diagnosis">Diagnosis</button>
                    <button type="button" class="list-field-btn d-none" id="btn_add_medication" data-field="medication">Medication</button>
                    <button type="button" class="list-field-btn d-none" id="btn_add_plan" data-field="plan">Plan</button>
                </div>
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="btn_save">
                    <i class="bi bi-check2"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="diagnosis_modal" tabindex="-1" aria-labelledby="diagnosis_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-heading">
                    <span class="modal-icon"><i class="bi bi-clipboard2-pulse"></i></span>
                    <h5 class="modal-title" id="diagnosis_modal_title">Enter diagnosis</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-floating">
                    <textarea type="text" class="form-control" id="diagnosis" style="height: 300px"></textarea>
                    <label for="diagnosis">Enter here</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="btn_save_diagnosis">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="list_item_modal" tabindex="-1" aria-labelledby="list_item_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-heading">
                    <span class="modal-icon"><i class="bi bi-list-check"></i></span>
                    <h5 class="modal-title" id="list_item_modal_title">Enter item</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-floating">
                    <textarea type="text" class="form-control" id="list_item_input" style="height: 300px"></textarea>
                    <label for="list_item_input">Enter here</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="btn_save_list_item">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="doctor_modal" tabindex="-1" aria-labelledby="doctor_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-heading">
                    <span class="modal-icon"><i class="bi bi-person-badge"></i></span>
                    <h5 class="modal-title" id="doctor_modal_title">Select physician</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body w-100">
                <label class="form-label" for="select_doctor">Physician</label>
                <select class="js-example-basic-single w-100" name="doctor" id="select_doctor">

                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="btn_set_doctor">Set</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="heading_modal" tabindex="-1" aria-labelledby="heading_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-heading">
                    <span class="modal-icon"><i class="bi bi-printer"></i></span>
                    <div>
                        <h5 class="modal-title" id="heading_modal_title">Print settings</h5>
                        <p class="modal-sub">Margins are in pixels on the printed page.</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body w-100">
                <div class="form-section">
                    <h6 class="section-title"><i class="bi bi-arrows-vertical"></i> Margins</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="d_margin_top">
                                <label for="d_margin_top">Top (Diagnosis)</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="d_margin_bottom">
                                <label for="d_margin_bottom">Bottom (Diagnosis)</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="s_margin_top">
                                <label for="s_margin_top">Top (Code)</label>
                            </div>
                        </div>
                        <div class="col-6 d-none">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="s_margin_bottom">
                                <label for="s_margin_bottom">Bottom (Code)</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="seal_margin_top">
                                <label for="seal_margin_top">Top (Seal)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h6 class="section-title"><i class="bi bi-layout-text-sidebar"></i> Layout</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="with_myla">
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <label for="with_myla">With Myla signatory</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="hide_middle_portion">
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <label for="hide_middle_portion">Hide details</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section medical-abstract-only d-none">
                    <h6 class="section-title"><i class="bi bi-files"></i> Page of each section</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="chief_complaint_page">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <label for="chief_complaint_page">Chief complaint</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="diagnosis_page">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <label for="diagnosis_page">Diagnosis</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="medication_page">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <label for="medication_page">Medication on board</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="plan_page">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <label for="plan_page">Plan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="btn_print_certificate">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="choose_certificate_modal" tabindex="-1" aria-labelledby="choose_certificate_modal_title"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm-plus">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-heading">
                    <span class="modal-icon"><i class="bi bi-file-earmark-plus"></i></span>
                    <h5 class="modal-title" id="choose_certificate_modal_title">Choose certificate</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body w-100">
                <label class="form-label" for="select_certificate">Certificate type</label>
                <select class="form-select" id="select_certificate">
                    <option value="10">AKSYON AGAD</option>
                    <option value="12">AKSYON AGAD - INPATIENT</option>
                    <option value="2">PRESIGNED - ER/OPD</option>
                    <option value="13">PRESIGNED - OPD</option>
                    <option value="1">ORDINARY MEDCERT - ER/OPD</option>
                    <option value="5">PRESIGNED - INPATIENT</option>
                    <option value="4">ORDINARY MEDCERT - INPATIENT</option>
                    <option value="14">MEDICAL CERT INPATIENT - FILING CASES</option>
                    <option value="3">MEDICO LEGAL</option>
                    <option value="6">COC</option>
                    <option value="7">MEDICAL ABSTRACT</option>
                    <option value="11">PRESIGNED - DENTAL</option>
                    <option value="8">DENTAL</option>
                    <option value="9">OTHER RECORDS</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="btn_set_certificate">Continue</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tagging_modal" tabindex="-1" aria-labelledby="tagging_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-heading">
                    <span class="modal-icon"><i class="bi bi-tag"></i></span>
                    <div>
                        <h5 class="modal-title" id="tagging_modal_title">Tag certificate</h5>
                        <p class="modal-sub">Patient: <span id="tag_patient" class="fw-semibold"></span></p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body w-100">
                <label class="form-label" for="select_tag">Tag as</label>
                <select class="js-example-basic-single w-100" name="doctor" id="select_tag">
                    <option>FOR RELEASE</option>
                    <option>RELEASED</option>
                    <option>CANCELLED</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="btn_save_tag">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="report_modal" tabindex="-1" aria-labelledby="report_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-heading">
                    <span class="modal-icon"><i class="bi bi-file-earmark-spreadsheet"></i></span>
                    <div>
                        <h5 class="modal-title" id="report_modal_title">Generate report</h5>
                        <p class="modal-sub">Pick a date range, generate, then download as Excel.</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <div class="input-icon report-range">
                        <i class="bi bi-calendar3"></i>
                        <input name="datefilter" class="form-control" placeholder="Select date range" id="filter_date"
                               readonly/>
                    </div>
                    <button class="btn btn-primary" id="btn_generate_report">
                        <i class="bi bi-arrow-repeat"></i> Generate
                    </button>
                </div>
                <div class="card list-card mb-0">
                    <div class="table-responsive">
                        <table class="table table-hover m-0 data-table">
                            <thead>
                            <tr>
                                <th>Date/Time Requested</th>
                                <th>Cert No.</th>
                                <th>Patient</th>
                                <th>Document Requested</th>
                                <th>CS No.</th>
                                <th>OR No.</th>
                                <th>Received by</th>
                                <th>Prepared by</th>
                                <th>Requested by</th>
                                <th>Relationship</th>
                                <th>Date/Time Completed</th>
                                <th>Date/Time Released</th>
                                <th>Released/Cancelled by</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody id="report_list">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-outline-primary" id="btn_download_report">
                    <i class="bi bi-download"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>
