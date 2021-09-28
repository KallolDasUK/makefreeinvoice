$(document).ready(function () {

    /* Register Events */
    $(document).ready(function () {
        $('#customer_id').select2({placeholder: "Select or Create Customer", allowClear: true})

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


    $('#credit_sale').on('click', function () {
        let pos_items = posRactive.get('pos_items')
        if (!pos_items.length) {
            $.notify("Cart cant be empty. Please add item to cart", "error", {
                globalPosition: 'bottom left',
            });
            return false;
        }
        placeCreditSale()

    })


    function placeCreditSale() {


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
                $('#payment').prop('disabled', true)
                $('.spinner').removeClass('d-none')
            },
            success: function (order) {
                $('#create_pos_sale_form').trigger("reset");
                $('#credit_sale').prop('disabled', false)
                $('#payment').prop('disabled', false)
                $('.spinner').addClass('d-none')
                posRactive.set('pos_items', []);
                console.log(order)
                $.notify("Order Placed", "success")
                posRactive.unshift('orders', order);

            }
        });
    }

})


