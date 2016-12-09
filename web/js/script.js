$(function() {
    $('#createRecordButton').on('click', function() {
        $('#new-record-form').submit();
    });

    $('.delete-note-button').on('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this note?')) {
            $(this).closest('form').submit();
        }
    });

    $('#record-modal').on('shown.bs.modal', function() {
        $('#record_content').focus();
    });

    $('#record_content').keypress(function (event) {
        if (event.keyCode === 13 && event.shiftKey) {
            $(this).val($(this).val());
            event.stopPropagation();
        } else if (event.keyCode === 13) {
            $(this.closest('form').submit());
            event.stopPropagation();
        }
    });
});