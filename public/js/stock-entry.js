var ractive = new Ractive({
    target: '#target',
    template: '#template',
    data: {
        items: items,
        products: products,
    },

    observe: {
        'items': (newValue) => {
            console.log(newValue)
            calculateOthers()
        },
        'products': (products) => {
            let items = [];

            for (let i = 0; i < products.length; i++) {
                items.push({
                    product_id: products[i].id, qnt: '', product: products[i]
                })
            }
            ractive.set('items', items)


        },

    }

});

$.ajax({
    url: route('products.product.index'),
    success: function (response) {
        ractive.set('products', response)
        console.log('bal', items)
        if (edit) {
            let newItem = [];
            for (let i = 0; i < items.length; i++) {
                newItem.push({
                    product_id: items[i].product_id,
                    qnt: items[i].qnt,
                    product: _.findWhere(products, {id: items[i].product_id})
                })
            }
            ractive.set('items', newItem)


        }
    }
})

function calculateOthers() {
    $('#items').val(JSON.stringify(ractive.get('items')))
}


calculateOthers()


$('#category_id').on('change', function () {

    newproducts = _.filter(products,
        function (product) {
            if ($('#category_id').val()) {

                return product.category_id == $('#category_id').val();
            } else {
                return true;
            }

        });
    ractive.set('products', newproducts)
})
$('#brand_id').on('change', function () {

    newproducts = _.filter(products,
        function (product) {
            if ($('#brand_id').val()) {

                return product.brand_id == $('#brand_id').val();
            } else {
                return true;
            }
        });
    ractive.set('products', newproducts)
})
$('#product_id').on('change', function () {

    newproducts = _.filter(products,
        function (product) {
            if ($('#product_id').val()) {

                return product.id == $('#product_id').val();
            } else {
                return true;
            }
        });
    ractive.set('products', newproducts)
})
