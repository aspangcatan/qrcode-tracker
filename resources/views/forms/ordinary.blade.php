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
                                <input type="text" id="certificate_no" value="{{ $certificates->certificate_no }}"/>
                            @else
                                <input type="text" id="certificate_no"/>
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
                                <input type="date" id="date_issued" value="{{ $certificates->date_issued }}"/>
                            @else
                                <input type="date" id="date_issued"/>
                            @endif
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="certificate-title">
        MEDICAL CERTIFICATE
    </div>
    <div class="certificate-text">
        <div>
            This is to certify
            <div class="medium">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="patient" placeholder="Name" value="{{ $certificates->patient }}"/>
                @else
                    <input type="text" id="patient" placeholder="Name"/>
                @endif
            </div>

            ,
            <div class="very-small">
                @if(isset($certificates) && $certificates)
                    <input type="number" id="age" placeholder="age" value="{{ $certificates->age }}"/>
                @else
                    <input type="number" id="age" placeholder="age"/>
                @endif
            </div>
            years old, of
        </div>
        <div>
            <div class="long">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="address" placeholder="address" value="{{ $certificates->address }}"/>
                @else
                    <input type="text" id="address" placeholder="address"/>
                @endif
            </div>
            was examined and treated in this<br/>
        </div>
        <div>
            hospital on/from
            <div class="small">
                @if(isset($certificates) && $certificates)
                    <input type="date" id="date_examined"
                           value="{{ \Illuminate\Support\Carbon::parse($certificates->date_examined)->format('Y-m-d') }}"/>
                @else
                    <input type="date" id="date_examined"/>
                @endif
            </div>
            with the following findings and/or diagnosis:
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3 mb-3">
        <table id="diagnosis_list" class="w-50">
            @if(isset($diagnosis) && $diagnosis)
                @foreach($diagnosis as $item)
                    <tr>
                        <td style='width: 90%'>{{ $item->diagnosis }}</td>
                        <td style='width: 5%'>
                            <button class='btn btn-sm btn-transparent' onClick='editDiagnosis(this)'><i
                                    class='bi bi-pencil-fill text-success'></i></button>
                        </td>
                        <td style='width: 5%'>
                            <button class='btn btn-sm btn-transparent' onClick='deleteDiagnosis(this)'><i
                                    class='bi bi-trash-fill text-danger'></i></button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
    <div class="certificate-text">
        <table style="width: 100%">
            <tr>
                <td>This certification is being issued at the requested of</td>
                <td>
                    <div class="small">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="requesting_person" placeholder="Name of Person Requesting"
                                   value="{{ $certificates->requesting_person }}"/>
                        @else
                            <input type="text" id="requesting_person" placeholder="Name of Person Requesting"/>
                        @endif
                    </div>
                    <div class="small">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="relationship" placeholder="Relationship"
                                   value="{{ $certificates->relationship }}"/>
                        @else
                            <input type="text" id="relationship" placeholder="Relationship"/>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr>
                <td>for</td>
                <td>
                    <div class="long ml-1">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="purpose" placeholder="Purpose" value="{{ $certificates->purpose }}"/>
                        @else
                            <input type="text" id="purpose" placeholder="Purpose"/>
                        @endif
                    </div>
                </td>
                <td style="width: 20%"></td>
            </tr>
        </table>
    </div>

    <div class="doctor-container mt-3">
        <div>Doctor:
            <div class="medium ml-1">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="doctor" value="{{ $certificates->doctor }}"/>
                @else
                    <input type="text" id="doctor"/>
                @endif
            </div>
        </div>
        <div>Designation:
            <div class="medium ml-1">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="doctor_designation" value="{{ $certificates->doctor_designation }}"/>
                @else
                    <input type="text" id="doctor_designation"/>
                @endif
            </div>
        </div>
        <div>License No.:
            <div class="medium ml-1">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="doctor_license" value="{{ $certificates->doctor_license }}"/>
                @else
                    <input type="text" id="doctor_license"/>
                @endif
            </div>
        </div>
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
            <tr>
                <td>Registry No.</td>
                <td>:</td>
                <td>
                    <div class="medium">
                        @if(isset($certificates) && $certificates)
                            <input type="text" id="registry_no" value="{{ $certificates->registry_no }}">
                        @else
                            <input type="text" id="registry_no">
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
                            <input type="datetime-local" id="date_requested" value="{{ $certificates->date_requested }}" />
                        @else
                            <input type="datetime-local" id="date_requested" />
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
                            <input type="datetime-local" id="date_finished" value="{{ $certificates->date_finished }}">
                        @else
                            <input type="datetime-local" id="date_finished">
                        @endif
                    </div>
                </td>
                <td>
                </td>
            </tr>
        </table>
    </div>
</div>
