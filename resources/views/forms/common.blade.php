<div class="container">
    <table style="width: 100%">
        <tr>
            <td></td>
            <td>
                <div class="certificate-details">
                    <div class="mt-1">
                        Certificate No:
                        <div class="small">
                            @if(isset($certificates) && $certificates)
                                <input type="text" id="certificate_no" value="{{ $certificates->certificate_no }}"
                                       disabled/>
                            @else
                                @if(isset($certificate_no) && $certificate_no)
                                    <input type="text" id="certificate_no" value="{{ $certificate_no }}" disabled/>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div>
                        Health Record No:
                        <div class="small">
                            @if(isset($certificates) && $certificates)
                                <input type="text" id="health_record_no" value="{{ $certificates->health_record_no }}"/>
                            @else
                                <input type="text" id="health_record_no"/>
                            @endif
                        </div>
                    </div>
                    <div class="mt-1">
                        Date:
                        <div class="small">
                            @if(isset($certificates) && $certificates)
                                <input type="date" id="date_issued"
                                       value="{{ date('Y-m-d', strtotime($certificates->created_at)) }}" disabled/>
                            @else
                                <input type="date" id="date_issued" value="{{ now()->format('Y-m-d') }}" disabled/>
                            @endif
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="certificate-title">
        COMMON CERTIFICATE
    </div>

    <div class="mt-3">
        <table class="w-100">
            <tr>
                <td>Type:</td>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check">
                                @if(isset($certificates) && $certificates)
                                    <input class="form-check-input" type="checkbox" name="document_type"
                                           @if($certificates->specific_document == 'Certified Machine Copy') checked @endif>
                                @else
                                    <input class="form-check-input" type="checkbox" name="document_type">
                                @endif
                                <label class="form-check-label">
                                    Certified Machine Copy
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                @if(isset($certificates) && $certificates)
                                    <input class="form-check-input" type="checkbox" name="document_type"
                                           @if($certificates->specific_document == 'OR Record') checked @endif>
                                @else
                                    <input class="form-check-input" type="checkbox" name="document_type">
                                @endif
                                <label class="form-check-label">
                                    OR Record
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                @if(isset($certificates) && $certificates)
                                    <input class="form-check-input" type="checkbox" name="document_type"
                                           @if($certificates->specific_document == 'Laboratory Results') checked @endif>
                                @else
                                    <input class="form-check-input" type="checkbox" name="document_type">
                                @endif
                                <label class="form-check-label">
                                    Laboratory Results
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                @if(isset($certificates) && $certificates)
                                    <input class="form-check-input" type="checkbox" name="document_type"
                                           @if($certificates->specific_document == 'Xray Results') checked @endif>
                                @else
                                    <input class="form-check-input" type="checkbox" name="document_type">
                                @endif
                                <label class="form-check-label">
                                    Xray Results
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                @if(isset($certificates) && $certificates)
                                    <input class="form-check-input" type="checkbox" name="document_type"
                                           @if($certificates->specific_document == 'Discharge Summary') checked @endif>
                                @else
                                    <input class="form-check-input" type="checkbox" name="document_type">
                                @endif
                                <label class="form-check-label">
                                    Discharge Summary
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                @if(isset($certificates) && $certificates)
                                    <input class="form-check-input" type="checkbox" name="document_type"
                                           @if($certificates->specific_document == 'Histopath Result') checked @endif>
                                @else
                                    <input class="form-check-input" type="checkbox" name="document_type">
                                @endif
                                <label class="form-check-label">
                                    Histopath Result
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                @if(isset($certificates) && $certificates)
                                    <input class="form-check-input" type="checkbox" name="document_type"
                                           @if($certificates->specific_document == 'Fetal Death Certificate') checked @endif>
                                @else
                                    <input class="form-check-input" type="checkbox" name="document_type">
                                @endif
                                <label class="form-check-label">
                                    Fetal Death Certificate
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                @if(isset($certificates) && $certificates)
                                    <input class="form-check-input" type="checkbox" name="document_type"
                                           @if($certificates->specific_document == 'Death Certificate') checked @endif>
                                @else
                                    <input class="form-check-input" type="checkbox" name="document_type">
                                @endif
                                <label class="form-check-label">
                                    Death Certificate
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                @if(isset($certificates) && $certificates)
                                    <input class="form-check-input" type="checkbox" name="document_type"
                                           @if($certificates->specific_document != ' Certified Machine Copy' && $certificates->specific_document != 'OR Record' &&
                                            $certificates->specific_document != 'Laboratory Results' && $certificates->specific_document != 'Xray Results' &&
                                            $certificates->specific_document != 'Discharge Summary' && $certificates->specific_document != 'Histopath Result' &&
                                            $certificates->specific_document != 'Fetal Death Certificate' && $certificates->specific_document != 'Death Certificate') checked @endif>
                                @else
                                    <input class="form-check-input" type="checkbox" name="document_type">
                                @endif
                                <div class="d-flex">
                                    <label class="form-check-label">Others</label>
                                    <div class="d-inline-block">
                                        <div class="medium">

                                            @if(isset($certificates) && $certificates && $certificates->specific_document != ' Certified Machine Copy' && $certificates->specific_document != 'OR Record' &&
                                            $certificates->specific_document != 'Laboratory Results' && $certificates->specific_document != 'Xray Results' &&
                                            $certificates->specific_document != 'Discharge Summary' && $certificates->specific_document != 'Histopath Result' &&
                                            $certificates->specific_document != 'Fetal Death Certificate' && $certificates->specific_document != 'Death Certificate')
                                                <input type="text" id="document_type"
                                                       value="{{ $certificates->specific_document }}"/>
                                            @else
                                                <input type="text" id="document_type"/>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <hr/>
        <div class="row">
            <div class="col-md-4">
                <div>Name of Patient:</div>
                @if(isset($certificates) && $certificates)
                    <input type="text" id="patient" class="text-start form-control"
                           value="{{ $certificates->patient }}"/>
                @else
                    <input type="text" id="patient" class="text-start form-control"/>
                @endif
            </div>
            <div class="col-md-4">
                <div>Relationship:</div>
                @if(isset($certificates) && $certificates)
                    <input type="text" id="relationship" class="text-start form-control"
                           value="{{ $certificates->relationship }}"/>
                @else
                    <input type="text" id="relationship" class="text-start form-control"/>
                @endif
            </div>
            <div class="col-md-4">
                <div>Requested by:</div>
                @if(isset($certificates) && $certificates)
                    <input type="text" id="requesting_person" class="text-start form-control"
                           value="{{ $certificates->requesting_person }}"/>
                @else
                    <input type="text" id="requesting_person" class="text-start form-control"/>
                @endif
            </div>
        </div>
    </div>
    <div class="doctor-container mt-3 d-none">
        <div>Doctor:
            <div class="medium ml-1">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="doctor" value="{{ $certificates->doctor }}" disabled/>
                @else
                    <input type="text" id="doctor" disabled/>
                @endif
            </div>
        </div>
        <div>Designation:
            <div class="medium ml-1">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="doctor_designation" value="{{ $certificates->doctor_designation }}"
                           disabled/>
                @else
                    <input type="text" id="doctor_designation" disabled/>
                @endif
            </div>
        </div>
        <div>License No.:
            <div class="medium ml-1">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="doctor_license" value="{{ $certificates->doctor_license }}" disabled/>
                @else
                    <input type="text" id="doctor_license" disabled/>
                @endif
            </div>
        </div>
    </div>
    <hr/>
    <div class="mt-5">
        <div>(NOT VALID WITHOUT SEAL)</div>
        <table style="width: 100%">
            <tr>
                <td style="width: 18%">OR NO</td>
                <td style="width: 3%">:</td>
                <td style="width: 49%">
                    <div class="medium">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="or_no" value="{{ $certificates->or_no }}">
                        @else
                            <input type="text" id="or_no">
                        @endif
                    </div>
                </td>
                <td style="width: 30%"></td>
            </tr>
            <tr>
                <td>AMOUNT</td>
                <td>:</td>
                <td>
                    <div class="medium">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="amount" value="{{ $certificates->amount }}">
                        @else
                            <input type="text" id="amount">
                        @endif
                    </div>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>Charge Slip no.</td>
                <td>:</td>
                <td>
                    <div class="medium">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="charge_slip_no" value="{{ $certificates->charge_slip_no }}">
                        @else
                            <input type="text" id="charge_slip_no">
                        @endif
                    </div>
                </td>
                <td>
                </td>
            </tr>
            <tr class="d-none">
                <td>Registry No.</td>
                <td>:</td>
                <td>
                    <div class="medium">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="registry_no" value="{{ $certificates->registry_no }}" disabled>
                        @else
                            <input type="text" id="registry_no" disabled>
                        @endif
                    </div>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>Date/Time Requested</td>
                <td>:</td>
                <td>
                    <div class="medium">
                        @if(isset($certificates) && $certificates)
                            <input type="datetime-local" id="date_requested"
                                   value="{{ $certificates->date_requested }}"/>
                        @else
                            <input type="datetime-local" id="date_requested"/>
                        @endif
                    </div>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>Date/Time Finished</td>
                <td>:</td>
                <td>
                    <div class="medium">
                        @if(isset($certificates) && $certificates)
                            <input type="datetime-local" id="date_finished" value="{{ $certificates->date_completed }}"
                                   disabled>
                        @else
                            <input type="datetime-local" id="date_finished" disabled>
                        @endif
                    </div>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>Received by</td>
                <td>:</td>
                <td>
                    <div class="medium">
                        <select class="js-example-basic-single w-100" id="received_by" class="w-100 text-center">
                            <option></option>
                            @foreach($receivers as $receiver)
                                @if(isset($certificates) && $certificates)
                                    <option {{ $certificates->received_by === $receiver->name ? 'selected' : '' }}>
                                        {{ $receiver->name }}
                                    </option>
                                @else
                                    <option>
                                        {{ $receiver->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </td>
                <td></td>
            </tr>
            <tr id="no_copies_container" class="d-none">
                <td>Number of Copies</td>
                <td>:</td>
                <td>
                    <div class="medium">
                        <select id="no_copies" class="w-100 text-center">
                            @for($i=1; $i<=6; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </td>
                <td></td>
            </tr>
        </table>
    </div>
</div>
