let subTotal = parseFloat($('subTotal').val());
var ractive = new Ractive({
    target: '#target',
    template: '#template',
    data: {
        invoice_items: invoice_items,
        products: products,
        taxes: taxes,
        appliedTax: [],
        currency: ''
    },
    addInvoiceItem() {

        var copiedObject = jQuery.extend(true, {}, sample_item)

        ractive.push('invoice_items', copiedObject)
        let i = ractive.get('invoice_items').length - 1;

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
            ractive.set(`invoice_items.${i}.product_id`, $(this).val())
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
                        $('#createTaxForm').attr('index',i)

                    });
            }
        }).on('change', function (event) {
            let i = $(this).attr('index');
            ractive.set(`invoice_items.${i}.tax_id`, $(this).val())

        })


        $(`#itemSelect${i}`).on('change', function (e) {
            onProductChangeEvent(e)
        });

        $("#invoice_item_table tbody").sortable();


    },
    delete(index) {
        ractive.splice('invoice_items', index, 1);
    },
    observe: {
        'invoice_items': (newValue) => {
            let invoice_items = newValue;
            let sub = 0;
            ractiveExtra.set(`appliedTax`, [])
            // alert('sdlfk')
            for (let i = 0; i < invoice_items.length; i++) {
                let item = invoice_items[i];
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
var ractiveExtra = new Ractive({
    target: '#extra',
    template: '#extraTemplate',
    data: {
        pairs: pair,
    },
    addExtraField: function () {
        ractiveExtra.push('pairs', {name: '', value: ''})
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    },
    removeExtraField: (index) => ractiveExtra.splice('pairs', index, 1),
    observe: {
        'pairs': (pairs) => {
            for (let i = 0; i < pairs.length; i++) {
                let pair = pairs[i];
                let value = pair.value || 0

                if (value < 0) {
                    ractiveExtra.set(`pairs.${i}.className`, 'text-danger')
                } else {
                    ractiveExtra.set(`pairs.${i}.className`, '')

                }

            }
            calculateOthers()

        }
    }
});
var ractiveAdditional = new Ractive({
    target: '#additionalFieldTarget',
    template: '#additionalFieldTemplate',
    data: {
        additional_fields: additional_fields,
    },
    addAdditionalField: function () {
        ractiveAdditional.push('additional_fields', {name: '', value: ''})
    },
    observe: {
        'additional_fields': (items) => $('#additionalField').val(JSON.stringify(items))
    },
    removeAdditionalField: (index) => ractiveAdditional.splice('additional_fields', index, 1),
});


for (let i = 0; i < invoice_items.length; i++) {

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
        // let i = $(this).attr('index');
        ractive.set(`invoice_items.${i}.product_id`, $(this).val())
        ractive.set(`invoice_items.${i}.product_id`, $(this).val())
        setTimeout(() => {
            $(`#row${i}`).find('.rate').focus()
        }, 10)

    })

    // Test
    $(`#itemTax${i}`).select2({placeholder: "Select or Add Item",
        allowClear: true}).on('select2:open', function (event) {
        let a = $(this).data('select2');
        let doExits = a.$results.parents('.select2-results').find('button')

        if (!doExits.length) {
            a.$results.parents('.select2-results')
                .append('<div><button  data-toggle="modal" data-target="#taxModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add Tax</button></div>')
                .on('click', function (b) {
                    $(event.target).select2("close");
                    $('#createTaxForm').attr('index',i)

                });
        }
    }).on('change', function (event) {
        let i = $(this).attr('index');
        ractive.set(`invoice_items.${i}.tax_id`, $(this).val())

    })


    $(`#itemSelect${i}`).on('change', function (e) {
        onProductChangeEvent(e)
    });

}

function onProductChangeEvent(e) {
    let id = e.target.value;
    let lineIndex = parseInt($(e.target).attr('index'));
    calculate(id, lineIndex)
}

function calculate(product_id, lineIndex) {
    let products = ractive.get('products')
    let product = products.filter((item) => item.id === parseInt(product_id));
    if (product.length)
        product = product[0];
    if (product) {
        ractive.set(`invoice_items.${lineIndex}.price`, product.sell_price)
        ractive.set(`invoice_items.${lineIndex}.unit`, product.sell_unit || 'unit')
        ractive.set(`invoice_items.${lineIndex}.description`, product.description || '')
    }

    calculateOthers()
}

function calculateOthers() {
    let discountType = $('#discount_type').val();
    let discountValue = $('#discountValue').val();
    let shippingInput = $('#shipping_input').val();
    let discount = 0;


    if (discountType === '%') {
        discount = (discountValue / 100) * subTotal;
    } else {
        discount = parseFloat(discountValue) || 0;
    }
    $('#discount').val(discount.toFixed(2))
    if (discount > 0) {
        $('#discountShown').addClass('text-danger')
        $('#discountShown').val('-' + discount.toFixed(2))

    } else {
        $('#discountShown').removeClass('text-danger')
        $('#discountShown').val(discount.toFixed(2))
    }
    let shippingCharge = parseFloat(shippingInput || 0) || 0
    $('#shipping_charge').val(shippingCharge.toFixed(2))

    let pairs = ractiveExtra.get('pairs');
    let appliedTax = ractiveExtra.get('appliedTax') || [];
    let tax = 0;
    for (let i = 0; i < appliedTax.length; i++) {
        tax += parseFloat(appliedTax[i].amount);
    }
    tax = tax ?? 0;

    let additionalCost = 0;
    for (let i = 0; i < pairs.length; i++) {
        let pair = pairs[i];
        additionalCost += parseFloat(pair.value) || 0

    }

    let total = ((subTotal - discount) + shippingCharge) + additionalCost + tax;
    // alert(tax)

    $('#total').val(total.toFixed(2))
    if (create){
        $('#paymentAmount').val(total.toFixed(2))
    }

    $('#paymentAmount').prop('max',total.toFixed(2))

    $('#invoice_items').val(JSON.stringify(ractive.get('invoice_items')))
    $('#additional').val(JSON.stringify(ractiveExtra.get('pairs').filter((pair) => pair.value !== '' && pair.value !== 0)))
    // console.log(ractiveExtra.get('pairs').filter((pair) => pair.value !== '' && pair.value !== 0))

}

$('#discountValue').on('input', () => calculateOthers());
$('#shipping_input').on('input', () => calculateOthers());
$('#discount_type').on('change', () => calculateOthers());


// Just the ui staff
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('#additionalCollapse').on('hidden.bs.collapse', function () {
        $('#caret').addClass('fa-caret-down')
        $('#caret').removeClass('fa-caret-up')

    })
    $('#additionalCollapse').on('shown.bs.collapse', function () {
        $('#caret').removeClass('fa-caret-down')
        $('#caret').addClass('fa-caret-up')
    })
    $('#payment_terms').select2()
    $("#invoice_item_table tbody").sortable();

    // calculateOthers()
    ractive.set('invoice_items.0.test', '')
    // window.onbeforeunload = confirmExit;
    // function confirmExit() {
    //     return "You have attempted to leave this page. Are you sure?";
    // }

});

$(document).on('keyup', `.select2-search__field`, function (e) {
    if (e.which === 13) {
        if (!e.target.value) {
            return false;
        }
        let ariaControl = $(e.target).attr('aria-controls');
        if (!ariaControl.includes('itemSelect')) {
            // alert('has area control'+$(e.target).attr('aria-controls'))
            return false;

        }

        let id = ariaControl.split('-')[1];
        let i = parseInt($(`#${id}`).attr('index'))

        var newState = new Option(e.target.value, e.target.value, true, true);
        // Append it to the select

        $(`#${id}`).append(newState).val(e.target.value).trigger('change');

        ractive.set(`invoice_items.${i}.product_id`, e.target.value)
        $(`#${id}`).select2("close");
        // $('.rate').focus()
        $(`#row${i}`).find('.rate').focus()

    }
});
