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

function addToCart(id) {
    console.log('Added To Cart', id)

}

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
        // this.data.tab = text;
        posRactive.set('tab', text)
        console.log(posRactive.get())

    },
});

