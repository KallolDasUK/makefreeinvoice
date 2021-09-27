$(document).on('click', 'input', function () {
    $(this).select();
})

$(document).ready(function () {
    $('#customer_id').select2()
    console.log(products)
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
            console.log(ui.content)
            let items = ui.content;
            if (items.length === 1) {
                setTimeout(() => {
                    $('.ui-menu-item').click()
                    $('#product_search').val('').trigger('')
                }, 100)


                // addToCart(items[0].value)
            }

        }

    }).data("autocomplete")._renderItem = function (ul, item) {
        var newText = String(item.value).replace(
            new RegExp(this.term, "gi"),
            "<span class='ui-state-highlight text-danger'>$&</span>");

        return $("<li></li>")
            .data("item.autocomplete", item)
            .append("<div>" + newText + "</div>")
            .appendTo(ul);
    };

    function showLabel(event, ui) {
        setTimeout(() => {
            $('#product_search').val('').trigger('')
        }, 100)
        addToCart(ui.item.value)

    }
})


const TABS = {
    PRODUCT_CONTAINER: "products",
    BOOKMARK: "bookmarks",
    CUSTOM_FIELD: "custom_fields",
    RESERVED: "orders",

}
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
        sub_total: 0,
        total: 0,
        currency: currency,
        charges: charges,
    },
    observe: {
        'products': (newProducts) => {
            posRactive.set('empty_boxes', Array.from({length: 23 - newProducts.length}, (x, i) => i))
        },
        'pos_items': (newPosItems) => {
            let sub_total = newPosItems.reduce((s, item) => s + (item.qnt * item.price), 0);
            posRactive.set('sub_total', sub_total)
            posRactive.set('total', sub_total)
            posRactive.calculate()
        },
        'charges': (newCharges) => {
            posRactive.calculate()


        }
    },
    onCategorySelected(category_id) {
        console.log(category_id, 'category_clicked')
        let categorizedProduct = _.filter(products, function (product) {
            if (product.category_id === category_id) {
                return product;
            }
        });
        posRactive.set('products', categorizedProduct)
        console.log(categorizedProduct)
    },
    onProductSelected(product_id) {
        console.log(product_id, 'product_clicked')
        addToCart(product_id)
    },
    onTabChange(text) {
        posRactive.set('tab', text)
        if (text === "products") {
            posRactive.set('products', products)

        }
    },
    delete_pos_item(i) {
        posRactive.splice('pos_items', i, 1);
    },
    increment(i) {
        let pos_item = posRactive.get(`pos_items.${i}`);
        posRactive.set(`pos_items.${i}.qnt`, ++pos_item.qnt)
        console.log(i, pos_item)
    },
    decrement(i) {
        let pos_item = posRactive.get(`pos_items.${i}`);
        posRactive.set(`pos_items.${i}.qnt`, --pos_item.qnt)
        console.log(i, pos_item)
    },
    onChargeCreate() {
        posRactive.push('charges', {});
    },
    onChargeDelete(i) {
        posRactive.splice('charges', i, 1);
    },
    calculate() {
        let charges = posRactive.get('charges')
        let total = posRactive.get('sub_total')
        _.each(charges, function (charge, index) {
            let input = charge.value;
            if (input.length > 0) {

                charge.percentage = input.includes('%');

                if (charge.percentage) {
                    let index = input.indexOf('%');
                    input = input.substring(0, index) + input.substring(index + 1);
                    charge.amount = percentage(parseFloat(input), posRactive.get('sub_total'))
                } else {
                    charge.amount = parseFloat(input);
                }
                posRactive.set('charges.' + index, charge)
                console.log(charge, index)
            }
            total += charge.amount || 0;
        });
        posRactive.set('total', total)

    }
});

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
    console.log('Added To Cart', is_product_already_in_cart)
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

}

function percentage(percent, total) {
    return parseFloat(((percent / 100) * total).toFixed(2))
}
