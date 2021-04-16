$(document).ready(function() {
    //  trigger on file change
    $('input[type="file"]').change(function(e) {
        if( $(this).get(0).files.length > 0) {
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                $('#files-selected').append('<span id="file' + i + '" class="badge badge-secondary mx-1">' + $(this).get(0).files[i].name + ' (' + bytesToSize($(this).get(0).files[i].size) + ')' + ' <i id="btn_tag_delete" class="bi bi-x-circle-fill" data-delete-id="' + i + '"></i></span>');
            }

            $('#files-selected').append('<span id="file-clear" class="badge badge-secondary mx-1 bg-danger">Clear All File</span>');
        }
    });

    //  function called when clicked on the close button on the tags
    $(document).on("click", "#btn_tag_delete", function() {
        var file_id = $(this).attr('data-delete-id');
        $('#file' + file_id).remove();
    });

    //  function called when clicked on the clear button
    $(document).on("click", "#file-clear", function() {
        $('#files-selected').html('');
    });

    //  function to convert byte to their respective size
    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }
});