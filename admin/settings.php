<?php
$domain = UdimiOptin::IS_LOCAL ? UdimiOptin::HOST_LOCAL : UdimiOptin::HOST_PROD;
$key = get_option( 'udimi_optin_key' );
?>
<div class="wrap">
    <h2>Udimi tracker Settings</h2>

    <div id="ajax-message-success" class="updated wrap-message-notice" style="display: none">
        <p></p>
    </div>

    <div id="ajax-message-error" class="updated error wrap-message-notice" style="display: none">
        <p></p>
    </div>

    <table id=form-table-connect class="form-table" style="display: <?= $key ? 'none' : '' ?>">
        <tr>
            <td>
                Please open the <a href="<?= $domain ?>/tracking/general/addsite" target="_blank">Optin tracking setup page</a> on Udimi and copy <strong>Client Key</strong> from there. Then put it here and save.
            </td>
        </tr>
        <tr>
            <td>
                <input id="client_key" type="text" maxlength="16" name="client_key" value="<?= $key ?>" placeholder="Client Key" />
            </td>
        </tr>
        <tr>
            <td>
                <button type="button" class="button button-primary" id="udimi-optin-connect-button">Save and connect</button>
            </td>
        </tr>
    </table>

    <table id="form-table-disconnect" class="form-table" style="display: <?= $key ? '' : 'none' ?>">
        <tr>
            <td>You are all set.<br>Now your site will automatically track optins. Go to Udimi and click <a href="<?= $domain ?>/tracking" target="_blank">Optin tracking link</a> on the leftside menu to setup your funnels.
            </td>
        </tr>
        <tr>
            <td>
                <button type="button" class="button button-primary" id="udimi-optin-disconnect-button">Disconnect</button>
            </td>
        </tr>
    </table>
</div>
