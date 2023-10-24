<script src="js/quirk.js?v=v={{ date('ymdhis') }}"></script>
<script>
    //COMMON HEADERS TO BE USED TO ALL POST,PUT,DELETE request
    let page = 0;
    let certificate_id = 0;
    let diagnosis_index = -1;
    const HEADERS = {
        "Content-Type": "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    let type = "";

    $(document).ready(() => {
        $("#select_doctor").select2({
            dropdownParent: $("#doctor_modal"),
            width: '100%'
        });

        $("#diagnosis").on("keypress", function (e) {
            // Check if the pressed key is Enter (key code 13)
            if (e.which == 13) {
                // Prevent the default behavior of Enter key (which creates a new line)
                // Append a <br> tag to the textarea's value
                $("#diagnosis").val($(this).val() + '<br>');
            }
        });

        $('#filter_patient').on('keyup', function (e) {
            if (e.key === 'Enter') {
                getCertificates();
            } else if ($(this).val() === '') {
                getCertificates();
            }
        });

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        $("body").on("change", "#purpose", function () {
            $("#purpose_container").addClass("d-none");
            $("#second_purpose").val("");
            if ($(this).val() == "Financial and Medical Assistance Program available in the hospital") {
                $("#purpose_container").removeClass("d-none");
            }
        });

        $("#btn_add_report").click(function () {
            $("#filter_date").val("");
            $("#report_list").empty();
            $("#report_modal").modal("show");
        });

        $("#btn_download_report").click(function () {
            const filtered_date = $("#filter_date").val();

            if (filtered_date == "") {
                alert("Please specify date range");
                return;
            }


            let from_date = moment(filtered_date.split("-")[0].trim(), "MM/DD/YYYY");
            let to_date = moment(filtered_date.split("-")[1].trim(), "MM/DD/YYYY");


            let to_month_name = "";
            if (from_date.format("M") !== to_date.format("M")) {
                to_month_name = to_date.format("MMMM");
            }

            let title = "SUMMARY REPORT FOR THE MONTH OF " + from_date.format("MMMM") + " " + from_date.format("D");
            if (to_month_name === "") {
                if (from_date.format("D") === to_date.format("D"))
                    title += to_date.format(", YYYY");
                else {
                    title += to_date.format("-D, YYYY");
                }
            } else
                title += " - " + to_month_name + " " + to_date.format("D, YYYY");

            window.open("/qrcode-tracker/generate_report?from_date=" + from_date.format("YYYY-MM-DD") + "&to_date=" + to_date.format("YYYY-MM-DD") + "&title=" + title, "_blank");
        });

        $("#btn_generate_report").click(async function () {
            const filtered_date = $("#filter_date").val();

            if (filtered_date == "") {
                alert("Please specify date range");
                return;
            }


            let from_date = moment(filtered_date.split("-")[0].trim(), "MM/DD/YYYY");
            let to_date = moment(filtered_date.split("-")[1].trim(), "MM/DD/YYYY");

            const response = await fetch('{{ route('generateTableReport') }}?from_date=' + from_date.format("YYYY-MM-DD") + "&to_date=" + to_date.format("YYYY-MM-DD"));
            const data = await response.json();

            $("#report_list").empty();
            if (data.length === 0) {
                $("#report_list").append("<tr><td colspan='9' class='text-center'>No record found</td></tr>");
                return;
            }
            data.forEach(it => {
                console.log(it);
                const date_requested = (it.date_requested) ? moment(it.date_requested).format("MM/DD/YYYY hh:mm A") : "";
                const date_finished = (it.date_finished) ? moment(it.date_finished).format("MM/DD/YYYY hh:mm A") : "";
                const status = (it.status) ? it.status : "";
                const tr = `
                <tr>
                    <td>` + it.patient + `</td>
                    <td>` + it.type + `</td>
                    <td>` + it.charge_slip_no + `</td>
                    <td>` + it.or_no + `</td>
                    <td>` + it.requesting_person + `</td>
                    <td>` + it.relationship + `</td>
                    <td>` + date_requested + `</td>
                    <td>` + it.registry_no + `</td>
                    <td>` + date_finished + `</td>
                    <td>` + status + `</td>
                </tr>`;
                $("#report_list").append(tr);
            });
        });

        $("#btn_search").click(function () {
            page = 0;
            getCertificates();
        });

        $("#btn_next").click(function () {
            page++;
            getCertificates();
            $("#btn_prev").removeClass("d-none");
        });

        $("#btn_prev").click(function () {
            if (page == 0) return;
            if (page == 1) {
                $("#btn_prev").addClass("d-none");
            }
            page--;
            getCertificates();
        });

        $("#btn_add_ordinary").click(() => {
            certificate_id = 0;
            type = "ordinary";
            $("#certificate_modal").modal('show');
            showSpinner();
            fetch('/qrcode-tracker/partial-form?type=' + type, {
                method: "GET"
            })
                .then(response => response.text()) // Convert response to text
                .then(html => {
                    $("#certificate_modal #certificate_form").html(html);
                    $("#certificate_modal .modal-footer").removeClass("d-none");
                    $("#no_copies_container").removeClass("d-none");
                })
                .catch(error => console.error(error));
        });

        $("#btn_add_maipp").click(() => {
            certificate_id = 0;
            type = "maipp";
            $("#certificate_modal").modal('show');
            showSpinner();
            fetch('/qrcode-tracker/partial-form?type=' + type, {
                method: "GET"
            })
                .then(response => response.text()) // Convert response to text
                .then(html => {
                    $("#certificate_modal #certificate_form").html(html);
                    $("#certificate_modal .modal-footer").removeClass("d-none");
                    $("#no_copies_container").removeClass("d-none");
                })
                .catch(error => console.error(error));
        });

        $("#btn_add_medico_legal").click(() => {
            certificate_id = 0;
            type = "medico_legal";
            $("#certificate_modal").modal('show');
            showSpinner();
            fetch('/qrcode-tracker/partial-form?type=' + type, {
                method: "GET"
            })
                .then(response => response.text()) // Convert response to text
                .then(html => {
                    $("#certificate_modal #certificate_form").html(html);
                    $("#certificate_modal .modal-footer").removeClass("d-none");
                    $("#no_copies_container").removeClass("d-none");
                })
                .catch(error => console.error(error));
        });

        $("#btn_add_diagnosis").click(function () {
            diagnosis_index = -1;
            $("#diagnosis").val("");
            $("#diagnosis_modal").modal("show");
        });

        $("#btn_add_doctor").click(function () {
            $("#doctor_modal").modal("show");
        });

        $("#btn_set_doctor").click(function () {
            const selected_doctor = $("#select_doctor").val();
            if (!selected_doctor) {
                alert("Please specify doctor");
                return;
            }

            const doctor = getDoctorByLicense(selected_doctor);
            if (!doctor) {
                alert("Doctor license no. dont't exists");
                return;
            }

            //SET FORM DOCTOR
            $("#doctor").val(doctor.name);
            $("#doctor_designation").val(doctor.designation);
            $("#doctor_license").val(doctor.license_no);

            $("#doctor_modal").modal("hide");
        });


        $("#btn_save_diagnosis").click(function () {
            let diagnosis = $("#diagnosis").val();
            diagnosis = diagnosis.replace(/\n/g, "");

            if (diagnosis == '') {
                alert("Please fill in diagnosis");
                return;
            }

            if (diagnosis_index > -1) {
                $("#diagnosis_list tr:eq(" + diagnosis_index + ") td:eq(0)").html(diagnosis);
                $("#diagnosis_modal").modal("hide");
                diagnosis_index = -1;
            } else {
                let tr = "<tr>";
                tr += "<td style='width: 90%'>" + diagnosis + "</td>"
                tr += "<td style='width: 5%'><button type='button' class='btn btn-sm btn-transparent' onClick='editDiagnosis(this)'><i class='bi bi-pencil-fill text-success'></i></button></td>"
                tr += "<td style='width: 5%'><button type='button' class='btn btn-sm btn-transparent' onClick='deleteDiagnosis(this)'><i class='bi bi-trash-fill text-danger'></i></button></td>"
                tr += "</tr>";
                $("#diagnosis_list").append(tr);
            }
            $("#diagnosis").val("");
        });

        $("#btn_save").click(async function () {
            const certificate_no = $("#certificate_no").val().trim();
            const health_record_no = $("#health_record_no").val().trim();
            const date_issued = $("#date_issued").val().trim();
            const patient = $("#patient").val().trim();
            const age = $("#age").val().trim();
            const sex = $("#sex").val();
            const civil_status = $("#civil_status").val();
            const address = $("#address").val().trim();
            const date_examined = $("#date_examined").val().trim();
            const days_barred = $("#days_barred").val();
            const doctor = $("#doctor").val().trim();
            const doctor_designation = $("#doctor_designation").val();
            const doctor_license = $("#doctor_license").val().trim();
            const requesting_person = $("#requesting_person").val();
            const relationship = $("#relationship").val();
            const purpose = $("#purpose").val();
            const second_purpose = $("#second_purpose").val();
            const or_no = $("#or_no").val().trim();
            const amount = $("#amount").val().trim();
            const charge_slip_no = $("#charge_slip_no").val();
            const registry_no = $("#registry_no").val();
            const date_requested = $("#date_requested").val().trim();
            const date_finished = $("#date_finished").val().trim();
            const no_copies = $("#no_copies").val();
            const diagnosis_array = [];

            for (let i = 0; i < $("#diagnosis_list tr").length; i++) {
                const diagnosis = $("#diagnosis_list tr:eq(" + i + ") td:eq(0)").html().trim();
                diagnosis_array.push({
                    diagnosis: diagnosis
                });
            }

            const noi = $("#noi").val();
            const doi = $("#doi").val();
            const poi = $("#poi").val();
            const toi = $("#toi").val();

            const sustained = {
                "noi": (noi === undefined) ? null : noi,
                "doi": (doi === undefined) ? null : doi,
                "poi": (poi === undefined) ? null : poi,
                "toi": (toi === undefined) ? null : toi
            }

            const params = {
                "id": certificate_id,
                "certificate_no": certificate_no,
                "health_record_no": health_record_no,
                "date_issued": date_issued,
                "patient": patient,
                "age": age,
                "sex": (sex === undefined) ? null : sex,
                "civil_status": (civil_status === undefined) ? null : civil_status,
                "address": address,
                "date_examined": date_examined,
                "days_barred": (days_barred === undefined) ? null : days_barred,
                "doctor": doctor,
                "doctor_designation": (doctor_designation === undefined) ? null : doctor_designation,
                "doctor_license": doctor_license,
                "requesting_person": (requesting_person === undefined) ? null : requesting_person,
                "relationship": relationship,
                "charge_slip_no": charge_slip_no,
                "registry_no": registry_no,
                "date_requested": date_requested,
                "date_finished": date_finished,
                "purpose": (purpose === undefined) ? null : purpose,
                "second_purpose": (second_purpose === undefined) ? null : second_purpose,
                "or_no": or_no,
                "amount": amount,
                "charge_slip_no": charge_slip_no,
                "registry_no": registry_no,
                "date_requested": date_requested,
                "date_finished": date_finished,
                "type": type,
                "diagnosis": diagnosis_array,
                "sustained": (noi === undefined) ? null : sustained,
                "no_copies": (no_copies && certificate_id === 0) ? no_copies : 1
            }

            let is_valid = true;
            $(".is-invalid").removeClass("is-invalid");

            if (!requesting_person) {
                toastr.error('Requesting person is required');
                $("#requesting_person").addClass("is-invalid");
                is_valid = false;
            }

            if (!relationship) {
                toastr.error('Relationship is required');
                $("#relationship").addClass("is-invalid");
                is_valid = false;
            }

            if (!charge_slip_no) {
                toastr.error('Charge slip no. is required');
                $("#charge_slip_no").addClass("is-invalid");
                is_valid = false;
            }

            if (!date_requested) {
                toastr.error('Requesting person is required');
                $("#date_requested").addClass("is-invalid");
                is_valid = false;
            }

            if (!health_record_no) {
                toastr.error('Health Record No. is required');
                $("#health_record_no").addClass("is-invalid");
                is_valid = false;
            }

            if (!date_issued) {
                toastr.error('Date issued is required');
                $("#date_issued").addClass("is-invalid");
                is_valid = false;
            }

            if (!patient) {
                toastr.error('Patient is required');
                $("#patient").addClass("is-invalid");
                is_valid = false;
            }

            if (!age) {
                toastr.error('Age is required');
                $("#age").addClass("is-invalid");
                is_valid = false;
            }

            if (!address) {
                toastr.error('Address is required');
                $("#address").addClass("is-invalid");
                is_valid = false;
            }

            switch (type) {
                case "ordinary":
                    if (!date_examined) {
                        toastr.error('Date examined is required');
                        $("#date_examined").addClass("is-invalid");
                        is_valid = false;
                    }


                    if (!purpose) {
                        toastr.error('Purpose is required');
                        $("#purpose").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor) {
                        toastr.error('Doctor is required');
                        $("#doctor").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor_designation) {
                        toastr.error('Doctor designation is required');
                        $("#doctor_designation").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor_license) {
                        toastr.error('Doctor license no. is required');
                        $("#doctor_license").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!amount) {
                        toastr.error('Amount is required');
                        $("#amount").addClass("is-invalid");
                        is_valid = false;
                    }

                    break;
                case "maipp":
                    if (!sex) {
                        toastr.error('Sex is required');
                        $("#sex").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!date_examined) {
                        toastr.error('Date examined is required');
                        $("#date_examined").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!purpose) {
                        toastr.error('Purpose is required');
                        $("#purpose").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (purpose === "Financial and Medical Assistance Program available in the hospital" && !second_purpose) {
                        toastr.error('Second purpose is required');
                        $("#second_purpose").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor) {
                        toastr.error('Doctor is required');
                        $("#doctor").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor_license) {
                        toastr.error('Doctor license no. is required');
                        $("#doctor_license").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!amount) {
                        toastr.error('Amount is required');
                        $("#amount").addClass("is-invalid");
                        is_valid = false;
                    }
                    break;
                case "medico_legal":
                    if (!sex) {
                        toastr.error('Sex is required');
                        $("#sex").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!civil_status) {
                        toastr.error('Civil status is required');
                        $("#civil_status").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!date_examined) {
                        toastr.error('Date examined is required');
                        $("#date_examined").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor) {
                        toastr.error('Doctor is required');
                        $("#doctor").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor_designation) {
                        toastr.error('Doctor designation is required');
                        $("#doctor_designation").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doctor_license) {
                        toastr.error('Doctor license no. is required');
                        $("#doctor_license").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!amount) {
                        toastr.error('Amount is required');
                        $("#amount").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!noi) {
                        toastr.error('NOI is required');
                        $("#noi").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!doi) {
                        toastr.error('DOI is required');
                        $("#doi").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!poi) {
                        toastr.error('POI is required');
                        $("#poi").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!toi) {
                        toastr.error('TOI is required');
                        $("#toi").addClass("is-invalid");
                        is_valid = false;
                    }
                    break;
            }

            if (!is_valid) {
                return;
            }

            try {
                $(this).prop("disabled", true);
                const response = await fetch('{{route('storeCertificate')}}', {
                    method: "POST",
                    headers: HEADERS,
                    body: JSON.stringify(params)
                });

                const data = await response.json();
                $("#certificate_modal").modal("hide");
                toastr.success(data.message, "Information");
                getCertificates();
            } catch (err) {
                toastr.error(err, "Ooops");
            } finally {
                $(this).prop("disabled", false);
            }
        });

        getCertificates();
        appendDoctors();
    });

    async function printPreview(id) {
        window.open("https://dohcsmc.site/qrcode-tracker/print-preview?id=" + id, '_blank');
    }

    function editCertificate(id) {
        certificate_id = id;
        type = $("#certificate_id_" + id + " td:eq(0)").text().trim();
        $("#certificate_modal").modal("show");
        $("#certificate_modal .modal-footer").addClass("d-none");
        showSpinner();
        fetch('/qrcode-tracker/partial-form?type=' + type +
            '&id=' + id, {
            method: "GET"
        })
            .then(response => response.text()) // Convert response to text
            .then(html => {
                $("#certificate_modal #certificate_form").html(html);
                $("#certificate_modal .modal-footer").removeClass("d-none");
            })
            .catch(error => console.error(error));
    }

    async function tagCertificate(id) {
        if (confirm("Are you sure you want to tag this as done?")) {
            const response = await fetch('{{ route('tagCertificate') }}', {
                method: "PUT",
                headers: HEADERS,
                body: JSON.stringify({id: id})
            });

            if (!response.ok) {
                toastr.error("Something went wrong", "Ooops");
                console.log(response);
                return;
            }

            const data = await response.json();
            toastr.success(data.message, "Information");
            getCertificates();
        }
    }

    async function deleteCertificate(id) {
        if (confirm("Are you sure you want to cancel this record?")) {
            const response = await fetch('{{ route('deleteCertificate') }}', {
                method: "DELETE",
                headers: HEADERS,
                body: JSON.stringify({id: id})
            });

            if (!response.ok) {
                toastr.error("Something went wrong", "Ooops");
                console.log(response);
                return;
            }

            const data = await response.json();
            toastr.success(data.message, "Information");
            getCertificates();
        }
    }

    function editDiagnosis(button) {
        const tr = $(button).closest('tr');
        const diagnosis = tr.find('td:first').html();
        diagnosis_index = tr.index();

        $("#diagnosis_modal").modal("show");
        const textWithLineBreaks = diagnosis.replace(/<br>/g, '<br>\n');
        $("#diagnosis").val(textWithLineBreaks);
    }

    function deleteDiagnosis(button) {
        if (confirm("Are you sure you want to remove this record?")) {
            const tr = $(button).closest('tr');
            tr.remove();
        }
    }

    async function getCertificates() {
        const filter_patient = $("#filter_patient").val().trim();
        const filter_date_issued = $("#filter_date_issued").val();
        const response = await fetch('{{ route('getCertificates') }}?page=' + page +
            '&filter_patient=' + filter_patient +
            '&filter_date_issued=' + filter_date_issued);

        const data = await response.json();

        $("#pagination_container").addClass("d-none")
        $("#certificate_lists").empty();
        $("#btn_next").addClass("d-none");
        if (data.length < 1) {
            $("#certificate_lists").append("<tr><td colspan='8'>No record found</td></tr>");
            return;
        }

        $("#pagination_container").removeClass("d-none")

        let max_visible = data.length;
        if (max_visible == 11) {
            max_visible = 10;
            $("#btn_next").removeClass("d-none");
        }

        $("#page_items_count").text(((page * 10) + 1) + " - " + ((page * 10) + max_visible));
        for (let i = 0; i < max_visible; i++) {
            const it = data[i];
            let tr = `
                    <tr id="certificate_id_` + it.id + `">
                        <td>` + it.type + `</td>
                        <td>` + it.patient + `</td>
                        <td>` + it.health_record_no + `</td>
                        <td>` + it.certificate_no + `</td>
                        <td>` + it.date_issued + `</td>
                        <td>` + it.created_at + `</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="printPreview(` + it.id + `)">
                                <i class="bi bi-qr-code"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="editCertificate(` + it.id + `)">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                        </td>`;
            if (it.date_finished)
                tr += `
                        <td>
                            <button class="btn btn-sm btn-secondary" disabled>
                                <i class="bi bi-tag-fill"></i>
                            </button>
                        </td>`;
            else
                tr += `
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="tagCertificate(` + it.id + `)">
                                <i class="bi bi-tag-fill"></i>
                            </button>
                        </td>`;

            if (it.status)
                tr += `<td>
                            <button class="btn btn-sm btn-danger" onclick="deleteCertificate(` + it.id + `)" disabled>
                                <i class="bi bi-x-octagon"></i>
                            </button>
                        </td>
                    </tr>`;
            else
                tr += `<td>
                            <button class="btn btn-sm btn-danger" onclick="deleteCertificate(` + it.id + `)">
                                <i class="bi bi-x-octagon"></i>
                            </button>
                        </td>
                    </tr>`

            $("#certificate_lists").append(tr);
        }
    }

    function appendDoctors() {
        $("#select_doctor").append("<option></option>");
        DOCTORS.forEach(it => {
            $("#select_doctor").append("<option value='" + it.license_no + "'>" + it.name + "</option>");
        });
    }

    function getDoctorByLicense(license_no) {
        for (let i = 0; i < DOCTORS.length; i++) {
            if (DOCTORS[i].license_no === license_no) {
                return DOCTORS[i];
            }
        }
        return null;
    }

    function showSpinner() {
        $("#certificate_modal #certificate_form").html(`
        <div class="d-flex justify-content-center align-items-center">
            <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
             </div>
        </div>`);
    }
</script>
