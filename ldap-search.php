<?php

/**
 * Plugin Name: LDAP Search
 * Description: Basic LDAP Search Plugin
 * Plugin URI: http://dtbaker.net
 * Version: 1.0.1
 * Author: dtbaker
 * Author URI: http://dtbaker.net
 * Text Domain: ldap-search
 */

if(!defined('ABSPATH'))exit;

class DtbakerLDAPSearch {

	private static $instance = null;
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function init() {
		add_action( 'admin_init', array( $this, 'settings_init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_css' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_shortcode('ldap_search', array($this,'shortcode_ldap_search'));
	}

	public function admin_menu(){
		add_options_page(
			'LDAP Search',
			'LDAP Search',
			'manage_options',
			'ldap-search-plugin',
			array( $this, 'menu_settings_callback' )
		);

	}

	public function shortcode_ldap_search($args = array()){
		$template_file = locate_template('ldap-search.php');
		ob_start();
		if($template_file && is_readable($template_file)){
			include $template_file;
		}else{
			include plugin_dir_path( __FILE__ ) . 'search-output.php';
		}
		return ob_get_clean();
	}

	public function menu_settings_callback(){
		?>
		<div class="wrap">
			<div id="poststuff">
				<div id="post-body">
					<div id="post-body-content">
						<form method="post" action="options.php">
							<?php
							settings_fields( 'ldap_search_settings' );
							do_settings_sections( 'ldap_search_settings' );
							submit_button();
							?>

						</form>
					</div> <!-- end post-body-content -->
				</div> <!-- end post-body -->
			</div> <!-- end poststuff -->
		</div>
		<?php
	}

	public function settings_init() {
		
		$search_settings_page =  'ldap_search_settings';
		$search_settings_id = 'ldap_search_settings';
		add_settings_section(
			$search_settings_id,
			'LDAP Search Settings',
			array( $this, 'settings_section_callback' ),
			$search_settings_page
		);

		$key = 'hostname';
		add_settings_field(
			'ldap_search_'.$key,
			'LDAP Hostname',
			function() use ($key){
				$setting = esc_attr( get_option( 'ldap_search_'.$key ) );
				?> <input type="text" name="ldap_search_<?php echo $key;?>" placeholder="e.g. localhost" value="<?php echo $setting;?>"><?php
			},
			$search_settings_page,
			$search_settings_id
		);
		register_setting( $search_settings_page, 'ldap_search_'.$key );

		$key = 'tree';
		add_settings_field(
			'ldap_search_'.$key,
			'LDAP Tree',
			function() use ($key){
				$setting = esc_attr( get_option( 'ldap_search_'.$key ) );
				?> <input type="text" name="ldap_search_<?php echo $key;?>" placeholder="e.g. OU=SBSUsers,OU=Users,OU=MyBusiness,DC=myDomain,DC=local" value="<?php echo $setting;?>"><?php
			},
			$search_settings_page,
			$search_settings_id
		);
		register_setting( $search_settings_page, 'ldap_search_'.$key );

		$key = 'username';
		add_settings_field(
			'ldap_search_'.$key,
			'LDAP Username',
			function() use ($key){
				$setting = esc_attr( get_option( 'ldap_search_'.$key ) );
				?> <input type="text" name="ldap_search_<?php echo $key;?>" placeholder="e.g. admin" value="<?php echo $setting;?>"><?php
			},
			$search_settings_page,
			$search_settings_id
		);
		register_setting( $search_settings_page, 'ldap_search_'.$key );


		$key = 'password';
		add_settings_field(
			'ldap_search_'.$key,
			'LDAP Password',
			function() use ($key){
				$setting = esc_attr( get_option( 'ldap_search_'.$key ) );
				?> <input type="password" name="ldap_search_<?php echo $key;?>" placeholder="" value="<?php echo $setting;?>"><?php
			},
			$search_settings_page,
			$search_settings_id
		);
		register_setting( $search_settings_page, 'ldap_search_'.$key );

	}

	public function settings_section_callback(){
		echo '<p>Please set the LDAP Search settings below:</p>';
	}

	public function frontend_css() {
		wp_register_style( 'ldap_search_frontend', plugins_url( 'css/ldap-frontend.css', __FILE__ ) , false, '1.0.1' );
		wp_enqueue_style( 'ldap_search_frontend' );
	}


}

DtbakerLDAPSearch::get_instance()->init();
