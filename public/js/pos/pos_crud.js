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
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
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
        // alert(form.action)
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
                posRactive.set('pos_items', []);
                console.log(order)
                $.notify("Order Placed", "success")
                posRactive.unshift('orders', order);
                $('#posPaymentModal').modal('hide')

            }
        });
    }

    $(document).on('click', '.order', function () {
        let pos_sales_id = $(this).attr('index');
        $.ajax({
            accepts: {
                text: "application/json"
            },
            url: posSalesDetailsUrl + "?pos_sales_id=" + pos_sales_id,
            type: "get",

            success: function (response) {
                $('#blankModal').modal('show')
                $('#content').html(response)
            }
        });

    })
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
        setTimeout(() => {
            $('.amount').focus()
            $('.amount').select()
        }, 200)
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
                    $('#ledgerModal').modal('hide');
                    let i = $('#createLedgerForm').attr('index') || 0;
                    posRactive.push('ledgers', response)
                    posRactive.set(`payments.${i}.ledger_id`, response.id)


                    $('#createLedgerForm').trigger("reset");
                    $('#storeLedger').prop('disabled', false)
                    $('.spinner').addClass('d-none')
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


