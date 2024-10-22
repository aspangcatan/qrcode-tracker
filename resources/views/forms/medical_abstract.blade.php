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
                        Hospital No:
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
        MEDICAL ABSTRACT
    </div>

    <div class="table-responsive mt-3">
        <table class="w-100">
            <tr>
                <td style="width: 12%">
                    <span>Name:</span>
                </td>
                <td style="width:43%">
                    <div class="medium">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="patient" value="{{ $certificates->patient }}"/>
                        @else
                            <input type="text" id="patient" />
                        @endif
                    </div>
                </td>
                <td style="width: 5%">
                    <span>Age:</span>
                </td>
                <td style="width: 10%">
                    <div class="small">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="age" value="{{ $certificates->age }}"/>
                        @else
                            <input type="text" id="age" />
                        @endif
                    </div>
                </td>
                <td style="width: 5%">
                    <span>Sex:</span>
                </td>
                <td style="width: 10%">
                    @if(isset($certificates) && $certificates)
                        <select id="sex" class="w-100 text-center">
                            <option></option>
                            @if(strtoupper($certificates->sex) == "MALE")
                                <option selected>MALE</option>
                            @else
                                <option>MALE</option>
                            @endif

                            @if(strtoupper($certificates->sex) == "FEMALE")
                                <option selected>FEMALE</option>
                            @else
                                <option>FEMALE</option>
                            @endif
                        </select>
                    @else
                        <select id="sex" class="w-100 text-center">
                            <option></option>
                            <option>MALE</option>
                            <option>FEMALE</option>
                        </select>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <span>Address:</span>
                </td>
                <td>
                    <div class="medium">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="address" value="{{ $certificates->address }}"/>
                        @else
                            <input type="text" id="address" />
                        @endif
                    </div>
                </td>
                <td>
                    <span>Ward/Room:</span>
                </td>
                <td colspan="3">
                    <div class="long w-100">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="ward" value="{{ $certificates->ward }}"/>
                        @else
                            <input type="text" id="ward" />
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span>Date Admitted:</span>
                </td>
                <td>
                    <div class="medium">
                        @if(isset($certificates) && $certificates)
                            <input type="datetime-local" id="date_examined" value="{{ $certificates->date_examined }}"/>
                        @else
                            <input type="datetime-local" id="date_examined" />
                        @endif
                    </div>
                </td>
            </tr>
        </table>
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
    <hr />
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
                            <input type="datetime-local" id="date_requested" value="{{ now()->format('Y-m-d\TH:i') }}"/>
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
