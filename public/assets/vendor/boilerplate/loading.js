$(document).on('submit', function() {
    if(confirm('Apakah anda yakin?')) {
        $("#waitttAmazingLover").css("display", "block");
        return true;
    }

    return false;
});

$(document).on('click', '[data-action="batal"]', function() {
    if(confirm('Apakah anda yakin?')) {
        $("#waitttAmazingLover").css("display", "block");
        return true;
    }

    return false;
});
