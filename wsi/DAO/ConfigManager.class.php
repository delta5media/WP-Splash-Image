<?php

/**
 * @author Benjamin Barbier
 *
 */
class ConfigManager {
	
	/**
	 * Singleton
	 */
	private static $_instance = null;
	private function __construct() {
	}
	/**
	 * @return ConfigManager instance
	 */
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new ConfigManager();
		} return self::$_instance;
	}
	
	private $configBean;
	
	/**
	 * @return string config table name
	 */
	public static function tableName() {
		global $wpdb;
		return $wpdb->prefix . "wsi_config";
	}
	
	/**
	 * @param ConfigBean $configBean
	 */
	//TODO: delete comment (Test OK)
	public function save(ConfigBean $configBean) {
		global $wpdb;
		
		$success = $wpdb->update(
				$this::tableName(),
				array('value' => (($configBean->isSplash_active())?'1':'0')), // boolean
				array('param' => 'splash_active'),
				$format = null,
				$where_format = null);
		
		$success = $wpdb->update(
				$this::tableName(),
				array('value' => (($configBean->isWsi_first_load_mode_active())?'1':'0')), // boolean
				array('param' => 'wsi_first_load_mode_active'),
				$format = null,
				$where_format = null);
		
		$success = $wpdb->update(
				$this::tableName(),
				array('value' => (($configBean->isSplash_test_active())?'1':'0')), // boolean
				array('param' => 'splash_test_active'),
				$format = null,
				$where_format = null);
		
		// Update class instance
		$this->configBean = $configBean;
		
	}

	/**
	 * @return ConfigBean with "esc_attr" security on each property.
	 */
	//TODO: delete comment (Test OK)
	public function get() {
	
		global $wpdb;
		if (!isset($this->configBean)) {
	
			$configBean = new ConfigBean();

			$splash_active =              $wpdb->get_var("SELECT value FROM ".$this::tableName()." WHERE param = 'splash_active'",0,0);
			$wsi_first_load_mode_active = $wpdb->get_var("SELECT value FROM ".$this::tableName()." WHERE param = 'wsi_first_load_mode_active'",0,0);
			$splash_test_active =         $wpdb->get_var("SELECT value FROM ".$this::tableName()." WHERE param = 'splash_test_active'",0,0);
			
			$configBean->setSplash_active(              ($splash_active=='1'?'true':'false'));
			$configBean->setWsi_first_load_mode_active( ($wsi_first_load_mode_active=='1'?'true':'false'));
			$configBean->setSplash_test_active(         ($splash_test_active=='1'?'true':'false'));
			
			$this->configBean = $configBean;
			
		}
		return $this->configBean;
	}
	
	//TODO: complete...
	
}