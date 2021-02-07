$('#keyword').on('keyup', function() {
    let keyword = $(this).val();
    let unitkerja_kode = $('#unitkerja_kode').val();
    let filetype = $('.f_filetype:checked').serializeArray();
    let _token = $('meta[name="csrf-token"]').attr('content');
    filterdokumen(keyword, unitkerja_kode, filetype, _token);
})

$('.f_filetype').on('click', function() {
    let keyword = $('#keyword').val();
    let unitkerja_kode = $('#unitkerja_kode').val();
    let filetype = $('.f_filetype:checked').serializeArray();
    let _token = $('meta[name="csrf-token"]').attr('content');
    filterdokumen(keyword, unitkerja_kode, filetype, _token);
})

function filterdokumen(keyword, unitkerja_kode, filetype, _token) {
    $('#table-file tbody').html('Loading...');
// console.log(keyword, unitkerja_kode, filetype, _token);
    $.post('dokumen-filearchive/searchdocument', { '_token': _token, 'keyword': keyword, 'unitkerja_kode': unitkerja_kode, 'filetype_id': filetype })
    // $.get('dokumen-filearchive-version/' + filetype + '/' + unitkerja_kode)
        .done(function(response) {
            console.log(response);
            $('#table-file tbody').html('No Record(s) Found');
            let tbody = '';

            $.each(response, function(x) {
                tbody = tbody + '<tr><td></td><td>' + response[x]['label'] + '</td>' +
                    '<td>' + response[x]['filetype_label'] + '</td>' +
                    '<td>' + response[x]['created_at_label'] + '</td>' +
                    '<td><span class="badge bg-success" style="color: white">' + response[x]['tipe_dokumen_label'] + '</span>' +
                    '<span class="badge bg-info" style="color: white">' + response[x]['fileext'] + '</span></td></tr>';

                $('#table-file tbody').html(tbody);
            })
        })
        .fail(function(xhr, status, error){
            console.log(xhr, status, error);
        })

    // $('.filetype_version').on('change', function() {
        // var filetype = $(this).val();
        // var unitkerja_kode = $('#unitkerja_kode').val();
        // $.ajax({
        //     url: 'dokumen-filearchive/searchdocument',
        //     type: 'POST',
        //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        //     data: { '_token': _token, 'keyword': keyword, 'unitkerja_kode': unitkerja_kode, 'filetype_id': filetype },
        //     success: function(response) {
        //         $('#table-file tbody').html('No Record(s) Found');
        //         let tbody = '';

        //         $.each(response, function(x) {
        //             tbody = tbody + '<tr><td></td><td>' + response[x]['label'] + '</td>' +
        //                 '<td>' + response[x]['filetype_label'] + '</td>' +
        //                 '<td>' + response[x]['created_at_label'] + '</td>' +
        //                 '<td><span class="badge bg-success" style="color: white">' + response[x]['tipe_dokumen_label'] + '</span>' +
        //                 '<span class="badge bg-info" style="color: white">' + response[x]['fileext'] + '</span></td></tr>';

        //             $('#table-file tbody').html(tbody);
        //         })
        //     },
        //     error: function(data) {
        //         alert(data.responseText);
        //     }
        // });
    // });
}

$("#request").on('click', function() {
    var filearchive = $("#filearchive").val();
    $("#mymodal").val(filearchive);
});
