<?php

/**
 * Plugin:   realtimeCountdown
 * @author:  HPdesigner (hpdesigner[at]web[dot]de)
 * @version: v1.1.2013-10-17
 * @license: GPL
 * @see:     Delight yourself in the LORD and he will give you the desires of your heart.
 *           - The Bible
 *
 * Plugin created by DEVMOUNT
 * www.devmount.de
 *
**/

if(!defined('IS_CMS')) die();

class realtimeCountdown extends Plugin {

	public $admin_lang;
	private $cms_lang;

	function getContent($value) {

		global $CMS_CONF;

		$this->cms_lang = new Language(PLUGIN_DIR_REL.'realtimeCountdown/sprachen/cms_language_'.$CMS_CONF->get('cmslanguage').'.txt');
		
		// initialize return content
		$content = '';
		
		// get params
		$values = explode('|', $value);
		$date = trim($values[0]); 		// date to count down
		$wrap = trim($values[1]);		// text to put before and after countdown while counting
		$aftercount = $values[2]; 		// text to display after countdown
		
		// get date elements
		$dateelements = explode(' ', $date);
		$year = $dateelements[0];
		$month = $dateelements[1];
		$day = $dateelements[2];
		$hour = $dateelements[3];
		$minute = $dateelements[4];
		$second = $dateelements[5];
		
		// get wrap text
		$wrap = explode('---', $wrap);
		$beforecountdown = $wrap[0];
		$aftercountdown = $wrap[1];
		
		// get language labels
		$language_labels = array(
			$this->cms_lang->getLanguageValue('label_year'),
			$this->cms_lang->getLanguageValue('label_years'),
			$this->cms_lang->getLanguageValue('label_month'),
			$this->cms_lang->getLanguageValue('label_months'),
			$this->cms_lang->getLanguageValue('label_day'),
			$this->cms_lang->getLanguageValue('label_days'),
			$this->cms_lang->getLanguageValue('label_hour'),
			$this->cms_lang->getLanguageValue('label_hours'),
			$this->cms_lang->getLanguageValue('label_minute'),
			$this->cms_lang->getLanguageValue('label_minutes'),
			$this->cms_lang->getLanguageValue('label_second'),
			$this->cms_lang->getLanguageValue('label_seconds')
		);
		$label_and = $this->cms_lang->getLanguageValue('label_and');
		
		// get conf
		$conf = array(
			'hide_year' 	=> ($this->settings->get('hide_year') == 'true') ? 'true' : 'false',
			'hide_month' 	=> ($this->settings->get('hide_month') == 'true') ? 'true' : 'false',
			'hide_day' 		=> ($this->settings->get('hide_day') == 'true') ? 'true' : 'false',
			'hide_hour' 	=> ($this->settings->get('hide_hour') == 'true') ? 'true' : 'false',
			'hide_minute' 	=> ($this->settings->get('hide_minute') == 'true') ? 'true' : 'false',
			'hide_second' 	=> ($this->settings->get('hide_second') == 'true') ? 'true' : 'false'
		);

		// javascript for realtime countdown
		$content .= '<script language="JavaScript" src="'.URL_BASE.PLUGIN_DIR_NAME.'/realtimeCountdown/countdown.js"></script>
					<script language="JavaScript">
						window.onload = function() {
							initLanguage("'.implode(' ',$language_labels).' '.$label_and.'");
							initCountdown(
								' . $year . ',
								' . $month . ',
								' . $day . ',
								' . $hour . ',
								' . $minute . ',
								' . $second . ',
								"' . $aftercount . '",
								"' . $beforecountdown . '",
								"' . $aftercountdown . '",
								' . $conf['hide_year'] . ',
								' . $conf['hide_month'] . ',
								' . $conf['hide_day'] . ',
								' . $conf['hide_hour'] . ',
								' . $conf['hide_minute'] . ',
								' . $conf['hide_second'] . '
							);
						}</script>';
		// html for container
		$content .= '<div class="realtimeCountdown"><span id="showcountdown"></span></div>';
		
		// return countdown
		return $content;

	} // function getContent
	
	
	function getConfig() {
		
		$config = array();

		// hide year
		$config['hide_year']  = array(
			'type' => 'checkbox',
			'description' => $this->admin_lang->getLanguageValue('config_hide_year')
		);
		// hide month
		$config['hide_month']  = array(
			'type' => 'checkbox',
			'description' => $this->admin_lang->getLanguageValue('config_hide_month')
		);
		// hide day
		$config['hide_day']  = array(
			'type' => 'checkbox',
			'description' => $this->admin_lang->getLanguageValue('config_hide_day')
		);
		// hide hour
		$config['hide_hour']  = array(
			'type' => 'checkbox',
			'description' => $this->admin_lang->getLanguageValue('config_hide_hour')
		);
		// hide minute
		$config['hide_minute']  = array(
			'type' => 'checkbox',
			'description' => $this->admin_lang->getLanguageValue('config_hide_minute')
		);
		// hide second
		$config['hide_second']  = array(
			'type' => 'checkbox',
			'description' => $this->admin_lang->getLanguageValue('config_hide_second')
		);

		return $config;

	} // function getConfig    
	
	
	function getInfo() {
		global $ADMIN_CONF;

		$this->admin_lang = new Language(PLUGIN_DIR_REL.'realtimeCountdown/sprachen/admin_language_'.$ADMIN_CONF->get('language').'.txt');
		
		$info = array(
			// Plugin-Name + Version
			'<b>realtimeCountdown</b> v1.1.2013-10-17',
			// moziloCMS-Version
			'2.0',
			// Kurzbeschreibung nur <span> und <br /> sind erlaubt
			$this->admin_lang->getLanguageValue('description'), 
			// Name des Autors
			'HPdesigner',
			// Download-URL
			'http://www.devmount.de/Develop/Mozilo%20Plugins/realtimeCountdown.html',
			// Platzhalter für die Selectbox in der Editieransicht 
			// - ist das Array leer, erscheint das Plugin nicht in der Selectbox
			array(
				'{realtimeCountdown|2012 1 0 0 0 0|wrap --- wrap|after}' => $this->admin_lang->getLanguageValue('placeholder'),
			)
		);
		// return plugin information
		return $info;
		
	} // function getInfo

} // class DEMOPLUGIN

?>