$('#vendor_id').on('change', function () {
    getVendorBills($(this).val())
})


function getVendorBills(customer_id) {
    // if (!customer_id) return;
    $.ajax({
        url: vendorBillUrl,
        type: "post",
        data: {
            vendor_id: $('#vendor_id').val(),
            _token: csrf
        },
        beforeSend: () => {

        },
        success: function (response) {
            $('#tbody').html(response)
            console.log(response.length, response)
            if (response.length > 500) {
                $('#message').hide()
                $('.receive').removeClass('d-none')
                setTimeout(() => {
                    $('#given').focus()
                }, 50)

            } else {
                $('#message').show()
                $('.receive').addClass('d-none')

                $('#message h3').text('Selected vendor does not have any unpaid invoices.')

            }
        },
        error: function () {
            $('#message').show()
            $('#message h3').text('Please select a vendor first')
        }

    });
}

$(document).ready(function () {
    if (create) {
        getVendorBills($('customer_id').val())
    } else {
        $("#vendor_id").prop("disabled", true);
    }
})


$('form').on('submit', function (e) {
    // e.preventDefault()preventDefault
    // alert('Eror')

    let data = [];

    $('.paymentAmount').each(function () {
        let bill_id = $(this).attr('bill_id')
        let amount = parseFloat($(this).val() || '0')
        if (!amount) return
        data.push({bill_id, amount})
    })
    $('#data').val(JSON.stringify(data))

    console.log($('form').serializeArray())
})

$(document).on('input', '.paymentAmount', function () {
    let totalAmount = 0;
    $('.paymentAmount').each(function (e) {
        totalAmount += parseFloat($(this).val() || '0') || 0
        console.log('called', totalAmount)

    })
    $('#totalAmount').val(totalAmount)
    if (totalAmount > 0) {
        $('#addPayment').prop('disabled', false)
    } else {
        $('#addPayment').prop('disabled', true)
    }


})

$(document).on('input', '#given', function () {
    let given = $(this).val();
    let inPocket = parseFloat(given);
    $('.paymentAmount').each(function (index) {
        let due = parseFloat($(this).attr('due')) || 0;
        if (inPocket > due) {
            $(this).val(due).change()
            inPocket = inPocket - due;
        } else {
            $(this).val(inPocket).change()
            inPocket = 0;
        }

    })

    let totalAmount = 0;
    $('.paymentAmount').each(function (e) {
        totalAmount += parseFloat($(this).val() || '0') || 0
        console.log('called', totalAmount)

    })
    $('#totalAmount').val(totalAmount)
    if (totalAmount > 0) {
        $('#addPayment').prop('disabled', false)
    } else {
        $('#addPayment').prop('disabled', true)
    }
})
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
