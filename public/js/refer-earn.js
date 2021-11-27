function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).val()).select();
    document.execCommand("copy");
    $temp.remove();
    alert('Affiliate Link Copied')
}

$(document).ready(function () {
    $('#copyLink').on('click', function () {
        copyToClipboard($('#refer_link'))
    })

    /*  Withdraw fund Via Ajax with Validation */
    $('#withdrawForm').validate({
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                beforeSend: () => {

                },
                success: function (response) {
                    location.reload()
                }
            });
        },
        rules: {},
        messages: {
            name: {
                required: "Name is required",
            },
            sell_price: {
                required: "required",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
})
