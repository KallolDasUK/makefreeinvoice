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
        },

    });
}

$(document).ready(function () {
    getCustomerInvoices($('customer_id').val())
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
    }else{
        $('#addPayment').prop('disabled', true)

    }
})
