<script>
    //COMMON HEADERS TO BE USED TO ALL POST,PUT,DELETE request
    let page = 0;
    let qr_id = 0;
    let diagnosis_index = -1;
    const HEADERS = {
        "Content-Type": "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    $(document).ready(() => {
        $("#certificate_modal").modal('show');
        fetch('/qrcode-tracker/form-original', {
            method: "GET"
        })
            .then(response => response.text()) // Convert response to text
            .then(html => {
                $("#certificate_modal .modal-body").append(html);
            })
            .catch(error => console.error(error));
        $("#btn_search").click(function () {
            page = 0;
            getQr();
        });

        $("#btn_next").click(function () {
            page++;
            getQr();
            $("#btn_prev").removeClass("d-none");
        });

        $("#btn_prev").click(function () {
            if (page == 0) return;
            if (page == 1) {
                $("#btn_prev").addClass("d-none");
            }
            page--;
            getQr();
        });

        $("#btn_add").click(() => {
            clearForms();
            $("#certificate_modal").modal('show');
            fetch('/qrcode-tracker/form-original', {
                method: "GET"
            })
                .then(response => response.text()) // Convert response to text
                .then(html => {
                    $("#certificate_modal .modal-body").append(html);
                })
                .catch(error => console.error(error));
        });

        $("#btn_add_diagnosis").click(function () {
            diagnosis_index = -1;
            $("#diagnosis_modal").modal("show");
        });

        $("#btn_save_diagnosis").click(function () {
            const diagnosis = $("#diagnosis").val().trim();
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

        $("#btn_save_ordinary").click(async function () {
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
            const purpose = $("#purpose").val();
            const or_no = $("#or_no").val().trim();
            const amount = $("#amount").val().trim();
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

            if (!certificate_no || !health_record_no || !date_issued || !patient || !age || !civil_status || !address || !date_examined) {
                alert("Please fill in records");
                return;
            }

            const params = {
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
                "purpose": (purpose === undefined) ? null : purpose,
                "or_no": or_no,
                "amount": amount,
                "diagnosis": diagnosis_array,
                "sustained": (noi === undefined) ? null : sustained
            }

            try {
                const response = await fetch('{{route('storeCertificate')}}', {
                    method: "POST",
                    headers: HEADERS,
                    body: JSON.stringify(params)
                });

                const data = await response.json();
                console.log(data);
            } catch (err) {
                console.log(err);
            }
        });

        $("#btn_save").click(async () => {
            const patient_name = $("#patient_name").val().trim().toUpperCase();
            const hospital_no = $("#hospital_no").val();
            const certificate_no = $("#certificate_no").val();
            const date_issued = $("#date_issued").val();

            if (!patient_name || !hospital_no || !certificate_no || !date_issued) {
                toastr.error("Please fill in all input fields", "Ooops");
                return;
            }

            const params = {
                id: qr_id,
                patient_name: patient_name,
                hospital_no: hospital_no,
                certificate_no: certificate_no,
                date_issued: date_issued
            }

            try {
                const response = await fetch('{{ route('storeCertificate') }}', {
                    method: "POST",
                    headers: HEADERS,
                    body: JSON.stringify(params)
                });

                if (!response.ok) {
                    alert("Oops, something went wrong");
                    return;
                }

                const data = await response.json();
                toastr.success(data.message, "Information");
                $("#qr_modal").modal('hide');
                clearForms();
                page = 0;
                getQr();
            } catch (error) {
                console.log(err);
            }
        });

        getQr();
    });

    async function showQr(id) {
        window.open("http://dohcsmc.site/qrcode-tracker/generate-qrcode?id=" + id, '_blank');
    }

    function editQr(id) {
        qr_id = id;
        const patient_name = $("#qr_id_" + id + " td:eq(0)").text().trim();
        const hospital_no = $("#qr_id_" + id + " td:eq(1)").text().trim();
        const certificate_no = $("#qr_id_" + id + " td:eq(2)").text().trim();
        const date_issued = $("#qr_id_" + id + " td:eq(3)").text().trim();

        $("#patient_name").val(patient_name);
        $("#hospital_no").val(hospital_no);
        $("#certificate_no").val(certificate_no);
        $("#date_issued").val(date_issued);
        $("#qr_modal").modal('show');
    }

    async function deleteQr(id) {
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
            getQr();
        }
    }

    function getQr() {
        const filter_patient = $("#filter_patient").val().trim();
        const filter_date_issued = $("#filter_date_issued").val();
        fetch('{{ route('getCertificates') }}?page=' + page +
            '&filter_patient=' + filter_patient +
            '&filter_date_issued=' + filter_date_issued)
            .then(res => res.json())
            .then(data => {
                $("#pagination_container").addClass("d-none")
                $("#qr_list").empty();
                $("#btn_next").addClass("d-none");
                if (data.length < 1) {
                    $("#qr_list").append("<tr><td colspan='8'>No record found</td></tr>");
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
                    <tr id="qr_id_` + it.id + `">
                        <td>` + it.patient_name + `</td>
                        <td>` + it.hospital_no + `</td>
                        <td>` + it.certificate_no + `</td>
                        <td>` + it.date_issued + `</td>
                        <td>` + it.created_at + `</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="showQr(` + it.id + `)">
                                <i class="bi bi-qr-code"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="editQr(` + it.id + `)">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="deleteQr(` + it.id + `)">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>`

                    $("#qr_list").append(tr);
                }
            })
    }

    function clearForms() {
        qr_id = 0;
        $("#patient_name").val("");
        $("#hospital_no").val("");
        $("#certificate_no").val("");
        $("#date_issued").val("");
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
</script>
