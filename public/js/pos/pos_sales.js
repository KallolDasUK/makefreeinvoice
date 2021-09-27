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
    RESERVED: "reserves",

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
    },
    onCategorySelected(category_id) {
        console.log(category_id, 'category_clicked')
    },
    onProductSelected(product_id) {
        console.log(product_id, 'product_clicked')
        addToCart(product_id)
    },
    onTabChange(text) {
        posRactive.set('tab', text)
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
