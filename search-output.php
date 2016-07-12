<?php

if(!defined('ABSPATH'))exit;

if(!isset($_POST['ldap_search'])){
  ?>
<div class="ldap_search_wrap">
			<form action="" method="post" class="ldap_search_form">
				<input type="text" name="ldap_search" value=""> <input type="submit" name="submit" value="Search">
			</form>
		</div>
	<?php
}else{

$search_string = isset($_POST['ldap_search']) ? '(cn=*'.(preg_replace('#[^a-zA-Z0-9 ]#','',$_POST['ldap_search'])).'*)' : '(cn=*)';

// connect
$ldapconn = ldap_connect(get_option('ldap_search_hostname')) or die("Could not connect to LDAP server.");

if($ldapconn) {
	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
	// binding to ldap server
	$ldapbind = ldap_bind($ldapconn, get_option('ldap_search_username'), get_option('ldap_search_password')) or die ("Error trying to bind: ".ldap_error($ldapconn));
	// verify binding
	if ($ldapbind) {

		$result = ldap_search($ldapconn, get_option('ldap_search_tree'), $search_string) or die ("Error in search query: ".ldap_error($ldapconn));
		$data = ldap_get_entries($ldapconn, $result);

		$template_file = locate_template('ldap-search-item.php');
		if($template_file && is_readable($template_file)){
			//
		}else{
			$template_file = plugin_dir_path( __FILE__ ) . 'search-output-item.php';
		}
		?>
		<div class="ldap_search_wrap">
			<h2><?php echo ldap_count_entries($ldapconn, $result);?> results: </h2>
			<form action="" method="post" class="ldap_search_form">
				<input type="text" name="ldap_search" value="<?php echo esc_attr(isset($_POST['ldap_search']) ? $_POST['ldap_search'] : '');?>"> <input type="submit" name="submit" value="Search">
			</form>
			<ul class="ldap_search_results">
				<?php for ($i=0; $i<$data["count"]; $i++) {
					$result = $data[$i];
					?>
					<li>
						<?php include($template_file); ?>
					</li>
				<?php } ?>
			</ul>
		</div>
		<?php

		// print number of entries found
	} else {
		echo "LDAP bind failed...";
	}

}

// all done? clean up
ldap_close($ldapconn);
}
