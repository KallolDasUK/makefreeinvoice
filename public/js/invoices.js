let exp_based_product = (settings.exp_based_product || '0') === '1';
// alert(exp_based_product)
let subTotal = parseFloat($('subTotal').val());
var ractive = new Ractive({
    target: '#target',
    template: '#template',
    data: {
        invoice_items: invoice_items,
        products: products,
        taxes: taxes,
        appliedTax: [],
        currency: '',
        exp_based_product: exp_based_product
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
        });

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
                        $('#createTaxForm').attr('index', i)
                    });
            }
        }).on('change', function (event) {
            let i = $(this).attr('index');
            ractive.set(`invoice_items.${i}.tax_id`, $(this).val())
        });

        $(`#itemSelect${i}`).on('change', function (e) {
            onProductChangeEvent(e)
        });

        $("#invoice_item_table tbody").sortable();

        $('.qnt').tooltip({'trigger': 'focus', 'title': 'Hit Enter to add new Line'});
    },
    delete(index) {
        if (ractive.get('invoice_items').length > 1) {
            ractive.splice('invoice_items', index, 1);
        }
    },
    observe: {
        'invoice_items': (newValue) => {
            let invoice_items = newValue;
            let sub = 0;
            let totalProfit = 0;
            ractiveExtra.set(`appliedTax`, []);


            for (let i = 0; i < invoice_items.length; i++) {

                let item = invoice_items[i];
                // sub += (parseFloat(item.qnt) || 0) * (parseFloat(item.price) || 0);
                let tax_id = parseInt(item.tax_id || 0);
                if (item.product_id && tax_id) {
                    let taxes = ractive.get('taxes');
                    let tax = taxes.find(tax => tax.id === tax_id);
                    let taxAmount = ((parseFloat(item.qnt || 0) * parseFloat(item.price || 0)) * parseFloat(tax.value)) / 100;
                    ractiveExtra.push(`appliedTax`, {
                        name: `${tax.name} ${tax.value} ${tax.tax_type}`,
                        minifiedName: `${tax.name} ${tax.value} ${tax.tax_type}`,
                        amount: taxAmount
                    });
                }                
                let products = ractive.get('products');
                let product = products.filter((p) => p.id === parseInt(item.product_id));
                if (product.length){

                    product = product[0];
                    if (product) {
                        ractive.set(`invoice_items.${i}.purchase_price`, product.purchase_price || 0);
                        $.ajax({
                            url: route('products.product.product_stock'),
                            data: {product_ids: [product.id]},
                            type: 'post',
                            success: function (response) {
                                let product_stocks = response;
                                for (let j = 0; j < product_stocks.length; j++) {
                                    let product_stock = product_stocks[j].product_stock;
                                    ractive.set(`invoice_items.${i}.stock`, product_stock);
                                }
                            }
                        });    
                    }
                }

                // Calculate profit
                let profit = (parseFloat(item.price || 0) - parseFloat(item.purchase_price || 0)) * (parseFloat(item.qnt) || 0);
                ractive.set(`invoice_items.${i}.profit`, profit.toFixed(2));
                
                // Add to total profit
                totalProfit += profit;
                sub += (parseFloat(item.qnt) || 0) * (parseFloat(item.price) || 0);

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
                tempArray.push(tax);
            }
            ractiveExtra.set('appliedTax', tempArray);
            subTotal = sub;
            $('#subTotal').val(subTotal.toFixed(2));
    
            // Update total profit in the HTML
            $('#total_profit').text(totalProfit.toFixed(2));
    
            calculate();
        },
        'currency': (newCurrency) => {
            $('.currency').text(newCurrency);
            ractiveExtra.set('currency', newCurrency);
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
        ractiveExtra.push('pairs', {name: '', value: '', calculatedValue: ''});
        bindDynamicFields();
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    },
    removeExtraField: (index) => ractiveExtra.splice('pairs', index, 1),
    observe: {
        'pairs': (pairs) => {
            for (let i = 0; i < pairs.length; i++) {
                let pair = pairs[i];
                let value = pair.value || 0;

                if (value < 0) {
                    ractiveExtra.set(`pairs.${i}.className`, 'text-danger');
                } else {
                    ractiveExtra.set(`pairs.${i}.className`, '');
                }
            }
            calculateOthers();
        }
    }
});

// Initial binding for existing fields
bindDynamicFields();
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
        // ajax: {
        //     url: route('products.product.search'),
        //     data: function (params) {
        //         var query = {
        //             search: params.term,
        //             type: 'public'
        //         }
        //         return query;
        //     }
        // },
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
    $(`#itemTax${i}`).select2({
        placeholder: "Select or Add Item",
        allowClear: true,

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
        ractive.set(`invoice_items.${i}.tax_id`, $(this).val())

    })


    $(`#itemSelect${i}`).on('change', function (e) {
        onProductChangeEvent(e)
    });

}

