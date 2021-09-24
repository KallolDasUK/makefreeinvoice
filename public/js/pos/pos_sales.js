$(document).on('click', 'input', function () {
    $(this).select();
})

$(document).ready(function () {
    $('#customer_id').select2()
    autocomplete({
        container: '#product_search',
        placeholder: 'Search for products',
        getSources() {
            return ['Enam', 'Babu'];
        },
    });

})

