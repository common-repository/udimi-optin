<?php
$domain = UdimiOptin::IS_LOCAL ? UdimiOptin::HOST_LOCAL : UdimiOptin::HOST_PROD;
$key = get_option( 'udimi_optin_key' );
$allow_optin_tracking = get_option( 'udimi_allow_optin_tracking' );
?>
<div class="wrap">
    <h2>Optin tracking settings</h2>

    <div id="ajax-message-success" class="updated wrap-message-notice" style="display: none">
        <p></p>
    </div>

    <div id="ajax-message-error" class="updated error wrap-message-notice" style="display: none">
        <p></p>
    </div>

    <table id="form-table-connect" class="form-table" style="display: <?= !$key ? '' : 'none' ?>">
        <tr>
            <td>
                Please open the <a href="<?= $domain ?>/settings/general" target="_blank">Settings &#8594; General</a> on Udimi and copy <b>API key</b> from there. Then put it here and click "Save and connect".
            </td>
        </tr>
        <tr>
            <td>
                <input id="client_key" type="text" maxlength="16" name="client_key" value="<?= $key ?>" placeholder="API key" />
            </td>
        </tr>
        <tr>
            <td>
                <button type="button" class="button button-primary" id="udimi-optin-connect-button">Save and connect</button>
            </td>
        </tr>
    </table>

    <table id="form-table-not-allow" class="form-table" style="display: <?= $key && !$allow_optin_tracking ? '' : 'none' ?>">
        <tr>
            <td>
                It appears that you do not have an active Prime subscription. As a result, this plugin will not function as expected.
                <br>
                To unlock all features and ensure the plugin operates correctly, please purchase a <a href="<?= $domain ?>/prime" target="_blank">Prime membership here</a>.
            </td>
        </tr>
        <tr>
            <td>
                If you have any questions or need further assistance, please <a href="<?= $domain ?>/help" target="_blank">contact our support team</a>.
            </td>
        </tr>
        <tr>
            <td>
                Thank you for your understanding.
            </td>
        </tr>
    </table>

    <table id="form-table-connected" class="form-table" style="display: <?= $key && $allow_optin_tracking ? '' : 'none' ?>">
        <tr>
            <td>
                Now your site will automatically track optins. Go to Udimi and click <a href="<?= $domain ?>/tracking" target="_blank">Optin tracking link</a> on the leftside menu to setup your funnels.
            </td>
        </tr>
    </table>

    <hr>
    <table id="form-table-disconnect" class="form-table" style="display: <?= $key ? '' : 'none' ?>">
        <tr>
            <td>
                Your Udimi account has been successfully linked to the WP plugin. To disconnect, please click the button below.
            </td>
        </tr>
        <tr>
            <td>
                <button type="button" class="button button-primary" id="udimi-optin-disconnect-button">Disconnect</button>
            </td>
        </tr>
    </table>
</div>
