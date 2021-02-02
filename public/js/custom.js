$(document).ready(function () {
    $('[data-toggle=tooltip]').tooltip();
});

function swalValidationErrors(errors) {
    var html = '<ul class="alert alert-danger">';
    for (var err in errors) {
        html += `<li>${errors[err][0]}</li>`;
    }
    html += '</ul>';
    Swal.fire({
        icon: 'error',
        title: 'خطا در داده های ورودی',
        html : html,
    });
}

function swalErrors(errors) {
    var html = '<ul class="alert alert-danger">';
    for (var i = 0; i < errors.length; i++) {
        html += `<li>${errors[i]}</li>`;
    }
    html += '</ul>';
    Swal.fire({
        icon: 'error',
        title: 'خطا در داده های ورودی',
        html : html,
    });
}

function swalError(m='خطایی رخ داد...') {
    Swal.fire({
        icon: 'error',
        title: m,
        showConfirmButton: false,
        timer: 1500
    });
}

function swalSuccess(m='تغییرات با موفقیت ذخیره شد') {
    Swal.fire({
        icon: 'success',
        title: m,
        showConfirmButton: false,
        timer: 1500
    });
}
