<?php
/**
 * The template part for header
 *
 * @package Travel Tourism 
 * @subpackage travel-tourism
 * @since travel-tourism 1.0
 */
?>

<div id="header" class="menubar">	
  <div class="toggle-nav mobile-menu">
    <?php if(has_nav_menu('responsive')){?>
      <button role="tab" onclick="travel_tourism_menu_open_nav()" class="responsivetoggle"><i class="<?php echo esc_attr(get_theme_mod('travel_tourism_res_menu_open_icon','fas fa-bars')); ?>"></i><span class="screen-reader-text"><?php esc_html_e('Open Button','travel-tourism'); ?></span></button>
    <?php } ?>
  </div>
  <div class="responsive-menu">
    <div id="mySidenav" class="nav sidenav">
      <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'travel-tourism' ); ?>">
        <?php 
          if(has_nav_menu('responsive')){
            wp_nav_menu( array( 
              'theme_location' => 'responsive',
              'container_class' => 'main-menu clearfix' ,
              'menu_class' => 'clearfix',
              'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
              'fallback_cb' => 'wp_page_menu',
            ) ); 
          }
        ?>
        <a href="javascript:void(0)" class="closebtn mobile-menu" onclick="travel_tourism_menu_close_nav()"><i class="<?php echo esc_attr(get_theme_mod('travel_tourism_res_menu_close_icon','fas fa-times')); ?>"></i><span class="screen-reader-text"><?php esc_html_e('Close Button','travel-tourism'); ?></span></a>
      </nav>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-md-5">
        <div id="mySidenav" class="nav sidenav left-menu">
          <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'travel-tourism' ); ?>">
            <?php 
              if(has_nav_menu('primary-left')){
                wp_nav_menu( array( 
                  'theme_location' => 'primary-left',
                  'container_class' => 'main-menu clearfix' ,
                  'menu_class' => 'clearfix',
                  'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
                  'fallback_cb' => 'wp_page_menu',
                ) ); 
              }
            ?>
          </nav>
        </div>
      </div>
      <div class="col-lg-2 col-md-12 col-12">
        <div class="logo">
          <?php if ( has_custom_logo() ) : ?>
            <div class="site-logo"><?php the_custom_logo(); ?></div>
          <?php endif; ?>
          <?php $blog_info = get_bloginfo( 'name' ); ?>
            <?php if ( ! empty( $blog_info ) ) : ?>
              <?php if ( is_front_page() && is_home() ) : ?>
                <?php if( get_theme_mod('travel_tourism_logo_title_hide_show',true) != ''){ ?>
                  <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php } ?>
              <?php else : ?>
                <?php if( get_theme_mod('travel_tourism_logo_title_hide_show',true) != ''){ ?>
                  <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php } ?>
              <?php endif; ?>
            <?php endif; ?>
            <?php
              $description = get_bloginfo( 'description', 'display' );
              if ( $description || is_customize_preview() ) :
            ?>
            <?php if( get_theme_mod('travel_tourism_tagline_hide_show',true) != ''){ ?>
              <p class="site-description">
                <?php echo esc_html($description); ?>
              </p>
            <?php } ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-5 col-md-5">
        <div id="mySidenav" class="nav sidenav right-menu">
          <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'travel-tourism' ); ?>">
            <?php 
              if(has_nav_menu('primary-right')){
                wp_nav_menu( array( 
                  'theme_location' => 'primary-right',
                  'container_class' => 'main-menu clearfix' ,
                  'menu_class' => 'clearfix',
                  'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
                  'fallback_cb' => 'wp_page_menu',
                ) ); 
              }
            ?>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>