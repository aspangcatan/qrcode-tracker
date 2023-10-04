<script>
    //COMMON HEADERS TO BE USED TO ALL POST,PUT,DELETE request
    let page = 0;
    let qr_id = 0;
    const HEADERS = {
        "Content-Type": "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    $(document).ready(() => {
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
            $("#qr_modal").modal('show');
        });

        $("#btn_save").click(async () => {
            const patient_name = $("#patient_name").val().trim().toUpperCase();
            const date_training = $("#date_training").val();
            const date_expiry = $("#date_expiry").val();
            const institution = $("#institution").val();

            if (!patient_name || !date_training || !date_expiry || !institution) {
                toastr.error("Please fill in all input fields", "Ooops");
                return;
            }

            const params = {
                id: qr_id,
                patient_name: patient_name,
                date_training: date_training,
                date_expiry: date_expiry,
                institution: institution
            }

            try {
                const response = await fetch('{{ route('storeQrHemb') }}', {
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
        window.open("https://dohcsmc.site/qrcode-tracker/generate-hemb-qrcode?id=" + id, '_blank');
    }

    function editQr(id) {
        qr_id = id;
        const patient_name = $("#qr_id_" + id + " td:eq(0)").text().trim();
        const date_training = $("#qr_id_" + id + " td:eq(1)").text().trim();
        const date_expiry = $("#qr_id_" + id + " td:eq(2)").text().trim();
        const institution = $("#qr_id_" + id + " td:eq(3)").text().trim();

        $("#patient_name").val(patient_name);
        $("#date_training").val(date_training);
        $("#date_expiry").val(date_expiry);
        $("#institution").val(institution);
        $("#qr_modal").modal('show');
    }

    async function deleteQr(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            const response = await fetch('{{ route('deleteQrHemb') }}', {
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
        fetch('{{ route('getQrHembList') }}?page=' + page +
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
                        <td>` + it.date_training + `</td>
                        <td>` + it.date_expiry + `</td>
                        <td>` + it.institution + `</td>
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
        $("#date_training").val("");
        $("#date_expiry").val("");
        $("#institution").val("");
    }
</script>
