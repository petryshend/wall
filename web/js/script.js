$(function() {
    $('#createRecordButton').on('click', function() {
        $('#new-record-form').submit();
    });

    $('#delete-note-button').on('click', function() {
        if (confirm('Are you sure you want to delete this note?')) {
            $(this).closest('form').submit();
        }
    });
});