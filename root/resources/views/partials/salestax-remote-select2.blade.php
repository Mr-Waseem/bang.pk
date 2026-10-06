(function() {
    var selectedParty = @json($selectedParty ?? null);
    var partySearchUrl = @json(asset('salestax/search-parties'));
    var productSearchUrl = @json(asset('salestax/search-products'));

    function initRemoteSelect2($el, url, placeholder, selected) {
        if (selected && selected.id) {
            $el.append(new Option(selected.text, selected.id, true, true));
        }
        $el.select2({
            ajax: {
                url: url,
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
            placeholder: placeholder,
            allowClear: true,
            width: '100%'
        });
    }

    window.setPartySelectValue = function(partyId, partyName) {
        var $el = $('#party_name');
        $el.empty();
        if (partyId) {
            $el.append(new Option(partyName || ('Party #' + partyId), partyId, true, true));
            $el.trigger('change');
        }
    };

    initRemoteSelect2($('#party_name'), partySearchUrl, 'Select Customer', selectedParty);
    initRemoteSelect2($('#product_name'), productSearchUrl, 'Select Product', null);

    $("#party_name").next(".select2").find(".select2-selection").focus(function() {
        $("#party_name").select2("open");
    });
    $("#product_name").next(".select2").find(".select2-selection").focus(function() {
        $("#product_name").select2("open");
    });
})();