function onProductChangeEvent(e) {
    let id = e.target.value;
    let lineIndex = parseInt($(e.target).attr('index'));
    $.ajax({
        url: route('ajax.productBatch'),
        type: 'post',
        data: {product_id: id, _token: csrf},

        success: function (response) {


            let options = '<option value="">-</option>'
            if (response.length > 0) {
                options = '<option value="">select batch</option>'
            }
            for (let i = 0; i < response.length; i++) {
                let item = response[i];
                let option = `<option value="${item}">${item}</option>`
                options = options.concat(option);
            }
            console.log(response, options)
            $('#batch' + lineIndex)
                .empty()
                .html(options);
        }
    });
    calculate(id, lineIndex)

}

function calculate(product_id, lineIndex) {
    let products = ractive.get('products');

    let product = products.filter((item) => item.id === parseInt(product_id));

    if (product.length)
        product = product[0];
    if (product) {

        ractive.set(`invoice_items.${lineIndex}.price`, product.sell_price);
        ractive.set(`invoice_items.${lineIndex}.unit`, product.sell_unit || 'unit');
        ractive.set(`invoice_items.${lineIndex}.description`, product.description || '');
        ractive.set(`invoice_items.${lineIndex}.purchase_price`, product.purchase_price || 0);

        $.ajax({
            url: route('products.product.product_stock'),
            data: {product_ids: [product.id]},
            type: 'post',
            success: function (response) {
                let product_stocks = response;
                for (let i = 0; i < product_stocks.length; i++) {
                    let product_stock = product_stocks[i].product_stock;
                    ractive.set(`invoice_items.${lineIndex}.stock`, product_stock);
                }
            }
        });
    }
    calculateOthers();
}

function calculateOthers() {
    let subTotal = parseFloat($('#subTotal').val()) || 0;
    let discountType = $('#discount_type').val();
    let discountValue = $('#discountValue').val();
    let shippingInput = $('#shipping_input').val();
    let discount = 0;

    if (discountType === '%') {
        discount = (parseFloat(discountValue) / 100) * subTotal;
    } else {
        discount = parseFloat(discountValue) || 0;
    }
    $('#discount').val(discount.toFixed(2));

    if (discount > 0) {
        $('#discountShown').addClass('text-danger');
        $('#discountShown').val('-' + discount.toFixed(2));
    } else {
        $('#discountShown').removeClass('text-danger');
        $('#discountShown').val(discount.toFixed(2));
    }

    let shippingCharge = parseFloat(shippingInput || 0) || 0;
    $('#shipping_charge').val(shippingCharge.toFixed(2));

    let pairs = ractiveExtra.get('pairs');
    let appliedTax = ractiveExtra.get('appliedTax') || [];
    let tax = 0;
    for (let i = 0; i < appliedTax.length; i++) {
        tax += parseFloat(appliedTax[i].amount);
    }

    let additionalCost = 0;
    pairs.forEach((pair, index) => {
        let value = pair.value.trim();
        let calculatedValue = 0;
        let className = '';

        if (value.includes('%')) {
            let percentageValue = parseFloat(value.replace('%', '')) || 0;
            calculatedValue = (subTotal * percentageValue / 100);
        } else {
            calculatedValue = parseFloat(value) || 0;
        }

        if (value.includes('-')) {
            className = 'text-danger';
        }

        additionalCost += calculatedValue;
        ractiveExtra.set(`pairs.${index}.calculatedValue`, calculatedValue.toFixed(2));
        ractiveExtra.set(`pairs.${index}.className`, className);
    });

    let total = ((subTotal - discount) + shippingCharge) + additionalCost + tax;
    $('#total').val(total.toFixed(2));
    $('#paymentAmount').val(total.toFixed(2)).prop('max', total.toFixed(2));
    $('#invoice_items').val(JSON.stringify(ractive.get('invoice_items')));
    $('#additional').val(JSON.stringify(pairs.filter(pair => pair.value !== '' && pair.value !== 0)));
    let advancePayment = $('#advance').val() || 0;
    ractive.set('payable', total);

    if (advancePayment > 0) {
        if (advancePayment >= total) {
            $('#paymentSection').hide();
            $('#from_advance').val(total).trigger('change');
            ractive.set('payable', 0);
        } else if (advancePayment < total) {
            $('#paymentSection').show();
            let remaining = total - advancePayment;
            $('#from_advance').val(advancePayment).trigger('change');
            $('#paymentAmount').prop('max', remaining.toFixed(2)).val(remaining.toFixed(2)).trigger('change');
            ractive.set('payable', remaining);
        }
    }
}

$('#discountValue').on('input', () => calculateOthers());
$('#shipping_input').on('input', () => calculateOthers());
$('#discount_type').on('change', () => calculateOthers());

$('#extrafieldValue').on('input', () => calculateOthers());
// $('#extrafield_type').on('change', () => calculateOthers());

function bindDynamicFields() {
    $('#extra').on('input', '.discountValue', () => calculateOthers());
    $('#extra').on('change', '.discount_type', () => calculateOthers());
}

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

$(document).on('click','.select2-results__option select2-results__option--highlighted', function (e) {
    console.log('clicked');
})
