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
        MEDICAL CERTIFICATE
    </div>
    <div class="text-start">TO WHOM IT MAY CONCERN:</div>
    <div class="certificate-text">
        <div>
            This is to certify that based on the Hospital Record
            <div class="medium">
                <input type="text" id="patient" placeholder="Patient's name">
            </div>
            , of
        </div>
        <div>
            <div class="long">
                <input type="text" id="address" placeholder="Patient's complete address">
            </div>
            <div class="very-small">
                <input type="number" id="age" placeholder="age"/>
            </div>
            <span>years old,</span>
            <div class="very-small">
                <input type="text" id="sex" placeholder="sex">
            </div>
            , was<br/>
        </div>
        <div>
            examined and treated in this hospital on
            <div class="small"><input type="date" id="date_examined"></div>
        </div>
        <div>
            under the care of
            <div class="medium">
                <input type="text" placeholder="Attending Physician" id="doctor">
            </div>
            <span class="mr-3">-</span>
            <div class="small">
                <input type="text" placeholder="License Number" id="doctor_license">
            </div>
        </div>
        <div>
            with the following findings and/or diagnosis:
        </div>
        <div class="mt-3 mb-3">
            <div>DIAGNOSIS:</div>
            <table id="diagnosis_list" class="ms-5"></table>
        </div>
        <div class="d-flex">
            <div>This certification is being issued at the request of</div>
            <div class="medium">
                <input type="text" id="requesting_person">
            </div>
        </div>
        <div>Purpose</div>
        <select id="purpose">
            <option>Financial and Medical Assistance Program available in the hospital</option>
            <option>School Related Purposes, except for insurance claims or any legal claim</option>
            <option>Work Related-Purposes, except for insurance claims or any legal claim</option>
        </select>
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
