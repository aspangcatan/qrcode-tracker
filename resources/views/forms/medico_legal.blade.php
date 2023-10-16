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
        MEDICO LEGAL CERTIFICATE
    </div>
    <div class="certificate-text">
        <div>
            This is to certify that
            <div class="medium">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="patient" placeholder="Patient's name" value="{{ $certificates->patient }}">
                @else
                    <input type="text" id="patient" placeholder="Patient's name">
                @endif
            </div>
            ,
            <div class="very-small">
                @if(isset($certificates) && $certificates)
                    <input type="number" id="age" placeholder="age" value="{{ $certificates->age }}">
                @else
                    <input type="number" id="age" placeholder="age">
                @endif
            </div>
            years old,
            <div class="small mt-2">
                @if(isset($certificates) && $certificates)
                    <input type="text" id="sex" placeholder="sex" value="{{ $certificates->sex }}"/>
                @else
                    <input type="text" id="sex" placeholder="sex"/>
                @endif
            </div>
            ,
            <div class="small">
                @if(isset($certificates) && $certificates)
                    <select id="civil_status">
                        @if($certificates->civil_status == "SINGLE")
                            <option selected>SINGLE</option>
                        @else
                            <option>SINGLE</option>
                        @endif

                        @if($certificates->civil_status == "MARRIED")
                            <option selected>MARRIED</option>
                        @else
                            <option>MARRIED</option>
                        @endif

                        @if($certificates->civil_status == "CHILD")
                            <option selected>CHILD</option>
                        @else
                            <option>CHILD</option>
                        @endif

                        @if($certificates->civil_status == "WIDOW/ER")
                            <option selected>WIDOW/ER</option>
                        @else
                            <option>WIDOW/ER</option>
                        @endif
                    </select>
                @else
                    <select id="civil_status">
                        <option>SINGLE</option>
                        <option>MARRIED</option>
                        <option>CHILD</option>
                        <option>WIDOW/ER</option>
                    </select>
                @endif
            </div>
            , Filipino, and a resident of
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
            <span>on</span>
            <div class="small">
                @if(isset($certificates) && $certificates)
                    <input type="datetime-local" id="date_examined" value="{{ $certificates->date_examined }}">
                @else
                    <input type="datetime-local" id="date_examined">
                @endif
            </div>
            <div class="mt-1">
                for the following lesion/injury:
            </div>
        </div>
        <div class="mt-3 mb-3">
            <div>DIAGNOSIS:</div>
            <table id="diagnosis_list" class="ms-5">
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
        <div class="mt-3 mb-3">
            <table class="w-100">
                <tr>
                    <td>sustained by:</td>
                    <td>
                        <div class="d-block">NOI:</div>
                    </td>
                    <td>
                        <div class="medium">
                            @if(isset($sustained) && $sustained)
                                <input type="text" id="noi" value="{{ $sustained->noi }}"/>
                            @else
                                <input type="text" id="noi"/>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="d-block">DOI:</div>
                    </td>
                    <td>
                        <div class="medium">
                            @if(isset($sustained) && $sustained)
                                <input type="text" id="doi" value="{{ $sustained->doi }}"/>
                            @else
                                <input type="text" id="doi"/>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="d-block">POI:</div>
                    </td>
                    <td>
                        <div class="medium">
                            @if(isset($sustained) && $sustained)
                                <input type="text" id="poi" value="{{ $sustained->poi }}"/>
                            @else
                                <input type="text" id="poi"/>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="d-block">TOI:</div>
                    </td>
                    <td>
                        <div class="medium">
                            @if(isset($sustained) && $sustained)
                                <input type="text" id="toi" value="{{ $sustained->toi }}"/>
                            @else
                                <input type="text" id="toi"/>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="mt-2">
            In my opinion, the injuries sustained by the patient will incapacitate or require medical attention for a
            period of
            <div class="very-small">
                @if(isset($certificates) && $certificates)
                    <input type="number" id="days_barred" placeholder="days" value="{{ $certificates->days_barred }}"/>
                @else
                    <input type="number" id="days_barred" placeholder="days"/>
                @endif
            </div>
            day/days barring complications, otherwise the period of healing will vary accordingly.
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
                                <input type="number" id="amount" value="{{ $certificates->amount }}">
                            @else
                                <input type="number" id="amount">
                            @endif
                        </div>
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
