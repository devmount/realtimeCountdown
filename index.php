<?php

/**
 * moziloCMS Plugin: realtimeCountdown
 *
 * Generates a Countdown that counts in realtime.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  PHP_MoziloPlugins
 * @author   HPdesigner <mail@devmount.de>
 * @license  GPL v3
 * @version  GIT: v1.1.2013-10-17
 * @link     https://github.com/devmount/realtimeCountdown
 * @link     http://devmount.de/Develop/Mozilo%20Plugins/realtimeCountdown.html
 * @see      Delight yourself in the LORD
 *           and he will give you the desires of your heart.
 *            - The Bible
 *
 * Plugin created by DEVMOUNT
 * www.devmount.de
 *
 */

// only allow moziloCMS environment
if (!defined('IS_CMS')) {
    die();
}

/**
 * realtimeCountdown Class
 *
 * @category PHP
 * @package  PHP_MoziloPlugins
 * @author   HPdesigner <mail@devmount.de>
 * @license  GPL v3
 * @link     https://github.com/devmount/realtimeCountdown
 */
class realtimeCountdown extends Plugin
{
    // language
    private $_admin_lang;
    private $_cms_lang;

    // plugin information
    const PLUGIN_AUTHOR  = 'HPdesigner';
    const PLUGIN_DOCU
        = 'http://devmount.de/Develop/Mozilo%20Plugins/realtimeCountdown.html';
    const PLUGIN_TITLE   = 'realtimeCountdown';
    const PLUGIN_VERSION = 'v1.1.2013-10-17';
    const MOZILO_VERSION = '2.0';
    private $_plugin_tags = array(
        'tag1' => '{realtimeCountdown|<date>|<wrap>|<after>}',
    );

    const LOGO_URL = 'http://media.devmount.de/logo_pluginconf.png';

    /**
     * set configuration elements, their default values and their configuration
     * parameters
     *
     * @var array $_confdefault
     *      text     => default, type, maxlength, size, regex
     *      textarea => default, type, cols, rows, regex
     *      password => default, type, maxlength, size, regex, saveasmd5
     *      check    => default, type
     *      radio    => default, type, descriptions
     *      select   => default, type, descriptions, multiselect
     */
    private $_confdefault = array(
        'hide_year' => array(
            'false',
            'check',
        ),
        'hide_month' => array(
            'false',
            'check',
        ),
        'hide_day' => array(
            'false',
            'check',
        ),
        'hide_hour' => array(
            'false',
            'check',
        ),
        'hide_minute' => array(
            'false',
            'check',
        ),
        'hide_second' => array(
            'false',
            'check',
        ),
        'hide_leading_zero' => array(
            'true',
            'check',
        ),
    );

