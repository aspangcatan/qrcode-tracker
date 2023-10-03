<div class="modal fade" id="qr_modal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-title p-1" style="font-size: 24px">Create QR</div>
            </div>
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="patient_name">
                    <label>Patient</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="hospital_no">
                    <label>Hospital No.</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="certificate_no">
                    <label>Certificate No.</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="date_issued">
                    <label>Date Issued</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary mr-1" data-bs-dismiss="modal">CANCEL</button>
                <button class="btn btn-success ml-1" id="btn_save">SAVE</button>
            </div>
        </div>
    </div>
</div>
