<?php
/**
 * Travel Tourism Theme Customizer
 *
 * @package Travel Tourism
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function travel_tourism_custom_controls() {
	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'travel_tourism_custom_controls' );

function travel_tourism_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage'; 
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array( 
		'selector' => '.logo .site-title a', 
	 	'render_callback' => 'travel_tourism_customize_partial_blogname', 
	)); 

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array( 
		'selector' => 'p.site-description', 
		'render_callback' => 'travel_tourism_customize_partial_blogdescription', 
	));

	//add home page setting pannel
	$travel_tourism_parent_panel = new Travel_Tourism_WP_Customize_Panel( $wp_customize, 'travel_tourism_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => esc_html__( 'VW Settings', 'travel-tourism' ),
		'priority' => 10,
	));

	// Layout
	$wp_customize->add_section( 'travel_tourism_left_right', array(
    	'title'      => esc_html__( 'General Settings', 'travel-tourism' ),
		'panel' => 'travel_tourism_panel_id'
	) );

	$wp_customize->add_setting('travel_tourism_width_option',array(
        'default' => 'Full Width',
        'sanitize_callback' => 'travel_tourism_sanitize_choices'
	));
	$wp_customize->add_control(new Travel_Tourism_Image_Radio_Control($wp_customize, 'travel_tourism_width_option', array(
        'type' => 'select',
        'label' => __('Width Layouts','travel-tourism'),
        'description' => __('Here you can change the width layout of Website.','travel-tourism'),
        'section' => 'travel_tourism_left_right',
        'choices' => array(
            'Full Width' => esc_url(get_template_directory_uri()).'/assets/images/full-width.png',
            'Wide Width' => esc_url(get_template_directory_uri()).'/assets/images/wide-width.png',
            'Boxed' => esc_url(get_template_directory_uri()).'/assets/images/boxed-width.png',
    ))));

	$wp_customize->add_setting('travel_tourism_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'travel_tourism_sanitize_choices'
	));
	$wp_customize->add_control('travel_tourism_theme_options',array(
        'type' => 'select',
        'label' => __('Post Sidebar Layout','travel-tourism'),
        'description' => __('Here you can change the sidebar layout for posts. ','travel-tourism'),
        'section' => 'travel_tourism_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','travel-tourism'),
            'Right Sidebar' => __('Right Sidebar','travel-tourism'),
            'One Column' => __('One Column','travel-tourism'),
            'Three Columns' => __('Three Columns','travel-tourism'),
            'Four Columns' => __('Four Columns','travel-tourism'),
            'Grid Layout' => __('Grid Layout','travel-tourism')
        ),
	) );

	$wp_customize->add_setting('travel_tourism_page_layout',array(
        'default' => 'One Column',
        'sanitize_callback' => 'travel_tourism_sanitize_choices'
	));
	$wp_customize->add_control('travel_tourism_page_layout',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','travel-tourism'),
        'description' => __('Here you can change the sidebar layout for pages. ','travel-tourism'),
        'section' => 'travel_tourism_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','travel-tourism'),
            'Right Sidebar' => __('Right Sidebar','travel-tourism'),
            'One Column' => __('One Column','travel-tourism')
        ),
	) );

    //Pre-Loader
	$wp_customize->add_setting( 'travel_tourism_loader_enable',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ) );
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_loader_enable',array(
        'label' => esc_html__( 'Pre-Loader','travel-tourism' ),
        'section' => 'travel_tourism_left_right'
    )));

	$wp_customize->add_setting('travel_tourism_loader_icon',array(
        'default' => 'Two Way',
        'sanitize_callback' => 'travel_tourism_sanitize_choices'
	));
	$wp_customize->add_control('travel_tourism_loader_icon',array(
        'type' => 'select',
        'label' => __('Pre-Loader Type','travel-tourism'),
        'section' => 'travel_tourism_left_right',
        'choices' => array(
            'Two Way' => __('Two Way','travel-tourism'),
            'Dots' => __('Dots','travel-tourism'),
            'Rotate' => __('Rotate','travel-tourism')
        ),
	) );

	//Top Header
	$wp_customize->add_section( 'travel_tourism_top_header' , array(
    	'title'      => __( 'Top Header', 'travel-tourism' ),
		'panel' => 'travel_tourism_panel_id'
	) );

	$wp_customize->add_setting('travel_tourism_phone_number',array(
		'default'=> '',
		'sanitize_callback'	=> 'travel_tourism_sanitize_phone_number'
	));	
	$wp_customize->add_control('travel_tourism_phone_number',array(
		'label'	=> __('Phone Number','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '+00 123 456 7890', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_email_address',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_email'
	));	
	$wp_customize->add_control('travel_tourism_email_address',array(
		'label'	=> __('Email Address','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( 'support@123.com', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_opening_time',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('travel_tourism_opening_time',array(
		'label'	=> __('Opening Time','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( 'Mon to Sat 8:00am - 5:00pm', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_top_header',
		'type'=> 'text'
	));
    
	//Slider
	$wp_customize->add_section( 'travel_tourism_slidersettings' , array(
    	'title'      => __( 'Slider Settings', 'travel-tourism' ),
		'panel' => 'travel_tourism_panel_id'
	) );

	$wp_customize->add_setting( 'travel_tourism_slider_arrows',array(
    	'default' => 0,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ));  
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_slider_arrows',array(
      	'label' => esc_html__( 'Show / Hide Slider','travel-tourism' ),
      	'section' => 'travel_tourism_slidersettings'
    )));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('travel_tourism_slider_arrows',array(
		'selector'        => '#slider .carousel-caption h1',
		'render_callback' => 'travel_tourism_customize_partial_travel_tourism_slider_arrows',
	));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'travel_tourism_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'travel_tourism_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'travel_tourism_slider_page' . $count, array(
			'label'    => __( 'Select Slider Page', 'travel-tourism' ),
			'description' => __('Slider image size (350 x 350)','travel-tourism'),
			'section'  => 'travel_tourism_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	$wp_customize->add_setting('travel_tourism_slider_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_slider_button_text',array(
		'label'	=> __('Add Slider Button Text','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( 'READ MORE', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_slidersettings',
		'type'=> 'text'
	));

	//content layout
	$wp_customize->add_setting('travel_tourism_slider_content_option',array(
        'default' => 'Center',
        'sanitize_callback' => 'travel_tourism_sanitize_choices'
	));
	$wp_customize->add_control(new Travel_Tourism_Image_Radio_Control($wp_customize, 'travel_tourism_slider_content_option', array(
        'type' => 'select',
        'label' => __('Slider Content Layouts','travel-tourism'),
        'section' => 'travel_tourism_slidersettings',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/slider-content1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/slider-content2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/slider-content3.png',
    ))));

    //Slider excerpt
	$wp_customize->add_setting( 'travel_tourism_slider_excerpt_number', array(
		'default'              => 8,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'travel_tourism_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'travel_tourism_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','travel-tourism' ),
		'section'     => 'travel_tourism_slidersettings',
		'type'        => 'range',
		'settings'    => 'travel_tourism_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Slider height
	$wp_customize->add_setting('travel_tourism_slider_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_slider_height',array(
		'label'	=> __('Slider Height','travel-tourism'),
		'description'	=> __('Specify the slider height (px).','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '500px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_slidersettings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'travel_tourism_slider_speed', array(
		'default'  => 3000,
		'sanitize_callback'	=> 'travel_tourism_sanitize_float'
	) );
	$wp_customize->add_control( 'travel_tourism_slider_speed', array(
		'label' => esc_html__('Slider Transition Speed','travel-tourism'),
		'section' => 'travel_tourism_slidersettings',
		'type'  => 'number',
	) );
 
	//Popular destination
	$wp_customize->add_section('travel_tourism_services',array(
		'title'	=> __('Popular Destination Section','travel-tourism'),
		'panel' => 'travel_tourism_panel_id',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'travel_tourism_section_title', array( 
		'selector' => '.heading-text h2', 
		'render_callback' => 'travel_tourism_customize_partial_travel_tourism_section_title',
	));

	$wp_customize->add_setting('travel_tourism_section_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('travel_tourism_section_text',array(
		'label'	=> __('Section Text','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( 'Check out our  popular destination', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_services',
		'type'=> 'text'
	));	

	$wp_customize->add_setting('travel_tourism_section_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('travel_tourism_section_title',array(
		'label'	=> __('Section Title','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( 'Choose Tour', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_services',
		'type'=> 'text'
	));	

	$categories = get_categories();
		$cat_posts = array();
			$i = 0;
			$cat_posts[]='Select';	
		foreach($categories as $category){
			if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_posts[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('travel_tourism_services_category',array(
		'default'	=> 'select',
		'sanitize_callback' => 'travel_tourism_sanitize_choices',
	));
	$wp_customize->add_control('travel_tourism_services_category',array(
		'type'    => 'select',
		'choices' => $cat_posts,
		'label' => __('Select Category to display Popular Destination Section','travel-tourism'),		
		'section' => 'travel_tourism_services',
	));

	//Blog Post
	$wp_customize->add_panel( $travel_tourism_parent_panel );

	$BlogPostParentPanel = new Travel_Tourism_WP_Customize_Panel( $wp_customize, 'blog_post_parent_panel', array(
		'title' => __( 'Blog Post Settings', 'travel-tourism' ),
		'panel' => 'travel_tourism_panel_id',
	));

	$wp_customize->add_panel( $BlogPostParentPanel );

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'travel_tourism_post_settings', array(
		'title' => __( 'Post Settings', 'travel-tourism' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('travel_tourism_toggle_postdate', array( 
		'selector' => '.post-main-box h2 a', 
		'render_callback' => 'travel_tourism_customize_partial_travel_tourism_toggle_postdate', 
	));

	$wp_customize->add_setting( 'travel_tourism_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ) );
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_toggle_postdate',array(
        'label' => esc_html__( 'Post Date','travel-tourism' ),
        'section' => 'travel_tourism_post_settings'
    )));

    $wp_customize->add_setting( 'travel_tourism_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ) );
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_toggle_author',array(
		'label' => esc_html__( 'Author','travel-tourism' ),
		'section' => 'travel_tourism_post_settings'
    )));

    $wp_customize->add_setting( 'travel_tourism_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ) );
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_toggle_comments',array(
		'label' => esc_html__( 'Comments','travel-tourism' ),
		'section' => 'travel_tourism_post_settings'
    )));

    $wp_customize->add_setting( 'travel_tourism_toggle_tags',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'travel_tourism_switch_sanitization'
	));
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_toggle_tags', array(
		'label' => esc_html__( 'Tags','travel-tourism' ),
		'section' => 'travel_tourism_post_settings'
    )));

    $wp_customize->add_setting( 'travel_tourism_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'travel_tourism_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'travel_tourism_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','travel-tourism' ),
		'section'     => 'travel_tourism_post_settings',
		'type'        => 'range',
		'settings'    => 'travel_tourism_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Blog layout
    $wp_customize->add_setting('travel_tourism_blog_layout_option',array(
        'default' => 'Default',
        'sanitize_callback' => 'travel_tourism_sanitize_choices'
    ));
    $wp_customize->add_control(new Travel_Tourism_Image_Radio_Control($wp_customize, 'travel_tourism_blog_layout_option', array(
        'type' => 'select',
        'label' => __('Blog Layouts','travel-tourism'),
        'section' => 'travel_tourism_post_settings',
        'choices' => array(
            'Default' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout2.png',
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout3.png',
    ))));

    $wp_customize->add_setting('travel_tourism_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'travel_tourism_sanitize_choices'
	));
	$wp_customize->add_control('travel_tourism_excerpt_settings',array(
        'type' => 'select',
        'label' => __('Post Content','travel-tourism'),
        'section' => 'travel_tourism_post_settings',
        'choices' => array(
        	'Content' => __('Content','travel-tourism'),
            'Excerpt' => __('Excerpt','travel-tourism'),
            'No Content' => __('No Content','travel-tourism')
        ),
	) );

	$wp_customize->add_setting('travel_tourism_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_post_settings',
		'type'=> 'text'
	));

    // Button Settings
	$wp_customize->add_section( 'travel_tourism_button_settings', array(
		'title' => __( 'Button Settings', 'travel-tourism' ),
		'panel' => 'blog_post_parent_panel',
	));

	$wp_customize->add_setting('travel_tourism_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_button_padding_top_bottom',array(
		'label'	=> __('Padding Top Bottom','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_button_padding_left_right',array(
		'label'	=> __('Padding Left Right','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'travel_tourism_button_border_radius', array(
		'default'              => 50,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'travel_tourism_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'travel_tourism_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','travel-tourism' ),
		'section'     => 'travel_tourism_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('travel_tourism_button_text', array( 
		'selector' => '.post-main-box .more-btn a', 
		'render_callback' => 'travel_tourism_customize_partial_travel_tourism_button_text', 
	));

    $wp_customize->add_setting('travel_tourism_button_text',array(
		'default'=> esc_html__( 'READ MORE', 'travel-tourism' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_button_text',array(
		'label'	=> __('Add Button Text','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( 'READ MORE', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_button_settings',
		'type'=> 'text'
	));

	// Related Post Settings
	$wp_customize->add_section( 'travel_tourism_related_posts_settings', array(
		'title' => __( 'Related Posts Settings', 'travel-tourism' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('travel_tourism_related_post_title', array( 
		'selector' => '.related-post h3', 
		'render_callback' => 'travel_tourism_customize_partial_travel_tourism_related_post_title', 
	));

    $wp_customize->add_setting( 'travel_tourism_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ) );
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_related_post',array(
		'label' => esc_html__( 'Related Post','travel-tourism' ),
		'section' => 'travel_tourism_related_posts_settings'
    )));

    $wp_customize->add_setting('travel_tourism_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_related_post_title',array(
		'label'	=> __('Add Related Post Title','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( 'Related Post', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('travel_tourism_related_posts_count',array(
		'default'=> '3',
		'sanitize_callback'	=> 'travel_tourism_sanitize_float'
	));
	$wp_customize->add_control('travel_tourism_related_posts_count',array(
		'label'	=> __('Add Related Post Count','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '3', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_related_posts_settings',
		'type'=> 'number'
	));

    //404 Page Setting
	$wp_customize->add_section('travel_tourism_404_page',array(
		'title'	=> __('404 Page Settings','travel-tourism'),
		'panel' => 'travel_tourism_panel_id',
	));	

	$wp_customize->add_setting('travel_tourism_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('travel_tourism_404_page_title',array(
		'label'	=> __('Add Title','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('travel_tourism_404_page_content',array(
		'label'	=> __('Add Text','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_404_page_button_text',array(
		'label'	=> __('Add Button Text','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( 'GO BACK', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_404_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('travel_tourism_social_icon_settings',array(
		'title'	=> __('Social Icons Settings','travel-tourism'),
		'panel' => 'travel_tourism_panel_id',
	));	

	$wp_customize->add_setting('travel_tourism_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_social_icon_padding',array(
		'label'	=> __('Icon Padding','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_social_icon_width',array(
		'label'	=> __('Icon Width','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_social_icon_height',array(
		'label'	=> __('Icon Height','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'travel_tourism_social_icon_border_radius', array(
		'default'              => '',
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'travel_tourism_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'travel_tourism_social_icon_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','travel-tourism' ),
		'section'     => 'travel_tourism_social_icon_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Responsive Media Settings
	$wp_customize->add_section('travel_tourism_responsive_media',array(
		'title'	=> __('Responsive Media','travel-tourism'),
		'panel' => 'travel_tourism_panel_id',
	));

    $wp_customize->add_setting( 'travel_tourism_resp_slider_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ));  
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_resp_slider_hide_show',array(
      'label' => esc_html__( 'Show / Hide Slider','travel-tourism' ),
      'section' => 'travel_tourism_responsive_media'
    )));

    $wp_customize->add_setting( 'travel_tourism_sidebar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ));  
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_sidebar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sidebar','travel-tourism' ),
      'section' => 'travel_tourism_responsive_media'
    )));

    $wp_customize->add_setting( 'travel_tourism_resp_scroll_top_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ));  
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_resp_scroll_top_hide_show',array(
      'label' => esc_html__( 'Show / Hide Scroll To Top','travel-tourism' ),
      'section' => 'travel_tourism_responsive_media'
    )));

    $wp_customize->add_setting('travel_tourism_res_menu_open_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Travel_Tourism_Fontawesome_Icon_Chooser(
        $wp_customize,'travel_tourism_res_menu_open_icon',array(
		'label'	=> __('Add Open Menu Icon','travel-tourism'),
		'transport' => 'refresh',
		'section'	=> 'travel_tourism_responsive_media',
		'setting'	=> 'travel_tourism_res_menu_open_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('travel_tourism_res_menu_close_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Travel_Tourism_Fontawesome_Icon_Chooser(
        $wp_customize,'travel_tourism_res_menu_close_icon',array(
		'label'	=> __('Add Close Menu Icon','travel-tourism'),
		'transport' => 'refresh',
		'section'	=> 'travel_tourism_responsive_media',
		'setting'	=> 'travel_tourism_res_menu_close_icon',
		'type'		=> 'icon'
	)));

	//Footer Text
	$wp_customize->add_section('travel_tourism_footer',array(
		'title'	=> __('Footer Settings','travel-tourism'),
		'panel' => 'travel_tourism_panel_id',
	));	

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('travel_tourism_footer_text', array( 
		'selector' => '.copyright p', 
		'render_callback' => 'travel_tourism_customize_partial_travel_tourism_footer_text', 
	));
	
	$wp_customize->add_setting('travel_tourism_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('travel_tourism_footer_text',array(
		'label'	=> __('Copyright Text','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( 'Copyright 2019, .....', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_copyright_alingment',array(
        'default' => 'center',
        'sanitize_callback' => 'travel_tourism_sanitize_choices'
	));
	$wp_customize->add_control(new Travel_Tourism_Image_Radio_Control($wp_customize, 'travel_tourism_copyright_alingment', array(
        'type' => 'select',
        'label' => __('Copyright Alignment','travel-tourism'),
        'section' => 'travel_tourism_footer',
        'settings' => 'travel_tourism_copyright_alingment',
        'choices' => array(
            'left' => esc_url(get_template_directory_uri()).'/assets/images/copyright1.png',
            'center' => esc_url(get_template_directory_uri()).'/assets/images/copyright2.png',
            'right' => esc_url(get_template_directory_uri()).'/assets/images/copyright3.png'
    ))));

    $wp_customize->add_setting('travel_tourism_copyright_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_copyright_padding_top_bottom',array(
		'label'	=> __('Copyright Padding Top Bottom','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'travel_tourism_footer_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ));  
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_footer_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll to Top','travel-tourism' ),
      	'section' => 'travel_tourism_footer'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('travel_tourism_scroll_to_top_icon', array( 
		'selector' => '.scrollup i', 
		'render_callback' => 'travel_tourism_customize_partial_travel_tourism_scroll_to_top_icon', 
	));

    $wp_customize->add_setting('travel_tourism_scroll_to_top_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Travel_Tourism_Fontawesome_Icon_Chooser(
        $wp_customize,'travel_tourism_scroll_to_top_icon',array(
		'label'	=> __('Add Scroll to Top Icon','travel-tourism'),
		'transport' => 'refresh',
		'section'	=> 'travel_tourism_footer',
		'setting'	=> 'travel_tourism_scroll_to_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('travel_tourism_scroll_to_top_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_scroll_to_top_font_size',array(
		'label'	=> __('Icon Font Size','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_scroll_to_top_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_scroll_to_top_padding',array(
		'label'	=> __('Icon Top Bottom Padding','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_scroll_to_top_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_scroll_to_top_width',array(
		'label'	=> __('Icon Width','travel-tourism'),
		'description'	=> __('Enter a value in pixels Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_scroll_to_top_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_scroll_to_top_height',array(
		'label'	=> __('Icon Height','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'travel_tourism_scroll_to_top_border_radius', array(
		'default'              => 50,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'travel_tourism_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'travel_tourism_scroll_to_top_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','travel-tourism' ),
		'section'     => 'travel_tourism_footer',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting('travel_tourism_scroll_top_alignment',array(
        'default' => 'Right',
        'sanitize_callback' => 'travel_tourism_sanitize_choices'
	));
	$wp_customize->add_control(new Travel_Tourism_Image_Radio_Control($wp_customize, 'travel_tourism_scroll_top_alignment', array(
        'type' => 'select',
        'label' => __('Scroll To Top','travel-tourism'),
        'section' => 'travel_tourism_footer',
        'settings' => 'travel_tourism_scroll_top_alignment',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/layout2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/layout3.png'
    ))));

    //Woocommerce settings
	$wp_customize->add_section('travel_tourism_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'travel-tourism'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

    //Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'travel_tourism_woocommerce_shop_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ) );
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Shop Page Sidebar','travel-tourism' ),
		'section' => 'travel_tourism_woocommerce_section'
    )));

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'travel_tourism_woocommerce_single_product_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'travel_tourism_switch_sanitization'
    ) );
    $wp_customize->add_control( new Travel_Tourism_Toggle_Switch_Custom_Control( $wp_customize, 'travel_tourism_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Single Product Sidebar','travel-tourism' ),
		'section' => 'travel_tourism_woocommerce_section'
    )));

    //Products per page
    $wp_customize->add_setting('travel_tourism_products_per_page',array(
		'default'=> '9',
		'sanitize_callback'	=> 'travel_tourism_sanitize_float'
	));
	$wp_customize->add_control('travel_tourism_products_per_page',array(
		'label'	=> __('Products Per Page','travel-tourism'),
		'description' => __('Display on shop page','travel-tourism'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'travel_tourism_woocommerce_section',
		'type'=> 'number',
	));

    //Products per row
    $wp_customize->add_setting('travel_tourism_products_per_row',array(
		'default'=> '3',
		'sanitize_callback'	=> 'travel_tourism_sanitize_choices'
	));
	$wp_customize->add_control('travel_tourism_products_per_row',array(
		'label'	=> __('Products Per Row','travel-tourism'),
		'description' => __('Display on shop page','travel-tourism'),
		'choices' => array(
            '2' => '2',
			'3' => '3',
			'4' => '4',
        ),
		'section'=> 'travel_tourism_woocommerce_section',
		'type'=> 'select',
	));

	//Products padding
	$wp_customize->add_setting('travel_tourism_products_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_products_padding_top_bottom',array(
		'label'	=> __('Products Padding Top Bottom','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('travel_tourism_products_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('travel_tourism_products_padding_left_right',array(
		'label'	=> __('Products Padding Left Right','travel-tourism'),
		'description'	=> __('Enter a value in pixels. Example:20px','travel-tourism'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'travel-tourism' ),
        ),
		'section'=> 'travel_tourism_woocommerce_section',
		'type'=> 'text'
	));

	//Products box shadow
	$wp_customize->add_setting( 'travel_tourism_products_box_shadow', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'travel_tourism_sanitize_number_range'
	) );
	$wp_customize->add_control( 'travel_tourism_products_box_shadow', array(
		'label'       => esc_html__( 'Products Box Shadow','travel-tourism' ),
		'section'     => 'travel_tourism_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products border radius
    $wp_customize->add_setting( 'travel_tourism_products_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'travel_tourism_sanitize_number_range'
	) );
	$wp_customize->add_control( 'travel_tourism_products_border_radius', array(
		'label'       => esc_html__( 'Products Border Radius','travel-tourism' ),
		'section'     => 'travel_tourism_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    // Has to be at the top
	$wp_customize->register_panel_type( 'Travel_Tourism_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'Travel_Tourism_WP_Customize_Section' );
}

add_action( 'customize_register', 'travel_tourism_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class Travel_Tourism_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'travel_tourism_panel';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;
	      return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class Travel_Tourism_WP_Customize_Section extends WP_Customize_Section {
	    public $section;
	    public $type = 'travel_tourism_section';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;

	      if ( $this->panel ) {
	        $array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
	      } else {
	        $array['customizeAction'] = 'Customizing';
	      }
	      return $array;
    	}
  	}
}

// Enqueue our scripts and styles
function travel_tourism_customize_controls_scripts() {
  wp_enqueue_script( 'travel-tourism-customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'travel_tourism_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Travel_Tourism_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Travel_Tourism_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section( new Travel_Tourism_Customize_Section_Pro( $manager,'travel_tourism_upgrade_pro_link', array(
			'priority'   => 1,
			'title'    => esc_html__( 'Travel Tourism Pro', 'travel-tourism' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'travel-tourism' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/themes/travel-agency-wordpress-theme/'),
		)));

		$manager->add_section(new Travel_Tourism_Customize_Section_Pro($manager,'travel_tourism_get_started_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'DOCUMENTATION', 'travel-tourism' ),
			'pro_text' => esc_html__( 'DOCS', 'travel-tourism' ),
			'pro_url'  => admin_url('themes.php?page=travel_tourism_guide'),
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'travel-tourism-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'travel-tourism-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Travel_Tourism_Customize::get_instance();