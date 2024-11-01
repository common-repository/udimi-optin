<?php

class UdimiOptin
{
    const IS_LOCAL = false;
    const API_HOST_PROD = 'https://api.udimi.com';
    const API_HOST_LOCAL = 'https://api.udimi.me';
    const HOST_PROD = 'https://udimi.com';
    const HOST_LOCAL = 'https://udimi.me';
    const PLUGIN_NAME = 'udimioptin';
    const PLUGIN_FOLDER = 'udimi-optin';
    const OPTIN_CODE_TTL_HOURS = 1;
    const UDIMI_LOGO_BASE64 = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgMzAgMTkiPg0KICAgIDxwYXRoIGZpbGw9ImN1cnJlbnRDb2xvciIgZD0iTTIwLjUyNjkgMTguNDYxNUwyOC40MDE5IDEwLjU4NjVWMTguNDYxNUgyMC41MjY5Wk0wLjI3NjkxNyAxOC40NjE1TDE4LjI3NjkgMC40NjE1NDhWNy4yMTE1NUw3LjAyNjkyIDE4LjQ2MTVIMC4yNzY5MTdaTTEwLjQwMTkgMTguNDYxNUwyOC40MDE5IDAuNDYxNTQ4VjcuMjExNTVMMTcuMTUxOSAxOC40NjE1SDEwLjQwMTlaIj48L3BhdGg+DQo8L3N2Zz4=';

    private $apiError = '';

    /**
     * Вызывается при каждом F5. Обновить сохраненный в плагине трекинг код с удалённого API
     * @return void
     */
    public function updateScript()
    {
        if ($key = get_option('udimi_optin_key')) {
            if (is_admin()) {
                $this->updateLoaderCodeFromServer($key);
            } else {
                $is_last_success = get_option('udimi_is_last_success');
                $date = get_option('udimi_optin_date');
                $ttlSeconds = $is_last_success ? self::OPTIN_CODE_TTL_HOURS * 3600 : 60;
                if (!$date || !strtotime($date) || time() - strtotime($date) > $ttlSeconds) {
                    $this->updateLoaderCodeFromServer($key);
                }
            }
        }
    }

    public function updateLoaderCodeFromServer($key)
    {
         if ($initData = $this->init($key)) {
            update_option('udimi_optin_script', $initData->loader);
            update_option('udimi_prime_features', $initData->prime_features);
            update_option('udimi_user_email', $initData->email);
        }
        update_option('udimi_optin_date', date('Y-m-d H:i:s'));
    }

    public function ajax_connect()
    {
        $key = isset($_POST['key']) && !is_array($_POST['key']) ? trim($_POST['key']) : '';

        $error = '';
        $initData = [];
        if (empty($key)) {
            $error = '"API key" is empty';
        } else {
            $initData = $this->init($key);
            if (!$initData) {
                $error = $this->getApiError();
            }
        }

        if ($error) {
            update_option('udimi_is_last_success', 0);
            wp_send_json_error([
                'error' => $error,
            ]);
        } else {
            if ($initData->loader) {
                update_option('udimi_optin_script', $initData->loader);
                update_option('udimi_prime_features', $initData->prime_features);
                update_option('udimi_user_email', $initData->email);
            }

            update_option('udimi_is_last_success', 1);
            update_option('udimi_optin_key', $key);
            update_option('udimi_optin_date', date('Y-m-d H:i:s'));

            wp_send_json_success($initData);
        }
    }

    public function ajax_disconnect()
    {
        delete_option('udimi_optin_key');
        delete_option('udimi_optin_date');
        delete_option('udimi_optin_script');
        delete_option('udimi_prime_features');
        delete_option('udimi_user_email');
        delete_option('udimi_is_last_success');

        wp_send_json_success();
    }

    /**
     * @return string
     */
    public function getApiError()
    {
        return $this->apiError;
    }

