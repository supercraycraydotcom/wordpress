<?php
/**
 * Plugin Name: WP CDN Url Replace
 * Plugin URI: https://github.com/kfuchs/wp-cdn-url-replace
 * Description: Easily replace existing urls to point to your CDN using regex. Instead of using the database to store
 * rewrite rules like other plugins it utilizes the $_ENV global to provide the developer control over multiple envs settings.
 * Version: 1.0
 * Author: Kirill Fuchs
 * Author URI: https://github.com/kfuchs
 * License: MIT
 */

/**
 * Class CdnUrlReplace
 */
class CdnUrlReplace
{
    /**
     * @var string
     */
    public $envKey = 'CDN_URL_REPLACE';

    /**
     * @param $content
     * @return mixed
     */
    public function replace($content)
    {
        $search = array_keys($_ENV[$this->envKey]);
        $replace = array_values($_ENV[$this->envKey]);
        return str_replace($search, $replace, $content);
    }
}

/**
 *
 */
function bufferHandler()
{
    $CdnUrlReplace = new CdnUrlReplace();
    ob_start(array(&$CdnUrlReplace, 'replace'));
}

if ($_ENV['CDN_URL_REPLACE']); {
    add_action('template_redirect', 'bufferHandler');
}