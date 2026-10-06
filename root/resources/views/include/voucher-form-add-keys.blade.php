<script type="text/javascript">
$(function () {
    $('.btn-add-line').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13 || ((e.key === 'Tab' || e.keyCode === 9) && !e.shiftKey)) {
            e.preventDefault();
            AddGridData();
        }
    });

    $('tr.st-entry input:not([disabled])').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            AddGridData();
        }
    });

    var $title = $('#title');
    if ($title.length) {
        $title.on('keydown.voucherAdd', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                var isOpen = $title.data('select2') && $title.next('.select2-container').hasClass('select2-container--open');
                if (!isOpen) {
                    e.preventDefault();
                    AddGridData();
                }
            }
        });
        $title.on('select2:select.voucherAdd', function () {
            $('.btn-add-line').focus();
        });
    }
});
</script>
