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
                beforeSend: () => {
                    $('#storeProduct').prop('disabled', true)
                    $('.spinner').removeClass('d-none')
                },
                success: function (response) {
                    ractive.push('products', response)
                    $('#productModal').modal('hide');
                    let i = $('#createProductForm').attr('index') || 0;
                    ractive.set(`invoice_items.${i}.product_id`, response.id)
                    ractive.set(`invoice_items.${i}.price`, response.sell_price)
                    ractive.set(`invoice_items.${i}.sell_unit`, response.sell_unit || 'unit')
                    $(`#row${i}`).find('.qnt').focus()
                    $('#createProductForm').trigger("reset");
                    $('#storeProduct').prop('disabled', false)
                    $('.spinner').addClass('d-none')
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
                beforeSend: () => {
                    $('#storeCustomerBtn').prop('disabled', true)
                    $('.spinner').removeClass('d-none')
                },
                success: function (response) {
                    $('#customerModal').modal('hide')
                    let customer = response;
                    $("#customer_id").append(new Option(customer.name, customer.id));
                    $("#customer_id").val(customer.id)
                    $("#customer_id").trigger('change')
                    $('#storeCustomerBtn').trigger("reset");
                    $('#storeCustomerBtn').prop('disabled', false)
                    $('.spinner').addClass('d-none')

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
                beforeSend: () => {
                    $('#storeTax').prop('disabled', true)
                    $('.spinner').removeClass('d-none')
                },
                success: function (response) {
                    $('#taxModal').modal('hide');
                    let i = $('#createTaxForm').attr('index') || 0;
                    ractive.push('taxes', response)
                    ractive.set(`invoice_items.${i}.tax_id`, response.id)
                    console.log(ractive.get('taxes'))
                    $('#createTaxForm').trigger("reset");
                    $('#storeTax').prop('disabled', false)
                    $('.spinner').addClass('d-none')
                },

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

    if (additional_fields.length > 0) {
        $('#additionalCollapse').collapse('show')
    } else {
        $('#additionalCollapse').collapse('hide')

    }
    $('#productModal').on('shown.bs.modal', () => $('#product_name').focus())
    $('#payment_terms').on('change', function () {
        let value = $(this).val();
        let invoiceDate = $('#invoice_date').val();
        console.log(value == -1)
        if (value == -1) {
            $('#due_date').val('')
            setTimeout(() => {
                $('#due_date').focus()
            }, 100)
        } else if (value) {
            $('#due_date').val(moment(invoiceDate).add(value, 'days').format('YYYY-MM-DD'))
        } else {
            $('#due_date').val('')

        }
    });
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


