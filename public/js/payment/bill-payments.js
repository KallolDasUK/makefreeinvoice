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
