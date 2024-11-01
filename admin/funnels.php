<?php
$domain = UdimiOptin::IS_LOCAL ? UdimiOptin::HOST_LOCAL : UdimiOptin::HOST_PROD;
$key = get_option( 'udimi_optin_key' );
$udimi_prime_features = get_option('udimi_prime_features');
$dashboard_url = admin_url('admin.php?page=udimi-dashboard')
?>
<div class="wrap">
    <h2>Funnels</h2>

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

    <table id="form-table-connect" class="form-table" style="display: <?= !$key ? '' : 'none' ?>">
        <tr>
            <td>
                Please <a href="<?= $dashboard_url ?>" target="_self">click here</a> to link your Udimi account with this plugin.
            </td>
        </tr>
    </table>

    <table id="form-table-connected" class="form-table" style="display: <?= $key && $udimi_prime_features ? '' : 'none' ?>">
        <tr>
            <td>
                Create funnels to track optins sales and other visitor actions on your site. To create new funnel, open <a href="<?= $domain ?>/funnels" target="_blank">Funnels screen</a> on Udimi
            </td>
        </tr>
    </table>
</div>
