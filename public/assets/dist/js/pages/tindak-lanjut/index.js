$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
    },
});

const table = $("#example1").DataTable({
    lengthMenu: [
        [10, 25, 50, 100, 500, -1],
        [10, 25, 50, 100, 500, "All"],
    ],
    searching: false,
    responsive: false,
    lengthChange: true,
    autoWidth: false,
    order: [],
    pagingType: "full_numbers",
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Cari...",
        processing:
            '<div class="spinner-border text-info" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            "</div>",
        paginate: {
            Search: '<i class="icon-search"></i>',
            first: "<i class='fas fa-angle-double-left'></i>",
            previous: "<i class='fas fa-angle-left'></i>",
            next: "<i class='fas fa-angle-right'></i>",
            last: "<i class='fas fa-angle-double-right'></i>",
        },
    },
    oLanguage: {
        sSearch: "",
    },
    processing: true,
    serverSide: true,
    ajax: {
        url: `${url}/admin/tindak-lanjut/dataTable`,
        method: "POST",
        data: function (d) {
            const input = $('input');
            const select = $('select');
            input.each(function() {
                let name = $(this).attr('name');
                let value = $(this).val();
                if (value != '')
                    d[name] = value;
            });
            select.each(function() {
                let name = $(this).attr('name');
                let value = $(this).val();
                if (value != '')
                    d[name] = value;
            });
            return d;
        },
    },
    columns: [
        {
            name: "created_at",
            data: "DT_RowIndex",
        },
        {
            name: "pengawas_bidang",
            data: "pengawas_bidang",
            orderable: false,
        },
        {
            name: "status",
            data: function(data) {
               let badge = '';
               let status = '';
               switch(data.status) {
                case 1 :
                case '1' :
                    badge = 'danger';
                    status = 'Belum ditindaklanjuti';
                    break;
                case 2 :
                case '2' :
                    badge = 'success';
                    status = 'Sudah ditindaklanjuti';
                    break;
               }

                return `<span class="badge badge-${badge} px-3 py-2">
                            ${status}
                        </span>`;
            },
            orderable: false,
        },
        {
            name: "penanggung_jawab_tindak_lanjut",
            data: "penanggung_jawab_tindak_lanjut",
            orderable: false,
        },
        {
            name: "tanggal_tindak_lanjut",
            data: "tanggal_tindak_lanjut",
            orderable: false,
        },
        {
            name: "hakim_pengawas_bidang",
            data: "hakim_pengawas.name",
            orderable: false,
        },
        {
            name: "triwulan",
            data: "triwulan",
            orderable: false,
        },
        {
            name: "foto_eviden",
            data: "foto_eviden",
            orderable: false,
        },
        {
            name: "action",
            data: "action",
            orderable: false,
        },

    ],
});

$('#modalSendEmail #formSendEmail').on('submit', async function(e) {
    e.preventDefault();
    const form = $(this);
    const id = form.find('[name="id"]').val();
    const useSendEmail = form.find('[name="user_send"]').val();
    const buttonSubmit = $('#submitBtn');
    buttonSubmit.attr('disabled', true);
    buttonSubmit.html('Loading...');
    const data = {
        user_send : useSendEmail
    }
    Swal.fire({
        title: 'Kirim Email',
        text: "Apakah anda yakin ingin mengirim email?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Kirim!'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const res = await sendData(`${url}/admin/temuan/send-email/${id}`, 'POST', data);
            if (res.status) {
               $('#modalSendEmail').modal('hide');
                Swal.fire(
                    'Berhasil!',
                    res.message,
                    'success'
                );
             } else
                Swal.fire(
                    'Gagal!',
                    res.message,
                    'error'
                );

        }
    });
});

$('#modalSendEmail').on('hidden.bs.modal', function() {
    $(this).find('[name="id"]').val('');
    $(this).find('[name="user_send"]').val('');
    $(this).find('[name="user_send"]').trigger('change');
});

table.on('click', '.send-email', function() {
    let id = $(this).data('id');
    $('#modalSendEmail #formSendEmail').find('[name="id"]').val(id);
    $('#modalSendEmail').modal('show');
});

$('input').on('keyup', function() {
    setTimeout(function() {
        table.draw();
    }, 900);
}).on('change', function() {
    setTimeout(function() {
        table.draw();
    }, 900);
});

$('select').on('change', function() {
    table.draw();
});


table.on("click", ".btn-hapus", function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const nama = $(this).data("title");
    const urlTarget = `${url}/admin/tahun-akademik/${id}`
    deleteDataTable(nama, urlTarget, table)
});


$(function() {
    $('.btnAdd').on('click', function() {
        $('#modalInput').modal('show');
    });

    table.on('click', '.btnEdit', function() {
        const form = $('#submitInput');
        const id = $(this).data('id');
        const name = $(this).data('name');
        const status = $(this).data('status');
        const modal = $('#modalInput');
        modal.modal('show');
        form.find('[name="id"]').val(id);
        form.find('[name="tahun_akademik"]').val(name);
        form.find('[name="semester"]').val(status);
    });

    $('#submitInput').on('change', function() {
        checkValue();
    }).on('keyup', function() {
        checkValue();
    }).on('submit', async function(e) {
        e.preventDefault();
        const form = $(this);
        const buttonSubmit = $('#submitBtn');
        buttonSubmit.attr('disabled', true);
        buttonSubmit.html('Loading...');
        const data = form.serialize();

       const result = await sendData(`${url}/admin/tahun-akademik`, 'POST', data);
        if (result.status == 'success') {
            buttonSubmit.attr('disabled', false).html('Simpan');
            $('#modalInput').modal('hide');
            table.draw();
            Swal.fire(`Berhasil disimpan`, result.message, "success");
        }else {
            buttonSubmit.attr('disabled', false).html('Simpan');
            Swal.fire(`Gagal`, result.message, "error");
        }
    });

    $('#modalInput').on('hide.bs.modal', function (e) {
        const form = $(this).find('#submitInput');
        form.find('[name="id"]').val('');
        form.trigger('reset');
    });

    function checkValue() {
        const submitBtn = $('#submitBtn');
        const name = $('#name').val();
        const status = $('#status').val();

        if (name == '' || status == '') {
            submitBtn.attr('disabled', true);
        } else {
            submitBtn.attr('disabled', false);
        }
    }

    $(function() {
        function formatState (state) {
            var state = state;
            if (!state.id) {
                return state.name;
            }

            return $(`
                <div style="display: flex; align-items: center; gap: 8px;">
                    <img class="img-selected" src="${state.profile_photo_url}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%">
                    <div>
                        <div>${state.name}</div>
                        <div>${state.email}</div>
                    </div>
                </div>
            `);
        };

        function formatList (state) {
            if (!state.id) {
                return state.name;
            }

            return $(`
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="${state.profile_photo_url}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%">
                    <div>
                        <div>${state.name}</div>
                        <div>${state.email}</div>
                    </div>
                </div>
            `);
        };

        $('#selectUser').select2({
            templateResult: formatList,
            templateSelection: formatState,
            minimumInputLength: 2,
            dropDownParent: $('#modalSendEmail'),
            placeholder: 'Pilih Pengguna',
            ajax: {
                url: urlUserList,
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        keyword: data.term
                    };
                },
                processResults: function (response) {
                    return {
                        results:response
                    };
                },
                cache: true
            }
        });

    });
})
