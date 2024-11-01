<?php
$domain = UdimiOptin::IS_LOCAL ? UdimiOptin::HOST_LOCAL : UdimiOptin::HOST_PROD;
$key = get_option('udimi_optin_key');
$udimi_prime_features = get_option('udimi_prime_features');
$udimi_user_email = get_option('udimi_user_email');
?>
<div class="wrap">
    <h2>Udimi tools</h2>

    <div id="ajax-message-success" class="updated wrap-message-notice" style="display: none">
        <p></p>
    </div>

    <div id="ajax-message-error" class="updated error wrap-message-notice" style="display: none">
        <p></p>
    </div>

    <table id="form-table-not-allow" class="form-table" style="display: <?= $key && !$udimi_prime_features ? '' : 'none' ?>">
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
    <hr style="display: <?= $key && !$udimi_prime_features ? '' : 'none' ?>">

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
                <button type="button" class="button button-primary" id="udimi-connect-button">Save and connect</button>
            </td>
        </tr>
    </table>

    <table id="form-table-disconnect" class="form-table" style="display: <?= $key ? '' : 'none' ?>">
        <tr>
            <td>
                Your WordPress blog was linked to your Udimi account <span id="udimi-user-email">(<?= $udimi_user_email ?>)</span> successfully.
                <a href="javascript:void(0)" role="button" id="udimi-disconnect-button">Disconnect</a>
            </td>
        </tr>
    </table>

    <table id="form-table-links" class="form-table" style="display: <?= $key && $udimi_prime_features ? '' : 'none' ?>">
        <tr>
            <td>
                Now you can <a href="<?= $domain ?>/funnels/create-funnel?si=1" target="_blank">Create funnels</a> or <a href="<?= $domain ?>/greyboxes/create-greybox?si=1" target="_blank">Create greyboxes</a>
            </td>
        </tr>
    </table>
</div>
