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

    $('#myModal').on('shown.bs.modal', function() {
        $('#record_content').focus();
    });
});