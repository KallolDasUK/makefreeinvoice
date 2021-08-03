var ractive = new Ractive({
    target: '#line_table',
    template: '#template',
    data: {
        expense_items: [],
        products: [],
        taxes: [],
        appliedTax: [],
        currency: ''
    },
    addInvoiceItem() {

        var copiedObject = jQuery.extend(true, {}, sample_item)

        ractive.push('expense_items', copiedObject)
        let i = ractive.get('expense_items').length - 1;

        let currentSelectItem = `#itemSelect${i}`;
        $(currentSelectItem).select2({
            placeholder: "Select or Add Item",
            allowClear: true,

            "language": {
                "noResults": function () {
                    return "Press <code>Enter</code> to add";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        }).on('select2:open', function (event) {
            let a = $(this).data('select2');
            let doExits = a.$results.parents('.select2-results').find('button')
            if (!doExits.length) {
                a.$results.parents('.select2-results')
                    .append('<div><button  data-toggle="modal" data-target="#productModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add Item</button></div>')
                    .on('click', function (b) {
                        $(event.target).select2("close");
                        $('#createProductForm').attr('index', i)
                    });
            }
        }).on('change', function (event) {
            let i = $(this).attr('index');
            ractive.set(`expense_items.${i}.product_id`, $(this).val())
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


    },
    delete(index) {
        ractive.splice('expense_items', index, 1);
    },
    observe: {
        'expense_items': (newValue) => {
            let expense_items = newValue;
            let sub = 0;
            ractiveExtra.set(`appliedTax`, [])
            // alert('sdlfk')
            for (let i = 0; i < expense_items.length; i++) {
                let item = expense_items[i];
                sub += (parseFloat(item.qnt) || 0) * (parseFloat(item.price) || 0);
                let tax_id = parseInt(item.tax_id || 0)
                if (item.product_id && tax_id) {
                    let taxes = ractive.get('taxes')
                    let tax = taxes.find(tax => tax.id === tax_id)
                    let taxAmount = ((parseFloat(item.qnt || 0) * parseFloat(item.price || 0)) * parseFloat(tax.value)) / 100;
                    ractiveExtra.push(`appliedTax`, {
                        name: `${tax.name} ${tax.value} ${tax.tax_type}`,
                        minifiedName: `${tax.name} ${tax.value} ${tax.tax_type}`,
                        amount: taxAmount
                    })

                }

            }
            let appliedTax = ractiveExtra.get('appliedTax') || [];
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
            ractiveExtra.set('appliedTax', tempArray)
            subTotal = sub;
            $('#subTotal').val(subTotal.toFixed(2))

            calculate()
        },
        'currency': (newCurrency) => {
            $('.currency').text(newCurrency)
            ractiveExtra.set('currency', newCurrency)
        }
    }
});
