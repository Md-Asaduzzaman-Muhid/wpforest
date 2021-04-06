<?php
  class Ibtana_visual_editor_pro_postControl{
    function __construct(){
      add_action('init', array($this, 'post_slider_layout_register_post_grid'));
      add_action( 'init', array($this,'gutenberg_my_block_init') );
      add_action('rest_api_init', array($this,'post_slider_layout_register_rest_fields'));
      add_action('after_setup_theme', array($this, 'post_slider_layout_image_sizes'));
    }
    private static $instance;

    /**
    * Initiator
    */
    public static function get_instance() {
      if ( ! isset( self::$instance ) ) {
        self::$instance = new self();
      }
      return self::$instance;
    }

    public function Ibtana_visual_editor_pro_init(){
    }

    function get_post_slider_layout_featured_media($object){

      $objFeatured_media = isset($object['featured_media']) ? $object['featured_media'] : 0;

      $featured_media = wp_get_attachment_image_src($objFeatured_media, 'full', false);

      return array(
        'thumbnail' => is_array($featured_media) ? wp_get_attachment_image_src(
          $objFeatured_media,
          'thumbnail',
          false
        ) : '',
        'post_slider_layout_landscape_large' => is_array($featured_media) ? wp_get_attachment_image_src(
          $objFeatured_media,
          'post_slider_layout_landscape_large',
          false
        ) : '',
        'post_slider_layout_portrait_large' => is_array($featured_media) ? wp_get_attachment_image_src(
          $objFeatured_media,
          'post_slider_layout_portrait_large',
          false
        ) : '',
        'post_slider_layout_square_large' => is_array($featured_media) ? wp_get_attachment_image_src(
          $objFeatured_media,
          'post_slider_layout_square_large',
          false
        ) : '',
        'post_slider_layout_landscape' => is_array($featured_media) ? wp_get_attachment_image_src(
          $objFeatured_media,
          'post_slider_layout_landscape',
          false
        ) : '',
        'post_slider_layout_portrait' => is_array($featured_media) ? wp_get_attachment_image_src(
          $objFeatured_media,
          'post_slider_layout_portrait',
          false
        ) : '',
        'post_slider_layout_square' => is_array($featured_media) ? wp_get_attachment_image_src(
          $objFeatured_media,
          'post_slider_layout_square',
          false
        ) : '',
        'full' => is_array($featured_media) ? $featured_media : '',
      );
    }

    function post_slider_layout_image_sizes(){
      add_image_size('post_slider_layout_landscape_large', 1200, 800, true);
      add_image_size('post_slider_layout_portrait_large', 1200, 1800, true);
      add_image_size('post_slider_layout_square_large', 1200, 1200, true);
      add_image_size('post_slider_layout_landscape', 600, 400, true);
      add_image_size('post_slider_layout_portrait', 600, 900, true);
      add_image_size('post_slider_layout_square', 600, 600, true);
    }

    function post_slider_layout_register_rest_fields(){
      $post_types = get_post_types();
      register_rest_field(
        $post_types,
        'post_slider_layout_featured_media_urls',
        array(
          'get_callback' => array($this, 'get_post_slider_layout_featured_media'),
          'update_callback' => null,
          'schema' => array(
            'description' => __('Different Sized Featured Images', 'post-slider-layout'),
            'type' => 'array'
          )
        )
      );
    }

    function post_slider_layout_register_post_grid(){
      if (!function_exists('register_block_type')) {
        return;
      }

      $ive_options = array(
        'admin_url' => admin_url(),
      );
      wp_localize_script('wp-blocks', 'ive_product_option', $ive_options );


      register_block_type('ive/ive-productscarousel', array(
        'editor_script' => 'wp-blocks',
        'attributes' => array(
          'postBlockWidth' => array(
            'type' => 'string',
            'default' => 'center'
          ),
          'align' => array(
            'type' => 'string',
            'default' => 'left',
          ),
          'post_type' => array(
            'type' => 'string',
            'default' => 'post'
          ),
          'categories' => array(
            'type' => 'string',
          ),
          'postcategories' => array(
            'type' => 'string',
          ),
          'team_cats' => array(
            'type' => 'string',
          ),
          'postscount' => array(
            'type' => 'number',
            'default' => 5,
          ),
          'order' => array(
            'type' => 'string',
            'default' => 'desc',
          ),
          'orderBy'  => array(
            'type' => 'string',
            'default' => 'date',
          ),
          'columns' => array(
            'type' => 'number',
            'default' => 2
          ),
          'columnGap' => array(
            'type' => 'number',
            'default' => 15
          ),
          'postLayout' => array(
            'type' => 'string',
            'default' => 'grid',
          ),
          'layoutType' => array(
            'type' => 'array',
            'default' => ['column', 'column', 'column']
          ),
          'carouselLayoutStyle' => array(
            'type' => 'string',
            'default' => 'skin1',
          ),
          'slidesToShow' => array(
            'type' => 'number',
            'default' => 2,
          ),
          'deskslideItems' => array(
            'type' => 'number',
            'default' => 3,
          ),
          'tabslideItems' => array(
            'type' => 'number',
            'default' => 2,
          ),
          'mobslideItems' => array(
            'type' => 'number',
            'default' => 1,
          ),
          'slideMargin' => array(
            'type' => 'number',
            'default' => 3,
          ),
          'autoPlay' => array(
            'type' => 'boolean',
            'default' => true
          ),
          'slideLoop'=>array(
            'type' => 'boolean',
            'default' => true
          ),
          'mouseDrag'=>array(
            'type' => 'boolean',
            'default' => true
          ),
          'overlayContent'=>array(
            'type' => 'boolean',
            'default' => true
          ),
          'overlayTop'=> array(
            'type' => 'number',
            'default' => 0,
          ),
          'uniqueID'=> array(
            'type'=> 'string',
            'default'=> '',
          ),
          'isSlider'=>array(
            'type' => 'boolean',
            'default' => true
          ),
          'navigation' => array(
            'type' => 'array',
            'default' => [ 'none', 'none', 'none' ]
          ),
          'gridLayoutStyle' => array(
            'type' => 'string',
            'default' => 'g_skin1',
          ),
          'postImageSizes' => array(
            'type' => 'string',
            'default' => 'full',
          ),
          'displayPostTitle' => array(
            'type' => 'array',
            'default' => [ 'true', 'true', 'true' ]
          ),
          'displayPostImage' => array(
            'type' => 'array',
            'default' => [ 'true', 'true', 'true' ]
          ),
          'displayPostDate' => array(
            'type' => 'array',
            'default' => [ 'false', 'false', 'false' ]
          ),
          'displayPostDateIcon' => array(
            'type' => 'array',
            'default' => [ 'false', 'false', 'false' ]
          ),
          'displayComment' => array(
            'type' => 'array',
            'default' => [ 'false', 'false', 'false' ]
          ),
          'displayCommentIcon' => array(
            'type' => 'array',
            'default' => [ 'false', 'false', 'false' ]
          ),
          'displayCommentText' => array(
            'type' => 'array',
            'default' => [ 'false', 'false', 'false' ]
          ),
          'CommentText' => array(
            'type' => 'string',
            'default' => 'Comment'
          ),
          'displayPostAuthor' => array(
            'type' => 'array',
            'default' => [ 'false', 'false', 'false' ]
          ),
          'displayPostAuthorIcon' => array(
            'type' => 'array',
            'default' => [ 'false', 'false', 'false' ]
          ),
          'displayPostExcerpt' => array(
            'type' => 'array',
            'default' => [ 'true', 'true', 'true' ]
          ),
          'displayProductExcerpt' => array(
            'type' => 'array',
            'default' => [ 'true', 'true', 'true' ]
          ),
          'displayProductSaleBadge' => array(
            'type' => 'array',
            'default' => [ 'true', 'true', 'true' ]
          ),
          'displayPostReadMoreButton' => array(
            'type' => 'array',
            'default' => [ 'true', 'true', 'true' ]
          ),
          'postReadMoreButtonText' => array(
            'type' => 'string',
            'default' => 'Read More',
          ),
          'postCurrency' => array(
            'type' => 'string',
            'default' => $this->show_currency_symbol(),
          ),
          'nameColor' => array(
            'type' => 'string',
            'default' => 'black',
          ),
          'nameHoverColor' => array(
            'type' => 'string',
            'default' => 'black',
          ),
          'contentColor' => array(
            'type' => 'string',
            'default' => 'black',
          ),
          'postMetaTextColor' => array(
            'type' => 'string',
            'default' => 'black'
          ),
          'postMetaIconColor' => array(
            'type' => 'string',
            'default' => '#222222'
          ),
          'postDateFormat' => array(
            'type' => 'string',
            'default' => 'd F Y'
          ),
          'priceColor' => array(
            'type' => 'string',
            'default' => 'black',
          ),
          'priceHoverColor'=> array(
            'type' => 'string',
            'default' => 'black',
          ),
          'contentBackgroundColor' => array(
            'type' => 'string',
            'default' => '#ffffff',
          ),
          'cartButton' => array(
            'type' => 'array',
            'default' => [ 'true', 'true', 'true' ],
          ),
          'contentOpacity'=> array(
            'type' => 'number',
            'default' => 0,
          ),
          'cartBackgroundColor' => array(
            'type' => 'string',
            'default' => '#f7f7f7',
          ),
          'cartBackgroundHovColor' => array(
            'type' => 'string',
            'default' => '#ffffff',
          ),
          'cartTextColor' => array(
            'type' => 'string',
            'default' => 'black',
          ),
          'cartTextHoverColor' => array(
            'type' => 'string',
            'default' => 'black',
          ),
          'cartIconColor' => array(
            'type' => 'string',
            'default' => 'black',
          ),
          'cartIconHoverColor' => array(
            'type' => 'string',
            'default' => 'black',
          ),
          'cartBorderColor' => array(
            'type' => 'string',
            'default' => 'black',
          ),
          'cartBorderRadius' => array(
            'type' => 'number',
            'default' => 0
          ),
          'cartFontSizemob' => array(
            'type' => 'number',
            'default' => 14,
          ),
          'cartFontSizetab' => array(
            'type' => 'number',
            'default' => 16,
          ),
          'cartFontSizedesk' => array(
            'type' => 'number',
            'default' => 18,
          ),
          'contentFontSizemob' => array(
            'type' => 'number',
            'default' => 14,
          ),
          'contentFontSizetab' => array(
            'type' => 'number',
            'default' => 16,
          ),
          'contentFontSizedesk' => array(
            'type' => 'number',
            'default' => 18,
          ),
          'titleFontSizemob' => array(
            'type' => 'number',
            'default' => 14,
          ),
          'titleFontSizetab' => array(
            'type' => 'number',
            'default' => 16,
          ),
          'titleFontSizedesk' => array(
            'type' => 'number',
            'default' => 18,
          ),
          'mobcartButtonPadding' => array(
            'type' => 'number',
            'default' => 10,
          ),
          'mobcartButtonPadding2' => array(
            'type' => 'number',
            'default' => 10,
          ),
          'tabcartButtonPadding' => array(
            'type' => 'number',
            'default' => 10,
          ),
          'tabcartButtonPadding2' => array(
            'type' => 'number',
            'default' => 10,
          ),
          'deskcartButtonPadding' => array(
            'type' => 'number',
            'default' => 10,
          ),
          'deskcartButtonPadding2' => array(
            'type' => 'number',
            'default' => 10,
          ),
          'cartButtonPaddingControl' => array(
            'type' => 'string',
            'default' => 'linked',
          ),
          'letterSpacing' => array(
            'type' => 'number'
          ),
          'typography' => array(
            'type' => 'string',
            'default' => ''
          ),
          'googleFont' => array(
            'type' => 'boolean',
            'default' => false
          ),
          'loadGoogleFont' => array(
            'type' => 'boolean',
            'default' => true
          ),
          'fontSubset' => array(
            'type' => 'string',
            'default' => ''
          ),
          'fontVariant' => array(
            'type' => 'string',
            'default' => ''
          ),
          'fontWeight' => array(
            'type' => 'string',
            'default' => '400'
          ),
          'fontStyle' => array(
            'type' => 'string',
            'default' => 'normal'
          ),
          'letterSpacingC' => array(
            'type' => 'number'
          ),
          'typographyC' => array(
            'type' => 'string',
            'default' => ''
          ),
          'googleFontC' => array(
            'type' => 'boolean',
            'default' => false
          ),
          'loadGoogleFontC' => array(
            'type' => 'boolean',
            'default' => true
          ),
          'fontSubsetC' => array(
            'type' => 'string',
            'default' => ''
          ),
          'fontVariantC' => array(
            'type' => 'string',
            'default' => ''
          ),
          'fontWeightC' => array(
            'type' => 'string',
            'default' => '400'
          ),
          'fontStyleC' => array(
            'type' => 'string',
            'default' => 'normal'
          ),
          'letterSpacingT' => array(
            'type' => 'number'
          ),
          'typographyT' => array(
            'type' => 'string',
            'default' => ''
          ),
          'googleFontT' => array(
            'type' => 'boolean',
            'default' => false
          ),
          'loadGoogleFontT' => array(
            'type' => 'boolean',
            'default' => true
          ),
          'fontSubsetT' => array(
            'type' => 'string',
            'default' => ''
          ),
          'fontVariantT' => array(
            'type' => 'string',
            'default' => ''
          ),
          'fontWeightT' => array(
            'type' => 'string',
            'default' => '400'
          ),
          'fontStyleT' => array(
            'type' => 'string',
            'default' => 'normal'
          ),
          'blockAlignment' => array(
            'type' => 'string',
            'default' => 'none'
          ),
          'autoplayHover' => array(
            'type' => 'boolean',
            'default' => true
          ),
          'rewind' => array(
            'type' => 'boolean',
            'default' => false
          ),
          'autoplayTimeOut' => array(
            'type' => 'number',
            'default' => 5000
          ),
          'autoplaySpeed' => array(
            'type' => 'number',
            'default' => 5000
          ),
          'navigationSpeed' => array(
            'type' => 'number',
            'default' => 5000
          ),
          'dotSpeed' => array(
            'type' => 'number',
            'default' => 5000
          ),
          'stagePadding' => array(
            'type' =>  'number',
            'default' =>  0
          ),
          'navArrowSize' => array(
            'type' =>  'array',
            'default' =>  [ 20, 20, 20 ]
          ),
          'navArrowColor' => array(
            'type' =>  'string',
            'default' =>  '#000000'
          ),
          'navArrowBgColor' => array(
            'type' =>  'string',
            'default' =>  '#ffffff'
          ),
          'navArrowBdColor' => array(
            'type' =>  'string',
            'default' =>  '#000000'
          ),
          'navArrowBdWidth' => array(
            'type' =>  'array',
            'default' =>  [ 0, 0, 0 ]
          ),
          'navArrowBdRadius' => array(
            'type' =>  'number',
            'default' =>  0
          ),
          'dotActiveColor' => array(
            'type' =>  'string',
            'default' =>  '#000000'
          ),
          'dotColor' => array(
            'type' =>  'string',
            'default' =>  '#222222'
          ),
          'navArrowHovColor' => array(
            'type' =>  'string',
            'default' =>  '#ffffff'
          ),
          'navArrowBgHovColor' => array(
            'type' =>  'string',
            'default' =>  '#000000'
          ),
          'navArrowBdHovColor' => array(
            'type' =>  'string',
            'default' =>  '#ffffff'
          ),
          'isnavText' => array(
            'type' => 'boolean',
            'default' => false
          ),
          'navbtntype' => array(
            'type' => 'string',
            'default' => 'icon'
          ),
          'navTextPrev' => array(
            'type' => 'string',
            'default' => 'Prev'
          ),
          'navTextNext' => array(
            'type' => 'string',
            'default' => 'Next'
          ),
          'navTextPrevicon' => array(
            'type' => 'string',
            'default' => 'fas fa-angle-left'
          ),
          'navTextNexticon' => array(
            'type' => 'string',
            'default' => 'fas fa-angle-right'
          ),
          'buttonOption' => array(
            'type' =>  'string',
            'default' => 'text'
          ),
          'buttonIconName' => array(
            'type' =>  'string',
            'default' => 'fas fa-cart-plus'
          ),
          'iconAlignButton' => array(
            'type' =>  'string',
            'default' => 'right'
          ),
          'imageDateOption' => array(
            'type' => 'array',
            'default' => [ 'true', 'true', 'true' ]
          ),
          'imgWidth' => array(
            'type' => 'array',
            'default' => [400, 400, 400]
          ),
          'imgHeight' => array(
            'type' => 'array',
            'default' => [400, 400, 400]
          ),
          'postdeskalign' => array(
            'type' => 'string',
            'default' => 'center'
          ),
          'posttabalign' => array(
            'type' => 'string',
            'default' => 'center'
          ),
          'postmobalign' => array(
            'type' => 'string',
            'default' => 'center'
          ),
          'productdeskalign' => array(
            'type' => 'string',
            'default' => 'center'
          ),
          'producttabalign' => array(
            'type' => 'string',
            'default' => 'center'
          ),
          'productmobalign' => array(
            'type' => 'string',
            'default' => 'center'
          ),
          'borderType' => array(
            'type' => 'string',
            'default' => 'solid'
          ),
          'cartBorderWidth' => array(
            'type' => 'number',
            'default' => 0
          ),
          'content_excerpt' => array(
            'type' => 'number',
            'default' => 100
          ),
          'showRegularPrice' => array(
            'type' => 'boolean',
            'default' => true
          ),
          'showproductName' => array(
            'type' => 'boolean',
            'default' => true
          ),
          'showSalePrice' => array(
            'type' => 'boolean',
            'default' => true
          ),
          'isWooComActive' => array(
            'type' => 'boolean',
            'default' => $this->check_woocommerce_active(),
          ),
          'marginPrice' => array(
            'type' => 'number',
            'default' => 0
          ),
          'fontPrice' => array(
            'type' => 'number',
            'default' => 18
          ),
          'marginTopPrice' => array(
            'type' => 'number',
            'default' => 0
          ),
          'marginBottomPrice' => array(
            'type' => 'number',
            'default' => 0
          ),
          'iconSpacingRight' => array(
            'type' => 'number',
            'default' => 0
          ),
          'iconSpacingLeft' => array(
            'type' => 'number',
            'default' => 0
          ),
          'iconPostMetaSize' => array(
            'type' => 'array',
            'default' => [ 10, 10, 10 ]
          ),
          'contentPostMetaSize' => array(
            'type' => 'array',
            'default' => [ 10, 10, 10 ]
          ),
          'iconGrad' => array(
            'type' => 'boolean',
            'default' => false
          ),
          'iconposTop' => array(
            'type' => 'boolean',
            'default' => false
          ),
          'israting' => array(
            'type' => 'boolean',
            'default' => false
          ),
          'ratingColor' => array(
            'type' => 'string',
            'default' => '#fe2b2b'
          ),
          'bgfirstcolorr' => array(
        		'type' => 'string',
        		'default' => '#00B5E2'
        	),
          'bgGradLoc' => array(
        		'type' => 'number',
        		'default' => 0
        	),
          'bgSecondColr' => array(
        		'type' => 'string',
        		'default' => '#00B5E2'
        	),
          'bgGradLocSecond' => array(
        		'type' => 'number',
        		'default' => 100
        	),
          'bgGradType' => array(
        		'type' => 'string',
        		'default' => 'linear'
        	),
          'bgGradAngle' => array(
        		'type' => 'number',
        		'default' => 180
        	),
          'vBgImgPosition' => array(
        		'type' => 'string',
        		'default' => 'center center'
        	),
          'hovGradFirstColor' => array(
        		'type' => 'string',
        		'default' => ''
        	),
          'hovGradSecondColor' => array(
        		'type' => 'string',
        		'default' => ''
        	),
          'productCount' => array(
            'type' => 'number',
            'default' => $this->get_product_count()
          ),
          'postCount' => array(
            'type' => 'number',
            'default' => $this->get_post_count()
          ),
        	'owlNavMaxWidth' => array(
        		'type' => 'array',
        		'default' => [ 100, 100, 100 ]
        	),
        	'owlNavTop' => array(
        		'type' => 'array',
        		'default' => [ 35, 35, 35 ]
        	),
        	'owlNavLeft' => array(
        		'type' => 'array',
        		'default' => [ 0, 0, 0 ]
        	),
        	'owlNavRight' => array(
        		'type' => 'array',
        		'default' => [ 0, 0, 0 ]
        	),
        	'arrowBtnWidth' => array(
        		'type' => 'array',
        		'default' => [ 45, 45, 45 ]
        	),
        	'arrowBtnHeight' => array(
        		'type' => 'array',
        		'default' => [ 40, 40, 40 ]
        	),
        	'arrowBtnPadding' => array(
        		'type' => 'array',
        		'default' => [
              [0, 0, 0, 0],
        			[0, 0, 0, 0],
        			[0, 0, 0, 0]
            ]
        	),
        	'arrowBtnPaddingControl' => array(
        		'type' => 'array',
        		'default' => [
        			'individual',
        			'individual',
        			'individual'
        		]
        	),
          'dotBorderRadius' => array(
            'type' => 'number',
            'default' => 0
          ),


          'letterSpacingPM' => array(
            'type' => 'number'
          ),
          'typographyPM' => array(
            'type' => 'string',
            'default' => ''
          ),
          'googleFontPM' => array(
            'type' => 'boolean',
            'default' => false
          ),
          'loadGoogleFontPM' => array(
            'type' => 'boolean',
            'default' => true
          ),
          'fontSubsetPM' => array(
            'type' => 'string',
            'default' => ''
          ),
          'fontVariantPM' => array(
            'type' => 'string',
            'default' => ''
          ),
          'fontWeightPM' => array(
            'type' => 'string',
            'default' => '400'
          ),
          'fontStylePM' => array(
            'type' => 'string',
            'default' => 'normal'
          ),
        ),
        'render_callback' => array($this, 'post_slider_layout_render_post_grid'),
      ));
    }

    function check_woocommerce_active(){
      if ( class_exists( 'WooCommerce' ) ) {
         return true;
       }else{
         return false;
       }
    }

    function get_product_count(){
      if ( class_exists( 'WooCommerce' ) ) {
         $productCount = wp_count_posts('product')->publish;
       }else{
         $productCount = "0";
       }
      return (int)$productCount;
    }
    function get_post_count(){
      $postCount = wp_count_posts('post')->publish;
      return (int)$postCount;
    }

    function show_currency_symbol( ) {
      if ( !function_exists( 'get_woocommerce_currency_symbol' ) ) {
        return '';
      }
      global  $woocommerce;
      $code= get_woocommerce_currency_symbol();
      return '<span>'.$code.'</span>';
    }
    function gutenberg_my_block_init() {
      register_meta( 'post', '_regular_price', array(
        'show_in_rest' => true,
      ));
      register_meta( 'post', 'currency_symbol', array(
        'show_in_rest' => true,
      ));

      //Adding align full width for blocks
      add_theme_support( 'align-wide' );
    }
    function hex2rgb( $colour ) {
      if ( $colour[0] == '#' ) {
        $colour = substr( $colour, 1 );
      }
      if ( strlen( $colour ) == 6 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
      } elseif ( strlen( $colour ) == 3 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
      } else {
        return false;
      }
      $r = hexdec( $r );
      $g = hexdec( $g );
      $b = hexdec( $b );
      return array( 'red' => $r, 'green' => $g, 'blue' => $b );
    }
    function object_to_array_ive($obj) {
      if(is_object($obj)) $obj = (array) $obj;
      if(is_array($obj)) {
        $new = array();
        foreach($obj as $key => $val) {
          $new[$key] = $this->object_to_array_ive($val);
        }
      }
      else $new = $obj;
      return $new;
    }
    function post_slider_layout_render_post_grid($attributes){
      if (isset($attributes['post_type']) && $attributes['post_type'] !== 'post') {
        if(isset($attributes['categories']) && $attributes['categories']!=''){
          $args     = array( 'post_type' => $attributes['post_type'], 'tax_query' => array(
            array(
              'taxonomy' => 'product_cat',
              'field'    => 'term_id',
              'terms'    => $attributes['categories'],
              'include_children' => true
            )
          ), 'posts_per_page' => $attributes['postscount'] );
        }else{
          $args = array( 'post_type' => $attributes['post_type'], 'product_cat' =>  isset($attributes['categories']) ? $attributes['categories'] : '', 'posts_per_page' => $attributes['postscount'] );
        }
      }else{
        if(isset($attributes['postcategories']) && $attributes['postcategories']!=''){
          $args = array(
            'posts_per_page'  => $attributes['postscount'],
            'post_type'       => $attributes['post_type'],
            'category'        => $attributes['postcategories']
          );
        }else{
          $args = array( 'post_type' => $attributes['post_type'], 'category' =>  isset($attributes['postcategories']) ? $attributes['postcategories'] : '', 'posts_per_page' => $attributes['postscount'] );
        }
      }
      $postss = get_posts( $args );
      $recent_posts = $this->object_to_array_ive($postss);

      if (count($recent_posts) == 0) {
        return;
      }

      $uniqueID = $attributes['uniqueID'];
      $className = isset($attributes['className']) ? $attributes['className'] : '';

      $deskNavDisplay  = 'display: none;';
  		$deskDotsDisplay = 'display: none;';
  		if ($attributes['navigation'][0] == 'arrows') {
  			$deskNavDisplay 	= '';
  		} else if ($attributes['navigation'][0] == 'dots') {
  			$deskDotsDisplay = '';
  		} else if ($attributes['navigation'][0] == 'both') {
  			$deskNavDisplay 	= '';
  			$deskDotsDisplay = '';
  		}

  		$tabNavDisplay	 	= 'display: none;';
  		$tabDotsDisplay  = 'display: none;';
  		if ($attributes['navigation'][1] == 'arrows') {
  			$tabNavDisplay = '';
  		} else if ($attributes['navigation'][1] == 'dots') {
  			$tabDotsDisplay = '';
  		} else if ($attributes['navigation'][1] == 'both') {
  			$tabNavDisplay = '';
  			$tabDotsDisplay = '';
  		}

  		$mobNavDisplay   = 'display: none;';
  		$mobDotsDisplay  = 'display: none;';
  		if ($attributes['navigation'][2] == 'arrows') {
  			$mobNavDisplay = '';
  		} else if ($attributes['navigation'][2] == 'dots') {
  			$mobDotsDisplay = '';
  		} else if ($attributes['navigation'][2] == 'both') {
  			$mobNavDisplay = '';
  			$mobDotsDisplay = '';
  		}

      $stagePadding = $attributes['slideLoop'] ? $attributes['stagePadding'] : 0;
      $rewind = $attributes['rewind'] ? 'true' : 'false';
      $autoPLay = $attributes['autoPlay'] ? 'true' : 'false';
      $autoplayTimeOut = $attributes['autoPlay'] ? $attributes['autoplayTimeOut'] : 0;
      $autoplayHover = $attributes['autoplayHover'] ? 'true' : 'false';
      $autoplaySpeed = $attributes['autoplaySpeed'] == 0 ? 'false' : $attributes['autoplaySpeed'];
      $navigationSpeed = $attributes['navigationSpeed'] == 0 ? 'false' : $attributes['navigationSpeed'];
      $dotSpeed = $attributes['dotSpeed'] == 0 ? 'false' : $attributes['dotSpeed'];
      $slideLoop = $attributes['slideLoop'] ? 'true' : 'false';

      $markup = '';

      $mobFlex = '0 0 50%'; $mobWidth = '50%';
      if ($attributes['layoutType'][0] == 'column' || $attributes['layoutType'][0] == 'column-reverse') {
        $mobFlex = '0 0 100%';
        $mobWidth = '100%';
      }

      $tabFlex = '0 0 50%'; $tabWidth = '50%';
      if ($attributes['layoutType'][1] == 'column' || $attributes['layoutType'][1] == 'column-reverse') {
        $tabFlex = '0 0 100%';
        $tabWidth = '100%';
      }

      $deskFlex = '0 0 50%'; $deskWidth = '50%';
      if ($attributes['layoutType'][2] == 'column' || $attributes['layoutType'][2] == 'column-reverse') {
        $deskFlex = '0 0 100%';
        $deskWidth = '100%';
      }

      if ($attributes['buttonOption'] == 'text') {
        $iconLeft = 'none';
        $iconRight = 'none';
        $textIcon = 'block';
      }elseif ($attributes['buttonOption'] == 'icon') {
        $iconLeft = 'block';
        $iconRight = 'none';
        $textIcon = 'none';
      }else{
        $textIcon = 'block';
        if ($attributes['iconAlignButton'] == 'left') {
          $iconLeft = 'block';
          $iconRight = 'none';
        }else{
          $iconLeft = 'none';
          $iconRight = 'block';
        }
      }

      $mobCartButton = $attributes['cartButton'][0] == 'true' ?  'flex' : 'none';
      $tabCartButton = $attributes['cartButton'][1] == 'true' ?  'flex' : 'none';
      $deskCartButton = $attributes['cartButton'][2] == 'true' ?  'flex' : 'none';
      $mobdispPostTitle = $attributes['displayPostTitle'][0] == 'true' ?  'block' : 'none';
      $tabdispPostTitle = $attributes['displayPostTitle'][1] == 'true' ?  'block' : 'none';
      $deskdispPostTitle = $attributes['displayPostTitle'][2] == 'true' ?  'block' : 'none';

      $mobdispPostContent = $attributes['displayPostExcerpt'][0] == 'true' ?  'block' : 'none';
      $tabdispPostContent = $attributes['displayPostExcerpt'][1] == 'true' ?  'block' : 'none';
      $deskdispPostContent = $attributes['displayPostExcerpt'][2] == 'true' ?  'block' : 'none';

      $mobdispProductContent = $attributes['displayProductExcerpt'][0] == 'true' ?  'block' : 'none';
      $tabdispProductContent = $attributes['displayProductExcerpt'][1] == 'true' ?  'block' : 'none';
      $deskdispProductContent = $attributes['displayProductExcerpt'][2] == 'true' ?  'block' : 'none';

      $mobProdSaleBadge = $attributes['displayProductSaleBadge'][0] == 'true' ?  'block' : 'none';
      $tabProdSaleBadge = $attributes['displayProductSaleBadge'][1] == 'true' ?  'block' : 'none';
      $deskProdSaleBadge = $attributes['displayProductSaleBadge'][2] == 'true' ?  'block' : 'none';

      $mobdispPostBtn = $attributes['displayPostReadMoreButton'][0] == 'true' ?  'inline-block' : 'none';
      $tabdispPostBtn = $attributes['displayPostReadMoreButton'][1] == 'true' ?  'inline-block' : 'none';
      $deskdispPostBtn = $attributes['displayPostReadMoreButton'][2] == 'true' ?  'inline-block' : 'none';

      $mobdispPostImg = $attributes['displayPostImage'][0] == 'true' ?  'block' : 'none';
      $tabdispPostImg = $attributes['displayPostImage'][1] == 'true' ?  'block' : 'none';
      $deskdispPostImg = $attributes['displayPostImage'][2] == 'true' ?  'block' : 'none';

      $mobdispPostImgDate = $attributes['imageDateOption'][0] == 'true' ?  'block' : 'none';
      $tabdispPostImgDate = $attributes['imageDateOption'][1] == 'true' ?  'block' : 'none';
      $deskdispPostImgDate = $attributes['imageDateOption'][2] == 'true' ?  'block' : 'none';

      $mobdispPostAuth = $attributes['displayPostAuthor'][0] == 'true' ?  'block' : 'none';
      $tabdispPostAuth = $attributes['displayPostAuthor'][1] == 'true' ?  'block' : 'none';
      $deskdispPostAuth = $attributes['displayPostAuthor'][2] == 'true' ?  'block' : 'none';
      $mobdispPostAuthIcon = $attributes['displayPostAuthorIcon'][0] == 'true' ?  'inline-block' : 'none';
      $tabdispPostAuthIcon = $attributes['displayPostAuthorIcon'][1] == 'true' ?  'inline-block' : 'none';
      $deskdispPostAuthIcon = $attributes['displayPostAuthorIcon'][2] == 'true' ?  'inline-block' : 'none';

      $mobdispPostDate = $attributes['displayPostDate'][0] == 'true' ?  'block' : 'none';
      $tabdispPostDate = $attributes['displayPostDate'][1] == 'true' ?  'block' : 'none';
      $deskdispPostDate = $attributes['displayPostDate'][2] == 'true' ?  'block' : 'none';
      $mobdispPostDateIcon = $attributes['displayPostDateIcon'][0] == 'true' ?  'inline-block' : 'none';
      $tabdispPostDateIcon = $attributes['displayPostDateIcon'][1] == 'true' ?  'inline-block' : 'none';
      $deskdispPostDateIcon = $attributes['displayPostDateIcon'][2] == 'true' ?  'inline-block' : 'none';

      $mobdispPostComment = $attributes['displayComment'][0] == 'true' ?  'block' : 'none';
      $tabdispPostComment = $attributes['displayComment'][1] == 'true' ?  'block' : 'none';
      $deskdispPostComment = $attributes['displayComment'][2] == 'true' ?  'block' : 'none';
      $mobdispPostCommentIcon = $attributes['displayCommentIcon'][0] == 'true' ?  'inline-block' : 'none';
      $tabdispPostCommentIcon = $attributes['displayCommentIcon'][1] == 'true' ?  'inline-block' : 'none';
      $deskdispPostCommentIcon = $attributes['displayCommentIcon'][2] == 'true' ?  'inline-block' : 'none';

      $mobdispdisplayCommentText = $attributes['displayCommentText'][0] == 'true' ?  'inline' : 'none';
      $tabdispdisplayCommentText = $attributes['displayCommentText'][1] == 'true' ?  'inline' : 'none';
      $deskdisplayCommentText = $attributes['displayCommentText'][2] == 'true' ?  'inline' : 'none';

      $opac =$attributes['contentOpacity']/100;
      $rgb = $this->hex2rgb($attributes['contentBackgroundColor']);
      $typographyC =  $attributes['typographyC'] !== '' ? $attributes['typographyC'] : 'Open+Sans';
      $typographyT =  $attributes['typographyT'] !== '' ? $attributes['typographyT'] : 'Open+Sans';
      $typography =  $attributes['typography'] !== '' ? $attributes['typography'] : 'Open+Sans';
      $tyochange =str_replace(" ","+",$typographyC);
      $tyochange2 =str_replace(" ","+",$typography);
      $tyochange3 =str_replace(" ","+",$typographyT);

      if($attributes['align'] == 'center'){
        $imgAlign = '0 auto';
      } elseif ($attributes['align'] == 'left') {
        $imgAlign = '0 auto 0 0';
      } else {
        $imgAlign = '0 0 0 auto';
      }

      $cartBackgroundColor = !$attributes['iconGrad'] ? $attributes['cartBackgroundColor'] : 'unset';
      $cartBackgroundHovColor = !$attributes['iconGrad'] ? $attributes['cartBackgroundHovColor'] : 'unset';

      $radialBtnGrad = 'radial-gradient(at '.$attributes['vBgImgPosition'].' }, '.$attributes['bgfirstcolorr'].' '.$attributes['bgGradLoc'].'%, '.$attributes['bgSecondColr'].' '.$attributes['bgGradLocSecond'].'%) !important;';
      $linearBtnGrad = 'linear-gradient('.$attributes['bgGradAngle'].'deg, '.$attributes['bgfirstcolorr'].' '.$attributes['bgGradLoc'].'%, '.$attributes['bgSecondColr'].' '.$attributes['bgGradLocSecond'].'%) !important;';
      $gradientColor = $attributes['bgGradType'] === 'radial' ? $radialBtnGrad : $linearBtnGrad;
      $cartBtnGradColor = $attributes['iconGrad'] ? $gradientColor : 'unset !important';

      $radialBtnGradHov = 'radial-gradient(at '.$attributes['vBgImgPosition'].' }, '.$attributes['hovGradFirstColor'].' '.$attributes['bgGradLoc'].'%, '.$attributes['hovGradSecondColor'].' '.$attributes['bgGradLocSecond'].'%) !important;';
      $linearBtnGradHov = 'linear-gradient('.$attributes['bgGradAngle'].'deg, '.$attributes['hovGradFirstColor'].' '.$attributes['bgGradLoc'].'%, '.$attributes['hovGradSecondColor'].' '.$attributes['bgGradLocSecond'].'%) !important;';
      $gradientColorHov = $attributes['bgGradType'] === 'radial' ? $radialBtnGradHov : $linearBtnGradHov;
      $cartBtnGradHovColor = $attributes['iconGrad'] ? $gradientColorHov : 'unset !important';

      $contentLetterSpacing = isset($attributes['letterSpacingC']) ? $attributes['letterSpacingC'].'px' : '0px';
      $titleLetterSpacing = isset($attributes['letterSpacingT']) ? $attributes['letterSpacingT'].'px' : '0px';

      $PMLetterSpacing = isset($attributes['letterSpacingPM']) ? $attributes['letterSpacingPM'].'px' : '0px';

      $cartIconSpacingLeft = $attributes['buttonOption'] == 'both' && $attributes['iconAlignButton'] == 'left' ? $attributes['iconSpacingLeft'] : 0;
      $cartIconSpacingRight = $attributes['buttonOption'] == 'both' && $attributes['iconAlignButton'] == 'right' ? $attributes['iconSpacingRight'] : 0;

      $fontWeight = isset($attributes['fontWeight']) ? $attributes['fontWeight'] : 400;
      $fontWeightC = isset($attributes['fontWeightC']) ? $attributes['fontWeightC'] : 400;
      $fontWeightT = isset($attributes['fontWeightT']) ? $attributes['fontWeightT'] : 400;

      $cartTextColor = isset($attributes['cartTextColor']) ? $attributes['cartTextColor'] : '';
      $cartBorderRadius = isset($attributes['cartBorderRadius']) ? $attributes['cartBorderRadius'] : '';
      $cartBorderColor = isset($attributes['cartBorderColor']) ? $attributes['cartBorderColor'] : '';
      $typography = isset($attributes['typography']) ? $attributes['typography'] : '';
      $fontStyle = isset($attributes['fontStyle']) ? $attributes['fontStyle'] : '';
      $borderType = isset($attributes['borderType']) ? $attributes['borderType'] : '';
      $cartBorderWidth = isset($attributes['cartBorderWidth']) ? $attributes['cartBorderWidth'] : '';
      $letterSpacing = isset($attributes['letterSpacing']) ? $attributes['letterSpacing'] : '0';
      $cartIconColor = isset($attributes['cartIconColor']) ? $attributes['cartIconColor'] : '0';
      $cartIconHoverColor = isset($attributes['cartIconHoverColor']) ? $attributes['cartIconHoverColor'] : '0';

      $markup .= '<style>
        @import url(https://fonts.googleapis.com/css2?family='.$tyochange.':wght@'.$fontWeightC.'&display=swap);
        @import url(https://fonts.googleapis.com/css2?family='.$tyochange2.':wght@'.$fontWeight.'&display=swap);
        @import url(https://fonts.googleapis.com/css2?family='.$tyochange3.':wght@'.$fontWeightT.'&display=swap);

        .ive-product-slider-parent'.$uniqueID.' .woo-prod-img img{
          margin-left: auto;
          margin-right: auto;
        }
        .ive-post-slider-parent'.$uniqueID.' .post-image img{
          margin-left: auto;
          margin-right: auto;
        }
        .ive-post-slider-parent'.$uniqueID.' .ive-posttype-icon-align-left, .ive-product-slider-parent'.$uniqueID.' .ive-posttype-icon-align-left{
          display: '.$iconLeft.';
        }
        .ive-post-slider-parent'.$uniqueID.' .ive-posttype-text-display, .ive-product-slider-parent'.$uniqueID.' .ive-posttype-text-display{
          display: '.$textIcon.';
        }
        .ive-post-slider-parent'.$uniqueID.' .ive-posttype-icon-align-right, .ive-product-slider-parent'.$uniqueID.' .ive-posttype-icon-align-right{
          display: '.$iconRight.';
        }
        .ibtana_cart_button_'.$uniqueID.'{
          background-color: '.$cartBackgroundColor.' !important;
          background-image: '.$cartBtnGradColor.';
          color: '.$cartTextColor.' !important;
          border-radius: '.$cartBorderRadius.'px !important;
          border-color: '.$cartBorderColor.' !important;
          font-family:'.$typography.' ;
          font-weight: '.$fontWeight.';
          font-style: '.$fontStyle.';
          border-style: '.$borderType.';
          border-width: '.$cartBorderWidth.'px !important;
          letter-spacing: '.$letterSpacing.'px;
        }
        .ibtana_cart_button_'.$uniqueID.' i{
          color: '.$cartIconColor.';
        }
        .ibtana_cart_button_'.$uniqueID.':hover{
          background-color: '.$cartBackgroundHovColor.' !important;
          background-image: '.$cartBtnGradHovColor.';
          color: '.$attributes['cartTextHoverColor'].' !important;
        }
        .ibtana_cart_button_'.$uniqueID.':hover i{
          color: '.$attributes['cartIconHoverColor'].' !important;
        }
        .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content{
          padding: 20px;
        }
        .ibtana_cart_button_'.$uniqueID.' .ive-posttype-text-display{
          margin-left: '.$cartIconSpacingLeft.'px;
          margin-right: '.$cartIconSpacingRight.'px;
        }
        .ibtana_cart_button_'.$uniqueID.'.ajax_add_to_cart, .ibtana_cart_button_'.$uniqueID.' .post-read-more{
          display: flex !important;
          flex-wrap: wrap;
          align-items: center;
        }
        .ibtana_cart_button_'.$uniqueID.'.ajax_add_to_cart, .ibtana_cart_button_'.$uniqueID.' .post-read-more i{
          color: '.$cartIconColor.';
        }
        .ibtana_cart_button_'.$uniqueID.'.ajax_add_to_cart, .ibtana_cart_button_'.$uniqueID.' .post-read-more:hover i{
          color: '.$cartIconHoverColor.';
        }

        .ibtana_cart_button_'.$uniqueID.' .post-read-more{
          color: '.$cartTextColor.' !important;
        }
        .ibtana_cart_button_'.$uniqueID.' .post-read-more:hover{
          color: '.$attributes['cartTextHoverColor'].' !important;
        }
        .ibtana-product-name-'.$uniqueID.' h6, .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-title a{
          color: '.$attributes['nameColor'].' !important;
        }
        .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-title a{
          color: '.$attributes['nameColor'].' !important;
        }
        .ibtana-product-name-'.$uniqueID.' .product-title-link .ibtana-product-title-child{
          color: '.$attributes['nameColor'].' !important;
        }
        .ibtana-product-name-'.$uniqueID.' h6, .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-title a:hover{
          color: '.$attributes['nameHoverColor'].' !important;
        }
        .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-title a:hover{
          color: '.$attributes['nameHoverColor'].' !important;
        }
        .ibtana-product-name-'.$uniqueID.' .product-title-link .ibtana-product-title-child:hover{
          color: '.$attributes['nameHoverColor'].' !important;
          font-size:18px;
        }
        .ibtana-product-name-'.$uniqueID.' h6, .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-title a{
          font-family: '.$attributes['typographyT'].';
          font-weight: '.$attributes['fontWeightT'].';
          font-style: '.$attributes['fontStyleT'].';
          letter-spacing: '.$titleLetterSpacing.';
        }

        .ibtana-product-name-'.$uniqueID.' h6, .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-meta , .ive_latest_post_date_img {
          font-family: '.$attributes['typographyPM'].';
          font-weight: '.$attributes['fontWeightPM'].';
          font-style: '.$attributes['fontStylePM'].';
          letter-spacing: '.$PMLetterSpacing.';
        }

        .ive-post-slider-parent'.$uniqueID.' .post-title,.ive-product-slider-parent'.$uniqueID.' .ibtana-product-title .ibtana-product-title-child{
          font-family: '.$attributes['typographyT'].';
          font-weight: '.$attributes['fontWeightT'].';
          font-style: '.$attributes['fontStyleT'].';
          letter-spacing: '.$titleLetterSpacing.';
        }
        .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-excerpt,.ive-product-slider-parent'.$uniqueID.' .ibtana-product-content .ibtana-product-content-child{
          color: '.$attributes['contentColor'].';
        }
        .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-excerpt,.ive-product-slider-parent'.$uniqueID.' .ibtana-product-content .ibtana-product-content-child p{
          color: '.$attributes['contentColor'].';
        }
        .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-meta, .ive-post-slider-parent'.$uniqueID.' .post-meta .ive_latest_post_date, .ive-post-slider-parent'.$uniqueID.' .post-meta .ive_latest_post_author a{
          color: '.$attributes['postMetaTextColor'].';
        }
        .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-meta i{
          color: '.$attributes['postMetaIconColor'].';
        }
        .ive-post-slider-parent'.$uniqueID.' .ive_latest_post_date_img{
          color: '.$attributes['postMetaTextColor'].' !important;
        }
        .ive-post-slider-parent'.$uniqueID.' .ive_latest_post_date_img i{
          color: '.$attributes['postMetaIconColor'].' !important;
        }
        .ive-post-slider-parent'.$uniqueID.' post-excerpt p{
          font-size: '.$attributes['contentFontSizedesk'].'px !important;
        }
        .ibtana-price-tag-'.$uniqueID.'{
          color: '.$attributes['priceColor'].';
          font-family: '.$attributes['typographyC'].';
          font-weight: '.$attributes['fontWeightC'].';
          font-style: '.$attributes['fontStyleC'].';
          margin-top: '.$attributes['marginTopPrice'].'px;
          margin-bottom: '.$attributes['marginBottomPrice'].'px;
          font-size: '. $attributes['fontPrice'] .'px;
        }
        .ibtana-price-tag-'.$uniqueID.':hover{
          color: '. $attributes['priceHoverColor'] .';
        }
        .content_full_'.$uniqueID.'{
          background-color: rgba('.$rgb['red'].', '.$rgb['green'].', '.$rgb['blue'].', '.$opac.');
          padding: 20px;
          text-align: '.$attributes['align'].';
        }
        .ive-post-slider-parent'.$uniqueID.'{
          background-color: rgba('.$rgb['red'].', '.$rgb['green'].', '.$rgb['blue'].', '.$opac.');
        }
        .woo-prd-slider'.$uniqueID.' .woo-prod-img img{
          margin: '.$imgAlign.';
        }
        .ibtana-product-cart-button{
          margin-top: 14px;
        }
        #ive-posttype-carousel'.$uniqueID.' .owl-dots .owl-dot.active span{
          background: '.$attributes['dotActiveColor'].' !important;
        }
        #ive-posttype-carousel'.$uniqueID.' .owl-dots .owl-dot span{
          display:flex;
          background: '.$attributes['dotColor'].' !important;
          border-radius: '.$attributes['dotBorderRadius'].'px;
          width: 10px;
          height: 10px;
          margin: 5px 7px;
          -webkit-backface-visibility: visible;
          transition: opacity 200ms ease;
        }
        #ive-posttype-carousel'.$uniqueID.' .owl-nav button{
          background: '.$attributes['navArrowBgColor'].' !important;
          border-radius: '.$attributes['navArrowBdRadius'].'px !important;
          border-color: '.$attributes['navArrowBdColor'].' !important;
          border-style: solid !important;
          color: '.$attributes['navArrowColor'].' !important;
        }
        #ive-posttype-carousel'.$uniqueID.' .owl-nav button:hover{
          background: '.$attributes['navArrowBgHovColor'].' !important;
          color: '.$attributes['navArrowHovColor'].' !important;
          border-color: '.$attributes['navArrowBdHovColor'].' !important;
        }
        .ive-post-slider-parent'.$uniqueID.' .post-excerpt p,.ive-product-slider-parent'.$uniqueID.' .ibtana-product-content .ibtana-product-content-child{
          font-family: '.$attributes['typographyC'].';
          font-weight: '.$attributes['fontWeightC'].';
          font-style: '.$attributes['fontStyleC'].';
          letter-spacing: '.$contentLetterSpacing.';
        }
        .ive-product-slider-parent'.$uniqueID.' .price-regular-sale-ibtana-parent{
          display: flex;
        }
        .ibtana-price-tag-'.$uniqueID.' .price-meta-regular-price{
          margin-right: '.$attributes['marginPrice'].'px;
        }
        .ive-product-slider-parent'.$uniqueID.' .comment-value{
          line-height: 24px;
          color: #000;
          top: -2px;
        }
        .ive-product-slider-parent'.$uniqueID.' .star-rating {
          overflow: hidden;
          position: relative;
          height: 1em;
          line-height: 1;
          font-size: 1em;
          width: 5.4em;
          font-family: star;
        }
        .ive-product-slider-parent'.$uniqueID.' .star-rating span {
          overflow: hidden;
          float: left;
          top: 0;
          left: 0;
          position: absolute;
          padding-top: 1.5em;
          color: '.$attributes['ratingColor'].';
          border-color: '.$attributes['ratingColor'].';
        }
      .ive-product-slider-parent'.$uniqueID.' .star-rating::before {
          content: "\73\73\73\73\73";
          float: left;
          top: 0;
          left: 0;
          position: absolute;
          color: '.$attributes['ratingColor'].';
        }
        .ive-product-slider-parent'.$uniqueID.' .star-rating span::before {
          content: "\53\53\53\53\53";
          top: 0;
          position: absolute;
          left: 0;
        }
        .post-meta-content{
          padding-left: 4px;
        }
        @media screen and (max-width: 767px){
          .ibtana_cart_button_'.$uniqueID.'{
            font-size: '.$attributes['cartFontSizemob'].'px !important;
            padding: '.$attributes['mobcartButtonPadding'].'px '.$attributes['mobcartButtonPadding2'].'px !important;
          }
          .content_full_'.$uniqueID.' .ibtana-product-cart-button{
            display: '.$mobCartButton.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-excerpt p,.ive-product-slider-parent'.$uniqueID.' .ibtana-product-content .ibtana-product-content-child{
            font-size: '.$attributes['contentFontSizemob'].'px !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-title,.ive-product-slider-parent'.$uniqueID.' .ibtana-product-title .ibtana-product-title-child{
            font-size: '.$attributes['titleFontSizemob'].'px !important;
          }
          .ive-product-slider-parent'.$uniqueID.' .ibtana-product-content .ibtana-product-content-child{
            font-size: '.$attributes['titleFontSizemob'].'px !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-title{
            display: '.$mobdispPostTitle.';
          }
          .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-excerpt{
            display: '.$mobdispPostContent.';
          }
          .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-read-more-parent{
            display: '.$mobdispPostBtn.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .post-image{
            display: '.$mobdispPostImg.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_author{
            display: '.$mobdispPostAuth.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_author i{
            display: '.$mobdispPostAuthIcon.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_date{
            display: '.$mobdispPostDate.' !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_date i{
            display: '.$mobdispPostDateIcon.' !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .ive_latest_post_date_img{
            display: '.$mobdispPostImgDate.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-meta.row i{
            font-size: '.$attributes['iconPostMetaSize'][0].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-meta-content{
            font-size: '.$attributes['contentPostMetaSize'][0].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .ive_latest_post_date_img i{
            display: '.$mobdispPostDateIcon.';
            font-size: '.$attributes['iconPostMetaSize'][0].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_comments{
            display: '.$mobdispPostComment.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_comments i{
            display: '.$mobdispPostCommentIcon.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_comments .comment-text{
            display: '.$mobdispdisplayCommentText.';
          }
          .ibtana-product-justify-content-'.$uniqueID.'{
            justify-content: '.$attributes['productmobalign'].' !important;
          }


          .ive-product-slider-parent'.$uniqueID.' .ibtana-product-content{
            display: '.$mobdispProductContent.';
          }
          .ive-product-slider-parent'.$uniqueID.' .onsale{
            display: '.$mobProdSaleBadge.';
          }
          .ive-product-slider-parent'.$uniqueID.' .full-width-banner-slider-inner-item, .ive-post-slider-parent'.$uniqueID.' .post-content-area{
            flex-direction: '.$attributes['layoutType'][0].';
          }
          .ive-product-slider-parent'.$uniqueID.' .full-width-banner-slider-inner-item .woo-prod-img, .ive-post-slider-parent'.$uniqueID.' .post-image{
            width: '.$mobWidth.';
            flex: '.$mobFlex.';
          }
          .ive-product-slider-parent'.$uniqueID.' .full-width-banner-slider-inner-item .woo-prod-content, .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content{
            width: '.$mobWidth.';
            flex: '.$mobFlex.';
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav {
            max-width: '.$attributes['owlNavMaxWidth'][2].'%;
            top: '.$attributes['owlNavTop'][2].'%;
            left: '.$attributes['owlNavLeft'][2].'%;
            right: '.$attributes['owlNavRight'][2].'%;
            '.$mobNavDisplay.'
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-dots {
            '.$mobDotsDisplay.'
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button{
            width: '.$attributes['arrowBtnWidth'][2].'px !important;
            height: '.$attributes['arrowBtnHeight'][2].'px !important;
            border-width: '.$attributes['navArrowBdWidth'][2].'px !important;
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button.owl-prev {
            padding: '.$attributes['arrowBtnPadding'][2][0].'px '.$attributes['arrowBtnPadding'][2][1].'px '.$attributes['arrowBtnPadding'][2][2].'px '.$attributes['arrowBtnPadding'][2][3].'px !important;
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button.owl-next {
            padding: '.$attributes['arrowBtnPadding'][2][0].'px '.$attributes['arrowBtnPadding'][2][1].'px '.$attributes['arrowBtnPadding'][2][2].'px '.$attributes['arrowBtnPadding'][2][3].'px !important;
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button i {
            font-size: '.$attributes['navArrowSize'][2].'px;
          }

          .ive-product-slider-parent'.$uniqueID.' .woo-prod-img img{
            width: '.$attributes['imgWidth'][2].'px;
            height: '.$attributes['imgHeight'][2].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-image img{
            width: '.$attributes['imgWidth'][2].'px;
            height: '.$attributes['imgHeight'][2].'px;
          }
        }
        @media screen and (min-width: 768px) and (max-width: 1023px){
          .ibtana_cart_button_'.$uniqueID.'{
            font-size: '.$attributes['cartFontSizetab'].'px !important;
            padding: '.$attributes['tabcartButtonPadding'].'px '.$attributes['tabcartButtonPadding2'].'px !important;
          }
          .content_full_'.$uniqueID.' .ibtana-product-cart-button{
            display: '.$tabCartButton.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-excerpt p,.ive-product-slider-parent'.$uniqueID.' .ibtana-product-content .ibtana-product-content-child{
            font-size: '.$attributes['contentFontSizetab'].'px !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-title,.ive-product-slider-parent'.$uniqueID.' .ibtana-product-title .ibtana-product-title-child{
            font-size: '.$attributes['titleFontSizetab'].'px !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-title{
            display: '.$tabdispPostTitle.';
          }
          .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-excerpt{
            display: '.$tabdispPostContent.';
          }
          .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-read-more-parent{
            display: '.$tabdispPostBtn.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .post-image{
            display: '.$tabdispPostImg.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-meta.row i{
            font-size: '.$attributes['iconPostMetaSize'][1].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-meta-content{
            font-size: '.$attributes['contentPostMetaSize'][1].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_author{
            display: '.$tabdispPostAuth.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_author i{
            display: '.$tabdispPostAuthIcon.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_date{
            display: '.$tabdispPostDate.' !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_date i{
            display: '.$tabdispPostDateIcon.' !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .ive_latest_post_date_img{
            display: '.$tabdispPostImgDate.';
          }
          .ive-post-slider-parent'.$uniqueID.' .ive_latest_post_date_img i{
            display: '.$tabdispPostDateIcon.';
            font-size: '.$attributes['iconPostMetaSize'][1].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_comments{
            display: '.$tabdispPostComment.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_comments i{
            display: '.$tabdispPostCommentIcon.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_comments .comment-text{
            display: '.$tabdispdisplayCommentText.';
          }
          .ibtana-product-justify-content-'.$uniqueID.'{
            justify-content: '.$attributes['producttabalign'].' !important;
          }
          .ive-product-slider-parent'.$uniqueID.' .ibtana-product-content{
            display: '.$tabdispProductContent.';
          }
          .ive-product-slider-parent'.$uniqueID.' .onsale{
            display: '.$tabProdSaleBadge.';
          }
          .ive-product-slider-parent'.$uniqueID.' .full-width-banner-slider-inner-item, .ive-post-slider-parent'.$uniqueID.' .post-content-area{
            flex-direction: '.$attributes['layoutType'][1].';
          }
          .ive-product-slider-parent'.$uniqueID.' .full-width-banner-slider-inner-item .woo-prod-img, .ive-post-slider-parent'.$uniqueID.' .post-image{
            width: '.$tabWidth.';
            flex: '.$tabFlex.';
          }
          .ive-product-slider-parent'.$uniqueID.' .full-width-banner-slider-inner-item .woo-prod-content, .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content{
            width: '.$tabWidth.';
            flex: '.$tabFlex.';
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav {
            max-width: '.$attributes['owlNavMaxWidth'][1].'%;
            top: '.$attributes['owlNavTop'][1].'%;
            left: '.$attributes['owlNavLeft'][1].'%;
            right: '.$attributes['owlNavRight'][1].'%;
            '.$tabNavDisplay.'
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-dots {
            '.$tabDotsDisplay.'
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button{
            width: '.$attributes['arrowBtnWidth'][1].'px !important;
            height: '.$attributes['arrowBtnHeight'][1].'px !important;
            border-width: '.$attributes['navArrowBdWidth'][1].'px !important;
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button.owl-prev {
            padding: '.$attributes['arrowBtnPadding'][1][0].'px '.$attributes['arrowBtnPadding'][1][1].'px '.$attributes['arrowBtnPadding'][1][2].'px '.$attributes['arrowBtnPadding'][1][3].'px !important;
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button.owl-next {
            padding: '.$attributes['arrowBtnPadding'][1][0].'px '.$attributes['arrowBtnPadding'][1][1].'px '.$attributes['arrowBtnPadding'][1][2].'px '.$attributes['arrowBtnPadding'][1][3].'px !important;
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button i {
            font-size: '.$attributes['navArrowSize'][1].'px;
          }
          .ive-product-slider-parent'.$uniqueID.' .woo-prod-img img{
            width: '.$attributes['imgWidth'][1].'px;
            height: '.$attributes['imgHeight'][1].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-image img{
            width: '.$attributes['imgWidth'][1].'px;
            height: '.$attributes['imgHeight'][1].'px;
          }
        }
        @media screen and (min-width: 1024px){
          .ibtana_cart_button_'.$uniqueID.'{
            font-size: '.$attributes['cartFontSizedesk'].'px !important;
            padding: '.$attributes['deskcartButtonPadding'].'px '.$attributes['deskcartButtonPadding2'].'px !important;
          }
          .content_full_'.$uniqueID.' .ibtana-product-cart-button{
            display: '.$deskCartButton.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-excerpt p,.ive-product-slider-parent'.$uniqueID.' .ibtana-product-content .ibtana-product-content-child{
            font-size: '.$attributes['contentFontSizedesk'].'px !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-title,.ive-product-slider-parent'.$uniqueID.' .ibtana-product-title .ibtana-product-title-child{
            font-size: '.$attributes['titleFontSizedesk'].'px !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-title{
            display: '.$deskdispPostTitle.';
          }
          .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-excerpt{
            display: '.$deskdispPostContent.';
          }
          .ive-product-slider-parent'.$uniqueID.' .ibtana-product-content{
            display: '.$deskdispProductContent.';
          }
          .ive-product-slider-parent'.$uniqueID.' .onsale{
            display: '.$deskProdSaleBadge.';
          }
          .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content .post-read-more-parent{
            display: '.$deskdispPostBtn.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .post-image{
            display: '.$deskdispPostImg.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-meta.row i{
            font-size: '.$attributes['iconPostMetaSize'][2].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-meta-content{
            font-size: '.$attributes['contentPostMetaSize'][2].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_author{
            display: '.$deskdispPostAuth.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_author i{
            display: '.$deskdispPostAuthIcon.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_date{
            display: '.$deskdispPostDate.' !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_date i{
            display: '.$deskdispPostDateIcon.' !important;
          }
          .ive-post-slider-parent'.$uniqueID.' .ive_latest_post_date_img{
            display: '.$deskdispPostImgDate.';
          }
          .ive-post-slider-parent'.$uniqueID.' .ive_latest_post_date_img i{
            display: '.$deskdispPostDateIcon.';
            font-size: '.$attributes['iconPostMetaSize'][2].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_comments{
            display: '.$deskdispPostComment.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_comments i{
            display: '.$deskdispPostCommentIcon.';
          }
          .ive-post-slider-parent'.$uniqueID.' .post-content-area .ive_latest_post_comments .comment-text{
            display: '.$deskdisplayCommentText.';
          }
          .ibtana-product-justify-content-'.$uniqueID.'{
            justify-content: '.$attributes['productdeskalign'].' !important;
          }
          .ive-product-slider-parent'.$uniqueID.' .full-width-banner-slider-inner-item, .ive-post-slider-parent'.$uniqueID.' .post-content-area{
            flex-direction: '.$attributes['layoutType'][2].';
          }
          .ive-product-slider-parent'.$uniqueID.' .full-width-banner-slider-inner-item .woo-prod-img, .ive-post-slider-parent'.$uniqueID.' .post-image{
            width: '.$deskWidth.';
            flex: '.$deskFlex.';
          }
          .ive-product-slider-parent'.$uniqueID.' .full-width-banner-slider-inner-item .woo-prod-content, .ive-post-slider-parent'.$uniqueID.' .ive-inner-post-content{
            width: '.$deskWidth.';
            flex: '.$deskFlex.';
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav {
            max-width: '.$attributes['owlNavMaxWidth'][0].'%;
            top: '.$attributes['owlNavTop'][0].'%;
            left: '.$attributes['owlNavLeft'][0].'%;
            right: '.$attributes['owlNavRight'][0].'%;
            '.$deskNavDisplay.'
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-dots {
            '.$deskDotsDisplay.'
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button{
            width: '.$attributes['arrowBtnWidth'][0].'px !important;
            height: '.$attributes['arrowBtnHeight'][0].'px !important;
            border-width: '.$attributes['navArrowBdWidth'][0].'px !important;
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button.owl-prev {
            padding: '.$attributes['arrowBtnPadding'][0][0].'px '.$attributes['arrowBtnPadding'][0][1].'px '.$attributes['arrowBtnPadding'][0][2].'px '.$attributes['arrowBtnPadding'][0][3].'px !important;
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button.owl-next {
            padding: '.$attributes['arrowBtnPadding'][0][0].'px '.$attributes['arrowBtnPadding'][0][1].'px '.$attributes['arrowBtnPadding'][0][2].'px '.$attributes['arrowBtnPadding'][0][3].'px !important;
          }
          #ive-posttype-carousel'.$uniqueID.' .owl-nav button i {
            font-size: '.$attributes['navArrowSize'][0].'px;
          }
          .ive-product-slider-parent'.$uniqueID.' .woo-prod-img img{
            width: '.$attributes['imgWidth'][0].'px;
            height: '.$attributes['imgHeight'][0].'px;
          }
          .ive-post-slider-parent'.$uniqueID.' .post-image img{
            width: '.$attributes['imgWidth'][0].'px;
            height: '.$attributes['imgHeight'][0].'px;
          }
        }
      </style>';
      $widthClass = (isset($attributes['postBlockWidth']) && $attributes['postBlockWidth']) ? 'align'.$attributes['postBlockWidth'] : '';
      $item_col_Class[1]='col-md-12 col-sm-12 col-lg-12 col-12';
      $item_col_Class[2]='col-md-6 col-sm-12 col-lg-6 col-12';
      $item_col_Class[3]='col-md-4 col-sm-6 col-lg-4 col-12';
      $item_col_Class[4]='col-md-4 col-sm-6 col-lg-3 col-12';
      $item_col_Class[5]='col-md-4 col-sm-6 col-lg-3 col-12';
      $item_col_Class[6]='col-md-4 col-sm-6 col-lg-3 col-12';

      if ($attributes['post_type']  == 'post') {

        if($attributes['postLayout'] == 'carousel'){
          if($attributes['navbtntype']=='icon'){
            $dataprev = json_encode($attributes['navTextPrevicon']);
            $datanext = json_encode($attributes['navTextNexticon']);
          } else { $dataprev= $attributes['navTextPrev']; $datanext= $attributes['navTextNext']; }

          $markup .= '<div id="ive-posttype-carousel'.$uniqueID.'" class="ive-carousel-content-wrap ive-product-slider-hidden owl-theme owl-carousel '.$className.' align'.$attributes['postBlockWidth'].'" data-unique='.$uniqueID.' data-margin='.$attributes['slideMargin'].' data-stagePadding='.$stagePadding.' data-rewind='.$rewind.' data-autoplay='.$autoPLay.'
          data-autoplayTimeout='.$autoplayTimeOut.' data-autoplayHoverPause='.$autoplayHover.' data-autoplaySpeed='.$autoplaySpeed.' data-navSpeed='.$navigationSpeed.' data-dotsSpeed='.$dotSpeed.' data-loop='.$slideLoop.' data-responsive-desk='.$attributes['deskslideItems'].' data-responsive-tab='.$attributes['tabslideItems'].' data-responsive-mob='.$attributes['mobslideItems'].' data-navtextprev='.$dataprev.' data-navtextnext='.$datanext.' data-navbtntype="'.$attributes['navbtntype'].'">';
        }else{
          $markup .= '<div class="row '.$className.'">';
        }


        foreach ($recent_posts as $post) {


          $post_id = $post['ID'];
          $comment_count = $post['comment_count'];
          $post_thumbnail_id = get_post_thumbnail_id($post_id);
          $attachment_image_id = $post_thumbnail_id !== 0 ? wp_get_attachment_image_src($post_thumbnail_id, '' . $attributes['postImageSizes'] . '', false)[0] : '';

          $gridView = $attributes['postLayout'] == 'grid' ? 'post-item mb-3 ive-column-'.$attributes['columns'].' ive-post-slider-parent'.$uniqueID.' '.$item_col_Class[$attributes['columns']].'' : 'post-item ive-post-slider-parent'.$uniqueID.' mb-3';
          $image = $attributes['post_type'] == 'attachment' ? $post['guid'] : $attachment_image_id;

          $hasImage = $image ? 'has-image' : '';
          $contentHasImage = $image ? 'content-has-image' : '';

          // start the post-item wrap
          $markup .= sprintf('<div class="%1$s %2$s">', esc_attr($gridView), $attributes['carouselLayoutStyle']);
          // start the post content wrap
          $markup .= '<div class="post-content-area ' . $attributes['align'] . ' '.$hasImage.'">';

          if ($attributes['displayPostImage'] && $image) {
            $markup .= sprintf(
              '<div class="post-image"><a href="%1$s" target="_blank" rel="bookmark"><img src="%2$s"/></a><div class="ive_latest_post_date_img"><i class="fas fa-calendar-alt"></i><time class="post-meta-content" datetime="%3$s">%4$s</time></div></div>',
              esc_url(get_permalink($post_id)),
              $image,
              esc_attr(get_the_date('c', $post_id)),
              esc_html(get_the_date($attributes['postDateFormat'], $post_id))
            );
          }

          // start the inner post content wrap
          $markup .= '<div class="ive-inner-post-content '.$contentHasImage.' text-xl-'.$attributes['postdeskalign'].' text-lg-'.$attributes['postdeskalign'].' text-sm-'.$attributes['posttabalign'].' text-'.$attributes['postmobalign'].'">';

          // start the post meta wrap
          $markup .= '<div class="post-meta row">';

          if (isset($attributes['displayPostAuthor']) && $attributes['displayPostAuthor'] && $attributes['carouselLayoutStyle'] !== 'g_skin2') {
            $markup .= '<div class="ive_latest_post_author col-md-4 text-xl-'.$attributes['postdeskalign'].' text-lg-'.$attributes['postdeskalign'].' text-sm-'.$attributes['posttabalign'].' text-'.$attributes['postmobalign'].'">';
            $markup .= sprintf(
              '<i class="fas fa-user"></i><a class="post-meta-content" target="_blank" href="%2$s">%1$s</a>',
              esc_html(get_the_author_meta('display_name', $post['post_author'])),
              esc_url(get_author_posts_url(get_author_posts_url($post['post_author'])))
            );
            $markup .= "</div>";
          }

          if (isset($attributes['displayPostDate']) && $attributes['displayPostDate']) {
            $markup .= '<div class="ive_latest_post_date col-md-4  text-xl-'.$attributes['postdeskalign'].' text-lg-'.$attributes['postdeskalign'].' text-sm-'.$attributes['posttabalign'].' text-'.$attributes['postmobalign'].'">';
            $markup .= sprintf(
              '<i class="fas fa-calendar-alt"></i><time class="post-meta-content" datetime="%1$s">%2$s</time>',
              esc_attr(get_the_date('c', $post_id)),
              esc_html(get_the_date($attributes['postDateFormat'], $post_id))
            );
            $markup .= "</div>";
          }

          if (isset($attributes['displayComment']) && $attributes['displayComment']) {
            $comment_text = $attributes['CommentText'] ? $attributes['CommentText'] : '';
            $markup .= '<div class="ive_latest_post_comments col-md-4  text-xl-'.$attributes['postdeskalign'].' text-lg-'.$attributes['postdeskalign'].' text-sm-'.$attributes['posttabalign'].' text-'.$attributes['postmobalign'].'">';
            $markup .= sprintf(
              '<i class="fas fa-comments"></i><span class="post-meta-content">%1$s</span>',
              esc_attr($comment_count)
            );
            $markup .= sprintf(
              '<span class="post-meta-content comment-text">%s</span>',
              esc_attr($comment_text)
            );
            $markup .= "</div>";
          }

          $markup .= '</div>';
          // close the post meta wrap

          // start the post title wrap
          $markup .= sprintf(
            '<h2 class="post-title text-xl-'.$attributes['postdeskalign'].' text-lg-'.$attributes['postdeskalign'].' text-sm-'.$attributes['posttabalign'].' text-'.$attributes['postmobalign'].'"><a href="%1$s" target="_blank" rel="bookmark">%2$s</a></h2>',
            esc_url(get_permalink($post_id)),
            esc_html(get_the_title($post_id))
          );
          // close the post title wrap

          // start the post excerpt wrap
          $content = get_the_excerpt($post_id);
          $excerpt = substr($content, 0, $attributes['content_excerpt']);
          $result = substr($content, 0, strrpos($excerpt, ' '));

          if ($content && $attributes['displayPostExcerpt'] && $attributes['carouselLayoutStyle'] !== 'g_skin1' && $attributes['carouselLayoutStyle'] !== 'g_skin2') {
            $markup .= sprintf(
              ' <div class="post-excerpt text-xl-'.$attributes['postdeskalign'].' text-lg-'.$attributes['postdeskalign'].' text-sm-'.$attributes['posttabalign'].' text-'.$attributes['postmobalign'].'"><p>%1$s</p></div>',
              wp_kses_post($result)
            );
          }
          // close the post excerpt wrap

          // start the post read more wrap
          if (isset($attributes['displayPostReadMoreButton']) && $attributes['displayPostReadMoreButton'] && $attributes['carouselLayoutStyle'] !== 'g_skin1' && $attributes['gridLayoutStyle'] !== 'g_skin2') {
            $markup .= sprintf('<div class="post-read-more-parent ibtana_cart_button_'.$uniqueID.' text-xl-'.$attributes['postdeskalign'].' text-lg-'.$attributes['postdeskalign'].' text-sm-'.$attributes['posttabalign'].' text-'.$attributes['postmobalign'].'"><a class="post-read-more" href="%1$s" target="_blank" rel="bookmark"><i class="%3$s ive-posttype-icon-align-left"></i><span class="ive-posttype-text-display">%2$s</span><i class="%3$s ive-posttype-icon-align-right"></i></a></div>', esc_url(get_permalink($post_id)), esc_html($attributes['postReadMoreButtonText']), esc_html($attributes['buttonIconName']));
          }
          // close the post read more wrap

          $markup .= '</div>';
          $markup .= '<div class="ive-overlay-effect"></div>';
          $markup .= '</div>';
          $markup .= '</div>';
        }
        $markup .= '</div>';

      }elseif($attributes['post_type'] == 'product'){

        if($attributes['postLayout'] == 'carousel'){
          if($attributes['navbtntype']=='icon'){
            $dataprev = json_encode($attributes['navTextPrevicon']);
            $datanext = json_encode($attributes['navTextNexticon']);
          } else { $dataprev= $attributes['navTextPrev']; $datanext= $attributes['navTextNext']; }

          $markup .= '<div id="ive-posttype-carousel'.$uniqueID.'" class="ive-carousel-content-wrap ive-product-slider-hidden owl-theme owl-carousel ive-product-slider woo-prd-slider'.$uniqueID.' '.$className.' align'.$attributes['postBlockWidth'].'" data-unique='.$uniqueID.' data-margin='.$attributes['slideMargin'].' data-stagePadding='.$stagePadding.' data-rewind='.$rewind.' data-autoplay='.$autoPLay.'
              data-autoplayTimeout='.$autoplayTimeOut.' data-autoplayHoverPause='.$autoplayHover.' data-autoplaySpeed='.$autoplaySpeed.' data-navSpeed='.$navigationSpeed.' data-dotsSpeed='.$dotSpeed.' data-loop='.$slideLoop.' data-responsive-desk='.$attributes['deskslideItems'].' data-responsive-tab='.$attributes['tabslideItems'].' data-responsive-mob='.$attributes['mobslideItems']. ' data-navtextprev='.$dataprev.' data-navtextnext='.$datanext.' data-navbtntype="'.$attributes['navbtntype'].'">';
        }else{
          $markup .= '<div class="row '.$className.'">';
        }

        foreach ($recent_posts as $post) {
          $post_id = $post['ID'];
          $post_thumbnail_id = get_post_thumbnail_id($post_id);
          $gridView = $attributes['postLayout'] == 'grid' ? 'slider-product-item mb-3 ive-column-'.$attributes['columns'].' ive-product-slider-parent'.$uniqueID.' '.$item_col_Class[$attributes['columns']].' ' : 'slider-product-item ive-product-slider-parent'.$uniqueID.' mb-3';

          $markup .= sprintf('<div class="%1$s">', esc_attr($gridView));
          $markup .='<div class="full-width-banner-slider-inner-item">';
          $image = $attributes['post_type'] == 'attachment' ? $post['guid'] : ($post_thumbnail_id !== 0 ? wp_get_attachment_image_src($post_thumbnail_id, '' . $attributes['postImageSizes'] . '', false)[0] : '' );
          $hasImage = $image ? 'has-image' : '';
          $contentHasImage = $image ? 'content-has-image' : '';
          if ($attributes['iconposTop']) {
            $cartoptop = '';
            $cartoptop .='<div class="icon-button-top ibtana-product-cart-but-top'.$uniqueID.'">';
            $cartoptop .='<a href="?add-to-cart='.$post_id.'" data-quantity="1"
            class="button product_type_simple add_to_cart_button
            ajax_add_to_cart ibtana_cart_button_'.$uniqueID.'" style="display: inline-block !important;"
            data-product_id='.$post_id.' data-product_sku=""
            rel="nofollow"><i class="'.$attributes['buttonIconName'].' ive-posttype-icon-align-left"></i><span class="ive-posttype-text-display">'.$attributes['postReadMoreButtonText'].'</span><i class="'.$attributes['buttonIconName'].' ive-posttype-icon-align-right"></i></a>';
            $cartoptop .='</div>';
          }else{ $cartoptop=''; }
          if ($attributes['displayPostImage'] && $image) {
            $markup .=
            '<div class="woo-prod-img"><a href="'.esc_url(get_permalink($post_id)).'" target="_blank" rel="bookmark"><img src="'.$image.'"/></a>
            '.$cartoptop.'
            </div>';
          }
          $product = wc_get_product( $post_id);
          if ( $product->is_on_sale() ){
            $span_class_onsale_esc_html_sale_woocommerce_span = apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );

            if ( !empty( $span_class_onsale_esc_html_sale_woocommerce_span ) ) {
               $markup .= $span_class_onsale_esc_html_sale_woocommerce_span ;
            }
          }

          $markup .='<div class="woo-prod-content text-xl-'.$attributes['postdeskalign'].' text-xl-'.$attributes['productdeskalign'].' text-lg-'.$attributes['productdeskalign'].' text-sm-'.$attributes['producttabalign'].' text-'.$attributes['productmobalign'].'">';
          $markup .='<div class="full_content content_full_'.$uniqueID.'">';
          $markup .='<div class="ibtana-product-title ibtana-product-name-'.$uniqueID.' text-xl-'.$attributes['productdeskalign'].' text-lg-'.$attributes['productdeskalign'].' text-sm-'.$attributes['producttabalign'].' text-'.$attributes['productmobalign'].'">';
          $markup .='<a class="product-title-link" href="'.esc_url(get_permalink($post_id)).'" target="_blank" rel="bookmark">';
          if ($attributes['showproductName']) {
            $markup .='<h6 class="ibtana-product-title-child">';
            $markup .= esc_html(get_the_title($post_id));
            $markup .='</h6>';
          }
          $markup .='</a>';
          $markup .='</div>';

          $content = get_the_excerpt($post_id);
          $excerpt = substr($content, 0, $attributes['content_excerpt']);
          $result = substr($content, 0, strrpos($excerpt, ' '));

          $markup .='<div class="ibtana-product-content ibtana-product-content-'.$uniqueID.' text-xl-'.$attributes['productdeskalign'].' text-lg-'.$attributes['productdeskalign'].' text-sm-'.$attributes['producttabalign'].' text-'.$attributes['productmobalign'].'">';
          $markup .='<p class="ibtana-product-content-child">'.$result.'</p>';
          $markup .='</div>';

          $sale_price = get_post_meta($post_id, '_sale_price', true);
          $regular_price = get_post_meta($post_id, '_regular_price', true);


          $markup .='<div class="price-tag ibtana-price-tag-'.$uniqueID.' ibtana-product-justify-content-'.$uniqueID.'" >';
          $markup .='<div class="price-regular-sale-ibtana-parent">';
          if ($regular_price !== '' && $attributes['showRegularPrice']) {
            if (!$attributes['showSalePrice'] || $sale_price == '') {
              $markup .= sprintf("<div class='price-meta-regular-price'>%s%u</div>",
                $this->show_currency_symbol(),
                $regular_price
              );
            }else{
              $markup .= sprintf("<div class='price-meta-regular-price'><strike>%s%u</strike></div>",
                $this->show_currency_symbol(),
                $regular_price
              );
            }
          }
          if ($sale_price !== '' && $attributes['showSalePrice']) {
            $markup .= sprintf("<div class='price-meta-sale-price'>%s%u</div>",
              $this->show_currency_symbol(),
              $sale_price
            );
          }
          $markup .='</div>';
          $markup .='</div>';
          if ($attributes['israting']) {
            $markup .='<div class="ibtana-product-review-parent ibtana-product-justify-content-'.$uniqueID.'">';
            $product = wc_get_product( $post_id);
            $rating_count = $product->get_rating_count();
            if ($average_rating = $product->get_average_rating()) :
             $markup .='<div class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average_rating).'" data-rating-count="'. $rating_count .'"><span style="width:'.( ( $average_rating / 5 ) * 100 ) . '%"></span></div>
             <div class="comment-value font-famrubik font-weight400">('.$rating_count.')</div>';
            endif;
            $markup .='</div>';
          }
          if (!$attributes['iconposTop']) {

          $markup .='<div class="ibtana-product-cart-button ibtana-product-justify-content-'.$uniqueID.'">';
          $markup .='<a href="?add-to-cart='.$post_id.'" data-quantity="1"
          class="button product_type_simple add_to_cart_button
          ajax_add_to_cart ibtana_cart_button_'.$uniqueID.'"
          data-product_id='.$post_id.' data-product_sku=""
          rel="nofollow"><i class="'.$attributes['buttonIconName'].' ive-posttype-icon-align-left"></i><span class="ive-posttype-text-display">'.$attributes['postReadMoreButtonText'].'</span><i class="'.$attributes['buttonIconName'].' ive-posttype-icon-align-right"></i></a>';

           $markup .='</div>';
          }
          $markup .='</div>';
          $markup .='</div>';
          $markup .='</div>';
          $markup .='</div>';
        }

        $markup .='</div>';
      }
      return $markup;
    }
  }
  Ibtana_visual_editor_pro_postControl::get_instance();
?>
