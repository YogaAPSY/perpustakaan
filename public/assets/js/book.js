$(function() {
    $('.select2').select2({
        dropdownParent: $("#modalBook"),
        theme:'bootstrap4'
    });

    $(".custom-file-input").on("change", function() {
        const fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    var table = $('#tableBook').DataTable({
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
            url: 'book',
        },
        order: [
            [1, 'asc']
        ],
        columns: [
            { data: 'DT_RowIndex', orderable: false },
            { data: 'name', },
            { data: 'author', },
            { data: 'image', },
            { data: 'description', },
            { data: 'created_at', },
            { data: 'aksi', orderable: false },
        ]
    });

    $('#modalBook').on('shown.bs.modal', function() {
        $('#nama').focus();
    })


    $(document).on('click','.btn-tambah', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'list_author',
            type: 'get',
            dataType: 'json',
            success:function(res){
            if(res){

                $('#author').empty().append('<option selected="true" disabled="disabled">--Pilih Author--</option>');
                $.each(res,function(name,id){
                    $("#author").append('<option value="'+id+'">'+name+'</option>');
                });
            }else{
                 $('#author').empty().append('<option selected="true" disabled="disabled">--Pilih Author--</option>');
            }
            }
        })
        $('#nama').val('');
        $('#description').text('');
        $('#formBook').trigger('reset');
        $('#submit').text('Submit');
        $('#modalBook').modal('show');
    })

    $(document).on('click', '.btn-update', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.ajax({
            url: 'books/' + id,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                $('#submit').text('Update');
                $('.modal-title').text('Update Buku');
                $('#book_id').val(response.id)
                $('#nama').val(response.name);
                $('#description').text(response.description);

                $.ajax({
                    url: 'list_author',
                    type: 'get',
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(res){
                    if(res){
                        $.each(res,function(name,id){
                            if(id == response.author){
                                $("#author").append('<option value="'+id+'" selected="true">'+name+'</option>');
                            }else{
                                $("#author").append('<option value="'+id+'">'+name+'</option>');
                            }

                        });
                    }else{
                        $('#author').empty();
                    }
                    }
                })

                $('#modalBook').modal('show');
            },
            error: function() {
                myswal('error', 'Gagal', 'Terjadi Kesalahan!')
            }
        })
    })

    $(document).on('submit','#formBook', function(e) {
        e.preventDefault();
        let id = $('#book_id').val();
        let btn = $('#submit').text();
        let type = 'post';
        let url = (btn == 'Submit') ? 'book' : 'books/' + id;
        let formData = new FormData(document.getElementById("formBook"));
        console.log(formData);
        $.ajax({
            url: url,
            type: type,
            dataType: 'json',
            data: formData,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                if (response.code == 1) {
                    myswal('success', 'Berhasil', response.msg);
                    $('#modalBook').modal('hide');
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
        let url = 'book/' + id;
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
