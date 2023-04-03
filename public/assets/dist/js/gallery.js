const imgPreview = $(".list-form").find('.img-preview');

$(".list-form").on("change", "input[type='file']", function () {
    if(this.files[0].size > 3000000) {
        alert('Ukuran file terlalu besar');
        sampul.val('');
        return false;
    }

    const sampul = $(this);
    const preview = $(this).parent().find(".img-preview");
    const fileSampul = new FileReader();
    fileSampul.readAsDataURL(sampul[0].files[0]);

    fileSampul.onload = function (e) {
        preview["prevObject"].attr(
            "style",
            `background-image: url('${e.target.result}')`
        );
    };
});

imgPreview.on("click", ".btn-remove-image", function () {
    const key = $(this).data("key");
    const name = $(`#foto_eviden-${key.split('[')[1].split(']')[0]}`);
    name.attr("style", "");
    $(this).hide();
    name.html(
        '<label for="image-upload">Pilih Gambar</label>' +
            `<input type="file" name="${key}" />`
    );
});
