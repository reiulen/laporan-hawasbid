$(function() {
    const formAction = $('#formAction');
    const listForm = $('.list-form');
    const formDetails = listForm.find('.form-details');
    const addDetails = $('.add-details');
    const removeDetails =  listForm.find('.remove-details');
    const alertMessageError = $('.alert-message-error');
    const listFormHtmml = listForm.html();
    addDetails.on('click', function() {
        let lastForm = listForm.find('.form-details').last();
        let newForm = lastForm.clone().appendTo(listForm);
        newForm.find('input').val('');
        newForm.find('textarea').val('');
        newForm.find('.gallery-item').css('background', '');
        let textareas = newForm.find('textarea');
        let inputForm = newForm.find('input');
        textareas.each(function() {
            let name = $(this).attr('name').split('[')[0];
            let index = $(this).attr('name').split('[')[1].split(']')[0];
            $(this).attr('name', name + '[' + (parseInt(index) + 1) + ']');
        });
        let imgPreview = newForm.find('.img-preview');
        let btnRemoveImage = newForm.find('.btn-remove-image');
        let input = newForm.find('input');
        let inputName = input.attr('name').split('[')[1].split(']')[0];
        newForm.find('.btn-remove-image').attr('data-key', 'foto_eviden[' + (parseInt(inputName) + 1) + ']');
        newForm.find('[type="hidden"]').attr('name', 'id_detail[' + (parseInt(inputName) + 1) + ']');
        btnRemoveImage.attr('data-key', 'foto_eviden[' + (parseInt(inputName) + 1) + ']');
        imgPreview.attr('id', 'foto_eviden-' + (parseInt(inputName) + 1));
        $('#foto_eviden-' + (parseInt(inputName) + 1)).html(
            '<label for="image-upload">Pilih Gambar</label>' +
                `<input type="file" name="foto_eviden[${parseInt(inputName) + 1}]" />`
        );
        checkLength(listForm.find('.form-details'));
    });
    listForm.on('click', '.remove-details', function() {
        console.log($(this))
        $(this).parent().remove();
        checkLength(listForm.find('.form-details'));
    });
    checkLength(listForm.find('.form-details'));
    function checkLength(element) {
        console.log(element.length)
        if (element.length > 1)
            listForm.find('.form-details').find('.remove-details').removeClass('d-none');
        else
            listForm.find('.form-details').find('.remove-details').addClass('d-none');
    }

    formAction.on('submit', async function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let url = $(this).attr('action');
        const res = await sendDataFile(url, 'POST', formData);
        if(res.status)
            window.location.href = '/admin/temuan';
        else {
            const message = res.message;
            let alert = `<div class="alert alert-danger text-sm p-2" role="alert">
                            <div class="font-weight-bold">Ada beberapa yang salah</div>
                            <ul>
                                ${message.map((item) => `<li>${item}</li>`).join('')}
                            </ul>
                        </div>`
            alertMessageError.html(alert);
        }
    });
});
