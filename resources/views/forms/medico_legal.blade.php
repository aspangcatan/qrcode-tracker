<div class="container">
    <table style="width: 100%">
        <tr>
            <td></td>
            <td>
                <div class="certificate-details">
                    <div class="mt-1">
                        Certificate No:
                        <div class="small">
                            <input type="text" id="certificate_no"/>
                        </div>
                    </div>
                    <div>
                        Health Record No:
                        <div class="small">
                            <input type="text" id="health_record_no"/>
                        </div>
                    </div>
                    <div class="mt-1">
                        Date:
                        <div class="small">
                            <input type="date" id="date_issued"/>
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
                <input type="text" id="patient" placeholder="Patient's name">
            </div>
            ,
            <div class="very-small">
                <input type="number" id="age" placeholder="age">
            </div>
            years old,
            <div class="small mt-2">
                <input type="text" id="sex" placeholder="sex"/>
            </div>
            ,
            <div class="small">
                <input type="text" id="civil_status" placeholder="civil status"/>
            </div>
            , Filipino, and a resident of
        </div>
        <div>
            <div class="long">
                <input type="text" id="address" placeholder="Patient's complete address">
            </div>
            <span>on</span>
            <div class="small">
                <input type="datetime-local" id="date_examined">
            </div>
            <div class="mt-1">
                for the following lesion/injury:
            </div>
        </div>
        <div class="mt-3 mb-3">
            <div>DIAGNOSIS:</div>
            <table id="diagnosis_list" class="ms-5"></table>
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
                            <input type="text" id="noi"/>
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
                            <input type="text" id="doi"/>
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
                            <input type="text" id="poi"/>
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
                            <input type="text" id="toi" />
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="mt-2">
            In my opinion, the injuries sustained by the patient will incapacitate or require medical attention for a period of
            <div class="very-small">
                <input type="number" id="days_barred" placeholder="days"/>
            </div>
            day/days barring complications, otherwise the period of healing will vary accordingly.
        </div>
        <div class="doctor-container mt-3">
            <div>Doctor: <div class="medium ml-1">
                    <input type="text" id="doctor"/>
                </div></div>
            <div>Designation: <div class="medium ml-1">
                    <input type="text" id="doctor_designation"/>
                </div></div>
            <div>License No.: <div class="medium ml-1" >
                    <input type="text" id="doctor_license"/>
                </div></div>
        </div>
        <div class="mt-3">
            <div>(NOT VALID WITHOUT SEAL)</div>
            <table style="width: 100%">
                <tr>
                    <td style="width: 18%">OR NO</td>
                    <td style="width: 3%">:</td>
                    <td style="width: 49%">
                        <div class="medium">
                            <input type="text" id="or_no">
                        </div>
                    </td>
                    <td style="width: 30%"></td>
                </tr>
                <tr>
                    <td>AMOUNT</td>
                    <td>:</td>
                    <td>
                        <div class="medium">
                            <input type="text" id="amount">
                        </div>
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
