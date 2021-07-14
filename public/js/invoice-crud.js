$(document).ready(function () {


    /* Initial Configuration*/
    $('#productModal select').select2({
        placeholder: "Type & Enter",
        "language": {
            "noResults": function () {
                return "Press <code>Enter</code> to add";
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    })


    /*  Creating Product Via Ajax with Validation */
    $('#createProductForm').validate({
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    ractive.push('products', response)
                    $('#productModal').modal('hide');
                    let i = $('#createProductForm').attr('index') || 0;
                    ractive.set(`invoice_items.${i}.product_id`, response.id)
                    ractive.set(`invoice_items.${i}.price`, response.sell_price)
                    ractive.set(`invoice_items.${i}.sell_unit`, response.sell_unit || 'unit')
                    $(`#row${i}`).find('.qnt').focus()
                    console.log(response)
                }
            });
        },
        rules: {
            name: {
                required: true,
            },
            sell_price: {
                required: true,
            },
        },
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


    /* Creating Customer Via Ajax With Validation */
    $('#createCustomerForm').validate({
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    $('#customerModal').modal('hide')
                    let customer = response;
                    $("#customer_id").append(new Option(customer.name, customer.id));
                    $("#customer_id").val(customer.id)
                    $("#customer_id").trigger('change')

                }
            });
        },
        rules: {
            name: {required: true,},
            email: {email: true,},
        },
        messages: {
            name: {required: "Name is required",},
            sell_price: {required: "required",},
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


    /* Creating Tax Via Ajax With Validation */
    $('#createTaxForm').validate({
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    $('#taxModal').modal('hide');
                    let i = $('#createTaxForm').attr('index') || 0;
                    ractive.push('taxes', response)
                    ractive.set(`invoice_items.${i}.tax_id`, response.id)
                    console.log(ractive.get('taxes'))


                }
            });
        },
        rules: {
            name: {required: true,},
            value: {required: true,},
        },
        messages: {
            name: {required: "Name is required",},
            sell_price: {required: "required",},
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

    /* Setting Up Event Listeners*/
    $('#productModal').on('shown.bs.modal', () => $('#product_name').focus())

    $(document).on('keyup', `.select2-search__field`, function (e) {
        if (e.which === 13) {
            if (!e.target.value) {
                return false;
            }
            var newState = new Option(e.target.value, e.target.value, true, true);

            let ariaControl = $(e.target).attr('aria-controls');

            if (ariaControl.includes('category_id')) {
                $('#category_id').append(newState).val(e.target.value).trigger('change');
                $('#category_id').select2("close")
            } else if (ariaControl.includes('sell_unit')) {
                $('#sell_unit').append(newState).val(e.target.value).trigger('change');
                $('#sell_unit').select2("close")

            } else if (ariaControl.includes('purchase_unit')) {
                $('#purchase_unit').append(newState).val(e.target.value).trigger('change');
                $('#purchase_unit').select2("close")

            }

        }
    });


})


