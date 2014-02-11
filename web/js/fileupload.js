
$('input:file').change(function () {
    var file = $(this).val();
    $(this).parent().parent().find('.file-title').html( file.substring( file.indexOf('\\', 3) + 1 ) );
});
