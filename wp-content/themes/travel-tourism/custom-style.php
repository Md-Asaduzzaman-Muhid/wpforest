<?php

/*---------------------------First highlight color-------------------*/

	$travel_tourism_first_color = get_theme_mod('travel_tourism_first_color');

	$travel_tourism_custom_css= "";

	if($travel_tourism_first_color != false){
		$travel_tourism_custom_css .='input[type="submit"], .read-btn a, .more-btn a,input[type="submit"],#sidebar h3,.search-box i,.scrollup i,#footer a.custom_read_more, #sidebar a.custom_read_more,#sidebar .custom-social-icons i, #footer .custom-social-icons i,.pagination span, .pagination a,#footer-2,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.widget_product_search button,#comments input[type="submit"],#comments a.comment-reply-link,#slider .carousel-control-prev-icon, #slider .carousel-control-next-icon,nav.woocommerce-MyAccount-navigation ul li,.toggle-nav i, .top-bar p i, #slider .carousel-control-prev-icon:hover, #slider .carousel-control-next-icon:hover, button.owl-next i:hover, button.owl-prev i:hover, .inner-box:hover, .woocommerce nav.woocommerce-pagination ul li a{';
			$travel_tourism_custom_css .='background: '.esc_attr($travel_tourism_first_color).';';
		$travel_tourism_custom_css .='}';
	}
	if($travel_tourism_first_color != false){
		$travel_tourism_custom_css .='a, .main-navigation a:hover,.main-navigation ul.sub-menu a:hover,.main-navigation .current_page_item > a, .main-navigation .current-menu-item > a, .main-navigation .current_page_ancestor > a,#slider .inner_carousel h1 a,.heading-text p,#sidebar ul li a:hover,#footer li a:hover, .heading-text i, .top-bar .custom-social-icons i:hover, .post-main-box:hover h3 a, .post-navigation a:hover .post-title, .post-navigation a:focus .post-title, .post-navigation a:hover, .post-main-box:hover h2 a, .post-main-box:hover .post-info a, .post-info:hover a, .top-bar p a:hover{';
			$travel_tourism_custom_css .='color: '.esc_attr($travel_tourism_first_color).';';
		$travel_tourism_custom_css .='}';
	}	
	if($travel_tourism_first_color != false){
		$travel_tourism_custom_css .='.main-navigation ul ul, #slider .carousel-control-prev-icon:hover, #slider .carousel-control-next-icon:hover, button.owl-next i:hover, button.owl-prev i:hover{';
			$travel_tourism_custom_css .='border-color: '.esc_attr($travel_tourism_first_color).';';
		$travel_tourism_custom_css .='}';
	}
	
	/*---------------------------second highlight color-------------------*/

	$travel_tourism_second_color = get_theme_mod('travel_tourism_second_color');

	if($travel_tourism_second_color != false){
		$travel_tourism_custom_css .='.read-btn a:hover, .more-btn a:hover,input[type="submit"]:hover,#sidebar a.custom_read_more:hover, #footer a.custom_read_more:hover,#sidebar .custom-social-icons i:hover, #footer .custom-social-icons i:hover,.pagination .current,.pagination a:hover,#sidebar .tagcloud a:hover,#footer .tagcloud a:hover,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .top-bar, #comments input[type="submit"]:hover, #comments a.comment-reply-link:hover{';
			$travel_tourism_custom_css .='background: '.esc_attr($travel_tourism_second_color).';';
		$travel_tourism_custom_css .='}';
	}

	if($travel_tourism_second_color != false){
		$travel_tourism_custom_css .='input[type="submit"], p.site-title a, .logo h1 a, p.site-description, .top-bar p i, #slider .carousel-control-prev-icon:hover, #slider .carousel-control-next-icon:hover, button.owl-next i:hover, button.owl-prev i:hover, .read-btn a, .more-btn a, .inner-box h3 a, .copyright p, .copyright p a, #comments input[type="submit"], #sidebar h3, .pagination span, .pagination a, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, nav.woocommerce-MyAccount-navigation ul li a, .toggle-nav i{';
			$travel_tourism_custom_css .='color: '.esc_attr($travel_tourism_second_color).';';
		$travel_tourism_custom_css .='}';
	}

	/*---------------------------Width Layout -------------------*/

	$travel_tourism_theme_lay = get_theme_mod( 'travel_tourism_width_option','Full Width');
    if($travel_tourism_theme_lay == 'Boxed'){
		$travel_tourism_custom_css .='body{';
			$travel_tourism_custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$travel_tourism_custom_css .='}';
		$travel_tourism_custom_css .='#slider{';
			$travel_tourism_custom_css .='right: 1%;';
		$travel_tourism_custom_css .='}';
	}else if($travel_tourism_theme_lay == 'Wide Width'){
		$travel_tourism_custom_css .='body{';
			$travel_tourism_custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$travel_tourism_custom_css .='}';
	}else if($travel_tourism_theme_lay == 'Full Width'){
		$travel_tourism_custom_css .='body{';
			$travel_tourism_custom_css .='max-width: 100%;';
		$travel_tourism_custom_css .='}';
	}

	/*---------------------------Slider Content Layout -------------------*/

	$travel_tourism_theme_lay = get_theme_mod( 'travel_tourism_slider_content_option','Center');
    if($travel_tourism_theme_lay == 'Left'){
		$travel_tourism_custom_css .='#slider .carousel-caption{';
			$travel_tourism_custom_css .='text-align:left;';
		$travel_tourism_custom_css .='}';
	}else if($travel_tourism_theme_lay == 'Center'){
		$travel_tourism_custom_css .='#slider .carousel-caption{';
			$travel_tourism_custom_css .='text-align:center;';
		$travel_tourism_custom_css .='}';
	}else if($travel_tourism_theme_lay == 'Right'){
		$travel_tourism_custom_css .='#slider .carousel-caption{';
			$travel_tourism_custom_css .='text-align:right;';
		$travel_tourism_custom_css .='}';
	}

	/*---------------------------Slider Height ------------*/

	$travel_tourism_slider_height = get_theme_mod('travel_tourism_slider_height');
	if($travel_tourism_slider_height != false){
		$travel_tourism_custom_css .='#slider img{';
			$travel_tourism_custom_css .='height: '.esc_attr($travel_tourism_slider_height).';';
		$travel_tourism_custom_css .='}';
	}

	/*--------------------------- Slider -------------------*/

	$travel_tourism_slider = get_theme_mod('travel_tourism_slider_arrows');
	if($travel_tourism_slider == false){
		$travel_tourism_custom_css .='#services-sec{';
			$travel_tourism_custom_css .='padding: 8% 0;';
		$travel_tourism_custom_css .='}';
	}

	/*---------------------------Blog Layout -------------------*/

	$travel_tourism_theme_lay = get_theme_mod( 'travel_tourism_blog_layout_option','Default');
    if($travel_tourism_theme_lay == 'Default'){
		$travel_tourism_custom_css .='.post-main-box{';
			$travel_tourism_custom_css .='';
		$travel_tourism_custom_css .='}';
	}else if($travel_tourism_theme_lay == 'Center'){
		$travel_tourism_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p{';
			$travel_tourism_custom_css .='text-align:center;';
		$travel_tourism_custom_css .='}';
		$travel_tourism_custom_css .='.post-info{';
			$travel_tourism_custom_css .='margin-top:10px;';
		$travel_tourism_custom_css .='}';
	}else if($travel_tourism_theme_lay == 'Left'){
		$travel_tourism_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p, #our-services p{';
			$travel_tourism_custom_css .='text-align:Left;';
		$travel_tourism_custom_css .='}';
		$travel_tourism_custom_css .='.post-main-box h2{';
			$travel_tourism_custom_css .='margin-top:10px;';
		$travel_tourism_custom_css .='}';
	}

	/*----------------Responsive Media -----------------------*/

	$travel_tourism_resp_slider = get_theme_mod( 'travel_tourism_resp_slider_hide_show',false);
	if($travel_tourism_resp_slider == true && get_theme_mod( 'travel_tourism_slider_arrows', false) == false){
    	$travel_tourism_custom_css .='#slider{';
			$travel_tourism_custom_css .='display:none;';
		$travel_tourism_custom_css .='} ';
	}
    if($travel_tourism_resp_slider == true){
    	$travel_tourism_custom_css .='@media screen and (max-width:575px) {';
		$travel_tourism_custom_css .='#slider{';
			$travel_tourism_custom_css .='display:block;';
		$travel_tourism_custom_css .='} }';
	}else if($travel_tourism_resp_slider == false){
		$travel_tourism_custom_css .='@media screen and (max-width:575px) {';
		$travel_tourism_custom_css .='#slider{';
			$travel_tourism_custom_css .='display:none;';
		$travel_tourism_custom_css .='} }';
	}

	$travel_tourism_resp_sidebar = get_theme_mod( 'travel_tourism_sidebar_hide_show',true);
    if($travel_tourism_resp_sidebar == true){
    	$travel_tourism_custom_css .='@media screen and (max-width:575px) {';
		$travel_tourism_custom_css .='#sidebar{';
			$travel_tourism_custom_css .='display:block;';
		$travel_tourism_custom_css .='} }';
	}else if($travel_tourism_resp_sidebar == false){
		$travel_tourism_custom_css .='@media screen and (max-width:575px) {';
		$travel_tourism_custom_css .='#sidebar{';
			$travel_tourism_custom_css .='display:none;';
		$travel_tourism_custom_css .='} }';
	}

	$travel_tourism_resp_scroll_top = get_theme_mod( 'travel_tourism_resp_scroll_top_hide_show',true);
	if($travel_tourism_resp_scroll_top == true && get_theme_mod( 'travel_tourism_footer_scroll',true) != true){
    	$travel_tourism_custom_css .='.scrollup i{';
			$travel_tourism_custom_css .='visibility:hidden !important;';
		$travel_tourism_custom_css .='} ';
	}
    if($travel_tourism_resp_scroll_top == true){
    	$travel_tourism_custom_css .='@media screen and (max-width:575px) {';
		$travel_tourism_custom_css .='.scrollup i{';
			$travel_tourism_custom_css .='visibility:visible !important;';
		$travel_tourism_custom_css .='} }';
	}else if($travel_tourism_resp_scroll_top == false){
		$travel_tourism_custom_css .='@media screen and (max-width:575px){';
		$travel_tourism_custom_css .='.scrollup i{';
			$travel_tourism_custom_css .='visibility:hidden !important;';
		$travel_tourism_custom_css .='} }';
	}

	/*---------------- Button Settings ------------------*/

	$travel_tourism_button_padding_top_bottom = get_theme_mod('travel_tourism_button_padding_top_bottom');
	$travel_tourism_button_padding_left_right = get_theme_mod('travel_tourism_button_padding_left_right');
	if($travel_tourism_button_padding_top_bottom != false || $travel_tourism_button_padding_left_right != false){
		$travel_tourism_custom_css .='.post-main-box .more-btn a{';
			$travel_tourism_custom_css .='padding-top: '.esc_attr($travel_tourism_button_padding_top_bottom).'; padding-bottom: '.esc_attr($travel_tourism_button_padding_top_bottom).';padding-left: '.esc_attr($travel_tourism_button_padding_left_right).';padding-right: '.esc_attr($travel_tourism_button_padding_left_right).';';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_button_border_radius = get_theme_mod('travel_tourism_button_border_radius');
	if($travel_tourism_button_border_radius != false){
		$travel_tourism_custom_css .='.post-main-box .more-btn a{';
			$travel_tourism_custom_css .='border-radius: '.esc_attr($travel_tourism_button_border_radius).'px;';
		$travel_tourism_custom_css .='}';
	}

	/*-------------- Copyright Alignment ----------------*/

	$travel_tourism_copyright_alingment = get_theme_mod('travel_tourism_copyright_alingment');
	if($travel_tourism_copyright_alingment != false){
		$travel_tourism_custom_css .='.copyright p{';
			$travel_tourism_custom_css .='text-align: '.esc_attr($travel_tourism_copyright_alingment).';';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_copyright_padding_top_bottom = get_theme_mod('travel_tourism_copyright_padding_top_bottom');
	if($travel_tourism_copyright_padding_top_bottom != false){
		$travel_tourism_custom_css .='#footer-2{';
			$travel_tourism_custom_css .='padding-top: '.esc_attr($travel_tourism_copyright_padding_top_bottom).'; padding-bottom: '.esc_attr($travel_tourism_copyright_padding_top_bottom).';';
		$travel_tourism_custom_css .='}';
	}

	/*----------------Sroll to top Settings ------------------*/

	$travel_tourism_scroll_to_top_font_size = get_theme_mod('travel_tourism_scroll_to_top_font_size');
	if($travel_tourism_scroll_to_top_font_size != false){
		$travel_tourism_custom_css .='.scrollup i{';
			$travel_tourism_custom_css .='font-size: '.esc_attr($travel_tourism_scroll_to_top_font_size).';';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_scroll_to_top_padding = get_theme_mod('travel_tourism_scroll_to_top_padding');
	$travel_tourism_scroll_to_top_padding = get_theme_mod('travel_tourism_scroll_to_top_padding');
	if($travel_tourism_scroll_to_top_padding != false){
		$travel_tourism_custom_css .='.scrollup i{';
			$travel_tourism_custom_css .='padding-top: '.esc_attr($travel_tourism_scroll_to_top_padding).';padding-bottom: '.esc_attr($travel_tourism_scroll_to_top_padding).';';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_scroll_to_top_width = get_theme_mod('travel_tourism_scroll_to_top_width');
	if($travel_tourism_scroll_to_top_width != false){
		$travel_tourism_custom_css .='.scrollup i{';
			$travel_tourism_custom_css .='width: '.esc_attr($travel_tourism_scroll_to_top_width).';';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_scroll_to_top_height = get_theme_mod('travel_tourism_scroll_to_top_height');
	if($travel_tourism_scroll_to_top_height != false){
		$travel_tourism_custom_css .='.scrollup i{';
			$travel_tourism_custom_css .='height: '.esc_attr($travel_tourism_scroll_to_top_height).';';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_scroll_to_top_border_radius = get_theme_mod('travel_tourism_scroll_to_top_border_radius');
	if($travel_tourism_scroll_to_top_border_radius != false){
		$travel_tourism_custom_css .='.scrollup i{';
			$travel_tourism_custom_css .='border-radius: '.esc_attr($travel_tourism_scroll_to_top_border_radius).'px;';
		$travel_tourism_custom_css .='}';
	}

	/*----------------Social Icons Settings ------------------*/

	$travel_tourism_social_icon_font_size = get_theme_mod('travel_tourism_social_icon_font_size');
	if($travel_tourism_social_icon_font_size != false){
		$travel_tourism_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$travel_tourism_custom_css .='font-size: '.esc_attr($travel_tourism_social_icon_font_size).';';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_social_icon_padding = get_theme_mod('travel_tourism_social_icon_padding');
	if($travel_tourism_social_icon_padding != false){
		$travel_tourism_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$travel_tourism_custom_css .='padding: '.esc_attr($travel_tourism_social_icon_padding).';';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_social_icon_width = get_theme_mod('travel_tourism_social_icon_width');
	if($travel_tourism_social_icon_width != false){
		$travel_tourism_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$travel_tourism_custom_css .='width: '.esc_attr($travel_tourism_social_icon_width).';';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_social_icon_height = get_theme_mod('travel_tourism_social_icon_height');
	if($travel_tourism_social_icon_height != false){
		$travel_tourism_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$travel_tourism_custom_css .='height: '.esc_attr($travel_tourism_social_icon_height).';';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_social_icon_border_radius = get_theme_mod('travel_tourism_social_icon_border_radius');
	if($travel_tourism_social_icon_border_radius != false){
		$travel_tourism_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$travel_tourism_custom_css .='border-radius: '.esc_attr($travel_tourism_social_icon_border_radius).'px;';
		$travel_tourism_custom_css .='}';
	}

	/*----------------Woocommerce Products Settings ------------------*/

	$travel_tourism_products_padding_top_bottom = get_theme_mod('travel_tourism_products_padding_top_bottom');
	if($travel_tourism_products_padding_top_bottom != false){
		$travel_tourism_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$travel_tourism_custom_css .='padding-top: '.esc_attr($travel_tourism_products_padding_top_bottom).'!important; padding-bottom: '.esc_attr($travel_tourism_products_padding_top_bottom).'!important;';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_products_padding_left_right = get_theme_mod('travel_tourism_products_padding_left_right');
	if($travel_tourism_products_padding_left_right != false){
		$travel_tourism_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$travel_tourism_custom_css .='padding-left: '.esc_attr($travel_tourism_products_padding_left_right).'!important; padding-right: '.esc_attr($travel_tourism_products_padding_left_right).'!important;';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_products_box_shadow = get_theme_mod('travel_tourism_products_box_shadow');
	if($travel_tourism_products_box_shadow != false){
		$travel_tourism_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
				$travel_tourism_custom_css .='box-shadow: '.esc_attr($travel_tourism_products_box_shadow).'px '.esc_attr($travel_tourism_products_box_shadow).'px '.esc_attr($travel_tourism_products_box_shadow).'px #ddd;';
		$travel_tourism_custom_css .='}';
	}

	$travel_tourism_products_border_radius = get_theme_mod('travel_tourism_products_border_radius');
	if($travel_tourism_products_border_radius != false){
		$travel_tourism_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$travel_tourism_custom_css .='border-radius: '.esc_attr($travel_tourism_products_border_radius).'px;';
		$travel_tourism_custom_css .='}';
	}