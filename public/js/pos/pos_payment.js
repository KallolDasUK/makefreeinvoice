var paymentRactive = new Ractive({
    target: '#singlePayment',
    template: '#singlePaymentTemplate',
    data: {
        sub_total: 0,
        total: 0,
        currency: currency,
        ledgers: ledgers,
        cash_ledger_id: cash_ledger_id,
        payments: [],
        given: 0,
        change: 0,
        order: null
    },
    observe: {
        'payments': (payments) => {

            let order = paymentRactive.get('order')
            let total = order.due;
            let given = 0;
            for (let i = 0; i < payments.length; i++) {
                given += parseFloat(payments[i].amount || 0 + '');
            }
            let change = parseFloat('' + (given - total)).toFixed(2);
            paymentRactive.set('given', given)
            paymentRactive.set('change', change)
        }
    },
    fetchOrder(order_id) {
        $.ajax({
            accepts: {
                text: "application/json"
            },
            url: route('pos_sales.pos_sale.eye', order_id),
            type: "post",
            data: {
                "_token": token,
            },
            beforeSend: function () {

            },
            success: function (response) {
                paymentRactive.set('pos_items', response.pos_items)
                paymentRactive.set('charges', response.pos_charges)
                paymentRactive.set('sub_total', response.sub_total)
                paymentRactive.set('total', response.total)
                paymentRactive.set('payments', [{amount: response.due, ledger_id: cash_ledger_id}])

                setTimeout(() => {
                    $('.amount').focus()
                    $('.amount').select()
                    initPaymentMethod()

                }, 200)

                console.log(paymentRactive.get())
            }
        });
    },
    onPaymentRowCreate() {
        let change = paymentRactive.get('change');
        let nextAmount = 0;
        if (change < 0) {
            nextAmount = Math.abs(change)
        }
        paymentRactive.push('payments', {amount: nextAmount, ledger_id: cash_ledger_id});
        initPaymentMethod()

    },
    onPaymentRowDelete(index) {
        paymentRactive.splice('payments', index, 1);
    },
    onPay() {
        let order_id = paymentRactive.get('order').id
        if (!order_id) return;
        $.ajax({
            accepts: {
                text: "application/json"
            },
            url: route('pos_sales.pos_sale.pay', order_id),
            type: "post",
            data: {
                "_token": token,
                "order_id": order_id,
                "pos_payments": paymentRactive.get('payments')

            },
            beforeSend: function () {
                $('#singlePaymentBtn').attr('disabled', true)
            },
            success: function (response) {
                $('#singlePaymentBtn').attr('disabled', false)
                $('#posPaymentSingleModal').modal('hide')
                posRactive.onOrderFilter()
                console.log(paymentRactive.get())
            }
        });
    }

});

function initPaymentMethod() {
    let i = paymentRactive.get('payments').length - 1;
    $(`#payment_ledger_id${i}`).select2({
        placeholder: "--"
    }).on('select2:open', function () {
        let a = $(this).data('select2');
        let doExits = a.$results.parents('.select2-results').find('button')
        if (!doExits.length) {
            a.$results.parents('.select2-results')
                .append('<div><button  data-toggle="modal" data-target="#ledgerModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add New Account</button></div>')
                .on('click', function (b) {
                    $(`#payment_ledger_id${i}`).select2("close");
                    $('#createLedgerForm').attr('index', i)
                })
        }


    }).on('change', function (event) {
        let i = $(this).attr('index');
        paymentRactive.set(`payments.${i}.ledger_id`, $(this).val())
        // alert('changed'+i)

    });
}

$(document).on('click', '#singlePaymentBtn', function () {
    paymentRactive.onPay()
})
