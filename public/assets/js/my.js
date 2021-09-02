function error_alert(xhr) {
    if (xhr.status == 422) {
        return $.each(xhr.responseJSON.errors, function(index, value) {
            $('.error-' + index).text(value[0]);
            $('#' + index).addClass('is-invalid');
        })
    }
}

function myswal(icon = 'success', title = 'Berhasil', text = 'Proses Berhasil') {
    return Swal.fire({
        icon: icon,
        title: title,
        text: text,
        showConfirmButton: false,
        timer: 1500
    })
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
    }
})


function myswalconfirm(text = "You won't be able to revert this!") {
    return Swal.fire({
        title: 'Are you sure?',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, continue!'
    })
}

function myswalloading(title = 'Loading', text = 'Harap tunggu...') {
    return Swal.fire({
        title: title,
        html: '<div class="spinner-border text-dark mb-1" role="status"><span class="sr-only">Loading...</span> </div><br> ' + text,
        showConfirmButton: false,
        allowOutsideClick: false,
    })
}

$('.btn-logout').on('click', function(e) {
    myswalconfirm('Anda akan logout').then(function(result) {
        if (result.isConfirmed) {
            window.location.href = 'logout';
        }
    })
})

$('img').attr("onerror", "this.src='/assets/img/noimage.jpg';")

// $('#tanggal_masuk').datetimepicker({
//     pickTime: false,
//     minView: 2,
//     format: 'yyyy-mm-dd',
//     autoclose: true,
// });