    /**
     * creates plugin content
     *
     * @param string $value Parameter divided by '|'
     *
     * @return string HTML output
     */
    function getContent($value)
    {
        global $CMS_CONF;
        global $syntax;

        $this->_cms_lang = new Language(
            $this->PLUGIN_SELF_DIR
            . 'lang/cms_language_'
            . $CMS_CONF->get('cmslanguage')
            . '.txt'
        );

        // get params
        list($date, $wrap, $aftercount)
            = $this->makeUserParaArray($value, false, '|');
        $date = trim($date);
        $wrap = trim($wrap);

        // get date elements
        $parameter = explode(' ', $date);
        // build id from date
        $id = implode('', $parameter);


        // add text for ended countdown
        $parameter[] = '"' . $aftercount . '"';

        // add wrap text
        $wrap = explode('---', $wrap);
        $parameter[] = '"' . $wrap[0] . '"';
        $parameter[] = '"' . $wrap[1] . '"';

        // get language labels
        $language_labels = array(
            $this->_cms_lang->getLanguageValue('label_year'),
            $this->_cms_lang->getLanguageValue('label_years'),
            $this->_cms_lang->getLanguageValue('label_month'),
            $this->_cms_lang->getLanguageValue('label_months'),
            $this->_cms_lang->getLanguageValue('label_day'),
            $this->_cms_lang->getLanguageValue('label_days'),
            $this->_cms_lang->getLanguageValue('label_hour'),
            $this->_cms_lang->getLanguageValue('label_hours'),
            $this->_cms_lang->getLanguageValue('label_minute'),
            $this->_cms_lang->getLanguageValue('label_minutes'),
            $this->_cms_lang->getLanguageValue('label_second'),
            $this->_cms_lang->getLanguageValue('label_seconds'),
            $this->_cms_lang->getLanguageValue('label_and'),
        );

        // get conf and set default
        $conf = array();
        foreach ($this->_confdefault as $elem => $default) {
            $conf[$elem] = ($this->settings->get($elem) == '')
                ? $default[0]
                : $this->settings->get($elem);
        }

        // add conf for hiding elements
        $parameter[] = $conf['hide_year'];
        $parameter[] = $conf['hide_month'];
        $parameter[] = $conf['hide_day'];
        $parameter[] = $conf['hide_hour'];
        $parameter[] = $conf['hide_minute'];
        $parameter[] = $conf['hide_second'];
        $parameter[] = $conf['hide_leading_zero'];

        // add id
        $parameter[] = '"' . $id . '"';

        // javascript for realtime countdown
        $syntax->insert_in_head(
            '<script language="JavaScript"
                src="' . $this->PLUGIN_SELF_URL . 'countdown.js"
            ></script>'
        );
        $syntax->insert_in_head(
            '<script language="JavaScript">
                window.onload = function() {
                    initCountdown("'
                        . implode(' ', $language_labels) . '", '
                        . implode(', ', $parameter)
                    . ');
                }
            </script>'
        );

        // build for container
        $content = '
            <div class="realtimeCountdown">
                <span id="' . $id . '"></span>
            </div>
        ';

        // return countdown
        return $content;
    }

    /**
     * sets backend configuration elements and template
     *
     * @return Array configuration
     */
    function getConfig()
    {
        $config = array();

        // read configuration values
        foreach ($this->_confdefault as $key => $value) {
            // handle each form type
            switch ($value[1]) {
            case 'text':
                $config[$key] = $this->confText(
                    $this->_admin_lang->getLanguageValue('config_' . $key),
                    $value[2],
                    $value[3],
                    $value[4],
                    $this->_admin_lang->getLanguageValue(
                        'config_' . $key . '_error'
                    )
                );
                break;

            case 'textarea':
                $config[$key] = $this->confTextarea(
                    $this->_admin_lang->getLanguageValue('config_' . $key),
                    $value[2],
                    $value[3],
                    $value[4],
                    $this->_admin_lang->getLanguageValue(
                        'config_' . $key . '_error'
                    )
                );
                break;

            case 'password':
                $config[$key] = $this->confPassword(
                    $this->_admin_lang->getLanguageValue('config_' . $key),
                    $value[2],
                    $value[3],
                    $value[4],
                    $this->_admin_lang->getLanguageValue(
                        'config_' . $key . '_error'
                    ),
                    $value[5]
                );
                break;

            case 'check':
                $config[$key] = $this->confCheck(
                    $this->_admin_lang->getLanguageValue('config_' . $key)
                );
                break;

            case 'radio':
                $descriptions = array();
                foreach ($value[2] as $label) {
                    $descriptions[$label] = $this->_admin_lang->getLanguageValue(
                        'config_' . $key . '_' . $label
                    );
                }
                $config[$key] = $this->confRadio(
                    $this->_admin_lang->getLanguageValue('config_' . $key),
                    $descriptions
                );
                break;

            case 'select':
                $descriptions = array();
                foreach ($value[2] as $label) {
                    $descriptions[$label] = $this->_admin_lang->getLanguageValue(
                        'config_' . $key . '_' . $label
                    );
                }
                $config[$key] = $this->confSelect(
                    $this->_admin_lang->getLanguageValue('config_' . $key),
                    $descriptions,
                    $value[3]
                );
                break;

            default:
                break;
            }
        }

        // read admin.css
        $admin_css = '';
        $lines = file('../plugins/' . self::PLUGIN_TITLE. '/admin.css');
        foreach ($lines as $line_num => $line) {
            $admin_css .= trim($line);
        }

        // add template CSS
        $template = '<style>' . $admin_css . '</style>';

        // build Template
        $template .= '
            <div class="realtimecountdown-admin-header">
            <span>'
                . $this->_admin_lang->getLanguageValue(
                    'admin_header',
                    self::PLUGIN_TITLE
                )
            . '</span>
            <a href="' . self::PLUGIN_DOCU . '" target="_blank">
            <img style="float:right;" src="' . self::LOGO_URL . '" />
            </a>
            </div>
        </li>
        <li class="mo-in-ul-li ui-widget-content realtimecountdown-admin-li">
            <div class="realtimecountdown-admin-subheader">'
            . $this->_admin_lang->getLanguageValue('admin_hide')
            . '</div>
            <div style="margin-bottom:5px;">
                {hide_year_checkbox}
                {hide_year_description}
                <span class="realtimecountdown-admin-default">
                    [' . $this->_confdefault['hide_year'][0] . ']
                </span>
            </div>
            <div style="margin-bottom:5px;">
                {hide_month_checkbox}
                {hide_month_description}
                <span class="realtimecountdown-admin-default">
                    [' . $this->_confdefault['hide_month'][0] . ']
                </span>
            </div>
            <div style="margin-bottom:5px;">
                {hide_day_checkbox}
                {hide_day_description}
                <span class="realtimecountdown-admin-default">
                    [' . $this->_confdefault['hide_day'][0] . ']
                </span>
            </div>
            <div style="margin-bottom:5px;">
                {hide_hour_checkbox}
                {hide_hour_description}
                <span class="realtimecountdown-admin-default">
                    [' . $this->_confdefault['hide_hour'][0] . ']
                </span>
            </div>
            <div style="margin-bottom:5px;">
                {hide_minute_checkbox}
                {hide_minute_description}
                <span class="realtimecountdown-admin-default">
                    [' . $this->_confdefault['hide_minute'][0] . ']
                </span>
            </div>
            <div style="margin-bottom:5px;">
                {hide_second_checkbox}
                {hide_second_description}
                <span class="realtimecountdown-admin-default">
                    [' . $this->_confdefault['hide_second'][0] . ']
                </span>
            </div>
            <div style="margin-bottom:5px;">
                {hide_leading_zero_checkbox}
                {hide_leading_zero_description}
                <span class="realtimecountdown-admin-default">
                    [' . $this->_confdefault['hide_leading_zero'][0] . ']
                </span>
        ';

        $config['--template~~'] = $template;

        return $config;
    }

    /**
     * sets backend plugin information
     *
     * @return Array information
     */
    function getInfo()
    {
        global $ADMIN_CONF;

        $this->_admin_lang = new Language(
            $this->PLUGIN_SELF_DIR
            . 'lang/admin_language_'
            . $ADMIN_CONF->get('language')
            . '.txt'
        );

        // build plugin tags
        $tags = array();
        foreach ($this->_plugin_tags as $key => $tag) {
            $tags[$tag] = $this->_admin_lang->getLanguageValue('tag_' . $key);
        }

        $info = array(
            '<b>' . self::PLUGIN_TITLE . '</b> ' . self::PLUGIN_VERSION,
            self::MOZILO_VERSION,
            $this->_admin_lang->getLanguageValue(
                'description',
                htmlspecialchars($this->_plugin_tags['tag1'])
            ),
            self::PLUGIN_AUTHOR,
            self::PLUGIN_DOCU,
            $tags
        );

        return $info;
    }

    /**
     * creates configuration for checkboxes
     *
     * @param string $description Label
     *
     * @return Array  Configuration
     */
    protected function confCheck($description)
    {
        // required properties
        return array(
            'type' => 'checkbox',
            'description' => $description,
        );
    }

    /**
     * throws styled error message
     *
     * @param string $text Content of error message
     *
     * @return string HTML content
     */
    protected function throwError($text)
    {
        return '<div class="' . self::PLUGIN_TITLE . 'Error">'
            . '<div>' . $this->_cms_lang->getLanguageValue('error') . '</div>'
            . '<span>' . $text. '</span>'
            . '</div>';
    }
}

?>