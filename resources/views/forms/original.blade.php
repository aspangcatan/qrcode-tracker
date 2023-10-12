<div class="container">
    <table style="width: 100%">
        <tr>
            <td></td>
            <td>
                <div class="certificate-details">
                    <div class="mt-1">
                        Certificate No:
                        <div class="small">
                            <input type="text" id="certificate_no" />
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
    <div class="certificate-text">
        <div>
            This is to certify
            <div class="medium">
                <input type="text" id="patient">
            </div>

            , <div class="very-small">
                <input type="number" id="age">
            </div> years old, of
        </div>
        <div>
            <div class="long">
                <input type="text" id="address">
            </div>
            was examined and treated in this<br/>
        </div>
        <div>
            hospital on/from
            <div class="small"><input type="date" id="date_examined"></div>
            with the following findings and/or diagnosis:
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3 mb-3">
        <table id="diagnosis_list" class="w-50"></table>
    </div>
    <div class="certificate-text">
        <table style="width: 100%">
            <tr>
                <td style="width: 30%">This certification is being issued at the requested of</td>
                <td style="width: 35%">
                    <div class="long">
                        <input type="text" id="requesting_person">
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <small>Name of Person Requesting</small>
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr>
                <td style="width: 10%">for</td>
                <td style="width: 50%">
                    <div class="long ml-1">
                        <input type="text" id="purpose">
                    </div>
                </td>
                <td style="width: 20%"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <small>Purpose</small>
                </td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="doctor-container mt-3">
        <div>Doctor: <div class="medium ml-1">
                <input type="text" id="doctor"/>
            </div></div>
        <div>Designation: <div class="medium ml-1">
                <input type="text" id="doctor_designation"/>
            </div></div>
        <div>License No.: <div class="medium ml-1" id="doctor_license">
                <input type="text" />
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
