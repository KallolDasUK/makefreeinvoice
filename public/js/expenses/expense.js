var ractiveTax = new Ractive({
    target: '#allTaxes',
    template: '#taxTemplate',
    data: {}
});
var ractive = new Ractive({
    target: '#line_table',
    template: '#template',
    data: {
        expense_items: expense_items,
        ledgers: ledgers,
        taxes: taxes,
        appliedTax: [],
        currency: ''
    },
    addExpenseItem() {

        var copiedObject = jQuery.extend(true, {}, sample_expense)

        ractive.push('expense_items', copiedObject)
        let i = ractive.get('expense_items').length - 1;

        let currentSelectItem = `#itemSelect${i}`;
        $(currentSelectItem).select2({
            placeholder: "Select or Add Item",
            allowClear: true,
        }).on('select2:open', function (event) {
            let a = $(this).data('select2');
            let doExits = a.$results.parents('.select2-results').find('button')
            if (!doExits.length) {
                a.$results.parents('.select2-results')
                    .append('<div><button  data-toggle="modal" data-target="#ledgerModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add Item</button></div>')
                    .on('click', function (b) {
                        $(event.target).select2("close");
                        $('#createLedgerForm').attr('index', i)
                    });
            }
        }).on('change', function (event) {
            let i = $(this).attr('index');
            ractive.set(`expense_items.${i}.ledger_id`, $(this).val())
            setTimeout(() => {
                $(`#row${i}`).find('.rate').focus()
            }, 10)

        })

        // Test
        $(`#itemTax${i}`).select2({
            placeholder: "--Select or Add Item--",
            allowClear: true
        }).on('select2:open', function (event) {
            let a = $(this).data('select2');
            let doExits = a.$results.parents('.select2-results').find('button')

            if (!doExits.length) {
                a.$results.parents('.select2-results')
                    .append('<div><button  data-toggle="modal" data-target="#taxModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add Tax</button></div>')
                    .on('click', function (b) {
                        $(event.target).select2("close");
                    });
            }
        }).on('change', function (event) {
            let i = $(this).attr('index');
            ractive.set(`expense_items.${i}.tax_id`, $(this).val())

        })


        $(`#itemSelect${i}`).on('change', function (e) {
            onProductChangeEvent(e)
        });

        $("#invoice_item_table tbody").sortable();

        $('.amount').tooltip({'trigger': 'focus', 'title': 'Hit Enter to add new Line'});

    },
    delete(index) {
        if (ractive.get('expense_items').length > 1) {
            ractive.splice('expense_items', index, 1);

        }
    },
    observe: {
        'expense_items': (newValue) => {
            // alert('sdlk')
            let expense_items = newValue;
            let sub = 0;
            ractive.set(`appliedTax`, [])
            // alert('sdlfk')
            for (let i = 0; i < expense_items.length; i++) {
                let item = expense_items[i];
                sub += parseFloat(item.amount) || 0;
                let tax_id = parseInt(item.tax_id || 0)
                if (item.ledger_id && tax_id) {
                    let taxes = ractive.get('taxes')
                    let tax = taxes.find(tax => tax.id === tax_id)
                    let taxAmount = (parseFloat(item.amount || 0) * parseFloat(tax.value)) / 100;
                    ractive.push(`appliedTax`, {
                        name: `${tax.name} ${tax.value} ${tax.tax_type}`,
                        minifiedName: `${tax.name} ${tax.value} ${tax.tax_type}`,
                        amount: taxAmount
                    })

                }

            }
            let appliedTax = ractive.get('appliedTax') || [];
            let tempArray = [];
            for (let j = 0; j < appliedTax.length; j++) {
                let tax = appliedTax[j];
                let existing = false;
                tempArray.forEach(function (item, index) {
                    if (item.name === tax.name) {
                        existing = true;
                        tempArray[index].minifiedName = tempArray[index].minifiedName + "," + tax.name;
                        tempArray[index].amount = parseFloat(tempArray[index].amount || 0) + parseFloat(tax.amount || 0);
                    }
                });
                if (existing) continue;
                tempArray.push(tax)

            }
            ractiveTax.set('appliedTax', tempArray)
            subTotal = sub;
            $('#subTotal').val(subTotal.toFixed(2))

            calculate()
        },
        'currency': (newCurrency) => {
            $('.currency').text(newCurrency)
            ractiveTax.set('currency', newCurrency)
        }
    }
});


for (let i = 0; i < expense_items.length; i++) {

    let currentSelectItem = `#itemSelect${i}`;
    $(currentSelectItem).select2({
        placeholder: "Select or Add Item",
        allowClear: true,
    }).on('select2:open', function (event) {
        let a = $(this).data('select2');
        let doExits = a.$results.parents('.select2-results').find('button')
        if (!doExits.length) {
            a.$results.parents('.select2-results')
                .append('<div><button  data-toggle="modal" data-target="#ledgerModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add Item</button></div>')
                .on('click', function (b) {
                    $(event.target).select2("close");
                    $('#createLedgerForm').attr('index', i)
                });
        }
    }).on('change', function (event) {
        // let i = $(this).attr('index');
        ractive.set(`expense_items.${i}.ledger_id`, $(this).val())
        ractive.set(`expense_items.${i}.ledger_id`, $(this).val())
        setTimeout(() => {
            $(`#row${i}`).find('.rate').focus()
        }, 10)

    })

    // Test
    $(`#itemTax${i}`).select2({
        placeholder: "Select or Add Item",
        allowClear: true
    }).on('select2:open', function (event) {
        let a = $(this).data('select2');
        let doExits = a.$results.parents('.select2-results').find('button')

        if (!doExits.length) {
            a.$results.parents('.select2-results')
                .append('<div><button  data-toggle="modal" data-target="#taxModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add Tax</button></div>')
                .on('click', function (b) {
                    $(event.target).select2("close");
                    $('#createTaxForm').attr('index', i)
                });
        }
    }).on('change', function (event) {
        let i = $(this).attr('index');
        ractive.set(`expense_items.${i}.tax_id`, $(this).val())

    })


    $(`#itemSelect${i}`).on('change', function (e) {
        // calculate()
    });

}

function calculate(ledger_id, lineIndex) {

    calculateOthers()
}

function calculateOthers() {

    let appliedTax = ractiveTax.get('appliedTax') || [];
    let tax = 0;
    for (let i = 0; i < appliedTax.length; i++) {
        tax += parseFloat(appliedTax[i].amount);
    }
    tax = tax ?? 0;


    let total = subTotal + tax;
    // alert(tax)

    $('#total').val(total.toFixed(2))


    $('#expense_items').val(JSON.stringify(ractive.get('expense_items')))
    // console.log(ractiveTax.get('pairs').filter((pair) => pair.value !== '' && pair.value !== 0))

}

let note = ractive.get('expense_items.0.notes')
ractive.set('expense_items.0.notes', '...')
ractive.set('expense_items.0.notes', note)
