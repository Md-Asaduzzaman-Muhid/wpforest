<?php
add_action( 'wp_ajax_install_ibtana_addon', 'install_ibtana_addon' );
add_action( 'wp_ajax_activate_license_ibtana_client', 'activate_license_ibtana_client' );
add_action( 'wp_ajax_ive_install_and_activate_plugin', 'ive_install_and_activate_plugin' );

function activate_license_ibtana_client() {
	if (!isset($_POST['key'])) {
		return;
	}
	if (empty($_POST['key'])) {
		return;
	}
	$endpoint = IBTANA_LICENSE_API_ENDPOINT.'activate_license';
	$body = [
		'domain'							=> site_url(),
		'key'									=> $_POST['key']
	];
	$body = wp_json_encode( $body );
	$options = [
		'body'        => $body,
		'headers'     => [
			'Content-Type' => 'application/json',
		]
	];
	$response 		 = wp_remote_post( $endpoint, $options );
	if (is_wp_error( $response )) {
		$response = array('status' => false, 'msg' => 'Something Went Wrong!');
		wp_send_json( $response );
		exit;
	}

	$response_body = wp_remote_retrieve_body( $response );
	$response_body = json_decode($response_body);
	if (!$response_body->status && !$response_body->data) {
		$response = array('status' => false, 'msg' => $response_body->msg);
		wp_send_json( $response );
		exit;
	}

	if ($response_body->status && $response_body->data) {
		$is_ibtana_license_key_saved = false;
		if (!get_option('ibtana_license_key')) {
			$is_ibtana_license_key_saved = add_option('ibtana_license_key', $_POST['key']);
		} else {
			$is_ibtana_license_key_saved = update_option('ibtana_license_key', $_POST['key']);
		}
		if (get_option('ibtana_license_key') == $_POST['key']) {
			$is_ibtana_license_key_saved = true;
		}

		if (!$is_ibtana_license_key_saved) {
			$response = array('status' => false, 'msg' => 'Something Went Wrong While Saving the Key!');
			wp_send_json( $response );
		} else {
			$response = array('status' => true, 'msg' => $response_body->msg);
			wp_send_json( $response );
		}
	}
}

function install_ibtana_addon() {
	$endpoint = IBTANA_LICENSE_API_ENDPOINT.'get_client_fetch_premium_add_on';
	$body = [
		'site_url'						=> site_url(),
		'ibtana_license_key'	=> get_option('ibtana_license_key'),
		'add_on_slug'					=> $_POST['add_on_slug']
	];
	$body = wp_json_encode( $body );
	$options = [
		'body'        => $body,
		'headers'     => [
			'Content-Type' => 'application/json',
		]
	];
	$response 		 = wp_remote_post( $endpoint, $options );

	if (is_wp_error( $response )) {
		$response = array('status' => false, 'msg' => 'Something Went Wrong!');
		wp_send_json( $response );
		exit;
	}

	$response_body = wp_remote_retrieve_body( $response );
	$response_body = json_decode($response_body);
	if (!$response_body->status) {
		$response = array('status' => false, 'msg' => $response_body->msg);
		wp_send_json( $response );
		exit;
	}

	$response_body_data = $response_body->data;

	$plugin = array(
		'text_domain'	=> $response_body_data->domain,
		'path' 				=> $response_body_data->json,
		'install' 		=> $response_body_data->domain.'/'.$response_body_data->php_file
	);
	$is_installed = mm_get_plugins($plugin);
	$msg = '';
	if ($is_installed) {
		$is_installed = true;
		$msg = 'Plugin Installed Successfully!';
	} else {
		$is_installed = false;
		$msg = 'Something Went Wrong!';
	}
	$response = array('status' => $is_installed, 'msg' => $msg);
	wp_send_json( $response );
}

function ive_install_and_activate_plugin() {
	$post_plugin_details = $_POST['plugin_details'];

	$plugin_text_domain = $post_plugin_details['plugin_text_domain'];
	$plugin_main_file		=	$post_plugin_details['plugin_main_file'];
	$plugin_url					=	$post_plugin_details['plugin_url'];

	$plugin = array(
		'text_domain'	=> $plugin_text_domain,
		'path' 				=> $plugin_url,
		'install' 		=> $plugin_text_domain . '/' . $plugin_main_file
	);
	$is_installed = mm_get_plugins( $plugin );
	$msg = '';
	if ( $is_installed ) {
		$is_installed = true;
		$msg = 'Plugin Installed Successfully!';
	} else {
		$is_installed = false;
		$msg = 'Something Went Wrong!';
	}
	$response = array( 'status' => $is_installed, 'msg' => $msg );
	wp_send_json( $response );
	exit;
}

function mm_get_plugins( $plugin ) {
	$args = array(
		'path' => ABSPATH.'wp-content/plugins/',
		'preserve_zip' => false
	);
	// foreach($plugins as $plugin) {
		$get_plugins = get_plugins();
		if ( !isset( $get_plugins[ trim( $plugin['install'] ) ] ) ) {
			mm_plugin_download( $plugin['path'], $args['path'].$plugin['text_domain'].'.zip' );
			mm_plugin_unpack( $args, $args['path'].$plugin['text_domain'].'.zip' );
			sleep( 3 );
		}
		$is_activated = mm_plugin_activate( $plugin['install'] );
		return $is_activated;
	// }
}

function mm_plugin_download($url, $path) {
// function mm_plugin_download($data, $path) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	curl_close($ch);
	// print_r(file_put_contents($path, $data));
	// exit;
	if(file_put_contents($path, $data)) {
		return true;
	} else {
		return false;
	}
}

function mm_plugin_unpack($args, $target) {
	if($zip = zip_open($target)) {
		while($entry = zip_read($zip)) {
			$is_file = substr(zip_entry_name($entry), -1) == '/' ? false : true;
			$file_path = $args['path'].zip_entry_name($entry);
			if($is_file) {
				if(zip_entry_open($zip,$entry,"r")) {
					$fstream = zip_entry_read($entry, zip_entry_filesize($entry));
					file_put_contents($file_path, $fstream );
					chmod($file_path, 0777);
					//echo "save: ".$file_path."<br />";
				}
				zip_entry_close($entry);
			} else {
				if(zip_entry_name($entry)) {
					if ( !file_exists( $file_path ) && !is_dir( $file_path ) ) {
						mkdir($file_path);
					}
					chmod($file_path, 0777);
					//echo "create: ".$file_path."<br />";
				}
			}
		}
		zip_close($zip);
	}
	if($args['preserve_zip'] === false) {
		unlink($target);
	}
}

function mm_plugin_activate( $installer ) {

	$current = get_option( 'active_plugins' );
	$plugin = plugin_basename( trim( $installer ) );
	if( !in_array($plugin, $current) ) {
		$current[] = $plugin;
		sort($current);
		do_action('activate_plugin', trim($plugin));
		update_option('active_plugins', $current);
		do_action('activate_'.trim($plugin));
		do_action('activated_plugin', trim($plugin));
		// return true;
	}
	// else {
	// 	return false;
	// }

	// $plugin_abs_path = ABSPATH . 'wp-content/plugins/' . $plugin;
	$activate_plugin = activate_plugin( $plugin );
	if ( is_wp_error( $activate_plugin ) ) {
		return false;
	}
	return true;
}
