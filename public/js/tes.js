$('#keyword').on('keyup', function() {
    var request = new FormData();
    request.append('key',123);
    request.append('action','getorders');
    $.ajax({
        url: "dokumen-filearchive/searchdocument",
        type: "POST",
        data: request,
        processData : false,
        contentType: false,
        success: function(data) {
            alert(data);
        }
    });
});
