<div class="modal fade" id="emailInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="emailInvoiceModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close js-email-invoice-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="emailInvoiceModalLabel">Email Invoice <span id="emailInvoiceNoLabel"></span></h4>
            </div>
            <div class="modal-body">
                <div id="emailInvoiceAlert" style="display:none;"></div>
                <div class="form-group">
                    <label for="emailInvoiceAddress">Email</label>
                    <input type="email" id="emailInvoiceAddress" class="form-control" placeholder="name@example.com" autocomplete="off">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default js-email-invoice-close">Cancel</button>
                <button type="button" class="btn btn-primary" id="emailInvoiceSend">
                    <span class="email-send-text">Send</span>
                    <span class="email-send-loading" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Sending...</span>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function showEmailInvoiceModal() {
        var $m = $('#emailInvoiceModal');
        if (typeof $m.modal === 'function') {
            $m.modal('show');
            return;
        }
        if (!$('#emailInvoiceBackdrop').length) {
            $('body').append('<div id="emailInvoiceBackdrop" class="modal-backdrop fade in"></div>');
        }
        $m.addClass('in').css({ display: 'block', opacity: 1 });
        $('body').addClass('modal-open');
    }

    function hideEmailInvoiceModal() {
        var $m = $('#emailInvoiceModal');
        if (typeof $m.modal === 'function') {
            $m.modal('hide');
            return;
        }
        $m.removeClass('in').hide();
        $('#emailInvoiceBackdrop').remove();
        $('body').removeClass('modal-open');
    }

    $(document).on('click', '.js-email-invoice', function(e) {
        e.preventDefault();
        var $btn = $(this);
        $('#emailInvoiceModal').data('url', $btn.data('url'));
        $('#emailInvoiceNoLabel').text($btn.data('invoice') ? '#' + $btn.data('invoice') : '');
        $('#emailInvoiceAddress').val('');
        $('#emailInvoiceAlert').hide().removeClass('alert alert-success alert-danger').empty();
        $('.email-send-text').show();
        $('.email-send-loading').hide();
        $('#emailInvoiceSend').prop('disabled', false);
        showEmailInvoiceModal();
        setTimeout(function() { $('#emailInvoiceAddress').focus(); }, 400);
    });

    $(document).on('click', '.js-email-invoice-close, #emailInvoiceBackdrop', function() {
        hideEmailInvoiceModal();
    });

    $('#emailInvoiceAddress').on('keydown', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#emailInvoiceSend').click();
        }
    });

    $('#emailInvoiceSend').on('click', function() {
        var email = $.trim($('#emailInvoiceAddress').val());
        var url = $('#emailInvoiceModal').data('url');
        var $alert = $('#emailInvoiceAlert');
        if (!email) {
            $alert.addClass('alert alert-danger').text('Please enter an email address.').show();
            return;
        }
        $('#emailInvoiceSend').prop('disabled', true);
        $('.email-send-text').hide();
        $('.email-send-loading').show();
        $alert.hide();

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                email: email,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                $alert.removeClass('alert-danger').addClass('alert alert-success')
                    .text((res && res.message) ? res.message : 'Invoice sent successfully.').show();
                setTimeout(function() { hideEmailInvoiceModal(); }, 1200);
            },
            error: function(xhr) {
                var msg = 'Unable to send invoice.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.email) {
                    msg = xhr.responseJSON.errors.email[0];
                }
                $alert.removeClass('alert-success').addClass('alert alert-danger').text(msg).show();
            },
            complete: function() {
                $('#emailInvoiceSend').prop('disabled', false);
                $('.email-send-text').show();
                $('.email-send-loading').hide();
            }
        });
    });
</script>
