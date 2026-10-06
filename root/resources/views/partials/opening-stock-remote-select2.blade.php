(function() {
    var productSearchUrl = @json(asset('opening-stock/search-products'));

    $('#product_name').select2({
        ajax: {
            url: productSearchUrl,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { q: params.term || '' };
            },
            processResults: function(data) {
                return data;
            }
        },
        minimumInputLength: 0,
        placeholder: 'Select Product',
        allowClear: true,
        width: '100%'
    });

    $("#product_name").next(".select2").find(".select2-selection").focus(function() {
        $("#product_name").select2("open");
    });
})();
