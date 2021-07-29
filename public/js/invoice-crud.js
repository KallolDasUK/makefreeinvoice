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


    $('#currency').select2()

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
            // street_1: {required: true},
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

    /* Creating Tax Via Ajax With Validation */
    $('#createPaymentMethodForm').validate({
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                beforeSend: () => {
                    $('#storePaymentMethodBtn').prop('disabled', true)
                    $('.spinner').removeClass('d-none')
                },
                success: function (response) {
                    $('#paymentMethodModal').modal('hide')
                    let method = response;
                    $("#payment_method_id").append(new Option(method.name, method.id));
                    $("#payment_method_id").val(method.id)
                    $("#payment_method_id").trigger('change')
                    $('#createPaymentMethodForm').trigger("reset");
                    $('#storePaymentMethodBtn').prop('disabled', false)
                    $('.spinner').addClass('d-none')
                },

            });
        },
        rules: {
            name: {required: true},
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
    var avatar1 = new KTImageInput('kt_image_1');
    let currency = $('#currency').val()
    ractive.set('currency', currency)
    $('#currency').on('change', function () {
        let currency = $('#currency').val()
        ractive.set('currency', currency)
    })


    $('#payment_method_id').select2().on('select2:open', function (event) {
        let a = $(this).data('select2');
        let doExits = a.$results.parents('.select2-results').find('button')

        if (!doExits.length) {
            a.$results.parents('.select2-results')
                .append('<div><button  data-toggle="modal" data-target="#paymentMethodModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add Payment Method</button></div>')
                .on('click', function (b) {
                    $(event.target).select2("close");
                });
        }
    })
    $('#deposit_to').select2()

    $('#paymentCheckBox').on('change', function () {

        if ($('#paymentCheckBox').is(':checked')) {
            console.log('checked')
            $('#paymentAmount').prop('required', true)
        } else {
            console.log('not checked')
            $('#paymentAmount').prop('required', false)
        }
        $('.paymentContainer').toggle(100)
    })
})


