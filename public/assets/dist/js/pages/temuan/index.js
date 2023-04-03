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
        url: `${url}/admin/temuan/dataTable`,
        method: "POST",
        data: function (d) {
            const input = $('input');
            const select = $('select');
            input.each(function() {
                let name = $(this).attr('name');
                let value = $(this).val();
                console.log(name);
                if (value != '')
                    d[name] = value;
            });
            select.each(function() {
                let name = $(this).attr('name');
                let value = $(this).val();
                console.log(name);
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
                return data.status == 1 ? 'Belum ditindaklanjuti' : 'Sudah ditindaklanjuti'
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
            name: "cetak",
            data: "cetak",
            orderable: false,
        },
        {
            name: "action",
            data: "action",
            orderable: false,
        },

    ],
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
})
