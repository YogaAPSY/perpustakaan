$(function() {
$('.select2').select2({
    dropdownParent: $("#modalAuthor"),
    theme:'bootstrap4'
});
    var table = $('#tableAuthor').DataTable({
        searchDelay: 500,
        processing: true,
        serverSide: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis',
        ],
        ajax: {
            url: 'author',
        },
        order: [
            [1, 'asc']
        ],
        autoWidth: false,
        columns: [
            { data: 'DT_RowIndex', orderable: false },
            { data: 'name', },
            { data: 'aksi', orderable: false },
        ]
    });

    $('#modalAuthor').on('shown.bs.modal', function() {
        $('#nama').focus();
    })

    $('.btn-tambah').on('click', function(e) {
        e.preventDefault();
        $('#formAuthor').trigger('reset');
        $('#nama').text('');
        $('#submit').text('Submit');
        $('#modalAuthor').modal('show');
    })

    $(document).on('click', '.btn-update', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.ajax({
            url: 'author/' + id,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                $('#submit').text('Update');
                $('.modal-title').text('Update Author');
                $('#nama').val(response.name);
                 $('#author_id').val(response.id);
                $('#modalAuthor').modal('show');
            },
            error: function() {
                myswal('error', 'Gagal', 'Terjadi Kesalahan!')
            }
        })
    })

    $('#formAuthor').on('submit', function(e) {
        e.preventDefault();
        let id = $('#author_id').val();
        alert(id);
        let btn = $('#submit').text();
        let type = (btn == 'Submit') ? 'post' : 'put';
        let url = (btn == 'Submit') ? 'author' : 'author/' + id;
        let data = $(this).serialize();

        $.ajax({
            url: url,
            type: type,
            dataType: 'json',
            data: data,
            success: function(response) {
                if (response.code == 1) {
                    myswal('success', 'Berhasil', response.msg);
                    $('#modalAuthor').modal('hide');
                    table.ajax.reload();
                }
            },
            error: function(xhr) {
                error_alert(xhr);
            }
        })
    })

    $(document).on('click', '.btn-hapus', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let url = 'author/' + id;
        myswalconfirm('Anda akan menghapus data ini').then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'delete',
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) {
                        if (response.code == 1) {
                            myswal('success', 'Berhasil', response.msg);
                            table.ajax.reload();
                        } else {
                            myswal('error', 'Gagal', response.msg);
                        }
                    },
                    error: function() {
                        myswal('error', 'Gagal', 'Gagal hapus data')
                    }
                })
            }
        })
    })
})