    public function addAdminScript()
    {
        $date = get_option('udimi_optin_date');
        wp_enqueue_script('jquery');

        // dashboard
        wp_register_script('udimi_dashboard_admin_js', plugins_url(self::PLUGIN_FOLDER . '/js/adminpanel-dashboard.js'), ['jquery'], $date);
        wp_localize_script(
            'udimi_dashboard_admin_js',
            'config',
            [
                'saveUrl' => admin_url('admin-ajax.php'),
            ]
        );
        wp_enqueue_script('udimi_dashboard_admin_js', false, ['jquery'], $date);

        // styles
        wp_enqueue_style('style', plugins_url(self::PLUGIN_FOLDER . '/css/style.css'), [], $date);
    }


	/**
	 * Получение loaded-кода с удаленного апи
	 * @param $key
	 *
	 * @return false|mixed
	 */
	private function init($key)
	{
		$res = wp_remote_get((self::IS_LOCAL ? self::API_HOST_LOCAL : self::API_HOST_PROD) . "/v1/clients/core/loader", array(
            'sslverify' => !self::IS_LOCAL,
		    'headers' => array(
		        'User-Hash' => $key
		    )
		));

		if (!is_array($res)) {
			$this->apiError = 'Wordpress error. Unable to execute init API request.';
			return false;
		} else {
			if ($res['response']['code'] != 200) {
				if (!$errorResponse = json_decode($res['body'])) {
					$errorMessage = 'Unknown error';
				} else {
					$errorMessage = $errorResponse->message;
				}

                $this->apiError = $res['response']['code'] === 401 ?
                    'Client not found. Make sure the "API key" is correct.' :
                    $errorMessage;

                return false;
			} else {
			    $successResponse = json_decode($res['body']);

				return $successResponse->data;
			}
		}
	}

    /**
     * Метод WP. Вставить скрипты в исходный код блога
     * @return void
     */
    public function addHeadScripts()
    {
        if ($trackingCode = get_option('udimi_optin_script', '')) {
            echo $trackingCode;
        }
    }

    /**
     * Метод WP. Вставить пункт в админскую панель
     * @return void
     */
    public function addAdminMenu()
    {
        $key = get_option('udimi_optin_key');
        add_menu_page('Udimi tools', $key ? 'Udimi tools' : 'Udimi tools <span id="udimi-menu-badge" class="awaiting-mod">1</span>', 'manage_options', 'udimi-dashboard', [
            $this,
            'renderDashboard'
        ], self::UDIMI_LOGO_BASE64);

        add_submenu_page('udimi-dashboard', 'Dashboard', 'Dashboard', 'manage_options', 'udimi-dashboard', [
            $this,
            'renderDashboard'
        ]);

        add_submenu_page('udimi-dashboard', 'Funnels', 'Funnels', 'manage_options', 'udimi-optin-settings', [
            $this,
            'renderOptin'
        ]);

        add_submenu_page('udimi-dashboard', 'Greyboxes', 'Greyboxes', 'manage_options', 'udimi-greyboxes-settings', [
            $this,
            'renderGreyboxes'
        ]);

        add_submenu_page('udimi-dashboard', 'Solo ad seller', 'Solo ad seller', 'manage_options', 'udimi-solo-ads-settings', [
            $this,
            'renderSoloAds'
        ]);
    }

    public function renderOptin()
    {
        include(dirname(__FILE__) . '/admin/funnels.php');
    }

    public function renderGreyboxes()
    {
        include(dirname(__FILE__) . '/admin/greyboxes.php');
    }

    public function renderSoloAds()
    {
        include(dirname(__FILE__) . '/admin/solo-ads.php');
    }

    public function renderDashboard()
    {
        include(dirname(__FILE__) . '/admin/dashboard.php');
    }

    private function logToFile($message) {
        $upload_dir = wp_upload_dir();
        $log_file = $upload_dir['basedir'] . '/api_log.txt';

        // Откроем файл для записи, если файла нет - он будет создан
        $file = fopen($log_file, 'a');
        if ($file) {
            fwrite($file, $message . "\n");
            fclose($file);
        }
    }
}
