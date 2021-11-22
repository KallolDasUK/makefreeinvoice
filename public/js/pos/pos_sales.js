$(document).on('click', 'input', function () {
    $(this).select();
})


const TABS = {
    PRODUCT_CONTAINER: "products",
    BOOKMARK: "bookmarks",
    CUSTOM_FIELD: "custom_fields",
    RESERVED: "orders",

}
let hide_price = (settings.pos_hide_price || '0') === '1';
let hide_stock = (settings.pos_hide_stock || '0') === '1';
let hide_image = (settings.pos_hide_image || '1') === '1';
let hide_name = (settings.pos_hide_name || '0') === '1';
let show_sale_price = (settings.pos_card_price || 'sale_price') === 'sale_price';
let show_purchase_price = settings.pos_card_price === 'purchase_price';

var posRactive = new Ractive({
        target: '#pos',
        template: '#posTemplate',
        data: {
            products: products,
            categories: categories,
            customers: customers,
            tab: TABS.PRODUCT_CONTAINER,
            pos_items: pos_items,
            empty_boxes: Array.from({length: 23 - products.length}, (x, i) => i),
            bookmark_empty_boxes: Array.from({length: 24 - bookmarks.length}, (x, i) => i),
            sub_total: 0,
            total: 0,
            currency: currency,
            charges: charges,
            orders: orders,
            paymentMethods: paymentMethods,
            payments: payments,
            bookmarks: bookmarks,
            ledgers: ledgers,
            cash_ledger_id: cash_ledger_id,
            given: 0,
            change: 0,
            start_date: start_date,
            end_date: end_date,
            needUpdate: true,
            can_delete: can_delete, hide_stock, hide_price, show_purchase_price, show_sale_price, hide_name, hide_image
        },
        observe: {
            'products': (newProducts) => {
                posRactive.set('empty_boxes', Array.from({length: 23 - newProducts.length}, (x, i) => i))
            },
            'bookmarks': (bookmarks) => {
                posRactive.set('bookmark_empty_boxes', Array.from({length: 24 - bookmarks.length}, (x, i) => i))
            },
            'pos_items': (newPosItems) => {
                let sub_total = newPosItems.reduce((s, item) => s + (item.qnt * item.price), 0);
                posRactive.set('sub_total', sub_total)
                posRactive.set('total', sub_total)
                posRactive.calculate()

                $('#pos_items').val(JSON.stringify(newPosItems))
                $('#product_search').focus()

            },
            'charges': (newCharges) => {
                let needUpdate = posRactive.get('needUpdate')
                if (needUpdate) {
                    posRactive.calculate()
                    console.log('calculate', newCharges, needUpdate)
                }
                $('#charges').val(JSON.stringify(newCharges))

            },
            'total': (newTotal) => {
                $('#total').val(newTotal)

            },
            'sub_total': (newSubtotal) => {
                $('#sub_total').val(newSubtotal)
            },
            'payments': (payments) => {
                let total = posRactive.get('total');
                let given = 0;
                for (let i = 0; i < payments.length; i++) {
                    given += parseFloat(payments[i].amount || 0 + '');
                }
                let change = parseFloat('' + (given - total)).toFixed(2);
                posRactive.set('given', given)
                posRactive.set('change', change)
                $('#payments').val(JSON.stringify(payments));
            }
        },
        onCategorySelected(category_id) {
            let categorizedProduct = _.filter(products, function (product) {
                if (product.category_id == category_id) {
                    return product;
                }
            });
            posRactive.set('products', categorizedProduct)
            posRactive.set('tab', "products")
        }
        ,
        onProductSelected(product_id) {
            addToCart(product_id)
        }
        ,
        onTabChange(text) {
            posRactive.set('tab', text)
            if (text === "products") {
                posRactive.set('products', products)
            }
            $('#product_search').focus()

        }
        ,
        delete_pos_item(i) {
            posRactive.splice('pos_items', i, 1);
            $('#product_search').focus()
        }
        ,
        increment(i) {
            let pos_item = posRactive.get(`pos_items.${i}`);
            posRactive.set(`pos_items.${i}.qnt`, ++pos_item.qnt)
        }
        ,
        decrement(i) {
            let pos_item = posRactive.get(`pos_items.${i}`);
            posRactive.set(`pos_items.${i}.qnt`, --pos_item.qnt)
        }
        ,
        onChargeCreate() {
            posRactive.push('charges', {});
        }
        ,
        onChargeDelete(i) {
            posRactive.splice('charges', i, 1);
        },
        calculate(paymentChanged = false) {
            let charges = posRactive.get('charges')
            let total = posRactive.get('sub_total')
            _.each(charges, function (charge, index) {
                let input = charge.value;
                if (input && input.length > 0) {
                    if (charge.key.toLowerCase().includes('discount') && !input.includes('-')) {
                        input = '-' + input;
                        charge.value = input;
                        // posRactive.set('charges.' + index + '.value', input)

                    }
                    charge.percentage = input.includes('%');

                    if (charge.percentage) {
                        let index = input.indexOf('%');
                        input = input.substring(0, index) + input.substring(index + 1);
                        charge.amount = percentage(parseFloat(input), posRactive.get('sub_total'))
                    } else {
                        charge.amount = parseFloat(input) || 0;
                    }

                    posRactive.set('needUpdate', false)
                    posRactive.set('charges.' + index, charge)
                    posRactive.set('needUpdate', true)

                }
                if (!input) {
                    charge.amount = 0;
                    posRactive.set('needUpdate', false)
                    posRactive.set('charges.' + index, charge)
                    posRactive.set('needUpdate', true)
                }
                total += charge.amount || 0;
            });

            posRactive.set('total', total)
            let payments = posRactive.get('payments');
            let given = 0;
            for (let i = 0; i < payments.length; i++) {
                given += parseFloat(payments[i].amount || 0 + '');
            }
            let change = parseFloat('' + (given - total)).toFixed(2);
            posRactive.set('given', given)
            posRactive.set('change', change)

        },
        onPaymentRowCreate() {
            let change = posRactive.get('change');
            let nextAmount = 0;
            if (change < 0) {
                nextAmount = Math.abs(change)
            }
            posRactive.push('payments', {amount: nextAmount, ledger_id: cash_ledger_id});
            initPaymentMethod()

        }
        ,
        onPaymentRowDelete(index) {
            posRactive.splice('payments', index, 1);
        }
        ,
        onOrderDelete(order_id) {
            if (!confirm('Are you sure to delete the order?')) {
                return;
            }
            let index = posRactive.get('orders').findIndex(order => order.id == order_id);
            posRactive.splice('orders', index, 1);

            $.ajax({
                accepts: {
                    text: "application/json"
                },
                url: route('pos_sales.pos_sale.destroy', order_id),
                type: "DELETE",
                data: {
                    "id": order_id,
                    "_token": token,
                },
                success: function (response) {

                }
            });


        }
        ,
        onOrderPrint(order_id) {
            $.ajax({
                accepts: {
                    text: "application/json"
                },
                url: posSalesDetailsUrl + "?pos_sales_id=" + order_id,
                type: "get",

                success: function (response) {
                    // $('#blankModal').modal('show')
                    $('#content').html(response)
                    $('#printable').printThis()
                    $('#product_search').focus()

                }
            });
        }
        ,
        onOrderView(order_id) {
            $.ajax({
                accepts: {
                    text: "application/json"
                },
                url: posSalesDetailsUrl + "?pos_sales_id=" + order_id,
                type: "get",

                success: function (response) {
                    $('#blankModal').modal('show')
                    $('#content').html(response)
                    // $('#printable').printThis()
                }
            });
        }
        ,
        onOrderFilter() {
            let start_date = $('#start_date').val()
            let end_date = $('#end_date').val()
            $.ajax({
                accepts: {
                    text: "application/json"
                },
                url: route('pos_sales.pos_sale.filter'),
                type: "post",
                data: {
                    "start_date": start_date,
                    "end_date": end_date,
                    "_token": token,
                },
                beforeSend: function () {
                    posRactive.set('orders', [])

                },
                success: function (response) {
                    posRactive.set('orders', response)
                }
            });
        }
        ,
        onOrderPay(order_id) {
            $('#posPaymentSingleModal').modal('show')
            let order = posRactive.get('orders').find(order => order.id == order_id)
            paymentRactive.set('order', order)
            paymentRactive.fetchOrder(order_id)

        }
        ,

    })
