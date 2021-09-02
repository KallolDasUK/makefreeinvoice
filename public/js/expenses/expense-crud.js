$('#ledger_id').select2({
    placeholder: "--", allowClear: true
}).on('select2:open', function () {
    let a = $(this).data('select2');
    let doExits = a.$results.parents('.select2-results').find('button')
    if (!doExits.length) {
        a.$results.parents('.select2-results')
            .append('<div><button  data-toggle="modal" data-target="#ledgerModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add New Account</button></div>')
            .on('click', function (b) {
                $("#ledger_id").select2("close");
            });
    }


})
$('#ledger_group_id').select2({
    placeholder: "--", allowClear: true
})
$('#vendor_id').select2({
    placeholder: "--",
    allowClear: true
}).on('select2:open', function () {
    let a = $(this).data('select2');
    let doExits = a.$results.parents('.select2-results').find('button')
    if (!doExits.length) {
        a.$results.parents('.select2-results')
            .append('<div><button  data-toggle="modal" data-target="#vendorModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add New Vendor</button></div>')
            .on('click', function (b) {
                $("#vendor_id").select2("close");
            });
    }


})
$('#customer_id').select2({
    placeholder: "--",
    allowClear: true

}).on('select2:open', function () {
    let a = $(this).data('select2');
    let doExits = a.$results.parents('.select2-results').find('button')
    if (!doExits.length) {
        a.$results.parents('.select2-results')
            .append('<div><button  data-toggle="modal" data-target="#customerModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add New Customer</button></div>')
            .on('click', function (b) {
                $("#customer_id").select2("close");
            });
    }


})

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
                let customer = response;
                $("#vendor_id").append(new Option(customer.name, customer.id));
                $("#vendor_id").val(customer.id)
                $("#vendor_id").trigger('change')
                $('#createVendorForm').trigger("reset");
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
                ractive.set(`expense_items.${i}.tax_id`, response.id)
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
                    $("#ledger_id").append(new Option(response.ledger_name, response.id));
                    $("#ledger_id").val(response.id)
                    $("#ledger_id").trigger('change')
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
$('.amount').tooltip({'trigger': 'focus', 'title': 'Hit Enter to add new Line'});
$(document).on('keypress', '.amount', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        ractive.addExpenseItem();
        let index = parseInt($(e.target).attr('index')) + 1
        $('#itemSelect'+index).select2('open');
        e.preventDefault();
        return false;
    }
})
