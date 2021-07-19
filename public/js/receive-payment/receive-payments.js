$('#customer_id').on('change', function () {
    getCustomerInvoices($(this).val())
})


function getCustomerInvoices(customer_id) {
    // if (!customer_id) return;
    $.ajax({
        url: customerInvoiceUrl,
        type: "post",
        data: {
            customer_id: $('#customer_id').val(),
            _token: csrf
        },
        beforeSend: () => {

        },
        success: function (response) {
            $('#tbody').html(response)
            console.log(response.length, response)
            if (response.length > 250) {
                $('#message').hide()

            } else {
                $('#message').show()
                $('#message h3').text('Selected customer does not have any unpaid invoices.')

            }
        },
        error: function () {
            $('#message').show()
            $('#message h3').text('Please select a customer first')
        }

    });
}

$(document).ready(function () {
    if (create) {
        getCustomerInvoices($('customer_id').val())
    } else {
        $("#customer_id").prop("disabled", true);
    }
})

$('form').on('submit', function (e) {
    // e.preventDefault()preventDefault
    let data = [];
    $('.paymentAmount').each(function () {
        let invoice_id = $(this).attr('invoice_id')
        let amount = parseFloat($(this).val() || '0')
        if (!amount) return
        data.push({invoice_id, amount})
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
