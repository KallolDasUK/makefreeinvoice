let subTotal = 0;
var ractive = new Ractive({
    target: '#target',
    template: '#template',
    data: {
        invoice_items: invoice_items,
        products: products,
        taxes: taxes,
        appliedTax: []
    },
    addInvoiceItem() {

        var copiedObject = jQuery.extend(true, {}, sample_item)

        ractive.push('invoice_items', copiedObject)
        let length = ractive.get('invoice_items').length;
        console.log(`#itemSelect${length - 1}`)

        new TomSelect(`#itemSelect${length - 1}`, {
            sortField: {
                field: "text",
                direction: "asc"
            },
            plugins: {
                'dropdown_header': {
                    title: 'Language',
                    html: function (data) {
                        return `<div >
                    <a href="/sdlfd" >+ Add New Item</a>
			            </div>`;
                    }
                },

            },
        });
        $(`#itemSelect${length - 1}`).on('change', function (e) {
            onProductChangeEvent(e)
        })

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
    }
});
var ractiveExtra = new Ractive({
    target: '#extra',
    template: '#extraTemplate',
    data: {
        pairs: [jQuery.extend(true, {}, pair)],
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
                console.log(pairs, value, value < 0)

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

new TomSelect(`#itemSelect0`, {
    create: true,
    sortField: {
        field: "text",
        direction: "asc"
    },
    plugins: {
        'dropdown_header': {
            title: 'Language',
            html: function (data) {
                return `<div >
                    <a href="/sdlfd" >+ Add New Item</a>
			            </div>`;
            }
        },

    },
});
$('#itemSelect0').on('change', function (e) {
    onProductChangeEvent(e)
})

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
    ractive.set(`invoice_items.${lineIndex}.unit`, product.sell_unit)
    ractive.set(`invoice_items.${lineIndex}.price`, product.sell_price)

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
        additionalCost += pair.value || 0

    }

    let total = ((subTotal - discount) + shippingCharge) + additionalCost + tax;

    // alert(tax)

    $('#total').val(total.toFixed(2))
    $('#invoice_items').val(JSON.stringify(ractive.get('invoice_items')))
    $('#additional').val(JSON.stringify(ractiveExtra.get('pairs')))

}

$('#discountValue').on('input', () => calculateOthers());
$('#shipping_input').on('input', () => calculateOthers());
$('#discount_type').on('change', () => calculateOthers());

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
