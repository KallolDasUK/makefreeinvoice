var ractive = new Ractive({
    target: '#target',
    template: '#template',
    data: {
        inventory_adjustment_items: inventory_adjustment_items,
        products: products,
        reasons: reasons,

    },
    addItem() {

        var copiedObject = jQuery.extend(true, {}, sample_item)

        ractive.push('inventory_adjustment_items', copiedObject)
        let i = ractive.get('inventory_adjustment_items').length - 1;

        let currentSelectItem = `#itemSelect${i}`;
        let reasonSelectItem = `#reasonSelect${i}`;
        $(currentSelectItem).select2({
            placeholder: "Select Item",
            allowClear: true,
        })


        $(`#itemSelect${i}`).on('change', function (e) {
            onProductChangeEvent(e)
        });
        $(reasonSelectItem).select2({
            placeholder: "Select Reason",
            allowClear: true,
        }).on('select2:open', function (event) {
            let a = $(this).data('select2');
            let doExits = a.$results.parents('.select2-results').find('button')
            if (!doExits.length) {
                a.$results.parents('.select2-results')
                    .append('<div><button  data-toggle="modal" data-target="#reasonModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add Reason</button></div>')
                    .on('click', function (b) {
                        $(event.target).select2("close");
                        $('#createReasonForm').attr('index', i)
                    });
            }
        }).on('change', function (event) {
            // let i = $(this).attr('index');
            ractive.set(`inventory_adjustment_items.${i}.reason_id`, $(this).val())
            console.log()
        })
        $("#invoice_item_table tbody").sortable();


    },
    delete(index) {
        if (ractive.get('inventory_adjustment_items').length > 1) {
            ractive.splice('inventory_adjustment_items', index, 1);
        }
    },
    observe: {
        'inventory_adjustment_items': (newValue) => {
            console.log(newValue)
            calculateOthers()
        }
    }

});

for (let i = 0; i < inventory_adjustment_items.length; i++) {

    let currentSelectItem = `#itemSelect${i}`;
    let reasonSelectItem = `#reasonSelect${i}`;
    $(currentSelectItem).select2({
        placeholder: "Select Item",
        allowClear: true,
    })

    $(reasonSelectItem).select2({
        placeholder: "Select Reason",
        allowClear: true,
    }).on('select2:open', function (event) {
        let a = $(this).data('select2');
        let doExits = a.$results.parents('.select2-results').find('button')
        if (!doExits.length) {
            a.$results.parents('.select2-results')
                .append('<div><button  data-toggle="modal" data-target="#reasonModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add Reason</button></div>')
                .on('click', function (b) {
                    $(event.target).select2("close");
                    $('#createReasonForm').attr('index', i)
                });
        }
    }).on('change', function (event) {
        // let i = $(this).attr('index');
        ractive.set(`inventory_adjustment_items.${i}.reason_id`, $(this).val())
        console.log()
    })
    // Test


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
    ractive.set(`inventory_adjustment_items.${lineIndex}.product_id`, product.id)


    calculateOthers()
}

function calculateOthers() {

    $('#inventory_adjustment_items').val(JSON.stringify(ractive.get('inventory_adjustment_items')))
    // console.log(ractiveExtra.get('pairs').filter((pair) => pair.value !== '' && pair.value !== 0))

}

/* Creating Tax Via Ajax With Validation */
$('#createReasonForm').validate({
    submitHandler: function (form) {
        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            beforeSend: () => {
                $('#storeReasonBtn').prop('disabled', true)
                $('.spinner').removeClass('d-none')
            },
            success: function (response) {
                $('#reasonModal').modal('hide')
                let method = response;

                let i = $('#createReasonForm').attr('index') || 0;
                ractive.push('reasons', response)
                ractive.set(`inventory_adjustment_items.${i}.reason_id`, response.id)



                $('#createReasonForm').trigger("reset");
                $('#storeReasonBtn').prop('disabled', false)
                $('.spinner').addClass('d-none')
            },

        });
    },
    rules: {
        name: {required: true},
    },
    messages: {
        name: {required: "Name is required",},
        sell_price: {required: "required",},
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});
