$(function() {
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
    }
})

$('.select2').select2({
    dropdownParent: $("#modalUser"),
    theme:'bootstrap4'
});
    var table = $('#tableUser').DataTable({
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
            url: 'user',
        },
        order: [
            [1, 'asc']
        ],
        autoWidth: false,
        columns: [
            { data: 'DT_RowIndex', orderable: false },
            { data: 'name', },
            { data: 'informasi', },
            { data: 'role', },
            // { data: 'status', class: 'text-center' },
            { data: 'aksi', orderable: false },
        ]
    });

    $('#modalUser').on('shown.bs.modal', function() {
        $('#nama').focus();
    })

    $(document).on('change', '.switch-status', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let url = 'user/update_status/' + id;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function(response) {
                if (response.code == 1) {
                    myswal('success', 'Berhasil', response.msg);
                } else {
                    myswal('error', 'Gagal', response.msg);
                    table.ajax.reload();
                }
            },
            error: function() {
                myswal('error', 'Gagal', 'Gagal update status');
                table.ajax.reload();
            }
        })
    })

    $('.btn-tambah').on('click', function(e) {
        e.preventDefault();
        $('#formUser').trigger('reset');
        // $('#alamat').text('');
        $('#submit').text('Submit');
        $('#modalUser').modal('show');
    })

    $(document).on('click', '.btn-update', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.ajax({
            url: 'user/' + id,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                $('#submit').text('Update');
                $('.modal-title').text('Update User');
                $('#user_id').val(response.id)
                $('#nama').val(response.name);

                $('#email').val(response.email);
                $('#role').val(response.role);
                $('#modalUser').modal('show');
            },
            error: function() {
                myswal('error', 'Gagal', 'Terjadi Kesalahan!')
            }
        })
    })

    $('#formUser').on('submit', function(e) {
        e.preventDefault();
        let id = $('#user_id').val();
        let btn = $('#submit').text();
        let type = (btn == 'Submit') ? 'post' : 'put';
        let url = (btn == 'Submit') ? 'user' : 'user/' + id;
        let data = $(this).serialize();

        $.ajax({
            url: url,
            type: type,
            dataType: 'json',
            data: data,
            success: function(response) {
                if (response.code == 1) {
                    myswal('success', 'Berhasil', response.msg);
                    $('#modalUser').modal('hide');
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
        let url = 'user/' + id;
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
