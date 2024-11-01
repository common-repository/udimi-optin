(function ($) {
    $(document).ready(function () {
        $(document).on('click', '#udimi-optin-connect-button', function () {
            jQuery.post(config.saveUrl, {
                action: 'connect',
                key: jQuery('#client_key').val()
            }, function(response) {
                jQuery('.wrap-message-notice').hide()
                if (!response.success) {
                    jQuery('#ajax-message-error p').html(response.data.error)
                    jQuery('#ajax-message-error').show()
                } else {
                    jQuery('#ajax-message-success p').html('Client Key successfully saved!')
                    jQuery('#ajax-message-success').show()
                    jQuery('#form-table-connect').hide()
                    jQuery('#form-table-disconnect').show()
                }
            });
        });
        $(document).on('click', '#udimi-optin-disconnect-button', function () {
            jQuery.post(config.saveUrl, {
                action: 'disconnect',
            }, function(response) {
                jQuery('.wrap-message-notice').hide()
                jQuery('#ajax-message-success p').html('Integration successfully disconnected!')
                jQuery('#ajax-message-success').show()
                jQuery('#form-table-connect').show()
                jQuery('#form-table-disconnect').hide()
                jQuery('#client_key').val('')
            });
        });
    });
})(jQuery);
