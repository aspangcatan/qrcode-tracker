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
                                       value="{{ date('Y-m-d', strtotime($certificates->created_at)) }}"/>
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
        CERTIFICATION
    </div>
    <div class="text-start">TO WHOM IT MAY CONCERN:</div>
    <div class="certificate-text">
        <div>
            This is to certify that based on the Hospital Record
            <div class="medium">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="patient" placeholder="Patient's name" value="{{ $certificates->patient }}">
                @else
                    <input type="text" id="patient" placeholder="Patient's name">
                @endif
            </div>
            , of
        </div>
        <div>
            <div class="long">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="address" placeholder="Patient's complete address"
                           value="{{ $certificates->address }}">
                @else
                    <input type="text" id="address" placeholder="Patient's complete address">
                @endif
            </div>
            <div class="small">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="age" placeholder="age" value="{{ $certificates->age }}"/>
                @else
                    <input type="text" id="age" placeholder="age"/>
                @endif
            </div>
            <div class="very-small">
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
            </div>
            , was<br/>
        </div>
        <div>
            <span>examined and treated in this hospital on</span>
            <div class="small">
                @if(isset($certificates) && $certificates)
                    <input type="date" id="date_examined"
                           value="{{ \Illuminate\Support\Carbon::parse($certificates->date_examined)->format('Y-m-d') }}">
                @else
                    <input type="date" id="date_examined">
                @endif
            </div>
            <span>to</span>
            <div class="small">
                @if(isset($certificates) && $certificates)
                    <input type="date" id="date_discharged"
                           value="{{ \Illuminate\Support\Carbon::parse($certificates->date_discharged)->format('Y-m-d') }}"/>
                @else
                    <input type="date" id="date_discharged"/>
                @endif
            </div>
        </div>
        <div>
            under the care of
            <div class="medium">
                @if(isset($certificates) && $certificates)
                    <input type="text" placeholder="Attending Physician" id="doctor"
                           value="{{ $certificates->doctor }}" disabled>
                @else
                    <input type="text" placeholder="Attending Physician" id="doctor" disabled>
                @endif
            </div>
            <span class="mr-3">-</span>
            <div class="small">
                @if(isset($certificates) && $certificates)
                    <input type="text" placeholder="License Number" id="doctor_license"
                           value="{{ $certificates->doctor_license }}" disabled>
                @else
                    <input type="text" placeholder="License Number" id="doctor_license" disabled>
                @endif
            </div>
        </div>
        <div>
            with the following working impression/s:
        </div>
        <div class="mt-3 mb-3">
            <div>DIAGNOSIS:</div>
            <table id="diagnosis_list" class="ms-5">
                @if(isset($diagnosis) && $diagnosis)
                    @foreach($diagnosis as $item)
                        <tr>
                            <td style='width: 90%'>{!! $item->diagnosis !!}</td>
                            <td style='width: 5%'>
                                <button type="button" class='btn btn-sm btn-transparent' onClick='editDiagnosis(this)'>
                                    <i
                                        class='bi bi-pencil-fill text-success'></i></button>
                            </td>
                            <td style='width: 5%'>
                                <button type="button" class='btn btn-sm btn-transparent'
                                        onClick='deleteDiagnosis(this)'><i
                                        class='bi bi-trash-fill text-danger'></i></button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
        <div class="d-flex">
            <div>This certification is being issued at the request of</div>
            <div class="small">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="requesting_person" value="{{ $certificates->requesting_person }}"
                           placeholder="Requesting person">
                @else
                    <input type="text" id="requesting_person" placeholder="Requesting person">
                @endif
            </div>
            ,
            <div class="small">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="relationship" value="{{ $certificates->relationship }}"
                           placeholder="Relationship">
                @else
                    <input type="text" id="relationship" placeholder="Relationship">
                @endif
            </div>
        </div>
        <div>Purpose</div>
        <select id="purpose">
            @if(isset($certificates) && $certificates)
                @if($certificates->purpose == 'Financial and Medical Assistance Program available in the hospital')
                    <option selected>Financial and Medical Assistance Program available in the hospital</option>
                @else
                    <option>Financial and Medical Assistance Program available in the hospital</option>
                @endif

                @if($certificates->purpose == 'School Related Purposes, except for insurance claims or any legal claim')
                    <option selected>School Related Purposes, except for insurance claims or any legal claim</option>
                @else
                    <option>School Related Purposes, except for insurance claims or any legal claim</option>
                @endif

                @if($certificates->purpose == 'Work Related-Purposes, except for insurance claims or any legal claim')
                    <option selected>Work Related-Purposes, except for insurance claims or any legal claim</option>
                @else
                    <option>Work Related-Purposes, except for insurance claims or any legal claim</option>
                @endif
            @else
                <option>Financial and Medical Assistance Program available in the hospital</option>
                <option>School Related Purposes, except for insurance claims or any legal claim</option>
                <option>Work Related-Purposes, except for insurance claims or any legal claim</option>
            @endif
        </select>
        <div id="purpose_container">
            <div>2nd Purpose</div>
            <select id="second_purpose">
                @if(isset($certificates) && $certificates)
                    @if($certificates->second_purpose === '')
                        <option selected></option>
                    @else
                        <option></option>
                    @endif
                    @if($certificates->second_purpose == '(AKSYON AGAD)')
                        <option selected>(AKSYON AGAD)</option>
                    @else
                        <option>(AKSYON AGAD)</option>
                    @endif

                    @if($certificates->second_purpose == '(CSWD)')
                        <option selected>(CSWD)</option>
                    @else
                        <option>(CSWD)</option>
                    @endif

                    @if($certificates->second_purpose == '(DSWD)')
                        <option selected>(DSWD)</option>
                    @else
                        <option>(DSWD)</option>
                    @endif

                    @if($certificates->second_purpose == '(MAIPP)')
                        <option selected>(MAIPP)</option>
                    @else
                        <option>(MAIPP)</option>
                    @endif
                @else
                    <option></option>
                    <option>(AKSYON AGAD)</option>
                    <option>(CSWD)</option>
                    <option>(DSWD)</option>
                    <option>(MAIPP)</option>
                @endif
            </select>
        </div>
        <div class="mt-3">
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
                                <input type="datetime-local" id="date_requested"
                                       value="{{ now()->format('Y-m-d\TH:i') }}"/>
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
                                <input type="datetime-local" id="date_finished"
                                       value="{{ $certificates->date_completed }}" disabled>
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
</div>
