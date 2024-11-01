(function ($) {
    $(document).ready(function () {
        $(document).on('click', '#udimi-greyboxes-connect-button', function (e) {
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
                    jQuery('#ajax-message-success p').html('API key successfully saved.')
                    jQuery('#ajax-message-success').show()
                    jQuery('#form-table-connect').hide()
                    jQuery('#form-table-disconnect').show()

                    if (!response?.data?.allow_greyboxes) {
                        jQuery('#form-table-not-allow').show()
                    } else {
                        jQuery('#form-table-connected').show()
                    }

                    var $select = $("#greyboxes-select")
                    if ($select) {
                        $select.empty()
                        $select.append($("<option></option>").attr("value", "").text('None selected'))
                        if (response?.data?.greyboxes_options?.length) {
                            response.data.greyboxes_options?.forEach((option) => {
                                $select.append($("<option></option>").attr("value", option.uid).text(option.name))
                            })
                        }
                    }
                }
            });
        });

        $(document).on('click', '#udimi-load_script-button', function (e) {
            jQuery(e.target).addClass('m-loading');
            jQuery.post(config.saveUrl, {
                action: 'load_greybox_script',
                uid: jQuery('#greyboxes-select').val()
            }, function(response) {
                jQuery(e.target).removeClass('m-loading');
                jQuery('.wrap-message-notice').hide()
                if (!response.success) {
                    jQuery('#ajax-message-error p').html(response.data.error)
                    jQuery('#ajax-message-error').show()
                } else {
                    jQuery('#ajax-message-success p').html(response?.data?.uid ? 'Greybox successfully installed.' : 'Greybox successfully removed.')
                    jQuery('#ajax-message-success').show()
                }
            });
        });

        $(document).on('click', '#udimi-greyboxes-disconnect-button', function () {
            jQuery.post(config.saveUrl, {
                action: 'disconnect',
            }, function(response) {
                jQuery('.wrap-message-notice').hide()
                jQuery('#ajax-message-success p').html('Integration successfully disconnected.')
                jQuery('#ajax-message-success').show()
                jQuery('#form-table-connect').show()
                jQuery('#form-table-disconnect').hide()
                jQuery('#form-table-connected').hide()
                jQuery('#form-table-not-allow').hide()
                jQuery('#client_key').val('')
            });
        });
    });
})(jQuery);
