<script>
    //COMMON HEADERS TO BE USED TO ALL POST,PUT,DELETE request
    let page = 0;
    let certificate_id = 0;
    let diagnosis_index = -1;
    const HEADERS = {
        "Content-Type": "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    const DOCTORS = [
        {
            name: "DR. JADY JEAN T. ALJAS",
            designation: "MEDICAL OFFICER III",
            license_no: "150568"
        },
        {
            name: "DR. JAMES C. BERNAL",
            designation: "MEDICAL OFFICER III",
            license_no: "142129"
        },
        {
            name: "DR. KAREN BEA E. DALENA",
            designation: "MEDICAL OFFICER III",
            license_no: "139377"
        },
        {
            name: "DR. WILSON C. DE LA CALZADA",
            designation: "ATTENDING PHYSICIAN",
            license_no: "86690"
        },
        {
            name: "DR. KENNY M. DURANGPARANG",
            designation: "MEDICAL OFFICER III",
            license_no: "152059"
        },
        {
            name: "DR. REY EVAN A. FLORES",
            designation: "MEDICAL OFFICER III",
            license_no: "140886"
        },
        {
            name: "DR. JOHN RAY D. GAGATAM",
            designation: "MEDICAL OFFICER III",
            license_no: "140559"
        },
        {
            name: "DR. STEPHEN PAUL C. MAHILUM",
            designation: "MEDICAL OFFICER III",
            license_no: "152911"
        },
        {
            name: "DR. SIMON PETER P. MOLLANEDA",
            designation: "MEDICAL OFFICER III",
            license_no: "140060"
        },
        {
            name: "DR. GLENN L. PUNAY",
            designation: "MEDICAL OFFICER III",
            license_no: "132175"
        },
        {
            name: "DR. GUADA GISELLE S. RARANG",
            designation: "MEDICAL OFFICER IV",
            license_no: "123741"
        },
        {
            name: "DR. KEITH MOON Q. SABERON",
            designation: "NEUROLOGY",
            license_no: "127707"
        },
        {
            name: "DR. DOMINIC VICUÑA",
            designation: "MEDICAL OFFICER IV",
            license_no: "117160"
        },
        {
            name: "DR. JASON P. WONG",
            designation: "MEDICAL OFFICER III",
            license_no: "145736"
        },
        {
            name: "DR. MARYAN C. SAMSON",
            designation: "MEDICAL OFFICER IV",
            license_no: "130710"
        },
    ];

    let type = "";

    $(document).ready(() => {
        $("#btn_add_report").click(function () {
            $("#report_modal").modal("show");
        });

        $("#btn_generate_report").click(function () {
            const month = $("#monthSelect").val();
            const year = $("#yearSelect").val();
            window.open("/qrcode-tracker/generate_report?month=" + month + "&year=" + year, "_blank");
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
                    $("#certificate_modal .modal-body").html(html);
                    $("#certificate_modal .modal-footer").removeClass("d-none");

                    //APPEND DOCTORS ON A SELECT
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
                    $("#certificate_modal .modal-body").html(html);
                    $("#certificate_modal .modal-footer").removeClass("d-none");
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
                    $("#certificate_modal .modal-body").html(html);
                    $("#certificate_modal .modal-footer").removeClass("d-none");
                })
                .catch(error => console.error(error));
        });

        $("#btn_add_diagnosis").click(function () {
            diagnosis_index = -1;
            $("#diagnosis_modal").modal("show");
        });

        $("#btn_save_diagnosis").click(function () {
            const diagnosis = $("#diagnosis").val().trim();
            if (diagnosis == '') {
                alert("Please fill in diagnosis");
                return;
            }
            if (diagnosis_index > -1) {
                $("#diagnosis_list tr:eq(" + diagnosis_index + ") td:eq(0)").text(diagnosis);
                $("#diagnosis_modal").modal("hide");
                diagnosis_index = -1;
            } else {
                let tr = "<tr>";
                tr += "<td style='width: 90%'>" + diagnosis + "</td>"
                tr += "<td style='width: 5%'><button class='btn btn-sm btn-transparent' onClick='editDiagnosis(this)'><i class='bi bi-pencil-fill text-success'></i></button></td>"
                tr += "<td style='width: 5%'><button class='btn btn-sm btn-transparent' onClick='deleteDiagnosis(this)'><i class='bi bi-trash-fill text-danger'></i></button></td>"
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
            const or_no = $("#or_no").val().trim();
            const amount = $("#amount").val().trim();
            const charge_slip_no = $("#charge_slip_no").val();
            const registry_no = $("#registry_no").val();
            const date_requested = $("#date_requested").val().trim();
            const date_finished = $("#date_finished").val().trim();
            const diagnosis_array = [];

            for (let i = 0; i < $("#diagnosis_list tr").length; i++) {
                const diagnosis = $("#diagnosis_list tr:eq(" + i + ") td:eq(0)").text().trim();
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
                "or_no": or_no,
                "amount": amount,
                "charge_slip_no": charge_slip_no,
                "registry_no": registry_no,
                "date_requested": date_requested,
                "date_finished": date_finished,
                "type": type,
                "diagnosis": diagnosis_array,
                "sustained": (noi === undefined) ? null : sustained
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

            if (!registry_no) {
                toastr.error('Registry no. is required');
                $("#registry_no").addClass("is-invalid");
                is_valid = false;
            }

            if (!date_requested) {
                toastr.error('Requesting person is required');
                $("#date_requested").addClass("is-invalid");
                is_valid = false;
            }

            // if (!date_finished) {
            //     toastr.error('Relationship is required');
            //     $("#date_finished").addClass("is-invalid");
            //     is_valid = false;
            // }


            switch (type) {
                case "ordinary":
                    if (!certificate_no) {
                        toastr.error('Certificate No. is required');
                        $("#certificate_no").addClass("is-invalid");
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

                    if (!or_no) {
                        toastr.error('OR no. is required');
                        $("#or_no").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!amount) {
                        toastr.error('Amount is required');
                        $("#amount").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (diagnosis_array.length < 1) {
                        toastr.error('Diagnosis is required');
                        is_valid = false;
                    }
                    break;
                case "maipp":
                    if (!certificate_no) {
                        toastr.error('Certificate No. is required');
                        $("#certificate_no").addClass("is-invalid");
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

                    if (!sex) {
                        toastr.error('Sex is required');
                        $("#sex").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!address) {
                        toastr.error('Address is required');
                        $("#address").addClass("is-invalid");
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

                    if (!or_no) {
                        toastr.error('OR no. is required');
                        $("#or_no").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!amount) {
                        toastr.error('Amount is required');
                        $("#amount").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (diagnosis_array.length < 1) {
                        toastr.error('Diagnosis is required');
                        is_valid = false;
                    }
                    break;
                case "medico_legal":
                    if (!certificate_no) {
                        toastr.error('Certificate No. is required');
                        $("#certificate_no").addClass("is-invalid");
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

                    if (!address) {
                        toastr.error('Address is required');
                        $("#address").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!date_examined) {
                        toastr.error('Date examined is required');
                        $("#date_examined").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!days_barred) {
                        toastr.error('Day/s barred is required');
                        $("#days_barred").addClass("is-invalid");
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

                    if (!or_no) {
                        toastr.error('OR no. is required');
                        $("#or_no").addClass("is-invalid");
                        is_valid = false;
                    }

                    if (!amount) {
                        toastr.error('Amount is required');
                        $("#amount").addClass("is-invalid");
                        is_valid = false;
                    }


                    if (diagnosis_array.length < 1) {
                        toastr.error('Diagnosis is required');
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
                $("#certificate_modal .modal-body").html(html);
                $("#certificate_modal .modal-footer").removeClass("d-none");
            })
            .catch(error => console.error(error));
    }

    async function deleteCertificate(id) {
        if (confirm("Are you sure you want to delete this record?")) {
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
        const diagnosis = tr.find('td:first').text();
        diagnosis_index = tr.index();

        $("#diagnosis_modal").modal("show");
        $("#diagnosis").val(diagnosis);
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
            const tr = `
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
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="deleteCertificate(` + it.id + `)">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>`

            $("#certificate_lists").append(tr);
        }
    }

    function showSpinner() {
        $("#certificate_modal .modal-body").html(`
        <div class="d-flex justify-content-center align-items-center">
            <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
             </div>
        </div>`);
    }
</script>
