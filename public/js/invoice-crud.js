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
    $('#sr_id').select2({placeholder: "-- Sales Representative --", allowClear: true});


    // $.ajax({
    //     url: route('products.product.index'),
    //     success: function (response) {
    //         ractive.set('products', response)
    //     }
    // })
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
                    ractive.set(`invoice_items.${i}.unit`, response.sell_unit || 'unit')
                    ractive.set(`invoice_items.${i}.description`, response.description || '')
                    ractive.set(`invoice_items.${i}.stock`, response.stock || '')
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
                    $('#createCustomerForm').trigger("reset");
                    $('#storeCustomerBtn').prop('disabled', false)
                    $('.spinner').addClass('d-none')

                }, error: function (xhr, textStatus, errorThrown) {
                    $('#storeCustomerBtn').prop('disabled', false)
                    $('.spinner').addClass('d-none')
                    console.log(xhr, textStatus, errorThrown)
                    $('#customer_ID').closest('.form-group').append('<span  class="error text-danger">Customer ID is already in use.</span>');
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


    $('#is_recurring').on('change', function () {
        if ($('#is_recurring').is(':checked')) {
            $('.recurringContainer').show(100)
            $('#recurringSection').addClass('border p-2 bg-secondary rounded')
        } else {
            $('.recurringContainer').hide(100)
            $('#recurringSection').removeClass('border p-2 bg-secondary rounded')

        }
    })
    $('#paymentCheckBox').on('change', function () {

        let payable = ractive.get('payable') || 0;
        if ($('#paymentCheckBox').is(':checked')) {
            console.log('checked')
            $('#paymentAmount').prop('required', true)
            $('#paymentAmount').val(payable)
        } else {
            console.log('not checked')
            $('#paymentAmount').prop('required', false)
            $('#paymentAmount').val('')

        }
        $('.paymentContainer').toggle(100)
    })
})

//
// $('form').on('keyup keypress', function (e) {
//     var keyCode = e.keyCode || e.which;
//     if (keyCode === 13) {
//         e.preventDefault();
//         return false;
//     }
// });
document.onkeyup = function (e) {
    var e = e || window.event;
    if(e.shiftKey && e.which == 80) {
        if($('#paymentCheckBox').is(':checked')) {
            $('#paymentCheckBox').prop('checked', false).click()
            $('#paymentCheckBox').prop('checked', false)
            
        }
        else{
            $('#paymentCheckBox').prop('checked', true).click()
            $('#paymentCheckBox').prop('checked', true)
            $('#paymentAmount').focus()
        }
    }
    if(e.shiftKey && e.which == 68) {
            $('#discountValue').focus()
        }
    if(e.shiftKey && e.which == 13) {
        $('#create_invoice_button').click();
    }
}


$('.qnt').tooltip({'trigger': 'focus', 'title': 'Hit Enter to add new Line'});
$(document).on('focus', '.select2', function () {
    $(this).siblings('select').select2('open');
});

$(document).on('keypress', '.qnt', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        ractive.addInvoiceItem();
        let index = parseInt($(e.target).attr('index')) + 1
        $('#itemSelect' + index).select2('open');
        e.preventDefault();
        return false;
    }
})

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

$('#customer_id').on('change', function () {

    $.ajax({
        url: route('customers.customer.advance_info', $(this).val()),
        beforeSend: () => {
            $('#from_advance').val('0').trigger('change')
            $('#advance').val('0').trigger('change')
            $('.advanceContainer').addClass('d-none')
            calculateOthers()

        },
        success: function (response) {

            if (response.customer_id_feature === '1') {
                $('#info').show()
                let customer = response.customer;
                $('#phone_number').text(customer.phone)
                $('#credit_limit').text(customer.credit_limit)
                $('#customer_type').text(customer.customer_type)
                $('#reference_by').text(customer.reference_by)
                console.log(customer)
            }


            if (response.advance <= 0) return;
            $('.advanceContainer').removeClass('d-none')
            $('#advance').val(response.advance).trigger('change')
            $('#advance_amount').text(response.advance)
            $('#customer_name').text(response.name)

            calculateOthers()


        }
    });


});

$('#from_advance').on('change', function () {
    $('#using_advance_amount').text($(this).val())
})

// $.ajax({
//     url: route('products.product.index'),
//     processData: false,
//     contentType: false,
//
//     success: function (response) {
//         ractive.set('products', response)
//         products = response;
//
//     }
// });

