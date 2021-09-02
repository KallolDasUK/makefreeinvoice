$('select').select2({
    placeholder: "Type & Enter",
    "language": {
        "noResults": function () {
            return "Press <code>Enter</code> to add";
        }
    },
    escapeMarkup: function (markup) {
        return markup;
    }
})
$(document).on('keyup', `.select2-search__field`, function (e) {
    if (e.which === 13) {
        if (!e.target.value) {
            return false;
        }
        var newState = new Option(e.target.value, e.target.value, true, true);

        let ariaControl = $(e.target).attr('aria-controls');

        if (ariaControl.includes('category_id')) {
            $('#category_id').append(newState).val(e.target.value).trigger('change');
            $('#category_id').select2("close")
        } else if (ariaControl.includes('brand_id')) {
            $('#brand_id').append(newState).val(e.target.value).trigger('change');
            $('#brand_id').select2("close")
        } else if (ariaControl.includes('sell_unit')) {
            $('#sell_unit').append(newState).val(e.target.value).trigger('change');
            $('#sell_unit').select2("close")

        } else if (ariaControl.includes('purchase_unit')) {
            $('#purchase_unit').append(newState).val(e.target.value).trigger('change');
            $('#purchase_unit').select2("close")

        }

    }
});

$('#purchase_price,#opening_stock').on('input', function () {
    $('#opening_stock_price').val(parseFloat(($('#purchase_price').val() || 0) * ($('#opening_stock').val() || 0)))
})
