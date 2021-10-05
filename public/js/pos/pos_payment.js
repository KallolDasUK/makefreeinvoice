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
        payable: 0,
        change: 0,
        order: null
    },
    observe: {
        'payments': (payments) => {

            let total = paymentRactive.get('payable')
            let given = 0;
            for (let i = 0; i < payments.length; i++) {
                given += parseFloat(payments[i].amount || 0 + '');
            }
            let change = parseFloat('' + (given - total)).toFixed(2);
            paymentRactive.set('given', given)
            paymentRactive.set('change', change)


        },
        'charges': (charges) => {
            let paid = parseFloat(paymentRactive.get('order').payment);
            let total = parseFloat(paymentRactive.get('order').sub_total) - paid

            _.each(charges, function (charge, index) {
                let input = charge.value;
                if (input && input.length > 0) {
                    if (charge.key.toLowerCase().includes('discount') && !input.includes('-')) {
                        input = '-' + input;
                        // paymentRactive.set('charges.' + index + '.value', input)
                        charge.value = input;

                    }
                    charge.percentage = input.includes('%');

                    if (charge.percentage) {
                        let index = input.indexOf('%');
                        input = input.substring(0, index) + input.substring(index + 1);
                        charge.amount = percentage(parseFloat(input), parseFloat(paymentRactive.get('order').sub_total))
                    } else {
                        charge.amount = parseFloat(input) || 0;
                    }

                    paymentRactive.set('charges.' + index, charge)
                    console.log(paymentRactive.get('charges'))

                }
                if (!input) {
                    charge.amount = 0;
                    paymentRactive.set('charges.' + index, charge)
                }

                total += charge.amount || 0;
            });
            paymentRactive.set('payable', total)
            paymentRactive.set('total', total + paid)
            paymentRactive.set('payments.0.amount', total)


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
                paymentRactive.set('payable', parseFloat(response.due))
                paymentRactive.set('payments', [{amount: response.due, ledger_id: cash_ledger_id}])

                setTimeout(() => {
                    $('.amount').focus()
                    $('.amount').select()
                    initPaymentMethodPOS()

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
        initPaymentMethodPOS()

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
                "pos_payments": paymentRactive.get('payments'),
                "pos_charges": paymentRactive.get('charges'),
                "total": paymentRactive.get('total')

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
    },
    onChargeCreate() {
        paymentRactive.push('charges', {});
    },
    onChargeDelete(i) {
        paymentRactive.splice('charges', i, 1);
    },

});

function initPaymentMethodPOS() {
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
