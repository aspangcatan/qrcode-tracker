<div class="modal fade" id="settings_modal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-end">
                    <button type="button" style="background: transparent !important;" class="btn"
                            data-bs-dismiss="modal" aria-label="Close">X
                    </button>
                </div>
                <h5 class="card-title">Change password</h5>
                <div class="text-white bg-danger rounded p-2 error_container d-none">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>There are some errors, please correct them below:</div>
                    </div>
                    <ul class="error_list"></ul>
                </div>
                <div class="form-label">
                    <label>Old password</label>
                    <input type="password" class="form-control" id="old_password"/>
                </div>
                <div class="form-label">
                    <label>New password</label>
                    <input type="password" class="form-control" id="new_password"/>
                </div>
                <div class="form-label">
                    <label>Confirm password</label>
                    <input type="password" class="form-control" id="confirm_password"/>
                </div>

                <button class="btn btn-primary mt-2 float-end" id="btn_change_password">Proceed</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="window_modal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <h4>SELECT WINDOW</h4>
                    <button type="button" style="background: transparent !important;" class="btn"
                            data-bs-dismiss="modal" aria-label="Close">X
                    </button>
                </div>

            </div>
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <select class="form-control" id="form_window">
                        <option value="">Select window</option>
                        <option value="1">OPD</option>
                        <option value="2">ER/INPATIENT (1)</option>
                        <option value="3">ER/INPATIENT (2)</option>
                        <option value="4">LIVE BIRTH CERT</option>
                    </select>
                    <label for="floatingInput">Window</label>
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <button class="btn btn-danger mr-1" id="btn_open_tv">OPEN TV</button>
                    <button class="btn btn-primary ml-1" id="btn_set_window">SAVE</button>
                </div>

            </div>
        </div>
    </div>
</div>

