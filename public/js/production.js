var ractive = new Ractive({
    target: '#target',
    template: '#template',
    data: {
        production_items: production_items,
        used_items: used_items,
        products: products,

    },
    addItem() {

        var copiedObject = jQuery.extend(true, {}, sample_item)

        ractive.push('production_items', copiedObject)
        let i = ractive.get('production_items').length - 1;

        let currentSelectItem = `#productionItemSelect${i}`;
        $(currentSelectItem).select2({
            placeholder: "Select Item",
            allowClear: true,
        })


        $(`#productionItemSelect${i}`).on('change', function (e) {
            onProductionItemChangeEvent(e)
        });


    }, addUsedItem() {

        var copiedObject = jQuery.extend(true, {}, sample_item)

        ractive.push('used_items', copiedObject)
        let i = ractive.get('used_items').length - 1;

        let currentSelectItem = `#itemSelect${i}`;
        $(currentSelectItem).select2({
            placeholder: "Select Item",
            allowClear: true,
        })


        $(`#itemSelect${i}`).on('change', function (e) {
            onUsedItemChangeEvent(e)
        });


    },
    deleteItem(index) {
        if (ractive.get('production_items').length > 1) {
            ractive.splice('production_items', index, 1);
        }
    }, deleteUsedItem(index) {
        if (ractive.get('used_items').length > 1) {
            ractive.splice('used_items', index, 1);
        }
    },
    observe: {
        'production_items': (newValue) => {
            console.log(newValue)
            calculateOthers()
        }, 'used_items': (newValue) => {
            console.log(newValue)
            calculateOthers()
        }
    }

});

for (let i = 0; i < production_items.length; i++) {

    let productionSelectItem = `#productionItemSelect${i}`;
    $(productionSelectItem).select2({
        placeholder: "Select Item",
        allowClear: true,
    })

    $(productionSelectItem).on('change', function (e) {
        onProductionItemChangeEvent(e)
    });
    let usedSelectItem = `#itemSelect${i}`;
    $(usedSelectItem).select2({
        placeholder: "Select Item",
        allowClear: true,
    })

    $(`#itemSelect${i}`).on('change', function (e) {
        onUsedItemChangeEvent(e)
    });

}

function onUsedItemChangeEvent(e) {
    let product_id = e.target.value;
    let lineIndex = parseInt($(e.target).attr('index'));
    let products = ractive.get('products')
    let product = products.filter((item) => item.id === parseInt(product_id));
    if (product.length)
        product = product[0];
    ractive.set(`used_items.${lineIndex}.product_id`, product.id)

    calculateOthers()
}

function onProductionItemChangeEvent(e) {
    let product_id = e.target.value;
    let lineIndex = parseInt($(e.target).attr('index'));
    let products = ractive.get('products')
    let product = products.filter((item) => item.id === parseInt(product_id));
    if (product.length)
        product = product[0];
    ractive.set(`production_items.${lineIndex}.product_id`, product.id)

    calculateOthers()
}


function calculateOthers() {
    $('#production_items').val(JSON.stringify(ractive.get('production_items')))
    $('#used_items').val(JSON.stringify(ractive.get('used_items')))
    // alert($('#used_items').val())
}

calculateOthers()
