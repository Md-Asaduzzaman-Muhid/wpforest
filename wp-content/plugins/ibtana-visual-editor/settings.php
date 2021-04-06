<?php

function ibtana_ajax_enqueue() {
	wp_localize_script(
		'ajax-script',
		'ibtana_ajax_object',
		array(
			'ajax_url'	=>	admin_url( 'admin-ajax.php' )
		)
	);
}
add_action( 'wp_enqueue_scripts', 'ibtana_ajax_enqueue' );
if ( ! function_exists( 'ibtana_visual_editor_register_ajax_json_endpont' ) ) {
	/**
	 * Plugin bootstrap process.
	 *
	 * @return void
	 */
	function ibtana_visual_editor_register_ajax_json_endpont() {
		register_rest_route(
			'ibtana-visual-editor/v1',
			'/importFreeTemplate',
			array(
				'methods' => 'POST',
				'callback' => 'ibtana_visual_editor_importFreeTemplate',
				'permission_callback' => '__return_true'
			)
		);

		register_rest_route(
        'ibtana-visual-editor/v1',
        '/update_google_recaptcha_keys',
        array(
            'methods'             => 'POST',
            'callback'            => 'ibtana_visual_editor_update_key_option',
            'permission_callback' => '__return_true',
        )
    );
	}
	add_action('rest_api_init', 'ibtana_visual_editor_register_ajax_json_endpont');
}
add_action( 'wp_ajax_import_template', 'ibtana_visual_editor_importFreeTemplate' );

if ( ! function_exists( 'ibtana_visual_editor_get_all_posts' ) ) {
	function ibtana_visual_editor_get_all_posts() {
		register_rest_route(
			'ibtana-visual-editor/v1',
			'getAllPosts/',
			array(
				'methods' => 'POST',
				'callback' => 'ibtana_visual_editor_getAllPosts',
				'permission_callback' => '__return_true'
			)
		);
	}
	add_action('rest_api_init', 'ibtana_visual_editor_get_all_posts');
}

if ( ! function_exists( 'ibtana_visual_editor_add_new_posttype' ) ) {
	function ibtana_visual_editor_add_new_posttype() {
		register_rest_route(
			'ibtana-visual-editor/v1',
			'addNewPosttype/',
			array(
				'methods' => 'POST',
				'callback' => 'ibtana_visual_editor_addNewPosttype',
				'permission_callback' => '__return_true'
			)
		);
	}
	add_action('rest_api_init', 'ibtana_visual_editor_add_new_posttype');
}

if ( ! function_exists( 'ibtana_visual_editor_get_all_categories' ) ) {
	function ibtana_visual_editor_get_all_categories() {
		register_rest_route(
			'ibtana-visual-editor/v1',
			'getAllCategories/',
			array(
				'methods' => 'GET',
				'callback' => 'ibtana_visual_editor_getAllCategories',
				'permission_callback' => '__return_true'
			)
		);
	}
	add_action('rest_api_init', 'ibtana_visual_editor_get_all_categories');
}

function ibtana_visual_editor_addNewPosttype($request){
	$params = $request->get_params();
	$psttyptitle = strtolower($params['pstTypTitle']);
	$psttypTitleNew = str_replace(" ","_",$psttyptitle);
	$ucpsttyptitle = ucwords($params['pstTypTitle']);
	$newParams = serialize($ucpsttyptitle);
	$isOptionSet = get_option('ibtana_visual_editor_posttype');

	$post_meta_fields=$params['metafieldcount'];
	$all_meta=[];
	if($post_meta_fields > 0){
		$ment_fields_arr=$params['metafieldarr'];
		for($i=1; $i<=$post_meta_fields; $i++){
		$all_meta[]=	$ment_fields_arr[0]['pstMetaField'.$i];
		}
		$isOptionSet_meta = get_option('ive_ib_'.$psttypTitleNew);
		$all_meta_serial = serialize($all_meta);
		if($isOptionSet_meta){
			$data_ive_ib_pstoption = get_option( 'ive_ib_'.$psttypTitleNew );
			$options['post_options'] = $all_meta_serial;
			update_option(  'ive_ib_'.$psttypTitleNew, $options );
		}else{
			$options['post_options'] = $all_meta_serial;
			$addOption = add_option('ive_ib_'.$psttypTitleNew,$options);
		}
	}

	if ($isOptionSet) {
		$data_ibtana_visual_editor_posttype = get_option( 'ibtana_visual_editor_posttype' );
		$options['pstTypTitle'] = $newParams;
		$data_ibtana_visual_editor_posttype[] = $options;
		update_option( 'ibtana_visual_editor_posttype', $data_ibtana_visual_editor_posttype );
	}else{
		$options['pstTypTitle'] = $newParams;
		$data[] = $options;
		$addOption = add_option('ibtana_visual_editor_posttype',$data);
	}
	return array('code' => 200);
}

function ibtana_visual_editor_getAllPosts($request) {
	if (count($request->get_params()['category']) > 0) {
		$categories = $request->get_params()['category'];
		$args = array(
		  'post_type'=> 'post',
		  'category__in'=> $categories,
		  'orderby'    => 'ID',
		  'post_status' => 'publish',
		  'order'    => 'DESC',
		  'posts_per_page' => -1
		);
	} else {
		$args = array(
		  'post_type'=> 'post',
		  'orderby'    => 'ID',
		  'post_status' => 'publish',
		  'order'    => 'DESC',
		  'posts_per_page' => $posts_per_page
		);
	}
  $result = new WP_Query( $args );
	$posts = $result->posts;
	foreach ($posts as $value) {
    $postId = $value->ID;
    $value->img = get_the_post_thumbnail_url($postId);
    $value->title = get_the_title($postId);
    $value->content = get_the_excerpt($postId);
    $value->btnlink = get_the_permalink($postId);
    $value->category = get_the_category($postId);
    $value->tags = get_the_tags($postId);
		$value->author_display_name = get_the_author_meta( 'display_name', $value->post_author );
	}
	return array('result' => $posts);
}

function ibtana_visual_editor_getAllCategories() {
	$categories = get_categories(array(
		'orderby' => 'name',
		'order'   => 'ASC'
	));
	return array('result' => $categories);
}

function ibtana_visual_editor_importFreeTemplate() {
	$theme_json = $_POST['theme_json'];
	$id = $_GET['page_id'];
	$title = get_the_title($id);
	if($title == 'Auto Draft'){
		$title = 'Free Template'	;
	}
	$ibtana_visual_editor_home = array(
		'ID'						=> $id,
		'post_type' 		=> 'page',
		'post_title' 		=> $title,
		'post_content'  => $theme_json,
		'post_status' 	=> 'publish',
		'post_author' 	=> 1
	);
	wp_update_post( $ibtana_visual_editor_home );
	echo json_encode(['code' => 200, 'msg' => $id, 'redirect_uri'=>admin_url('post.php?post='.$id.'&action=edit')]);
	exit;
}

function ibtana_visual_editor_update_key_option($request){
	update_option( 'ive_googleReCaptchaAPISiteKey', $request->get_param( 'site_key' ) );
  update_option( 'ive_googleReCaptchaAPISecretKey', $request->get_param( 'secret_key' ) );
	return new WP_REST_Response(
      array(
          'success'  => true,
          'response' => true,
      ),
      200
  );
}

function ibtana_visual_editor_file_generation() {
	wp_send_json_success(
		array(
			'success' => true,
			'message' => update_option( '_ive_allow_file_generation', $_POST['value'] ),
		)
	);
}
add_action( 'wp_ajax_ive_file_generation', 'ibtana_visual_editor_file_generation' );
