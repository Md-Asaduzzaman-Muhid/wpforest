<?php
/**
 * Template Name: Custom Home Page
 */

get_header(); ?>

<main id="maincontent" role="main">  
  <?php do_action( 'travel_tourism_before_slider' ); ?>

  <?php if( get_theme_mod( 'travel_tourism_slider_arrows', false) != '' || get_theme_mod( 'travel_tourism_resp_slider_hide_show', false) != '') { ?>
    <section id="slider">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="<?php echo esc_attr(get_theme_mod( 'travel_tourism_slider_speed',3000)) ?>"> 
        <?php $travel_tourism_pages = array();
          for ( $count = 1; $count <= 4; $count++ ) {
            $mod = intval( get_theme_mod( 'travel_tourism_slider_page' . $count ));
            if ( 'page-none-selected' != $mod ) {
              $travel_tourism_pages[] = $mod;
            }
          }
          if( !empty($travel_tourism_pages) ) :
            $args = array(
              'post_type' => 'page',
              'post__in' => $travel_tourism_pages,
              'orderby' => 'post__in'
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              $i = 1;
        ?>     
        <div class="carousel-inner" role="listbox">
          <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
              <?php the_post_thumbnail(); ?>
              <div class="carousel-caption">
                <div class="inner_carousel">
                  <h1><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                  <p><?php $excerpt = get_the_excerpt(); echo esc_html( travel_tourism_string_limit_words( $excerpt, esc_attr(get_theme_mod('travel_tourism_slider_excerpt_number','8')))); ?></p>
                  <?php if( get_theme_mod('travel_tourism_slider_button_text','READ MORE') != ''){ ?>
                    <div class="more-btn">
                      <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_theme_mod('travel_tourism_slider_button_text',__('READ MORE','travel-tourism')));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('travel_tourism_slider_button_text',__('READ MORE','travel-tourism')));?></span></a>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php $i++; endwhile; 
          wp_reset_postdata();?>
        </div>
        <?php else : ?>
            <div class="no-postfound"></div>
        <?php endif;
        endif;?>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-long-arrow-alt-left"></i></span>
          <span class="screen-reader-text"><?php esc_html_e( 'Previous','travel-tourism' );?></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-long-arrow-alt-right"></i></span>
          <span class="screen-reader-text"><?php esc_html_e( 'Next','travel-tourism' );?></span>
        </a>
      </div>
      <div class="clearfix"></div>
    </section>
  <?php }?>

  <?php do_action( 'travel_tourism_after_slider' ); ?>

  <?php if( get_theme_mod('travel_tourism_services_category') != '' ){ ?>

  <section id="services-sec">
    <div class="container">
      <div class="heading-text pb-3 text-center">
        <span><i class="fas fa-plane"></i></span>
        <?php if( get_theme_mod( 'travel_tourism_section_text') != '') { ?>
          <p class="sec-text"><?php echo esc_html(get_theme_mod('travel_tourism_section_text',''));?></p>
        <?php } ?>
        <?php if( get_theme_mod( 'travel_tourism_section_title') != '') { ?>
          <h2><?php echo esc_html(get_theme_mod('travel_tourism_section_title',''));?></h2>
        <?php } ?>
      </div>
      <div class="owl-carousel">
        <?php 
          $travel_tourism_catData = get_theme_mod('travel_tourism_services_category');
          if($travel_tourism_catData){
          $page_query = new WP_Query(array( 'category_name' => esc_html( $travel_tourism_catData ,'travel-tourism')));?>
          <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
            <div class="inner-box">
              <div class="imagebox">
                <?php the_post_thumbnail(); ?>
              </div>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            </div>
            <?php endwhile; 
            wp_reset_postdata();
          }
          ?>
      </div>
    </div>
  </section>

  <?php }?>

  <?php do_action( 'travel_tourism_after_service' ); ?>

  <div id="content-vw">
    <div class="container">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>