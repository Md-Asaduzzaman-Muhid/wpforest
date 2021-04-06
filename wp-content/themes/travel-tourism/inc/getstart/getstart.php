<?php
//about theme info
add_action( 'admin_menu', 'travel_tourism_gettingstarted' );
function travel_tourism_gettingstarted() {    	
	add_theme_page( esc_html__('About Travel Tourism', 'travel-tourism'), esc_html__('About Travel Tourism', 'travel-tourism'), 'edit_theme_options', 'travel_tourism_guide', 'travel_tourism_mostrar_guide');   
}

// Add a Custom CSS file to WP Admin Area
function travel_tourism_admin_theme_style() {
   wp_enqueue_style('travel-tourism-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getstart/getstart.css');
   wp_enqueue_script('travel-tourism-tabs', esc_url(get_template_directory_uri()) . '/inc/getstart/js/tab.js');
   wp_enqueue_style( 'font-awesome-css', esc_url(get_template_directory_uri()).'/assets/css/fontawesome-all.css' );
}
add_action('admin_enqueue_scripts', 'travel_tourism_admin_theme_style');

//guidline for about theme
function travel_tourism_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'travel-tourism' );
?>

<div class="wrapper-info">
    <div class="col-left">
    	<h2><?php esc_html_e( 'Welcome to Travel Tourism Theme', 'travel-tourism' ); ?> <span class="version">Version: <?php echo esc_html($theme['Version']);?></span></h2>
    	<p><?php esc_html_e('All our WordPress themes are modern, minimalist, 100% responsive, seo-friendly,feature-rich, and multipurpose that best suit designers, bloggers and other professionals who are working in the creative fields.','travel-tourism'); ?></p>
    </div>
    <div class="col-right">
    	<div class="logo">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/final-logo.png" alt="" />
		</div>
		<div class="update-now">
			<h4><?php esc_html_e('Buy Travel Tourism at 20% Discount','travel-tourism'); ?></h4>
			<h4><?php esc_html_e('Use Coupon','travel-tourism'); ?> ( <span><?php esc_html_e('vwpro20','travel-tourism'); ?></span> ) </h4> 
			<div class="info-link">
				<a href="<?php echo esc_url( TRAVEL_TOURISM_BUY_NOW ); ?>" target="_blank"> <?php esc_html_e( 'Upgrade to Pro', 'travel-tourism' ); ?></a>
			</div>
		</div>
    </div>

    <div class="tab-sec">
		<div class="tab">
			<button class="tablinks" onclick="travel_tourism_open_tab(event, 'gutenberg_editor')"><?php esc_html_e( 'Setup With Gutunberg Block', 'travel-tourism' ); ?></button>	
			<button class="tablinks" onclick="travel_tourism_open_tab(event, 'block_pattern')"><?php esc_html_e( 'Setup With Block Pattern', 'travel-tourism' ); ?></button>
		  	<button class="tablinks" onclick="travel_tourism_open_tab(event, 'lite_theme')"><?php esc_html_e( 'Setup With Customizer', 'travel-tourism' ); ?></button>	
		  	<button class="tablinks" onclick="travel_tourism_open_tab(event, 'travel_tourism_pro')"><?php esc_html_e( 'Get Premium', 'travel-tourism' ); ?></button>
		  	<button class="tablinks" onclick="travel_tourism_open_tab(event, 'free_pro')"><?php esc_html_e( 'Support', 'travel-tourism' ); ?></button>
		</div>

		<!-- Tab content -->

		<?php
			$travel_tourism_plugin_custom_css = '';
			if(class_exists('Ibtana_Visual_Editor_Menu_Class')){
				$travel_tourism_plugin_custom_css ='display: block';
			}
		?>
		<div id="gutenberg_editor" class="tabcontent open">
			<?php if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
			$plugin_ins = Travel_Tourism_Plugin_Activation_Settings::get_instance();
			$travel_tourism_actions = $plugin_ins->recommended_actions;
			?>
				<div class="travel-tourism-recommended-plugins">
				    <div class="travel-tourism-action-list">
				        <?php if ($travel_tourism_actions): foreach ($travel_tourism_actions as $key => $travel_tourism_actionValue): ?>
				                <div class="travel-tourism-action" id="<?php echo esc_attr($travel_tourism_actionValue['id']);?>">
			                        <div class="action-inner plugin-activation-redirect">
			                            <h3 class="action-title"><?php echo esc_html($travel_tourism_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($travel_tourism_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($travel_tourism_actionValue['link']); ?>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php }else{ ?>
				<h3><?php esc_html_e( 'Gutunberg Blocks', 'travel-tourism' ); ?></h3>
				<hr class="h3hr">
				<div class="travel-tourism-pattern-page">
			    	<a href="<?php echo esc_url( admin_url( 'admin.php?page=ibtana-visual-editor-templates' ) ); ?>" class="vw-pattern-page-btn ibtana-dashboard-page-btn button-primary button"><?php esc_html_e('Ibtana Settings','travel-tourism'); ?></a>
			    </div>

			    <div class="link-customizer-with-guternberg-ibtana">
					<h3><?php esc_html_e( 'Link to customizer', 'travel-tourism' ); ?></h3>
					<hr class="h3hr">
					<div class="first-row">
						<div class="row-box">
							<div class="row-box1">
								<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','travel-tourism'); ?></a>
							</div>
							<div class="row-box2">
								<span class="dashicons dashicons-networking"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_social_icon_settings') ); ?>" target="_blank"><?php esc_html_e('Social Icons','travel-tourism'); ?></a>
							</div>
						</div>
						<div class="row-box">
							<div class="row-box1">
								<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Menus','travel-tourism'); ?></a>
							</div>
							
							<div class="row-box2">
								<span class="dashicons dashicons-text-page"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_footer') ); ?>" target="_blank"><?php esc_html_e('Footer Text','travel-tourism'); ?></a>
							</div>
						</div>

						<div class="row-box">
							<div class="row-box1">
								<span class="dashicons dashicons-format-gallery"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_post_settings') ); ?>" target="_blank"><?php esc_html_e('Post settings','travel-tourism'); ?></a>
							</div>
							 <div class="row-box2">
								<span class="dashicons dashicons-align-center"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_woocommerce_section') ); ?>" target="_blank"><?php esc_html_e('WooCommerce Layout','travel-tourism'); ?></a>
							</div> 
						</div>
						
						<div class="row-box">
							<div class="row-box1">
								<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_left_right') ); ?>" target="_blank"><?php esc_html_e('General Settings','travel-tourism'); ?></a>
							</div>
							 <div class="row-box2">
								<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widget','travel-tourism'); ?></a>
							</div> 
						</div>
					</div>
				</div>
			<?php } ?>
		</div>

		<div id="block_pattern" class="tabcontent">
			<?php if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
			$plugin_ins = Travel_Tourism_Plugin_Activation_Settings::get_instance();
			$travel_tourism_actions = $plugin_ins->recommended_actions;
			?>
				<div class="travel-tourism-recommended-plugins">
				    <div class="travel-tourism-action-list">
				        <?php if ($travel_tourism_actions): foreach ($travel_tourism_actions as $key => $travel_tourism_actionValue): ?>
				                <div class="travel-tourism-action" id="<?php echo esc_attr($travel_tourism_actionValue['id']);?>">
			                        <div class="action-inner">
			                            <h3 class="action-title"><?php echo esc_html($travel_tourism_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($travel_tourism_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($travel_tourism_actionValue['link']); ?>
			                            <a class="ibtana-skip-btn" href="javascript:void(0);" get-start-tab-id="gutenberg-editor-tab"><?php esc_html_e('Skip','travel-tourism'); ?></a>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php } ?>
			<div class="gutenberg-editor-tab" style="<?php echo esc_attr($travel_tourism_plugin_custom_css); ?>">
				<div class="block-pattern-img">
				  	<h3><?php esc_html_e( 'Block Patterns', 'travel-tourism' ); ?></h3>
					<hr class="h3hr">
					<p><?php esc_html_e('Follow the below instructions to setup Home page with Block Patterns.','travel-tourism'); ?></p>
	              	<p><b><?php esc_html_e('Click on Below Add new page button >> Click on "+" Icon >> Click Pattern Tab >> Click on homepage sections >> Publish.','travel-tourism'); ?></span></b></p>
	              	<div class="travel-tourism-pattern-page">
				    	<a href="javascript:void(0)" class="vw-pattern-page-btn button-primary button"><?php esc_html_e('Add New Page','travel-tourism'); ?></a>
				    </div>
	              	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/block-pattern.png" alt="" />	
	            </div>

	            <div class="block-pattern-link-customizer">
	              	<div class="link-customizer-with-block-pattern">
							<h3><?php esc_html_e( 'Link to customizer', 'travel-tourism' ); ?></h3>
							<hr class="h3hr">
							<div class="first-row">
								<div class="row-box">
									<div class="row-box1">
										<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','travel-tourism'); ?></a>
									</div>
									<div class="row-box2">
										<span class="dashicons dashicons-networking"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_social_icon_settings') ); ?>" target="_blank"><?php esc_html_e('Social Icons','travel-tourism'); ?></a>
									</div>
								</div>
								<div class="row-box">
									<div class="row-box1">
										<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Menus','travel-tourism'); ?></a>
									</div>
									
									<div class="row-box2">
										<span class="dashicons dashicons-text-page"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_footer') ); ?>" target="_blank"><?php esc_html_e('Footer Text','travel-tourism'); ?></a>
									</div>
								</div>

								<div class="row-box">
									<div class="row-box1">
										<span class="dashicons dashicons-format-gallery"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_post_settings') ); ?>" target="_blank"><?php esc_html_e('Post settings','travel-tourism'); ?></a>
									</div>
									 <div class="row-box2">
										<span class="dashicons dashicons-align-center"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_woocommerce_section') ); ?>" target="_blank"><?php esc_html_e('WooCommerce Layout','travel-tourism'); ?></a>
									</div> 
								</div>
								
								<div class="row-box">
									<div class="row-box1">
										<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_left_right') ); ?>" target="_blank"><?php esc_html_e('General Settings','travel-tourism'); ?></a>
									</div>
									 <div class="row-box2">
										<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widget','travel-tourism'); ?></a>
									</div> 
								</div>
							</div>
					</div>	
				</div>

	        </div>
		</div>

		<div id="lite_theme" class="tabcontent">
			<?php if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
				$plugin_ins = Travel_Tourism_Plugin_Activation_Settings::get_instance();
				$travel_tourism_actions = $plugin_ins->recommended_actions;
				?>
				<div class="travel-tourism-recommended-plugins">
				    <div class="travel-tourism-action-list">
				        <?php if ($travel_tourism_actions): foreach ($travel_tourism_actions as $key => $travel_tourism_actionValue): ?>
				                <div class="travel-tourism-action" id="<?php echo esc_attr($travel_tourism_actionValue['id']);?>">
			                        <div class="action-inner">
			                            <h3 class="action-title"><?php echo esc_html($travel_tourism_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($travel_tourism_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($travel_tourism_actionValue['link']); ?>
			                            <a class="ibtana-skip-btn" get-start-tab-id="lite-theme-tab" href="javascript:void(0);"><?php esc_html_e('Skip','travel-tourism'); ?></a>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php } ?>
			<div class="lite-theme-tab" style="<?php echo esc_attr($travel_tourism_plugin_custom_css); ?>">
				<h3><?php esc_html_e( 'Lite Theme Information', 'travel-tourism' ); ?></h3>
				<hr class="h3hr">
			  	<p><?php esc_html_e('Free Travel Agency WordPress Theme serves as a fantastic tool for creating top-notch and user-friendly tours and travel agency websites with a minimum investment of time, money, and efforts. This wonderful theme allows you to design your own website by providing the options to tweak. It supports both, the web designing experts as well the novices who are looking to build their website without any assistance. There are some of the best navigation features for keeping the interest of your visitors alive. To make sure that you dont get stuck somewhere while designing your site, it is furnished with well-written theme documentation that explains everything right from installation, setup, and theme features. There are a lot of standard features included that come handy while you design a web page. The theme comes with a header with space for uploading the customized logo of your travel agency.','travel-tourism'); ?></p>
			  	<div class="col-left-inner">
			  		<h4><?php esc_html_e( 'Theme Documentation', 'travel-tourism' ); ?></h4>
					<p><?php esc_html_e( 'If you need any assistance regarding setting up and configuring the Theme, our documentation is there.', 'travel-tourism' ); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( TRAVEL_TOURISM_FREE_THEME_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'travel-tourism' ); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Theme Customizer', 'travel-tourism'); ?></h4>
					<p> <?php esc_html_e('To begin customizing your website, start by clicking "Customize".', 'travel-tourism'); ?></p>
					<div class="info-link">
						<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customizing', 'travel-tourism'); ?></a>
					</div>
					<hr>				
					<h4><?php esc_html_e('Having Trouble, Need Support?', 'travel-tourism'); ?></h4>
					<p> <?php esc_html_e('Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme.', 'travel-tourism'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( TRAVEL_TOURISM_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'travel-tourism'); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Reviews & Testimonials', 'travel-tourism'); ?></h4>
					<p> <?php esc_html_e('All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'travel-tourism'); ?>  </p>
					<div class="info-link">
						<a href="<?php echo esc_url( TRAVEL_TOURISM_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'travel-tourism'); ?></a>
					</div>
			  		<div class="link-customizer">
						<h3><?php esc_html_e( 'Link to customizer', 'travel-tourism' ); ?></h3>
						<hr class="h3hr">
						<div class="first-row">
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','travel-tourism'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-slides"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_slidersettings') ); ?>" target="_blank"><?php esc_html_e('Slider Settings','travel-tourism'); ?></a>
								</div>
							</div>
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-align-center"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_top_header') ); ?>" target="_blank"><?php esc_html_e('Top Header Settings','travel-tourism'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-editor-table"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_services') ); ?>" target="_blank"><?php esc_html_e('Popular Destination','travel-tourism'); ?></a>
								</div>
							</div>
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Menus','travel-tourism'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widget','travel-tourism'); ?></a>
								</div>
							</div>

							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-format-gallery"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_post_settings') ); ?>" target="_blank"><?php esc_html_e('Post settings','travel-tourism'); ?></a>
								</div>
								 <div class="row-box2">
									<span class="dashicons dashicons-align-center"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_woocommerce_section') ); ?>" target="_blank"><?php esc_html_e('WooCommerce Layout','travel-tourism'); ?></a>
								</div> 
							</div>
							
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_left_right') ); ?>" target="_blank"><?php esc_html_e('General Settings','travel-tourism'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-text-page"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=travel_tourism_footer') ); ?>" target="_blank"><?php esc_html_e('Footer Text','travel-tourism'); ?></a>
								</div>
							</div>
						</div>
					</div>
			  	</div>
				<div class="col-right-inner">
					<h3 class="page-template"><?php esc_html_e('How to set up Home Page Template','travel-tourism'); ?></h3>
				  	<hr class="h3hr">
					<p><?php esc_html_e('Follow these instructions to setup Home page.','travel-tourism'); ?></p>
	                <ul>
	                  	<p><span class="strong"><?php esc_html_e('1. Create a new page :','travel-tourism'); ?></span><?php esc_html_e(' Go to ','travel-tourism'); ?>
					  	<b><?php esc_html_e(' Dashboard >> Pages >> Add New Page','travel-tourism'); ?></b></p>

	                  	<p><?php esc_html_e('Name it as "Home" then select the template "Custom Home Page".','travel-tourism'); ?></p>
	                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/home-page-template.png" alt="" />
	                  	<p><span class="strong"><?php esc_html_e('2. Set the front page:','travel-tourism'); ?></span><?php esc_html_e(' Go to ','travel-tourism'); ?>
					  	<b><?php esc_html_e(' Settings >> Reading ','travel-tourism'); ?></b></p>
					  	<p><?php esc_html_e('Select the option of Static Page, now select the page you created to be the homepage, while another page to be your default page.','travel-tourism'); ?></p>
	                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/set-front-page.png" alt="" />
	                  	<p><?php esc_html_e(' Once you are done with this, then follow the','travel-tourism'); ?> <a class="doc-links" href="https://www.vwthemesdemo.com/docs/free-travel-tourism/" target="_blank"><?php esc_html_e('Documentation','travel-tourism'); ?></a></p>
	                </ul>
			  	</div>
			</div>
		</div>	
		
		<div id="travel_tourism_pro" class="tabcontent">
		  	<h3><?php esc_html_e( 'Premium Theme Information', 'travel-tourism' ); ?></h3>
			<hr class="h3hr">
		    <div class="col-left-pro">
		    	<p><?php esc_html_e('This Travel Agency WordPress Theme comes with a super attractive design that never fails to catch the eye of your visitors. Considering the fact that tours and travel businesses often attract visitors by displaying the beautiful pictures of tourist destinations across the world. For this, your site needs to be alluring. This theme does an exceptional job when it comes to getting enticing websites for your tours and travel company or any business related to travel and tourism. WP Travel Agency WordPress Theme comes with an out of the box design that looks different from any other website. Its revolution slider shows a spectacular display of images related to your services and tourist destinations. There are settings provided for the slider and a number of Call To Action (CTA) buttons that will guide the visitors. It has many unique features that will make all the other themes appear obsolete in front of it.','travel-tourism'); ?></p>
		    	<div class="pro-links">
			    	<a href="<?php echo esc_url( TRAVEL_TOURISM_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'travel-tourism'); ?></a>
					<a href="<?php echo esc_url( TRAVEL_TOURISM_BUY_NOW ); ?>"><?php esc_html_e('Buy Pro', 'travel-tourism'); ?></a>
					<a href="<?php echo esc_url( TRAVEL_TOURISM_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'travel-tourism'); ?></a>
				</div>
		    </div>
		    <div class="col-right-pro">
		    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/responsive.png" alt="" />
		    </div>
		    <div class="featurebox">
			    <h3><?php esc_html_e( 'Theme Features', 'travel-tourism' ); ?></h3>
				<hr class="h3hr">
				<div class="table-image">
					<table class="tablebox">
						<thead>
							<tr>
								<th></th>
								<th><?php esc_html_e('Free Themes', 'travel-tourism'); ?></th>
								<th><?php esc_html_e('Premium Themes', 'travel-tourism'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php esc_html_e('Theme Customization', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Responsive Design', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Logo Upload', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Social Media Links', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Slider Settings', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Number of Slides', 'travel-tourism'); ?></td>
								<td class="table-img"><?php esc_html_e('4', 'travel-tourism'); ?></td>
								<td class="table-img"><?php esc_html_e('Unlimited', 'travel-tourism'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Template Pages', 'travel-tourism'); ?></td>
								<td class="table-img"><?php esc_html_e('3', 'travel-tourism'); ?></td>
								<td class="table-img"><?php esc_html_e('6', 'travel-tourism'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Home Page Template', 'travel-tourism'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'travel-tourism'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'travel-tourism'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Theme sections', 'travel-tourism'); ?></td>
								<td class="table-img"><?php esc_html_e('2', 'travel-tourism'); ?></td>
								<td class="table-img"><?php esc_html_e('14', 'travel-tourism'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Contact us Page Template', 'travel-tourism'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('1', 'travel-tourism'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Blog Templates & Layout', 'travel-tourism'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('3(Full width/Left/Right Sidebar)', 'travel-tourism'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Page Templates & Layout', 'travel-tourism'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('2(Left/Right Sidebar)', 'travel-tourism'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Color Pallete For Particular Sections', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Global Color Option', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Reordering', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Demo Importer', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Allow To Set Site Title, Tagline, Logo', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Enable Disable Options On All Sections, Logo', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Full Documentation', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Latest WordPress Compatibility', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Woo-Commerce Compatibility', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Support 3rd Party Plugins', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Secure and Optimized Code', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Exclusive Functionalities', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Enable / Disable', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Section Google Font Choices', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Gallery', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Simple & Mega Menu Option', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Support to add custom CSS / JS ', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Shortcodes', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Background, Colors, Header, Logo & Menu', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Premium Membership', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Budget Friendly Value', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Priority Error Fixing', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Feature Addition', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('All Access Theme Pass', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Seamless Customer Support', 'travel-tourism'); ?></td>
								<td class="table-img"><i class="fas fa-times"></i></td>
								<td class="table-img"><i class="fas fa-check"></i></td>
							</tr>
							<tr>
								<td></td>
								<td class="table-img"></td>
								<td class="update-link"><a href="<?php echo esc_url( TRAVEL_TOURISM_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade to Pro', 'travel-tourism'); ?></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div id="free_pro" class="tabcontent">
		  	<div class="col-3">
		  		<h4><span class="dashicons dashicons-star-filled"></span><?php esc_html_e('Pro Version', 'travel-tourism'); ?></h4>
				<p> <?php esc_html_e('To gain access to extra theme options and more interesting features, upgrade to pro version.', 'travel-tourism'); ?></p>
				<div class="info-link">
					<a href="<?php echo esc_url( TRAVEL_TOURISM_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Get Pro', 'travel-tourism'); ?></a>
				</div>
		  	</div>
		  	<div class="col-3">
		  		<h4><span class="dashicons dashicons-cart"></span><?php esc_html_e('Pre-purchase Queries', 'travel-tourism'); ?></h4>
				<p> <?php esc_html_e('If you have any pre-sale query, we are prepared to resolve it.', 'travel-tourism'); ?></p>
				<div class="info-link">
					<a href="<?php echo esc_url( TRAVEL_TOURISM_CONTACT ); ?>" target="_blank"><?php esc_html_e('Question', 'travel-tourism'); ?></a>
				</div>
		  	</div>
		  	<div class="col-3">		  		
		  		<h4><span class="dashicons dashicons-admin-customizer"></span><?php esc_html_e('Child Theme', 'travel-tourism'); ?></h4>
				<p> <?php esc_html_e('For theme file customizations, make modifications in the child theme and not in the main theme file.', 'travel-tourism'); ?></p>
				<div class="info-link">
					<a href="<?php echo esc_url( TRAVEL_TOURISM_CHILD_THEME ); ?>" target="_blank"><?php esc_html_e('About Child Theme', 'travel-tourism'); ?></a>
				</div>
		  	</div>

		  	<div class="col-3">
		  		<h4><span class="dashicons dashicons-admin-comments"></span><?php esc_html_e('Frequently Asked Questions', 'travel-tourism'); ?></h4>
				<p> <?php esc_html_e('We have gathered top most, frequently asked questions and answered them for your easy understanding. We will list down more as we get new challenging queries. Check back often.', 'travel-tourism'); ?></p>
				<div class="info-link">
					<a href="<?php echo esc_url( TRAVEL_TOURISM_FAQ ); ?>" target="_blank"><?php esc_html_e('View FAQ','travel-tourism'); ?></a>
				</div>
		  	</div>

		  	<div class="col-3">
		  		<h4><span class="dashicons dashicons-sos"></span><?php esc_html_e('Support Queries', 'travel-tourism'); ?></h4>
				<p> <?php esc_html_e('If you have any queries after purchase, you can contact us. We are eveready to help you out.', 'travel-tourism'); ?></p>
				<div class="info-link">
					<a href="<?php echo esc_url( TRAVEL_TOURISM_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Contact Us', 'travel-tourism'); ?></a>
				</div>
		  	</div>
		</div>
	</div>
</div>
<?php } ?>