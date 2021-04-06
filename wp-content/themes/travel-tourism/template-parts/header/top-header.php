<?php
/**
 * The template part for top header
 *
 * @package Travel Tourism 
 * @subpackage travel-tourism
 * @since travel-tourism 1.0
 */
?>

<div class="top-bar">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8">
        <div class="row">
          <div class="col-lg-4 col-md-4">
            <?php if( get_theme_mod( 'travel_tourism_phone_number') != '') { ?>
              <p><i class="fas fa-phone-volume"></i><a href="tel:<?php echo esc_url( get_theme_mod('travel_tourism_phone_number','') ); ?>"><?php echo esc_html(get_theme_mod('travel_tourism_phone_number',''));?></a></p>
            <?php } ?>
          </div>
          <div class="col-lg-4 col-md-4">
            <?php if( get_theme_mod( 'travel_tourism_email_address') != '') { ?>
              <p><i class="fas fa-envelope"></i><a href="mailto:<?php echo esc_html(get_theme_mod('travel_tourism_email_address',''));?>"><?php echo esc_html(get_theme_mod('travel_tourism_email_address',''));?></a></p>
            <?php } ?>
          </div>
          <div class="col-lg-4 col-md-4">
            <?php if( get_theme_mod( 'travel_tourism_opening_time') != '') { ?>
              <p><i class="fas fa-clock"></i><?php echo esc_html(get_theme_mod('travel_tourism_opening_time',''));?></p>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <?php dynamic_sidebar('social-links'); ?>
      </div>
    </div>
  </div>
</div>