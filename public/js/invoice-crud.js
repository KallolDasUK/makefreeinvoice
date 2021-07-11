let storeUserBtn = document.getElementById('storeUserBtn');
let nameInput = document.getElementById('name');
let csrf_token = document.querySelector('meta[name~="csrf-token"]').getAttribute('content');

storeUserBtn.disabled = true;

storeUserBtn.addEventListener('click', async (event) => {


    let data = {
        name: document.getElementById('name').value,
        phone: document.getElementById('phone').value,
        email: document.getElementById('email').value,
        address: document.getElementById('address').value,
        website: document.getElementById('website').value,
        _token: csrf_token
    };
    let request = await fetch('/customers', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf_token
        },
        body: JSON.stringify(data)
    })
    let customer = await request.json();
    // if (request.status !== 200) {
    //     $('#customerModal').modal('hide')
    //     alert('Unable to save customer. Contact Our Team ASAP.');
    // }
    $("#customer_id").append(new Option(customer.name, customer.id));

    $("#customer_id").val(customer.id)
    $("#customer_id").trigger('change')
    $('#customerModal').modal('hide')


});
nameInput.addEventListener('input', (event) => {
    storeUserBtn.disabled = event.target.value === '';
});
