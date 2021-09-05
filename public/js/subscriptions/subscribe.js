$('#basicM_btn,#premiumM_btn,#basicY_btn,#premiumY_btn')
    .on('click', function () {
        $('#priceID').val($(this).attr('data'))
        $('#subscriptionPaymentModal').modal('show')

        /* Payment Goes Here */


    });

var stripe = Stripe('pk_live_51JVJpVI8TcFb3W7t6bikYaJd74v76XvdNG0nNkT9s0JlN09yrEOevpQV4bYhkOZRUSKPn79wueWGonbuHmVwG7NL003E8Vw0SV');
// Create an instance of the card Element.
var elements = stripe.elements();

var card = elements.create('card', {style: style});
// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
// Handle real-time validation errors from the card Element.
card.on('change', function (event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};
$('#subscriptionPaymentForm').validate({
    submitHandler: async function (form) {
        $('#payment_btn').prop('disabled', true)
        $('.spinner').removeClass('d-none')
        let valid = false;
        var cardHolderName = document.getElementById('card-holder-name');
        var clientSecret = form.dataset.secret;
        const {setupIntent, error} = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card,
                    billing_details: {name: cardHolderName.value}
                }
            }
        );
        if (error) {
            // Inform the user if there was an error.
            console.log('error')
            valid = false;
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        } else {
            valid = true;
            console.log('success')
            await stripeTokenHandler(setupIntent);
        }

        if (valid) {
            $.ajax({
                url: form.action,
                type: form.method,
                async: false,
                data: $(form).serialize(),
                beforeSend: async (e) => {
                    $('#payment_btn').prop('disabled', true)
                    $('.spinner').removeClass('d-none')

                },
                success: function (response) {
                    console.log(response)
                    $('#subscriptionPaymentModal').modal('hide')
                    location.reload()
                    $('#payment_btn').prop('disabled', false)
                    $('.spinner').addClass('d-none')
                }
            });
        } else {
            $('#payment_btn').prop('disabled', false)
            $('.spinner').addClass('d-none')
        }

    },
    rules: {
        card_holder_name: {
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
})

// Submit the form with the token ID.
function stripeTokenHandler(setupIntent) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('subscriptionPaymentForm');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'paymentMethod');
    hiddenInput.setAttribute('value', setupIntent.payment_method);
    form.appendChild(hiddenInput);
    // Submit the form
    // form.submit();
}

