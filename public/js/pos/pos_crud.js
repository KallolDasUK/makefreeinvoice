$(document).ready(function () {

    /* Register Events */
    $(document).ready(function () {
        $('#customer_id').select2({placeholder: "Select or Create Customer", allowClear: true})
        $('#ledger_id').select2({placeholder: "Select or Create Account"})

    });
    window.addEventListener("beforeunload", function (e) {
        var confirmationMessage = 'It looks like you have been editing something. '
            + 'If you leave before saving, your changes will be lost.';

        let pos_items = posRactive.get('pos_items')
        if (pos_items.length) {
            (e || window.event).returnValue = confirmationMessage; //Gecko + IE
            return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
        }
    });


    /*  Creating Product Via Ajax with Validation */
    $('#createProductForm').validate({
        submitHandler: function (form) {

            var formData = new FormData(form);
            // alert('hey')
            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: () => {
                    $('#storeProduct').prop('disabled', true)
                    $('.spinner').removeClass('d-none')
                },
                success: function (response) {
                    posRactive.push('products', response)
                    setUpProductSearch()
                    addToCart(response.id)
                    $('#productModal').modal('hide');
                    $('#createProductForm').trigger("reset");
                    $("#category_id").val('').trigger('change')
                    $("#brand_id").val('').trigger('change')
                    $("#purchase_unit").val('').trigger('change')
                    $("#sell_unit").val('').trigger('change')
                    $('#storeProduct').prop('disabled', false)
                    $('.spinner').addClass('d-none')
                }
            });


        },
        rules: {
            name: {
                required: true,
            },
            sell_price: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Name is required",
            },
            sell_price: {
                required: "required",
            },
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


    /*  Creating Category Via Ajax with Validation */
    $('#createCategoryForm').validate({
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                beforeSend: () => {
                    $('#storeCategory').prop('disabled', true)
                    $('.spinner').removeClass('d-none')
                },
                success: function (category) {
                    posRactive.push('categories', category)

                    $('#categoryModal').modal('hide');
                    $('#createCategoryForm').trigger("reset");
                    $('#storeCategory').prop('disabled', false)
                    $('.spinner').addClass('d-none')
                    var data = {
                        id: category.id,
                        text: category.name
                    };

                    var newOption = new Option(data.text, data.id, false, false);
                    $('#category_id').append(newOption).trigger('change');
                }
            });
        },
        rules: {
            name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Name is required",
            },
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


    /* Creating Customer Via Ajax With Validation */
    $('#createCustomerForm').validate({
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                beforeSend: () => {
                    $('#storeCustomerBtn').prop('disabled', true)
                    $('.spinner').removeClass('d-none')
                },
                success: function (response) {
                    $('#customerModal').modal('hide')
                    let customer = response;
                    $("#customer_id").append(new Option(customer.name, customer.id, true, true));
                    $("#customer_id").val(customer.id)
                    $("#customer_id").trigger('change')
                    $('#createCustomerForm').trigger("reset");
                    $('#storeCustomerBtn').prop('disabled', false)
                    $('.spinner').addClass('d-none')

                }
            });
        },
        rules: {
            name: {required: true,},
            // street_1: {required: true},
            email: {email: true,},
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

    /* Creating Payment Method Via Ajax With Validation */
    $('#createPaymentMethodForm').validate({
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                beforeSend: () => {
                    $('#storePaymentMethodBtn').prop('disabled', true)
                    $('.spinner').removeClass('d-none')
                },
                success: function (response) {
                    $('#paymentMethodModal').modal('hide')
                    let method = response;
                    $("#payment_method_id").append(new Option(method.name, method.id));
                    $("#payment_method_id").val(method.id)
                    $("#payment_method_id").trigger('change')
                    $('#createPaymentMethodForm').trigger("reset");
                    $('#storePaymentMethodBtn').prop('disabled', false)
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

    $('#credit_sale').on('click', function () {
        let pos_items = posRactive.get('pos_items')
        posRactive.set('payments', {});
        if (!pos_items.length) {
            $.notify("Cart cant be empty. Please add item to cart", "error", {
                globalPosition: 'bottom left',
            });
            return false;
        }
        placeOrder()

    })

    $('#payment').on('click', function () {
        let pos_items = posRactive.get('pos_items')
        if (!pos_items.length) {
            $.notify("Cart cant be empty. Please add item to cart", "error", {
                globalPosition: 'bottom left',
            });
            return false;
        }
    })
    $('#storePosPaymentBtn').on('click', function () {
        placeOrder()
    })


    function placeOrder() {

        let form = $('#create_pos_sale_form');
        form.action = form.attr('action')
        form.method = form.attr('method')
        let pos_items = posRactive.get('pos_items');
        for (let i = 0; i < pos_items.length; i++) {
            let item = pos_items[i]
            let product = _.find(products, function (product) {
                return product.id == item.product_id;
            });
            product.stock = product.stock - item.qnt;
        }

        posRactive.set('products',products)
        $.ajax({
            accepts: {
                text: "application/json"
            },
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            beforeSend: () => {
                $('#credit_sale').prop('disabled', true)
                $('#storePosPaymentBtn').prop('disabled', true)
                $('#payment').prop('disabled', true)
                $('.spinner').removeClass('d-none')
            },
            success: function (order) {
                $('#create_pos_sale_form').trigger("reset");
                $('#credit_sale').prop('disabled', false)
                $('#payment').prop('disabled', false)
                $('#storePosPaymentBtn').prop('disabled', false)
                $('.spinner').addClass('d-none')
                var pos_charges = _.each(order.pos_charges, function (pos_charge, index, list) {
                    if (("" + pos_charge.key).toLowerCase() == 'discount') {
                        pos_charge.value = '';
                    }
                    return pos_charge;
                });


                console.log(order)
                $.notify("Order Placed", "success")
                posRactive.unshift('orders', order);
                $('#posPaymentModal').modal('hide')
                if (pos_print_receipt) {
                    // alert("printing "+pos_print_receipt)
                    posRactive.onOrderPrint(order.id)
                }

                setTimeout(() => {
                    // posRactive.set('charges', pos_charges);
                }, 1000)
                // posRactive.set('needUpdate', false);
                posRactive.set('charges', []);
                posRactive.set('pos_items', []);
                console.info('setting charges', pos_charges)
                posRactive.set('charges', pos_charges);
            }
        });
    }


    $('.order').tooltip({title: 'Click to see details'})
    $('#payment_method_id').select2().on('select2:open', function (event) {
        let a = $(this).data('select2');
        let doExits = a.$results.parents('.select2-results').find('button')

        if (!doExits.length) {
            a.$results.parents('.select2-results')
                .append('<div><button  data-toggle="modal" data-target="#paymentMethodModal" class="btn btn-default text-primary underline btn-fw" style="width: 100%">+ Add Payment Method</button></div>')
                .on('click', function (b) {
                    $(event.target).select2("close");
                });
        }
    })
    $('#posPaymentModal').on('shown.bs.modal', function (e) {

        posRactive.set('payments', [{amount: posRactive.get('total'), ledger_id: cash_ledger_id}])

        setTimeout(() => {
            $('.amount').focus()
            $('.amount').select()
            initPaymentMethod()

        }, 200)
    })
    $('#posPaymentModal').on('hidden.bs.modal', function (e) {
        posRactive.set('payments', [])
        $('#product_search').focus()
    })

    /* Creating Ledger Account Via Ajax With Validation */
    $('#createLedgerForm').validate({
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                beforeSend: () => {
                    $('#storeLedger').prop('disabled', true)
                    $('.spinner').removeClass('d-none')
                },
                success: function (response) {

                    let i = $('#createLedgerForm').attr('index') || 0;
                    if (($("#posPaymentSingleModal").data('bs.modal') || {})._isShown) {
                        paymentRactive.push('ledgers', response)

                        var data = {
                            id: response.id,
                            text: response.ledger_name
                        };

                        var newOption = new Option(data.text, data.id, true, true);
                        $(`payment_ledger_id${i}`).append(newOption).trigger('change');
                        paymentRactive.set(`payments.${i}.ledger_id`, response.id)
                        $('#createLedgerForm').trigger("reset");
                        $('#ledger_group_id').val(null).trigger('change');
                        $('#storeLedger').prop('disabled', false)
                        $('.spinner').addClass('d-none')
                        console.log(i, response, paymentRactive.get())
                        $('#ledgerModal').modal('hide');
                        // alert('ops')


                    } else {

                        console.log(response)

                        posRactive.push('ledgers', response)
                        posRactive.set(`payments.${i}.ledger_id`, response.id)
                        $('#createLedgerForm').trigger("reset");
                        $('#ledger_group_id').val(null).trigger('change');
                        $('#storeLedger').prop('disabled', false)
                        $('.spinner').addClass('d-none')
                        $('#ledgerModal').modal('hide');
                    }


                },

            });
        },
        rules: {
            ledger_name: {required: true,},
            ledger_group_id: {required: true,},
            value: {required: true,},
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


})


$(document).on('mouseenter', '.product', function () {
    let bookmark_icon = $(this).find('.bookmark_icon')

    bookmark_icon.show()
})
$(document).on('mouseleave', '.product', function () {
    let bookmark_icon = $(this).find('.bookmark_icon')

    bookmark_icon.hide()
})
$(document).on('click', '.bookmark_icon', function (e) {
    let product_id = $(this).attr('product-id')
    let products = posRactive.get('products')
    let index = products.findIndex((product) => product.id == product_id)
    let product = products.find((product) => product.id == product_id)
    if (product.is_bookmarked == '0') {
        product.is_bookmarked = 1;
    } else {
        product.is_bookmarked = 0;
    }
    posRactive.set(`products.${index}.is_bookmarked`, product.is_bookmarked)
    if (product.is_bookmarked) {
        $.notify("Added to Bookmark", "success");

    } else {
        $.notify("Removed from Bookmark", "success");

    }
    // alert('clicked')
    $.ajax({
        accepts: {
            text: "application/json"
        },
        url: productBookmarkedUrl + "?product_id=" + product_id,
        type: "get",

        success: function (response) {
            posRactive.set('bookmarks', response);
        }
    });
})

$(document).ready(function () {
    $('#product_search').focus()

})
document.onkeyup = function (e) {
    var e = e || window.event; // for IE to cover IEs window event-object
    if (e.ctrlKey && e.which == 13) {
        console.log('got the event')
        if (($("#posPaymentModal").data('bs.modal') || {})._isShown) {
            $('#storePosPaymentBtn').click()
            console.log('storePosPaymentBtn')
        } else if (($("#posPaymentSingleModal").data('bs.modal') || {})._isShown) {
            $('#singlePaymentBtn').click()
            console.log('posPaymentSingleModal')
        } else {
            $('#payment').click()
            console.log('payment')

        }

        return false;
    } else if (e.altKey && e.which == 13) {
        console.log('got the event')
        $('#credit_sale').click()
        return false;
    }
}