;

function onReceiptPrint() {
    $('#blankModal').modal('hide')

    $('#printable').printThis()
}

function initPaymentMethod() {
    let i = posRactive.get('payments').length - 1;
    $(`#ledger_id${i}`).select2({
        placeholder: "--"
    }).on('select2:open', function () {
        let a = $(this).data('select2');
        let doExits = a.$results.parents('.select2-results').find('button')
        if (!doExits.length) {
            a.$results.parents('.select2-results')
                .append('<div><button  data-toggle="modal" data-target="#ledgerModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add New Account</button></div>')
                .on('click', function (b) {
                    $(`#ledger_id${i}`).select2("close");
                    $('#createLedgerForm').attr('index', i)
                })
        }


    }).on('change', function (event) {
        let i = $(this).attr('index');
        posRactive.set(`payments.${i}.ledger_id`, $(this).val())
        // alert('changed'+i)

    });
}

function setUpProductSearch() {
    let products = posRactive.get('products')
    var product_names = _.map(products, function (product, index) {
        let name = product.name;
        if (product.code) {
            name = product.code + ' ' + name;
        }
        return {label: name, value: product.id};
    });
    $("#product_search").autocomplete({
        source: product_names,
        select: showLabel,
        response: function (event, ui) {
            let items = ui.content;
            if (items.length === 1) {
                setTimeout(() => {
                    $('.ui-menu-item').click()
                    $('#product_search').val('').trigger('')
                }, 100)


                // addToCart(items[0].value)
            }

        }

    });
}

function showLabel(event, ui) {
    setTimeout(() => {
        $('#product_search').val('').trigger('')
    }, 100)
    addToCart(ui.item.value)

}

function addToCart(id) {


    let product = _.find(products, function (product) {
        return product.id == id;
    });

    let is_product_already_in_cart = _.findIndex(posRactive.get('pos_items'), function (item) {
        return item.product_id == id;
    });
    if (is_product_already_in_cart !== -1) {
        posRactive.increment(is_product_already_in_cart)
        $('#line' + is_product_already_in_cart).addClass('animate_color')
        setTimeout(() => {
            $('#line' + is_product_already_in_cart).removeClass('animate_color')
        }, 800)
        return false;
    }
    var sample_pos_item = {
        product_id: id,
        product: product,
        description: '',
        price: product.sell_price,
        qnt: 1,
        tax_id: '',
        unit: product.sell_unit || 'unit',
        amount: ''
    };
    var copiedObject = jQuery.extend(true, {}, sample_pos_item)
    posRactive.unshift('pos_items', copiedObject)
    $('#product_search').focus()

}

function percentage(percent, total) {
    return parseFloat(((percent / 100) * total).toFixed(2))
}


/* Calling Functions */

setUpProductSearch()

$(document).on('click', '#product_search', function () {
    $('#product_search').focus()
    // alert('lsd')
})
console.log(posRactive.get())
