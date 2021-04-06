<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Travel Tourism
 */

get_header(); ?>

<div class="container">
	<main id="maincontent" role="main">
		<div class="page-content">
	    	<h1><?php echo esc_html(get_theme_mod('travel_tourism_404_page_title',__('404 Not Found','travel-tourism')));?></h1>
			<p class="text-404"><?php echo esc_html(get_theme_mod('travel_tourism_404_page_content',__('Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.','travel-tourism')));?></p>
			<?php if( get_theme_mod('travel_tourism_404_page_button_text','GO BACK') != ''){ ?>
				<div class="more-btn">
				    <a href="<?php echo esc_url(home_url()); ?>"><?php echo esc_html(get_theme_mod('travel_tourism_404_page_button_text',__('GO BACK','travel-tourism')));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('travel_tourism_404_page_button_text',__('GO BACK','travel-tourism')));?></span></a>
				</div>
			<?php } ?>
		</div>
		<div class="clearfix"></div>
	</main>
</div>

<?php get_footer(); ?>