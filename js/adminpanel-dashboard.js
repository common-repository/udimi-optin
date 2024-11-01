(function ($) {
    $(document).ready(function () {
        const connect = function () {
            $('#client_key').attr("disabled", "disabled")
            $('#udimi-connect-button').addClass('m-loading');

            jQuery.post(config.saveUrl, {
                action: 'connect',
                key: jQuery('#client_key').val()
            }, function(response) {
                $('#client_key').removeAttr("disabled");
                $('#udimi-connect-button').removeClass('m-loading');

                jQuery('.wrap-message-notice').hide()
                if (!response.success) {
                    jQuery('#ajax-message-error p').html(response.data.error)
                    jQuery('#ajax-message-error').show()
                } else {
                    jQuery('#ajax-message-success p').html('API key successfully saved.')
                    jQuery('#ajax-message-success').show()
                    jQuery('#form-table-connect').hide()
                    jQuery('#form-table-disconnect').show()
                    jQuery('#udimi-menu-badge').hide()

                    if (!response?.data?.prime_features) {
                        jQuery('#form-table-not-allow').show()
                    } else {
                        jQuery('#form-table-connected').show()
                        jQuery('#form-table-links').show()
                    }

                    if (response?.data?.email) {
                        jQuery('#udimi-user-email').text(response?.data?.email)
                    }
                }
            });
        }

        $(document).on('click', '#udimi-connect-button', connect);
        $('#client_key').on('keypress', function (e) {
            if (e.which === 13) {
                connect()
            }
        });

        $(document).on('click', '#udimi-disconnect-button', function () {
            jQuery.post(config.saveUrl, {
                action: 'disconnect',
            }, function(response) {
                jQuery('.wrap-message-notice').hide()
                jQuery('#ajax-message-success p').html('Integration successfully disconnected.')
                jQuery('#ajax-message-success').show()
                jQuery('#form-table-connect').show()
                jQuery('#form-table-disconnect').hide()
                jQuery('#form-table-links').hide()
                jQuery('#form-table-connected').hide()
                jQuery('#form-table-not-allow').hide()
                jQuery('#client_key').val('')
                jQuery('#udimi-menu-badge').show()
            });
        });
    });
})(jQuery);
