$(document).on('submit', function() {
    if(confirm('Apakah anda yakin?')) {
        $("#waitttAmazingLover").css("display", "block");
        return true;
    }

    return false;
});

$('.btn-danger').on('click', function() {
    if(confirm('Apakah anda yakin?')) {
        $("#waitttAmazingLover").css("display", "block");
        return true;
    }

    return false;
});
