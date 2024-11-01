(function ($) {
    $(document).ready(function () {
        $(document).on('click', '#udimi-optin-connect-button', function (e) {
            jQuery(e.target).addClass('m-loading');
            jQuery.post(config.saveUrl, {
                action: 'connect',
                key: jQuery('#client_key').val()
            }, function(response) {
                jQuery(e.target).removeClass('m-loading');
                jQuery('.wrap-message-notice').hide()
                if (!response.success) {
                    jQuery('#ajax-message-error p').html(response.data.error)
                    jQuery('#ajax-message-error').show()
                } else {
                    jQuery('#ajax-message-success p').html('API key successfully saved!')
                    jQuery('#ajax-message-success').show()
                    jQuery('#form-table-connect').hide()
                    jQuery('#form-table-disconnect').show()

                    if (!response?.data?.allow_optin_tracking) {
                        jQuery('#form-table-not-allow').show()
                    } else {
                        jQuery('#form-table-connected').show()
                    }
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
                jQuery('#form-table-connected').hide()
                jQuery('#form-table-disconnect').hide()
                jQuery('#form-table-not-allow').hide()
                jQuery('#client_key').val('')
            });
        });
    });
})(jQuery);
