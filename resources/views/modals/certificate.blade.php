<div class="modal fade" id="certificate_modal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-title p-1" style="font-size: 24px">Create Certificate</div>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary mr-1" data-bs-dismiss="modal">CANCEL</button>
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
                    <textarea type="text" class="form-control" id="diagnosis" style="height: 100px"></textarea>
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

<div class="modal fade" id="report_modal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-title p-1" style="font-size: 24px">Generate Report</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="monthSelect">Select Month:</label>
                    <select class="form-select" id="monthSelect">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="yearSelect">Select Year:</label>
                    <select class="form-select" id="yearSelect">
                        @for($i=\Carbon\Carbon::now()->format('Y'); $i>=2010; $i--)
                            <option>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary mr-1" data-bs-dismiss="modal">CANCEL</button>
                <button class="btn btn-success ml-1" id="btn_generate_report">GENERATE</button>
            </div>
        </div>
    </div>
</div>

