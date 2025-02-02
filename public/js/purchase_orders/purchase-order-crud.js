$(document).ready(function () {

    $('#order_number').tooltip({'trigger': 'focus', 'title': 'Purchase Order or Shipping Order'});

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
                    ractive.set(`bill_items.${i}.product_id`, response.id)
                    ractive.set(`bill_items.${i}.price`, response.purchase_price)
                    ractive.set(`bill_items.${i}.unit`, response.sell_unit || 'unit')
                    ractive.set(`bill_items.${i}.description`, response.description || '')
                    ractive.set(`bill_items.${i}.stock`, response.stock || '')
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
    $('#createVendorForm').validate({
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                beforeSend: () => {
                    $('#storeVendorBtn').prop('disabled', true)
                    $('.spinner').removeClass('d-none')
                },
                success: function (response) {
                    $('#vendorModal').modal('hide')
                    let vendor = response;
                    $("#vendor_id").append(new Option(vendor.name, vendor.id));
                    $("#vendor_id").val(vendor.id)
                    $("#vendor_id").trigger('change')
                    $('#storeVendorBtn').trigger("reset");
                    $('#storeVendorBtn').prop('disabled', false)
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
                    ractive.set(`bill_items.${i}.tax_id`, response.id)
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
            } else if (ariaControl.includes('brand_id')) {
                $('#brand_id').append(newState).val(e.target.value).trigger('change');
                $('#brand_id').select2("close")
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
            $('#paymentAmount').val($('#total').val())

        } else {
            console.log('not checked')
            $('#paymentAmount').prop('required', false)
            $('#paymentAmount').val('')

        }
        $('.paymentContainer').toggle(100)
    })
})


$('.qnt').tooltip({'trigger': 'focus', 'title': 'Hit Enter to add new Line'});

$(document).on('keypress', '.qnt', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        ractive.addBillItem();
        let index = parseInt($(e.target).attr('index')) + 1
        $('#itemSelect' + index).select2('open');
        e.preventDefault();
        return false;
    }
})

$(document).on('focus', '.select2', function () {
    $(this).siblings('select').select2('open');
});
$(document).on('keyup keypress', '.rate', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
})
$(document).on('keyup keypress', '.unit', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
})
$(document).on('keyup keypress', '.description', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
})
$('#deposit_to').select2({
    placeholder: "--", allowClear: true
}).on('select2:open', function () {
    let a = $(this).data('select2');
    let doExits = a.$results.parents('.select2-results').find('button')
    if (!doExits.length) {
        a.$results.parents('.select2-results')
            .append('<div><button  data-toggle="modal" data-target="#ledgerModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add New Account</button></div>')
            .on('click', function (b) {
                $("#deposit_to").select2("close");
            });
    }


})
/* Creating Ledger Account Via Ajax With Validation */
$('#createLedgerForm').validate({
    submitHandler: function (form) {
        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            beforeSend: () => {
                $('#storeLedger').prop('disabled', true)
                $('.spinner').removeClass('d-none')
            },
            success: function (response) {
                $('#ledgerModal').modal('hide');
                let i = $('#createLedgerForm').attr('index') || 0;
                if (i === 0 || i === '') {
                    $("#deposit_to").append(new Option(response.ledger_name, response.id));
                    $("#deposit_to").val(response.id)
                    $("#deposit_to").trigger('change')
                } else {
                    ractive.push('ledgers', response)
                    ractive.set(`expense_items.${i}.ledger_id`, response.id)
                }

                console.log(ractive.get('taxes'))
                $('#createLedgerForm').trigger("reset");
                $('#storeLedger').prop('disabled', false)
                $('.spinner').addClass('d-none')
            },

        });
    },
    rules: {
        ledger_name: {required: true,},
        ledger_group_id: {required: true,},
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
