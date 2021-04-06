var IVE_WIZARD = (function($) {

  window.onhashchange = function() {
    console.log( 'onhashchanged...' );
  };


  function ibtana_visual_editor_setup_preview_popup( $this ) {

    var is_demo_premium_template  = parseInt( jQuery($this).attr('ive-is-premium') );
    var ive_template_type         = jQuery($this).attr( 'ive-template-type' );
    var demo_slug                 = jQuery($this).attr('ive-template-slug');
    console.log( 'is_demo_premium_template', is_demo_premium_template );
    console.log( 'ive_template_type', ive_template_type );
    console.log( 'demo_slug', demo_slug );

    jQuery('.step-ive-wizard-three-step .ive-wz-spinner-wrap').show();

    var data_to_send  = {
      site_url:       ive_whizzie_params.ive_domain_name,
      template_slug:  demo_slug
    };

    if ( is_demo_premium_template == 1 ) {

      if ( ive_template_type == 'wordpress' ) {
        data_to_send.text_domain    = ive_whizzie_params.theme_text_domain;
        data_to_send.license_key    = ive_whizzie_params.ive_license_key;
        data_to_send.template_type  = ive_template_type;
      } else if ( ive_template_type == 'woocommerce' ) {
        if ( ive_whizzie_params.ive_add_on_keys ) {
          if ( ive_whizzie_params.ive_add_on_keys.hasOwnProperty( 'ibtana_ecommerce_product_addons_license_key' ) ) {
            if ( ive_whizzie_params.ive_add_on_keys.ibtana_ecommerce_product_addons_license_key.hasOwnProperty( 'license_key' ) ) {
              data_to_send.text_domain    = "ibtana-ecommerce-product-addons";
              data_to_send.license_key    = ive_whizzie_params.ive_add_on_keys.ibtana_ecommerce_product_addons_license_key.license_key;
              data_to_send.template_type  = ive_template_type;
            }
          }
        }
      }
    }

    jQuery.ajax({
      method: "POST",
      url: ive_whizzie_params.IBTANA_LICENSE_API_ENDPOINT + "get_client_page_info_for_import",
      data: JSON.stringify(data_to_send),
      dataType: 'json',
      contentType: 'application/json',
    }).done( function( data ) {
      jQuery('.step-ive-wizard-three-step .ive-wz-spinner-wrap').hide();

      var current_theme         = ive_whizzie_params.custom_text_domain;
      var demo_url              = data.data.demo_url;
      var demo_image            = data.data.image;
      var demo_title            = data.data.name;
      var demo_permalink        = data.data.permalink;
      var template_text_domain  = data.data.domain;
      var demo_description      = data.data.description;
      var data_template_type    = data.data.template_type;
      console.log( 'data_template_type', data_template_type );

      var is_premium__key_valid  = data.is_key_valid;
      console.log( 'is_premium__key_valid', is_premium__key_valid );

      if ( is_demo_premium_template === 1 ) {
        jQuery('.ive-sidebar-import-button a').text( 'Premium Import' );
        jQuery('.ive-sidebar-import-button a').attr( 'ive-is-premium', 1 );
      } else {
        jQuery('.ive-sidebar-import-button a').text( 'Free Import' );
        jQuery('.ive-sidebar-import-button a').attr( 'ive-is-premium', 0 );
      }

      var ive_template_page_type    = jQuery($this).attr( 'ive-template-page-type' );
      var ive_template_text_domain  = jQuery($this).attr( 'ive-template-text-domain' );

      jQuery( '.ive-sidebar-import-button a' ).attr( 'ive-template-type', ive_template_type );

      if ( ive_template_type == 'wordpress' ) {
        if( is_demo_premium_template == 1 && is_premium__key_valid == 1 && current_theme == ive_template_text_domain ) {
          jQuery('.ive-sidebar-import-button a').show();
          jQuery('.ive-template-import-sidebar .ive-sidebar-view-icons').removeClass('.ive-premium-template-view-icon');
        } else if( !is_demo_premium_template || is_demo_premium_template == 0 ) {
          jQuery('.ive-sidebar-import-button a').show();
        } else {
          jQuery('.ive-sidebar-import-button a').hide();
        }
      } else {
        // Condition for the other template types.
        if ( ( is_demo_premium_template == 1 ) && ( is_premium__key_valid == 1 ) ) {
          jQuery('.ive-sidebar-import-button a').show();
        } else if ( is_demo_premium_template == 0 ) {
          jQuery('.ive-sidebar-import-button a').show();
        } else {
          jQuery('.ive-sidebar-import-button a').hide();
        }
      }


      if (is_demo_premium_template === 1) {
        jQuery('.ive-sidebar-import-button a').attr('data-callback', 'import_premium_template');
      } else {
        jQuery('.ive-sidebar-import-button a').attr('data-callback', 'import_free_template');
      }


      jQuery('.ive-sidebar-content a.ive-plugin-btn').show();

      jQuery('.ive-sidebar-import-button a').attr( 'ive-template-page-type', ive_template_page_type );
      jQuery('.ive-sidebar-import-button a').attr( 'ive-template-page-title', demo_title );
      jQuery('.ive-sidebar-import-button a').attr( 'ive-template-text-domain', ive_template_text_domain );

      jQuery('.ive-template-import-sidebar .ive-sidebar-content img').attr( 'src', demo_image );

      jQuery('.ive-sidebar-content h4').text( demo_title );
      jQuery('.ive-sidebar-import-button a').attr( 'ive-template-slug', demo_slug );

      jQuery('.ive-template-demo-sidebar iframe').attr( 'src', demo_url );
      jQuery('.ive-template-import-sidebar .ive-sidebar-content p').text( demo_description );

      jQuery('.ive-template-import-sidebar').addClass('free-template-import-sidebar');

      jQuery('.nav-step-ive-wizard-three-step').attr('data-enable', 1);
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-first-step').css('display', 'none');
      jQuery('.ive-wizard-content-menu li').removeClass('active-step');
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-second-step').css('display', 'none');
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-three-step').css('display', 'block');
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-four-step').css('display', 'none');
      jQuery('.ive-wizard-content-menu .step-ive-wizard-five-step').css('display', 'none');
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-three-step').addClass('active-step');
      jQuery('.ive-sidebar-content a.ive-plugin-btn').attr( 'href', demo_permalink );
      jQuery('.ive-sidebar-content a.ive-plugin-btn').text('Go Pro');
      jQuery('.ive-template-import-sidebar').removeClass('ive-premium-demo-sidebar');
      jQuery('.ive-template-import-sidebar .ive-preview-close-btn').removeClass('ive-premium-close-demo');
      jQuery('.ive-template-import-sidebar .ive-preview-close-btn').addClass('ive-free-close-demo');
      IVE_WIZARD.ibtana_visual_editor_changeQueryParams(
        {
          ive_wizard_view:    'popup',
          ive_template_slug:  demo_slug
        }
      );


      // Template Base Theme Condition
      jQuery( '.ive-demo-child .ive-checkbox-container' ).remove();
      if ( data_template_type != 'wordpress' ) {
        jQuery( '.ive-demo-child p' ).text( 'No base theme installation is required!' );
      } else {
        jQuery( '.ive-demo-child p' ).text( 'We strongly recommend to install the base theme.' );
        jQuery( '.ive-demo-child' ).append(
          `<div class="ive-checkbox-container">
            Install Base Theme
            <span class="ive-checkbox active">
              <svg width="10" height="8" viewBox="0 0 11.2 9.1">
                <polyline class="check" points="1.2,4.8 4.4,7.9 9.9,1.2 "></polyline>
              </svg>
            </span>
          </div>`
        );
      }


      var template_plugins = data.data.template_plugins;
      console.log('template_plugins', template_plugins);
      jQuery( '.ive-demo-plugins' ).find( '.ive-checkbox-container' ).remove();
      if ( !template_plugins.length ) {
        jQuery( '.ive-demo-plugins p' ).text( 'No plugin installation is required!' );
      } else {
        // Append plugin data to the step popup
        jQuery( '.ive-demo-plugins p' ).text( 'The following plugins are required for this template in order to work properly. Ignore if already installed.' );
        for (var i = 0; i < template_plugins.length; i++) {
          var template_plugin = template_plugins[i];
          jQuery('.ive-demo-plugins').append(
            `<div class="ive-checkbox-container" ive-plugin-text-domain="` + template_plugin.plugin_text_domain + `" ive-plugin-main-file="` + template_plugin.plugin_main_file + `" ive-plugin-url="` + template_plugin.plugin_url + `">
              ` + template_plugin.plugin_title + `
              <span class="ive-checkbox active">
                <svg width="10" height="8" viewBox="0 0 11.2 9.1">
                  <polyline class="check" points="1.2,4.8 4.4,7.9 9.9,1.2 "></polyline>
                </svg>
              </span>
            </div>`
          );
        }
      }


    });

  }

  function ibtana_visual_editor_all_template_grid( search_key, next_page_number, will_clear = 1, template_type = 'wordpress', pro_cat = null ) {

    jQuery('.ibtana-wizard-first-step-content .ive-wz-spinner-wrap').show();

    var data_post = {
      "theme_license_key":  ive_whizzie_params.ive_license_key,
      "domain":             ive_whizzie_params.ive_domain_name,
      "theme_text_domain":  ive_whizzie_params.theme_text_domain,
      "limit":              9,
      "start":              next_page_number,
      "search":             search_key,
      "template_type":      template_type,
      "product_category":   pro_cat
    };

    if (ive_whizzie_params.custom_text_domain != "") {
      data_post.theme_text_domain = ive_whizzie_params.custom_text_domain;
    }

    jQuery.ajax({
      method:       "POST",
      url:          ive_whizzie_params.IBTANA_LICENSE_API_ENDPOINT + "get_client_template_list",
      data:         JSON.stringify(data_post),
      dataType:     'json',
      contentType:  'application/json',
    }).done(function( data ) {
      console.log( 'data', data );


      // Check if the product categories are created or not
      var data_product_categories  = data.product_categories;
      if ( ive_whizzie_params.are_product_categories_created === undefined ) {
        jQuery( '.ibtana-wizard-first-step-content .ive-ibtaba-wizard-inner-sub-cats' ).empty();
        for (var i = 0; i < data_product_categories.length; i++) {
          var data_product_category = data_product_categories[i];
          jQuery( '.ibtana-wizard-first-step-content .ive-ibtaba-wizard-inner-sub-cats' ).append(
            `<li data-product-category="` + data_product_category.term_id +  `">` +
              `<span class="ive-cat-name">` + data_product_category.name + `</span>` +
              `<span class="ive-cat-count">` + data_product_category.product_category_tags_count + `</span>` +
            `</li>`
          );
        }
        ive_whizzie_params.are_product_categories_created = true;
      }
      // Check if the product categories are created or not END

      // Check if the tabs are already appended START
      var tabs  = data.tabs;
      if ( ive_whizzie_params.are_tabs_created === undefined ) {
        jQuery('.ive-ibtana-wizard-button-wrapper').empty();
        for (var i = 0; i < tabs.length; i++) {
          var tab  = tabs[i];
          if ( i == 0 ) {
            jQuery('.ive-ibtana-wizard-button-wrapper').append(
              `<div class="button-wrap">
                <a href="#" class="ibtana-free-template-button button button-primary active" data-callback="do_next_step" data-step="ive-wizard-first-step" data-template-type="`+tab.option+`">
                  <span class="dashicons dashicons-format-image"></span>
                  `+tab.display_string+`
                </a>
              </div>`
            );
          } else {
            jQuery('.ive-ibtana-wizard-button-wrapper').append(
              `<div class="button-wrap">
                <a href="#" class="ibtana-free-template-button button button-primary custom-template" data-callback="do_next_step" data-step="ive-wizard-first-step" data-template-type="`+tab.option+`">
                  <span class="dashicons dashicons-format-image"></span>
                  `+tab.display_string+`
                </a>
              </div>`
            );
          }
        }
        ive_whizzie_params.are_tabs_created  = true;
      }
      // Check if the tabs are already appended END

      jQuery('.ibtana-wizard-first-step-content .ive-wz-spinner-wrap').hide();
      if (data.next_page_number) {
        jQuery( '.ibtana-wizard-first-step-content .ive-template-load-more a' ).attr( 'ive_current_grid_no', data.next_page_number );
        jQuery( '.ibtana-wizard-first-step-content .ive-template-load-more' ).show();
      } else {
        jQuery( '.ibtana-wizard-first-step-content .ive-template-load-more' ).hide();
      }

      var free_data = data.data;

      if (will_clear) {
        jQuery('.ibtana-wizard-first-step-content .ive-ibtaba-wizard-product-row').empty();
      }

      var active_theme_data = data.active_theme_data;
      if (data.active_theme_data) {
        jQuery('.ibtana-wizard-first-step-content .ive-ibtaba-wizard-product-row').append(
          `<div class="ive-o-products-col ive-current-theme-card">
              <div class="ive-o-products-image">
                <img src="` + active_theme_data.image + `">
                <div>
                    <a class="ive-show-inner-templates-btn" href="javascript:void(0);" ive-template-parent-reference="`+active_theme_data.parent_reference+`" ive-template-text-domain="` + active_theme_data.domain + `" ive-template-demo="` + active_theme_data.demo_url + `" ive-template-image="` + active_theme_data.image + `" ive-template-title="` + active_theme_data.name + `" ive-template-slug="` + active_theme_data.slug + `" ive-template-permalink="` + active_theme_data.permalink + `" ive-template-description="` + active_theme_data.description + `" ive-is-premium="`+active_theme_data.is_premium+`">View</a>
                </div>
                <div class="ive-template-grid-overlay"></div>
              </div>
              <h3>` + active_theme_data.name + `</h3>
              <a href="javascript:void(0);" class="ive-activated-theme">Activated</a>
          </div>`
        );
      }

      if (free_data && free_data.length) {
        for (var i = 0; i < free_data.length; i++) {
          var free_product = free_data[i];
          var card_content = `
            <div class="ive-o-products-col">
                <div class="ive-o-products-image">
                  <img src="` + free_product.image + `">
                  <div>
                      <a class="ive-show-inner-templates-btn" href="javascript:void(0);" ive-template-parent-reference="`+free_product.parent_reference+`" ive-template-text-domain="` + free_product.domain + `" ive-template-demo="` + free_product.demo_url + `" ive-template-image="` + free_product.image + `" ive-template-title="` + free_product.name + `" ive-template-slug="` + free_product.slug + `" ive-template-permalink="` + free_product.permalink + `" ive-template-description="` + free_product.description + `" ive-is-premium="`+free_product.is_premium+`">View</a>
                  </div>
                  <div class="ive-template-grid-overlay"></div>
                </div>
                <h3>` + free_product.name + `</h3>
                <a href="javascript:void(0);" class="ive-activated-theme">Activated</a>
            </div>`;
          jQuery('.ibtana-wizard-first-step-content .ive-ibtaba-wizard-product-row').append(card_content);
        }
      }

      if (free_data && free_data.length) {
        jQuery('.ibtana-wizard-first-step-content h3.ive-coming-soon').css('display', 'block');
      } else {
        jQuery('.ibtana-wizard-first-step-content h3.ive-coming-soon').css('display', 'none');
      }
    });
  }

  function ibtana_visual_editor_all_inner_pages_grid(parent_reference) {
    jQuery('.ibtana-wizard-four-step-content').addClass('ive-custom-template-container-search');
    var is_theme_active = '';
    var preview_btn= '';
    jQuery('.step-ive-wizard-four-step .ive-wz-spinner-wrap').show();
    jQuery.ajax({
      method: "POST",
      url: ive_whizzie_params.IBTANA_LICENSE_API_ENDPOINT + "get_client_inner_pages_list",
      data: JSON.stringify({
        parent_reference: parent_reference,
        domain: ive_whizzie_params.ive_domain_name,
        theme_license_key: ive_whizzie_params.ive_license_key,
        theme_text_domain: ive_whizzie_params.theme_text_domain
      }),
      dataType: 'json',
      contentType: 'application/json',
    }).done( function( data ) {
      jQuery('.step-ive-wizard-four-step .ive-wz-spinner-wrap').hide();
      console.log( 'data', data );
      var is_premium_theme_key_valid = data.is_key_valid;
      var template_with_inner_pages = data.data;
      for ( var k = 0; k < template_with_inner_pages.length; k++ ) {
        var template_or_inner_page  = template_with_inner_pages[k];
        var template_or_inner_page_is_premium = parseInt(template_or_inner_page.is_premium);
        var premium_badge = ``;
        if ( template_or_inner_page_is_premium ) {
          premium_badge = `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 76.65 100.86"><defs><style>.cls-1{fill:#330f48;}.cls-2{font-size:25.18px;fill:#fff;font-family:Lato-Black, Lato;font-weight:800;}.cls-3{letter-spacing:-0.02em;}</style><linearGradient id="linear-gradient" x1="38.3" y1="4.1" x2="37.36" y2="184.18" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#330f48"/><stop offset="0.05" stop-color="#35134b"/><stop offset="0.28" stop-color="#3c1f53"/><stop offset="0.5" stop-color="#3e2356"/></linearGradient></defs><g id="Layer_2" data-name="Layer 2"><g id="Ñëîé_1" data-name="Ñëîé 1"><path class="cls-1" d="M76.65,0H0c.57,1.11,1,2,1.21,2.66a28.73,28.73,0,0,1,2.2,10.25V15.3h0v85.41c4-3.95,7.9-6.47,11.85-10.42l12,10.57,11.08-9.65,11.07,9.65,12-10.57c4,3.95,7.9,6.47,11.85,10.42V15.3h0c0-.79,0-1.59,0-2.38a28.73,28.73,0,0,1,2.2-10.25C75.69,2.05,76.08,1.12,76.65,0Z"/><text class="cls-2" transform="translate(12.17 59.06)">P<tspan class="cls-3" x="16.06" y="0">R</tspan><tspan x="32.18" y="0">O</tspan></text></g></g></svg>`;
        }

        jQuery('.ibtana-wizard-four-step-content .ive-ibtaba-wizard-product-row').append(
          ` <div class="ive-o-products-col" data-page-type="`+template_or_inner_page.page_type+`">
              <div class="ive-o-products-image">
                  `+premium_badge+`
                  <img src="`+template_or_inner_page.image+`">
                  <div>
                      <a class="ive-template-preview-btn" ive-template-type="`+template_or_inner_page.template_type+`" ive-template-text-domain="`+template_or_inner_page.domain+`" ive-template-page-type="`+template_or_inner_page.page_type+`" ive-template-demo="`+template_or_inner_page.demo_url+`" ive-template-image="`+template_or_inner_page.image+`" ive-template-title="`+template_or_inner_page.name+`" ive-template-permalink="`+template_or_inner_page.permalink+`" ive-template-slug="`+template_or_inner_page.slug+`" ive-template-description="`+template_or_inner_page.description+`" ive-is-premium="`+template_or_inner_page.is_premium+`" ive-is-premium-theme-key-valid="`+is_premium_theme_key_valid+`" ive-template-textdomain="`+template_or_inner_page.domain+`" href="javascript:void(0);">Preview</a>
                  </div>
                  <div class="ive-template-grid-overlay"></div>
              </div>
              <h3>`+template_or_inner_page.name+`</h3>
          </div>`
        );
      }

      var page_types  = data.page_types;
      var total_count_page_types  = 0;
      jQuery('.ibtana-wizard-four-step-content ul').empty();
      for (var i = 0; i < page_types.length; i++) {
        var page_type = page_types[i];
        if ( page_type.page_type == 'template' ) {
          jQuery(
            `<li class="" data-page-type="`+page_type.page_type+`">
              <span class="ive-cat-name">` + page_type.display_string + `</span>
              <span class="ive-cat-count">` + page_type.count + `</span>
            </li>`
          ).prependTo( '.ibtana-wizard-four-step-content ul' );
        } else {
          jQuery( '.ibtana-wizard-four-step-content ul' ).append(
            `<li class="" data-page-type="`+page_type.page_type+`">
              <span class="ive-cat-name">` + page_type.display_string + `</span>
              <span class="ive-cat-count">` + page_type.count + `</span>
            </li>`
          );
        }
        total_count_page_types  +=  parseInt( page_type.count );
      }

      jQuery('.ive-ibtaba-wizard-inner-sub-cats li[data-page-type]:first').trigger( 'click' );
      if ( ibtana_visual_editor_get_the_current_view() == 'popup' ) {
        var ive_template_slug = IVE_WIZARD.ibtana_visual_editor_get_parsed_query_string().ive_template_slug;
        console.log( 'ive_template_slug', ive_template_slug );
        console.log(jQuery('.ive-template-preview-btn[ive-template-slug="'+ive_template_slug+'"]'));
        jQuery( '.ive-template-preview-btn[ive-template-slug="'+ive_template_slug+'"]' ).trigger( 'click' );
      }
    });
    return;
  }

  function ibtana_visual_editor_activate_inner_page_step( ive_template_parent_reference ) {
    jQuery( '.ibtana-wizard-four-step-content .ive-ibtaba-wizard-product-row' ).empty();
    jQuery('.ive-wizard-content-menu li').removeClass('active-step');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-four-step').addClass('active-step');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-first-step').hide();
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-second-step').hide();
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-three-step').hide();
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-four-step').show();
    jQuery('.ive-wizard-content-menu .step-ive-wizard-five-step').hide();
    IVE_WIZARD.ibtana_visual_editor_all_inner_pages_grid(ive_template_parent_reference);



    if ( ibtana_visual_editor_get_the_current_view() != 'popup' ) {
      IVE_WIZARD.ibtana_visual_editor_changeQueryParams(
        {
          ive_wizard_view: 'inner',
          page_template_parent: ive_template_parent_reference
        }
      );
    }
    return;
  }

  function ibtana_visual_editor_activate_parent_page_step() {
    jQuery( '.ive-ibtana-wizard-button-wrapper a.ibtana-free-template-button.active' ).trigger( 'click' );
  }

  function ibtana_visual_editor_set_query_string( query_object, prefix ) {
    var str = [], p;
    for (p in query_object) {
      if (query_object.hasOwnProperty(p)) {
        var k = prefix ? prefix + "[" + p + "]" : p,
        v = query_object[p];
        str.push((v !== null && typeof v === "object") ?
        ibtana_visual_editor_set_query_string(v, k) :
        encodeURIComponent(k) + "=" + encodeURIComponent(v));
      }
    }
    return str.join("&");
  }

  function ibtana_visual_editor_get_parsed_query_string( query_string = window.location.search.substring(1) ) {

    if ( query_string.charAt(0) == '?' ) {
      query_string  = query_string.substring(1);
    }

    var vars = query_string.split("&");
    var query_string_obj = {};
    for (var i = 0; i < vars.length; i++) {
      var pair = vars[i].split("=");
      var key = decodeURIComponent(pair[0]);
      var value = decodeURIComponent(pair[1]);
      // If first entry with this name
      if (typeof query_string_obj[key] === "undefined") {
        query_string_obj[key] = decodeURIComponent(value);
        // If second entry with this name
      } else if (typeof query_string_obj[key] === "string") {
        var arr = [query_string_obj[key], decodeURIComponent(value)];
        query_string_obj[key] = arr;
        // If third or later entry with this name
      } else {
        query_string_obj[key].push(decodeURIComponent(value));
      }
    }
    return query_string_obj;
  }

  function ibtana_visual_editor_ive_pushState( query_string_to_replace ) {
    window.history.pushState( null, null, window.location.origin + window.location.pathname + '?' + query_string_to_replace );
    return;
  }

  function ibtana_visual_editor_replaceState(  ) {
    window.history.replaceState( null, null, window.location.origin + window.location.pathname + '?' + query_string_to_replace );
    return;
  }

  function ibtana_visual_editor_changeQueryParams( passed_query_obj, will_add = true ) {
    var existing_query_obj  = IVE_WIZARD.ibtana_visual_editor_get_parsed_query_string();
    for ( pk in passed_query_obj ) {
      existing_query_obj[pk] = passed_query_obj[pk];
    }
    var new_query_string  = ibtana_visual_editor_set_query_string(existing_query_obj);
    ibtana_visual_editor_ive_pushState(new_query_string);
    return;
  }

  var current_step = '';
  var step_pointer = '';

  // callbacks from form button clicks.
  var callbacks = {
    do_next_step: function( btn ) {
      do_next_step( btn );
    },
    import_free_template: function(btn) {
      $('.ive-wizard-spinner').css('display', 'block');
      var free_tem_slug       = document.querySelector('.ive-sidebar-import-button a').getAttribute('ive-template-slug');
      var temp_type           = document.querySelector('.ive-sidebar-import-button a').getAttribute('ive-template-type');
      var free_tem_page_type  = document.querySelector('.ive-sidebar-import-button a').getAttribute('ive-template-page-type');
      var ive_page_title      = document.querySelector('.ive-sidebar-import-button a').getAttribute('ive-template-page-title');
      var free_theme_demo     = new ibtana_visual_editor_importThemeTemplateDemo(free_tem_slug, 0, temp_type, free_tem_page_type, ive_page_title);
      free_theme_demo.init(btn);
    },
    import_premium_template: function(btn) {
      $('.ive-wizard-spinner').css('display', 'block');
      var premium_tem_slug      = document.querySelector('.ive-sidebar-import-button a').getAttribute('ive-template-slug');
      var temp_type             = document.querySelector('.ive-sidebar-import-button a').getAttribute('ive-template-type');
      var premium_tem_page_type = document.querySelector('.ive-sidebar-import-button a').getAttribute('ive-template-page-type');
      var ive_page_title        = document.querySelector('.ive-sidebar-import-button a').getAttribute('ive-template-page-title');
      var premium_theme_demo    = new ibtana_visual_editor_importThemeTemplateDemo(premium_tem_slug, 1, temp_type, premium_tem_page_type, ive_page_title);
      premium_theme_demo.init(btn);
    }
  };

  function ibtana_visual_editor_window_loaded() {
    // Get all steps and find the biggest
    // Set all steps to same height
    var maxHeight = 0;

    $('.ive-wizard-content-menu li.step').each(function(index) {
      $(this).attr('data-height', $(this).innerHeight());
      if ($(this).innerHeight() > maxHeight) {
        maxHeight = $(this).innerHeight();
      }
    });

    $('.ive-wizard-content-menu li .detail').each(function(index) {
      $(this).attr('data-height', $(this).innerHeight());
      $(this).addClass('scale-down');
    });

    // $('.ive-wizard-content-menu li.step').css('height', '100%');
    $('.ive-wizard-content-menu li.step:first-child').addClass('active-step');

    $('.ive-whizzie-wrap').addClass('loaded');

    // init button clicks
    $( '.ive-do-it' ).on( 'click', function(e) {
      e.preventDefault();
      var ive_template_text_domain = $( this ).attr( 'ive-template-text-domain' );
      var $this = $( this );
      jQuery( '.ive-demo-child .ive-checkbox-container' ).attr( 'ive-template-text-domain', ive_template_text_domain );

      // $('.ive-whizzie-wrap').addClass('ive-spinning');
      if ($(this).attr('data-callback') && typeof callbacks[$(this).attr('data-callback')] != 'undefined') {
        // we have to process a callback before continue with form submission
        if ( ($(this).attr('data-callback') == 'import_free_template') || ($(this).attr('data-callback') == 'import_premium_template') ) {
          if ( ( ive_template_text_domain == ive_whizzie_params.theme_text_domain ) || ( ive_template_text_domain == ive_whizzie_params.custom_text_domain ) ) {
            // callbacks[$(this).attr('data-callback')](this);
            // return false;
            jQuery( '.ive-demo-child .ive-checkbox-container' ).addClass( 'activated' );
          }
          $( '.ive-plugin-popup' ).show();
          activate_first_step_in_step_popup();
          // else {
          //   alertify.confirm("Notice that you dont have the base theme installed/activated. Click the below button to install/activate the base theme.")
          //   .setHeader('Base Theme')
          //   .setContent(
          //     `<p>Note that you don\'t have the base theme installed/activated.</p>
          //     <p>Click <b>Yes</b> to install and acitvate the base theme first and import.</p>
          //     <p>Click <b>No</b> to import without the base theme.</p>`
          //   )
          //   .set( 'labels', { ok: 'Yes', cancel: 'No' } )
          //   .set( 'onok', function( event ) {
          //     $('.ive-wizard-spinner').show();
          //     var $button = jQuery( event.button.element ), $document  = jQuery( document );
          //     // Check the theme is already is installed or not START
          //     jQuery.ajax({
          //       url:   ive_whizzie_params.ajaxurl,
          //       type:  "POST",
          //       data: {
          //         "action" : "ive-get-installed-theme",
          //         "slug"   : ive_template_text_domain,
          //         "nonce"  : ive_whizzie_params.wpnonce,
          //       },
          //     }).done(function (result) {
          //       if( result.success ) {
          //
          //         if ( result.data.install_status === true ) {
          //           // Theme is already installed and ready to active
          //
          //           // Activation Script START
          //           $button.text( "Activating" ).addClass( "updating-message" );
          //           // WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
          //           setTimeout( function() {
          //             jQuery.ajax({
          //               url:   ive_whizzie_params.ajaxurl,
          //               type:  "POST",
          //               data: {
          //                 "action" : "ive-theme-activate",
          //                 "slug"   : ive_template_text_domain,
          //                 "nonce"  : ive_whizzie_params.wpnonce,
          //               },
          //             }).done(function (result) {
          //               if( result.success ) {
          //                 ive_whizzie_params.theme_text_domain = ive_template_text_domain;
          //                 $button.text( "Activated" ).removeClass( "updating-message" );
          //                 callbacks[$this.attr('data-callback')]($this);
          //               }
          //             });
          //           }, 1200 );
          //           // Activation Script END
          //
          //         } else {
          //           // Theme is need to be downloaded and installed.
          //
          //           $button.text( 'Installing' ).addClass( "ive-updating-message" );
          //           if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
          //             wp.updates.requestFilesystemCredentials( event );
          //             $document.on( "credential-modal-cancel", function() {
          //               $button.text( wp.updates.l10n.installNow );
          //               wp.a11y.speak( wp.updates.l10n.updateCancel, "polite" )
          //             } );
          //           }
          //           wp.updates.installTheme( {
          //             slug:    ive_template_text_domain
          //           }).then(function(e) {
          //             $button.removeClass( "ive-install-theme ive-updating-message" ).addClass( "ive-activate-theme" ).text( "Activate "+e.themeName+"!" );
          //             // Activation Script START
          //             $button.text( "Activating" ).addClass( "updating-message" );
          //             // WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
          //             setTimeout( function() {
          //               jQuery.ajax({
          //                 url:   ive_whizzie_params.ajaxurl,
          //                 type:  "POST",
          //                 data: {
          //                   "action" : "ive-theme-activate",
          //                   "slug"   : ive_template_text_domain,
          //                   "nonce"  : ive_whizzie_params.wpnonce,
          //                 },
          //               }).done(function (result) {
          //                 if( result.success ) {
          //                   ive_whizzie_params.theme_text_domain = ive_template_text_domain;
          //                   $button.text( "Activated" ).removeClass( "updating-message" );
          //                   callbacks[$this.attr('data-callback')]($this);
          //                 }
          //               });
          //             }, 1200 );
          //             // Activation Script END
          //           });
          //         }
          //       }
          //     });
          //     // Check the theme is already is installed or not
          //   } )
          //   .set( 'oncancel' , function( event ) {
          //     $('.ive-wizard-spinner').show();
          //     callbacks[$this.attr('data-callback')]($this);
          //     return false;
          //   })
          //   .set( 'onclose', function( event ) {
          //   } );
          // }
        } else {
          callbacks[$($this).attr('data-callback')]($this);
          return false;
        }
      } else {
        return true;
      }
    });

    function activate_first_step_in_step_popup() {
      $( '.ive-current-step .ive-demo-step' ).removeClass( 'active' );
      $( '.ive-current-step .ive-demo-step-0' ).addClass( 'active' );
      $( '.ive-steps-pills li' ).removeClass( 'active' );
      $( '.ive-steps-pills li:first' ).addClass( 'active' );
      $( '.ive-demo-back-btn' ).hide();
      $( '.ive-demo-main-btn' ).text( 'Next' );
      $( '.ive-demo-main-btn' ).show();
      $( '.ive-steps-pills' ).show();
      $( '.ive-close-button' ).show();
    }

    $( '.ive-demo-btn' ).on( 'click', function() {
      var $this_btn = $( this );

      var current_step_index = jQuery( '.ive-current-step .ive-demo-step.active' ).index();
      if ( $this_btn.hasClass( 'ive-demo-main-btn' ) ) {
        ++current_step_index;
      } else if ( $this_btn.hasClass( 'ive-demo-back-btn' ) ) {
        --current_step_index;
      }
      $( '.ive-current-step .ive-demo-step' ).removeClass( 'active' );
      $( '.ive-current-step .ive-demo-step-' + current_step_index ).addClass( 'active' );
      $( '.ive-steps-pills li' ).removeClass( 'active' );
      $( '.ive-steps-pills li' ).eq( current_step_index ).addClass( 'active' );

      // Back Button Show Hide
      if ( current_step_index != 0 ) {
        $( '.ive-demo-back-btn' ).show();
      } else {
        $( '.ive-demo-back-btn' ).hide();
      }

      if ( current_step_index == 2 ) {
        $( '.ive-demo-main-btn' ).text( 'Install & Import' );
      } else {
        $( '.ive-demo-main-btn' ).text( 'Next' );
      }

      if ( current_step_index != 3 ) {
        $( '.ive-demo-main-btn' ).show();
      } else {
        $( '.ive-demo-main-btn' ).hide();
        $( '.ive-demo-back-btn' ).hide();
        $( '.ive-steps-pills' ).hide();
        $( '.ive-close-button' ).hide();
        install_theme_and_plugins_using_ajax();
      }
    });

    function install_theme_and_plugins_using_ajax() {

      var total_progress_count = 0;

      // Check if the base theme is selected
      var theme_text_domain = '';
      if ( $( '.ive-demo-child .ive-checkbox-container:not(.activated) .ive-checkbox' ).hasClass('active') ) {
        // Get the theme name
        theme_text_domain = $('.ive-demo-child .ive-checkbox-container').attr('ive-template-text-domain');
        ++total_progress_count;
      }

      // Check if the plugins are selected
      var plugins_array = [];
      var plugin_checked_boxes = jQuery('.ive-demo-plugins .ive-checkbox-container .ive-checkbox.active');
      $.each( plugin_checked_boxes, function( index, plugin_checked_box ) {
        var $parent_div = jQuery(this).closest('.ive-checkbox-container');
        var plugin_text_domain = $parent_div.attr( 'ive-plugin-text-domain' );
        var plugin_main_file = $parent_div.attr( 'ive-plugin-main-file' );
        var ive_plugin_url = $parent_div.attr( 'ive-plugin-url' );
        plugins_array.push({
          plugin_text_domain: plugin_text_domain,
          plugin_main_file: plugin_main_file,
          plugin_url: ive_plugin_url
        });
        ++total_progress_count;
      });
      console.log( 'plugins_array', plugins_array );
      console.log( 'total_progress_count', total_progress_count );

      set_installation_progress_status();

      if ( total_progress_count === 0 ) {
        set_installation_progress_status( 100 );
        ibtana_visual_editor_importThemeTemplateJson( jQuery('.ive-do-it') );
      } else {
        if ( theme_text_domain != '' ) {
          install_or_activate_theme( theme_text_domain, function() {
            --total_progress_count;
            if ( total_progress_count === 0 ) {
              set_installation_progress_status( 100 );
              ibtana_visual_editor_importThemeTemplateJson( jQuery('.ive-do-it') );
            }
            for (var i = 0; i < plugins_array.length; i++) {
              var plugin_single = plugins_array[i];
              install_or_activate_plugin( plugin_single, function( result ) {
                console.log( 'result', result );
                --total_progress_count;
                console.log( 'total_progress_count', total_progress_count );
                if ( total_progress_count == 0 ) {
                  set_installation_progress_status( 100 );
                  ibtana_visual_editor_importThemeTemplateJson( jQuery('.ive-do-it') );
                }
              });
            }
          });
        } else {
          for (var i = 0; i < plugins_array.length; i++) {
            var plugin_single = plugins_array[i];
            install_or_activate_plugin( plugin_single, function( result ) {
              console.log( 'result', result );
              --total_progress_count;
              console.log( 'total_progress_count', total_progress_count );
              if ( total_progress_count == 0 ) {
                set_installation_progress_status( 100 );
                ibtana_visual_editor_importThemeTemplateJson( jQuery('.ive-do-it') );
              }
            });
          }
        }
      }

    }

    function ibtana_visual_editor_importThemeTemplateJson( $this ) {
      var free_template_slug  = $this.attr( 'ive-template-slug' );
      var is_pro_or_free      = parseInt( $this.attr( 'ive-is-premium' ) );
      var temp_type           = $this.attr( 'ive-template-type' );
      var page_type           = $this.attr( 'ive-template-page-type' );
      var ive_page_title      = $this.attr( 'ive-template-page-title' );
      var demo_action = '';
      var params = {
        action:         'ibtana_visual_editor_setup_free_demo',
        slug:           free_template_slug,
        temp_type:      temp_type,
        page_type:      page_type,
        page_title:     ive_page_title,
        wpnonce:        ive_whizzie_params.wpnonce,
        is_pro_or_free: is_pro_or_free
      };

      jQuery.post(
        ive_whizzie_params.ajaxurl,
        params,
        function( response ) {
          if ( response.home_page_url != "" ) {
            location.href = response.home_page_url;
          }
        }
      );
    }

    function install_or_activate_plugin( plugin_details, callback ) {
      jQuery.ajax({
        url:   ive_whizzie_params.ajaxurl,
        type:  "POST",
        data: {
          "action"         : "ive_install_and_activate_plugin",
          "plugin_details" : plugin_details,
          "nonce"          : ive_whizzie_params.wpnonce,
        },
      }).done(function ( result ) {
        callback( result );
      });
    }

    function install_or_activate_theme( ive_template_text_domain, callback ) {
      jQuery.ajax({
        url:   ive_whizzie_params.ajaxurl,
        type:  "POST",
        data: {
          "action" : "ive-get-installed-theme",
          "slug"   : ive_template_text_domain,
          "nonce"  : ive_whizzie_params.wpnonce,
        },
      }).done(function (result) {
        if( result.success ) {
          if ( result.data.install_status === true ) {
            // Theme is already installed and ready to active

            // Activation Script START
            setTimeout( function() {
              jQuery.ajax({
                url:   ive_whizzie_params.ajaxurl,
                type:  "POST",
                data: {
                  "action" : "ive-theme-activate",
                  "slug"   : ive_template_text_domain,
                  "nonce"  : ive_whizzie_params.wpnonce,
                },
              }).done(function (result) {
                if( result.success ) {
                  ive_whizzie_params.theme_text_domain = ive_template_text_domain;
                  // return
                  callback();
                }
              });
            }, 1200 );
            // Activation Script END

          } else {
            // Theme is need to be downloaded and installed.
            wp.updates.installTheme( {
              slug:    ive_template_text_domain
            }).then(function(e) {
              // Activation Script START
              setTimeout( function() {
                jQuery.ajax({
                  url:   ive_whizzie_params.ajaxurl,
                  type:  "POST",
                  data: {
                    "action" : "ive-theme-activate",
                    "slug"   : ive_template_text_domain,
                    "nonce"  : ive_whizzie_params.wpnonce,
                  },
                }).done(function (result) {
                  if( result.success ) {
                    ive_whizzie_params.theme_text_domain = ive_template_text_domain;
                    // return
                    callback()
                  }
                });
              }, 1200 );
              // Activation Script END
            });
          }
        }
      });
    }

    var progress_interval;
    function set_installation_progress_status( progress = 1 ) {
      if ( progress >= 100 ) {
        clearInterval( progress_interval );
        jQuery( '.ive-demo-install' ).attr( 'data-progress', 100 );
        jQuery( '.ive-demo-install span' ).text( '100%' );
        jQuery( '.ive-demo-install .ive-installer-progress div' ).css( 'width', '100%' );
      } else {
        progress_interval = setInterval( do_progress, 1000 );
      }
      function do_progress() {
        ++progress;
        jQuery( '.ive-demo-install' ).attr( 'data-progress', progress );
        jQuery( '.ive-demo-install span' ).text( progress + '%' );
        jQuery( '.ive-demo-install .ive-installer-progress div' ).css( 'width', progress + '%' );
      }
    }

    // Conditions for prev and next buttons START
    if ( IVE_WIZARD.ibtana_visual_editor_get_the_current_view() == 'popup' ) {

    }
    // Conditions for prev and next buttons END
  }

  function do_next_step( btn ) {
    $('.nav-step-ive-wizard-second-step').attr('data-enable', 1);
    current_step = $('.step-' + $(this).data('step'));
    current_step.removeClass('active-step');
    step_pointer = $(this).data('step');
    $('.nav-step-' + step_pointer).removeClass('active-step');
    current_step.addClass('done-step');
    $('.nav-step-' + step_pointer).addClass('done-step');
    current_step.fadeOut(500, function() {
      current_step = current_step.next();
      step_pointer = current_step.data('step');
      current_step.fadeIn();
      current_step.addClass('active-step');
      $('.nav-step-' + step_pointer).addClass('active-step');
      $('.ive-whizzie-wrap').removeClass('ive-spinning');
    });
  }

  function ibtana_visual_editor_importThemeTemplateDemo(free_template_slug, is_pro_or_free, temp_type, page_type, ive_page_title) {
    var demo_action = '';
    var params = {
      action:         'ibtana_visual_editor_setup_free_demo',
      slug:           free_template_slug,
      temp_type:      temp_type,
      page_type:      page_type,
      page_title:     ive_page_title,
      wpnonce:        ive_whizzie_params.wpnonce,
      is_pro_or_free: is_pro_or_free
    };

    function ibtana_visual_editor_import_template() {
      jQuery.post(
        ive_whizzie_params.ajaxurl,
        params,
        ajax_callback).fail(ajax_callback);
    }
    return {
      init: function( btn ) {
        ajax_callback = function( response ) {
          if ( response.home_page_url != "" ) {
            location.href = response.home_page_url;
          }
          // $('.ive-wizard-spinner').css('display', 'none');
          do_next_step();
        }
        ibtana_visual_editor_import_template();
      }
    }
  }

  function ibtana_visual_editor_get_the_current_view() {
    var ibtana_visual_editor_get_the_current_view  = IVE_WIZARD.ibtana_visual_editor_get_parsed_query_string();
    if (ibtana_visual_editor_get_the_current_view) {
      if ( ibtana_visual_editor_get_the_current_view.ive_wizard_view !== undefined ) {
        return ibtana_visual_editor_get_the_current_view.ive_wizard_view;
      } else {
        return 'parent';
      }
    }
  }

  function ibtana_visual_editor_check_the_page_state() {
    IVE_WIZARD.ibtana_visual_editor_all_template_grid( '', 1, 1, 'wordpress' );
    var parsed_query_string_obj = IVE_WIZARD.ibtana_visual_editor_get_parsed_query_string();
    if ( parsed_query_string_obj.ive_wizard_view !== undefined ) {

      if ( parsed_query_string_obj.ive_wizard_view == "inner" ) {
        IVE_WIZARD.ibtana_visual_editor_activate_inner_page_step( IVE_WIZARD.ibtana_visual_editor_get_parsed_query_string().page_template_parent );

      } else if ( parsed_query_string_obj.ive_wizard_view == "popup" ) {
        ibtana_visual_editor_activate_inner_page_step( IVE_WIZARD.ibtana_visual_editor_get_parsed_query_string().page_template_parent );

      } else {
        ibtana_visual_editor_activate_parent_page_step();
      }
    } else {
      ibtana_visual_editor_activate_parent_page_step();
    }
  }

  window.onpopstate = function ( event ) {
    console.log( 'onpopstate event', event );
    var current_view  = ibtana_visual_editor_get_the_current_view();
    console.log( 'current_view', current_view );

    if ( current_view == 'parent' ) {
      ibtana_visual_editor_activate_parent_page_step();
    } else if ( current_view == 'inner' ) {
      ibtana_visual_editor_activate_inner_page_step( IVE_WIZARD.ibtana_visual_editor_get_parsed_query_string().page_template_parent );
    } else if ( current_view == 'popup' ) {
      ibtana_visual_editor_activate_inner_page_step( IVE_WIZARD.ibtana_visual_editor_get_parsed_query_string().page_template_parent );
      var ive_template_slug = IVE_WIZARD.ibtana_visual_editor_get_parsed_query_string().ive_template_slug;
      console.log( 'ive_template_slug', ive_template_slug );
      jQuery('.ive-template-preview-btn[ive-template-slug="'+ive_template_slug+'"]').trigger('click');
    }
  };

  return {
    init: function() {
      $(ibtana_visual_editor_window_loaded);
    },
    callbacks: callbacks,
    ibtana_visual_editor_get_parsed_query_string: ibtana_visual_editor_get_parsed_query_string,
    ibtana_visual_editor_set_query_string: ibtana_visual_editor_set_query_string,
    ibtana_visual_editor_ive_pushState: ibtana_visual_editor_ive_pushState,
    ibtana_visual_editor_changeQueryParams: ibtana_visual_editor_changeQueryParams,
    ibtana_visual_editor_activate_inner_page_step: ibtana_visual_editor_activate_inner_page_step,
    ibtana_visual_editor_all_template_grid: ibtana_visual_editor_all_template_grid,
    ibtana_visual_editor_all_inner_pages_grid: ibtana_visual_editor_all_inner_pages_grid,
    ibtana_visual_editor_check_the_page_state: ibtana_visual_editor_check_the_page_state,
    ibtana_visual_editor_setup_preview_popup: ibtana_visual_editor_setup_preview_popup,
    ibtana_visual_editor_get_the_current_view: ibtana_visual_editor_get_the_current_view
  };

})(jQuery);


window.addEventListener( 'load', function() {

  IVE_WIZARD.ibtana_visual_editor_check_the_page_state();

  var current_menu = '';
  var current_icon_step = '';

  var search_keyword= '';
  var next_theme_page= '';
  //---------- Ibtana Wizard Templates --------


  // --------- Free Template Button ----------

  jQuery( document.body ).on( 'click', '.ive-ibtana-wizard-button-wrapper a.ibtana-free-template-button', function(e) {
    e.preventDefault();
    var $this = jQuery( this );

    if ( $this.hasClass('custom-template') ) {
      if ( jQuery(this).attr('data-callback') && typeof IVE_WIZARD.callbacks[jQuery(this).attr('data-callback')] != 'undefined' ) {
        IVE_WIZARD.callbacks[jQuery($this).attr('data-callback')]($this);
      }
      // jQuery( '.ibtana-wizard-four-step-content .ive-ibtaba-wizard-product-row' ).empty();
      jQuery('.ive-ibtana-wizard-button-wrapper .button-wrap a').removeClass('active');
      jQuery($this).addClass('active');
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-first-step').hide();
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-second-step').hide();
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-three-step').hide();
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-four-step').show();
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-five-step').hide();
      jQuery('.ive-wizard-content-menu li').removeClass('active-step');
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-four-step').addClass('active-step');

      jQuery('.ibtana-wizard-four-step-content .ive-o-product-main-row').addClass('custom-template-container');
      jQuery('.ibtana-wizard-four-step-content').removeClass('ive-custom-template-container-search');

      ibtana_visual_editor_all__pages_list_by_template_type( '', 1, 1, jQuery($this).attr('data-template-type') );
    } else {
      if ( jQuery(this).attr('data-callback') && typeof IVE_WIZARD.callbacks[jQuery(this).attr('data-callback')] != 'undefined' ) {
        IVE_WIZARD.callbacks[jQuery($this).attr('data-callback')]($this);
      }
      jQuery('.ive-ibtana-wizard-button-wrapper .button-wrap a').removeClass('active');
      jQuery($this).addClass('active');
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-first-step').show();
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-second-step').hide();
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-three-step').hide();
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-four-step').hide();
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-five-step').hide();
      jQuery('.ive-wizard-content-menu li').removeClass('active-step');
      jQuery('.ive-wizard-content-menu li.step-ive-wizard-first-step').addClass('active-step');

      jQuery('.ibtana-wizard-four-step-content .ive-o-product-main-row').removeClass('custom-template-container');
      jQuery('.ibtana-wizard-four-step-content').addClass('ive-custom-template-container-search');

      // Clear the search and product Categories START
      jQuery( '.step-ive-wizard-first-step .ive-admin-wizard-search' ).val( '' );
      jQuery( '.ibtana-wizard-first-step-content .ive-ibtaba-wizard-inner-sub-cats li[data-product-category]' ).removeClass( 'active' );
      // Clear the search and product Categories END
      IVE_WIZARD.ibtana_visual_editor_all_template_grid( '', 1, 1, jQuery($this).attr('data-template-type') );
    }

    ibtana_visual_editor_fix_the_loader();
    IVE_WIZARD.ibtana_visual_editor_changeQueryParams(
      {
        ive_wizard_view:  'parent',
      }
    );
  });

  jQuery( '.ibtana-wizard-four-step-content .ive-template-load-more a' ).click(function() {
    var page_no = parseInt(jQuery(this).attr('ive_current_grid_no'));
    ibtana_visual_editor_all__pages_list_by_template_type( '', page_no, 0, jQuery('.ive-ibtana-wizard-button-wrapper a.ibtana-free-template-button.active').attr('data-template-type') );
  });

  jQuery(".step-ive-wizard-four-step .ive-admin-wizard-search").on( 'input', function() {
    search_keyword = jQuery(this).val().toLowerCase().trim();
    ibtana_visual_editor_all__pages_list_by_template_type( search_keyword, 1, 1, jQuery('.ive-ibtana-wizard-button-wrapper a.ibtana-free-template-button.active').attr('data-template-type') );
  });

  function ibtana_visual_editor_all__pages_list_by_template_type( search_key, next_page_number, will_clear = 1, template_type ) {

    var data_post = {
      "domain":             ive_whizzie_params.ive_domain_name,
      "limit":              9,
      "start":              next_page_number,
      "search":             search_key,
      "template_type":      template_type
    };

    console.log( 'data_post', data_post );

    jQuery('.step-ive-wizard-four-step .ive-wz-spinner-wrap').show();
    jQuery.ajax({
      method: "POST",
      url: ive_whizzie_params.IBTANA_LICENSE_API_ENDPOINT + "get_client_pages_list_by_template_type",
      data: JSON.stringify(data_post),
      dataType: 'json',
      contentType: 'application/json',
    }).done(function( data ) {
      jQuery('.step-ive-wizard-four-step .ive-wz-spinner-wrap').hide();

      if ( data.next_page_number ) {
        jQuery( '.ibtana-wizard-four-step-content .ive-template-load-more a' ).attr( 'ive_current_grid_no', data.next_page_number );
        jQuery( '.ibtana-wizard-four-step-content .ive-template-load-more' ).show();
      } else {
        jQuery( '.ibtana-wizard-four-step-content .ive-template-load-more' ).hide();
      }

      if ( will_clear === 1 ) {
        jQuery( '.ibtana-wizard-four-step-content .ive-ibtaba-wizard-product-row' ).empty();
      }

      var is_premium_theme_key_valid = data.is_key_valid;
      var template_with_inner_pages = data.data;
      jQuery('.ibtana-wizard-four-step-content ul').empty();
      for ( var k = 0; k < template_with_inner_pages.length; k++ ) {
        var template_or_inner_page  = template_with_inner_pages[k];

        var template_or_inner_page_is_premium = parseInt(template_or_inner_page.is_premium);
        var premium_badge = ``;
        if ( template_or_inner_page_is_premium ) {
          premium_badge = `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 76.65 100.86"><defs><style>.cls-1{fill:#330f48;}.cls-2{font-size:25.18px;fill:#fff;font-family:Lato-Black, Lato;font-weight:800;}.cls-3{letter-spacing:-0.02em;}</style><linearGradient id="linear-gradient" x1="38.3" y1="4.1" x2="37.36" y2="184.18" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#330f48"/><stop offset="0.05" stop-color="#35134b"/><stop offset="0.28" stop-color="#3c1f53"/><stop offset="0.5" stop-color="#3e2356"/></linearGradient></defs><g id="Layer_2" data-name="Layer 2"><g id="Ñëîé_1" data-name="Ñëîé 1"><path class="cls-1" d="M76.65,0H0c.57,1.11,1,2,1.21,2.66a28.73,28.73,0,0,1,2.2,10.25V15.3h0v85.41c4-3.95,7.9-6.47,11.85-10.42l12,10.57,11.08-9.65,11.07,9.65,12-10.57c4,3.95,7.9,6.47,11.85,10.42V15.3h0c0-.79,0-1.59,0-2.38a28.73,28.73,0,0,1,2.2-10.25C75.69,2.05,76.08,1.12,76.65,0Z"/><text class="cls-2" transform="translate(12.17 59.06)">P<tspan class="cls-3" x="16.06" y="0">R</tspan><tspan x="32.18" y="0">O</tspan></text></g></g></svg>`;
        }
        jQuery('.ibtana-wizard-four-step-content .ive-ibtaba-wizard-product-row').append(
          ` <div class="ive-o-products-col" data-page-type="`+template_or_inner_page.page_type+`">
              <div class="ive-o-products-image">
                  `+premium_badge+`
                  <img src="`+template_or_inner_page.image+`">
                  <div>
                      <a class="ive-template-preview-btn" ive-template-type="`+template_or_inner_page.template_type+`" ive-template-text-domain="`+template_or_inner_page.domain+`" ive-template-page-type="`+template_or_inner_page.page_type+`" ive-template-demo="`+template_or_inner_page.demo_url+`" ive-template-image="`+template_or_inner_page.image+`" ive-template-title="`+template_or_inner_page.name+`" ive-template-permalink="`+template_or_inner_page.permalink+`" ive-template-slug="`+template_or_inner_page.slug+`" ive-template-description="`+template_or_inner_page.description+`" ive-is-premium="`+template_or_inner_page.is_premium+`" ive-is-premium-theme-key-valid="`+is_premium_theme_key_valid+`" ive-template-textdomain="`+template_or_inner_page.domain+`" href="javascript:void(0);">Preview</a>
                  </div>
                  <div class="ive-template-grid-overlay"></div>
              </div>
              <h3>`+template_or_inner_page.name+`</h3>
          </div>`
        );
      }
    });
  }

  jQuery('.ive-ibtana-wizard-button-wrapper a.ibtana-premium-template-button').click(function() {
    var premium_data='';
    jQuery('.ive-wizard-content-menu li').removeClass('active-step');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-second-step ').addClass('active-step');

    jQuery('.ive-ibtana-wizard-button-wrapper .button-wrap a').removeClass('active');
    jQuery(this).addClass('active');
    jQuery('.ive-wizard-content-menu .step-ive-wizard-three-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu .step-ive-wizard-four-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu .step-ive-wizard-five-step').css('display', 'none');
    var premium_tem = jQuery('.step-ive-wizard-second-step .ive-ibtaba-wizard-product-row .ive-o-products-col');
    if(premium_tem.length==0){
      jQuery('.step-ive-wizard-second-step .ive-wz-spinner-wrap').css('display', 'block');
      var data_post = {
        "admin_user_ibtana_license_key": ive_whizzie_params.ive_license_key,
        "domain": ive_whizzie_params.ive_domain_name
      };
      jQuery.ajax({
        method: "POST",
        url: ive_whizzie_params.IBTANA_LICENSE_API_ENDPOINT + "get_modal_contents",
        data: JSON.stringify(data_post),
        dataType: 'json',
        contentType: 'application/json',
      }).done(function(data) {
          premium_data = data.data.premium;
          for (var i = 0; i < premium_data.length; i++) {
            var premium_product = premium_data[i];

            var premium_product_title = premium_product.name;

            var premium_product_description = '';
            if (premium_product.description) {
              premium_product_description = premium_product.description;
            }

            var premium_product_demo_url = '';
            if (premium_product.demo_url) {
              premium_product_demo_url = premium_product.demo_url;
            }

            var premium_product_permalink = '';
            if (premium_product.permalink) {
              premium_product_permalink = premium_product.permalink;
            }
            var card_content = `
              <div class="ive-o-products-col" data-id="` + premium_product.id + `">
                <div class="ive-o-products-image">
                    <img src="` + premium_product.image + `">
                    <div>
                        <a class="ive-premium-template-import-btn" href="javascript:void(0);" ive-template-demo="` + premium_product_demo_url + `" ive-template-image="` + premium_product.image + `" ive-template-title="` + premium_product_title + `" ive-template-demo-url="` + premium_product_demo_url + `" ive-template-permalink="` + premium_product_permalink + `" ive-is-key-valid="` + data.data.is_key_valid + `" ive-template-description="` + premium_product_description + `" ive-template-slug="` + premium_product.slug + `">Preview</a>
                    </div>
                    <div class="ive-template-grid-overlay"></div>
                </div>
                <h3>` + premium_product_title + `</h3>
              </div>`;
            jQuery('#ibtana-free-templates .ive-ibtaba-wizard-product-row').append(card_content);

          }
        jQuery('.ive-wz-spinner-wrap').css('display', 'none');
        if (data.data.premium.length == 0) {
          jQuery('#ibtana-free-templates h3.ive-coming-soon').show();
          jQuery('#ibtana-free-templates .ive-social-theme-search').hide();
        } else {
          jQuery('#ibtana-free-templates h3.ive-coming-soon').hide();
          jQuery('#ibtana-free-templates .ive-social-theme-search').show();
        }
      });
    }
  });

 /* --------- Load More Event --------- */

  jQuery( '.ibtana-wizard-first-step-content .ive-template-load-more a' ).click(function() {
    var page_no = parseInt( jQuery(this).attr( 'ive_current_grid_no' ) );
    var product_category = jQuery('.ibtana-wizard-first-step-content li[data-product-category].active').attr('data-product-category');
    if ( !product_category ) {
      product_category = null;
    }
    IVE_WIZARD.ibtana_visual_editor_all_template_grid(
      '',
      page_no,
      0,
      jQuery('.ive-ibtana-wizard-button-wrapper a.ibtana-free-template-button.active').attr('data-template-type'),
      product_category
    );
  });

  /* ----------  Demo Import Step ------ */
  jQuery( '.ive-ibtaba-wizard-product-row' ).on( 'click', '.ive-template-preview-btn', function() {
    IVE_WIZARD.ibtana_visual_editor_setup_preview_popup( jQuery(this) );
  });



  jQuery('.ive-base-theme-notice button').on('click', function(event) {
    return false;
    event.preventDefault()

    var $button = jQuery( event.target ), $document  = jQuery(document);
    var $slug = $button.attr("data-slug")

    $button.text( 'Installing' ).addClass( "ive-updating-message" );
    if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
      wp.updates.requestFilesystemCredentials( event );
      $document.on( "credential-modal-cancel", function() {
        $button.text( wp.updates.l10n.installNow );
        wp.a11y.speak( wp.updates.l10n.updateCancel, "polite" )
      } );
    }
    wp.updates.installTheme( {
      slug:    $slug
    }).then(function(e) {
      $button.removeClass( "ive-install-theme ive-updating-message" ).addClass( "ive-activate-theme" ).text( "Activate "+e.themeName+"!" );
      ibtana_visual_editor_activate_ive_theme($button, $slug);
    });
    ibtana_visual_editor_activate_ive_theme($button, $slug);
  });

  function ibtana_visual_editor_activate_ive_theme($button, $slug) {
    // Activation Script START
    $button.text( "Activating" ).addClass( "updating-message" );
    // WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
    setTimeout( function() {
      jQuery.ajax({
        url:   ive_whizzie_params.ajaxurl,
        type:  "POST",
        data: {
          "action" : "ive-theme-activate",
          "slug"   : $slug,
          "nonce"  : ive_whizzie_params.wpnonce,
        },
      }).done(function (result) {
        if( result.success ) {
          ive_whizzie_params.theme_text_domain = $slug;
          $button.text( "Activated" ).removeClass( "updating-message" );
        }
      });
    }, 1200 );
    // Activation Script END
  }

  jQuery('.ive-ibtaba-wizard-product-row').on('click', '.ive-premium-template-import-btn', function() {

    var demo_url = jQuery(this).attr('ive-template-demo-url');
    var demo_image = jQuery(this).attr('ive-template-image');
    var demo_title = jQuery(this).attr('ive-template-title');
    var demo_slug = jQuery(this).attr('ive-template-slug');
    var demo_permalink = jQuery(this).attr('ive-template-permalink');
    var is_key_valid = jQuery(this).attr('ive-is-key-valid');
    var demo_description = jQuery(this).attr('ive-template-description');

    if (is_key_valid == 0) {
      jQuery('.ive-sidebar-content a.ive-plugin-btn').show();
      jQuery('.ive-template-import-sidebar a.ive-import-demo-btn').hide();

    } else {
      jQuery('.ive-sidebar-content a.ive-plugin-btn').hide();
      jQuery('.ive-template-import-sidebar a.ive-import-demo-btn').show();
    }
    jQuery('.ive-sidebar-content a.ive-plugin-btn').attr('href', demo_permalink);
    jQuery('.ive-sidebar-content a.ive-plugin-btn').text('Buy Now');


    jQuery('.ive-sidebar-import-button a').attr('data-callback', 'import_premium_template');
    jQuery('.ive-template-demo-sidebar iframe').attr('src', demo_url);
    jQuery('.ive-template-import-sidebar .ive-sidebar-content img').attr('src', demo_image);

    jQuery('.ive-sidebar-content h4').text(demo_title);
    jQuery('.ive-sidebar-import-button a').attr('ive-template-slug', demo_slug);


    jQuery('.ive-template-import-sidebar .ive-sidebar-content .ive-template-text p').text(demo_description);

    jQuery('.ive-template-import-sidebar').removeClass('free-template-import-sidebar');
    jQuery('.nav-step-ive-wizard-three-step').attr('data-enable', 1);
    //var ive_template_demo = jQuery(this).attr('ive-template-demo');
    jQuery('.ive-wizard-content-menu li').removeClass('active-step');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-second-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-three-step').css('display', 'block');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-four-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu .step-ive-wizard-five-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-three-step').addClass('active-step');
    jQuery('.ive-template-import-sidebar').addClass('ive-premium-demo-sidebar');
    jQuery('.ive-template-import-sidebar .ive-preview-close-btn').removeClass('ive-free-close-demo');
    jQuery('.ive-template-import-sidebar .ive-preview-close-btn').addClass('ive-premium-close-demo');

  });

  // Go Back START
  jQuery( '.ive-go-back-special' ).on( 'click', function() {
    jQuery( '.ive-ibtana-wizard-button-wrapper a.ibtana-free-template-button.active' ).trigger( 'click' );
  });
  // Go Back END

  jQuery( '.ibtana-wizard-first-step-content .ive-ibtaba-wizard-inner-sub-cats' ).on( 'click', 'li[data-product-category]', function() {
    var $this = jQuery( this );
    $this.closest( '.ive-ibtaba-wizard-inner-sub-cats' ).find( 'li' ).removeClass( 'active' );
    $this.addClass( 'active' );
    var product_category  = $this.attr( 'data-product-category' );
    var search_keyword = jQuery('.step-ive-wizard-first-step .ive-admin-wizard-search').val().toLowerCase().trim();
    IVE_WIZARD.ibtana_visual_editor_all_template_grid(
      search_keyword,
      1,
      1,
      jQuery('.ive-ibtana-wizard-button-wrapper a.ibtana-free-template-button.active').attr('data-template-type'),
      product_category
    );
  });

  jQuery( '.ibtana-wizard-four-step-content .ive-ibtaba-wizard-inner-sub-cats' ).on( 'click', 'li[data-page-type]', function() {
    var $this           = jQuery( this );
    $this.closest( '.ive-ibtaba-wizard-inner-sub-cats' ).find( 'li[data-page-type]' ).removeClass( 'active' );
    $this.addClass( 'active' );
    var data_page_type  = $this.attr('data-page-type');
    if ( !data_page_type ) {
      jQuery('.ibtana-wizard-four-step-content .ive-ibtaba-wizard-product-row div[data-page-type]').show();
    } else {
      jQuery('.ibtana-wizard-four-step-content .ive-ibtaba-wizard-product-row div[data-page-type]').hide();
      jQuery('.ibtana-wizard-four-step-content .ive-ibtaba-wizard-product-row div[data-page-type="'+data_page_type+'"]').show();
    }
  });

  jQuery('.ive-ibtaba-wizard-product-row').on( 'click', '.ive-show-inner-templates-btn', function() {
    var ive_template_parent_reference = jQuery(this).attr('ive-template-parent-reference');
    IVE_WIZARD.ibtana_visual_editor_activate_inner_page_step( ive_template_parent_reference );
  });


  jQuery( '.ive-template-import-sidebar' ).on( 'click', '.ive-preview-close-btn .prev, .ive-preview-close-btn .next', function() {

    if ( jQuery(this).hasClass('ive-arrow-disabled') ) {
      return;
    }

    var current_template_slug = jQuery( '.ive-sidebar-import-button a' ).attr( 'ive-template-slug' );
    var $current_preview_btn_card = jQuery( '.ive-template-preview-btn[ive-template-slug="'+current_template_slug+'"]' ).closest( '.ive-o-products-col' );
    var current_card_index  = $current_preview_btn_card.index();

    var next_or_prev_card_index = null;
    var next_or_prev_card_index_after_one_card = null;

    if ( jQuery(this).hasClass( 'prev' ) ) {
      next_or_prev_card_index = current_card_index - 1;

      // Code to check if next or previous after one card is available or not.
      next_or_prev_card_index_after_one_card  =  next_or_prev_card_index - 1;
    } else if ( jQuery(this).hasClass( 'next' ) ) {
      next_or_prev_card_index = current_card_index + 1;

      // Code to check if next or previous after one card is available or not.
      next_or_prev_card_index_after_one_card  =  next_or_prev_card_index + 1;
    }
    console.log('next_or_prev_card_index_after_one_card', next_or_prev_card_index_after_one_card);

    var $next_or_prev_card = jQuery( '.ibtana-wizard-four-step-content .ive-ibtaba-wizard-product-row' ).find( '.ive-o-products-col' ).eq( next_or_prev_card_index );
    var $next_or_prev_card_btn = $next_or_prev_card.find( '.ive-template-preview-btn[ive-template-slug]' );
    IVE_WIZARD.ibtana_visual_editor_setup_preview_popup( $next_or_prev_card_btn );


    // Code to check if next or previous after one card is available or not.
    jQuery( '.ive-preview-close-btn .prev' ).removeClass( 'ive-arrow-disabled' );
    jQuery( '.ive-preview-close-btn .next' ).removeClass( 'ive-arrow-disabled' );
    if ( ( next_or_prev_card_index_after_one_card < 0 ) || jQuery( '.ibtana-wizard-four-step-content .ive-ibtaba-wizard-product-row .ive-o-products-col' ).eq( next_or_prev_card_index_after_one_card ).length == 0 ) {
      jQuery( this ).addClass( 'ive-arrow-disabled' );
    }
  });


  // ---------- Free Preview Close Event -----
  jQuery('.ive-template-import-sidebar').on('click', '.ive-preview-close-btn.ive-free-close-demo span.ive-close-preview', function() {
    jQuery( '.ive-template-demo-sidebar iframe' ).attr( 'src', '' );
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-first-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu li').removeClass('active-step');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-second-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-three-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-four-step').css('display', 'block');
    jQuery('.ive-wizard-content-menu .step-ive-wizard-five-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-four-step').addClass('active-step');

    jQuery('.ive-template-import-sidebar').removeClass('ive-premium-demo-sidebar');
    jQuery('.ive-template-import-sidebar .ive-preview-close-btn').removeClass('ive-premium-close-demo');
    jQuery('.ive-template-import-sidebar .ive-preview-close-btn').removeClass('ive-free-close-demo');

    IVE_WIZARD.ibtana_visual_editor_changeQueryParams(
      {
        ive_wizard_view: 'inner'
      }
    );
  });

  // ----------- Premium Preview Close Event --------

  jQuery('.ive-template-import-sidebar').on('click', '.ive-preview-close-btn.ive-premium-close-demo span.ive-close-preview', function() {
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-first-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu li').removeClass('active-step');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-second-step').css('display', 'block');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-three-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-four-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu .step-ive-wizard-five-step').css('display', 'none');
    jQuery('.ive-wizard-content-menu li.step-ive-wizard-second-step').addClass('active-step');

    jQuery('.ive-template-import-sidebar').removeClass('ive-premium-demo-sidebar');
    jQuery('.ive-template-import-sidebar .ive-preview-close-btn').removeClass('ive-premium-close-demo');
    jQuery('.ive-template-import-sidebar .ive-preview-close-btn').removeClass('ive-free-close-demo');
  });

  // --------- Search --------
  jQuery( ".step-ive-wizard-first-step .ive-admin-wizard-search" ).on( 'input', function() {
    var search_keyword = jQuery(this).val().toLowerCase().trim();
    var product_category = jQuery('.ibtana-wizard-first-step-content li[data-product-category].active').attr('data-product-category');
    if ( !product_category ) {
      product_category = null;
    }
    IVE_WIZARD.ibtana_visual_editor_all_template_grid(
      search_keyword,
      1,
      1,
      jQuery('.ive-ibtana-wizard-button-wrapper a.ibtana-free-template-button.active').attr('data-template-type'),
      product_category
    );
  });

  /* --------- Responsive Template View --------- */

  jQuery('.ibtana-template-import-steps .ive-sidebar-view-icons .dashicons-desktop').css('color','#016194');
  jQuery('.ibtana-template-import-steps .ive-sidebar-view-icons .dashicons-desktop').click(function() {
    jQuery('.ive-template-demo-sidebar iframe').css("width", "100%");
    jQuery('.ibtana-template-import-steps .ive-sidebar-view-icons ul li span.dashicons').css('color','#222');
    jQuery(this).css('color','#016194');
  });

  jQuery('.ibtana-template-import-steps .ive-sidebar-view-icons .dashicons-tablet').click(function() {
    jQuery('.ive-template-demo-sidebar iframe').css("width", "772px");
    jQuery('.ibtana-template-import-steps .ive-sidebar-view-icons ul li span.dashicons').css('color','#222');
    jQuery(this).css('color','#016194');
  });

  jQuery('.ibtana-template-import-steps .ive-sidebar-view-icons .dashicons-smartphone').click(function() {
    jQuery('.ive-template-demo-sidebar iframe').css("width", "356px");
    jQuery('.ibtana-template-import-steps .ive-sidebar-view-icons ul li span.dashicons').css('color','#222');
    jQuery(this).css('color','#016194');
  });

  /* --------- Collapse Template Iframe -------- */
  var template_demo_width = "yes";
  jQuery('.ibtana-template-import-steps .dashicons-admin-collapse').click(function() {
    if (template_demo_width == "yes") {
      jQuery('.ibtana-template-import-steps .ive-template-import-sidebar').css({
        "width": "0",
        "opacity": "0",
        "flex": "0 0 0"
      });
      jQuery('.ive-template-demo-sidebar').css({
        "width": "100%",
        "flex": "0 0 100%"
      });
      template_demo_width = "no";
      jQuery(this).css({
        "transform": "rotate(180deg)"
      });
    } else {
      jQuery('.ibtana-template-import-steps .ive-template-import-sidebar').css({
        "width": "21%",
        "opacity": "1",
        "flex": "0 0 21%"
      });
      jQuery('.ive-template-demo-sidebar').css({
        "width": "78%",
        "flex": "0 0 78%"
      });
      template_demo_width = "yes";
      jQuery(this).css({
        "transform": "none"
      });
    }
  });

  /* ------ Css File Generation ------*/
  jQuery('.ive-file-generation').click(function() {
    var btnVal = jQuery(this).attr('data-value');
    var data = {
      value : btnVal,
      action: "ive_file_generation",
      nonce: ive_whizzie_params.wpnonce,
    }
    jQuery.ajax({
      url: ive_whizzie_params.ajaxurl,
      method: "POST",
      data: data,
    }).done(function(data) {
      location.reload();
    });
  });

  function ibtana_visual_editor_fix_the_loader() {
    if (jQuery('div[class*="ibtana-wizard-"][class*="step-content"]:visible .ive-social-theme-search')[0]) {
      if(ibtana_visual_editor_elementInViewport2(jQuery('div[class*="ibtana-wizard-"][class*="step-content"]:visible .ive-social-theme-search')[0])) {
        jQuery('div[class*="ibtana-wizard-"][class*="step-content"] .ive-wz-spinner-wrap').removeClass('sticky');
      } else {
        jQuery('div[class*="ibtana-wizard-"][class*="step-content"] .ive-wz-spinner-wrap').addClass('sticky');
      }
    }
  }

  function ibtana_visual_editor_elementInViewport2(el) {
    var top = el.offsetTop;
    var left = el.offsetLeft;
    var width = el.offsetWidth;
    var height = el.offsetHeight;

    while(el.offsetParent) {
      el = el.offsetParent;
      top += el.offsetTop;
      left += el.offsetLeft;
    }

    return (
      top < (window.pageYOffset + window.innerHeight) &&
      left < (window.pageXOffset + window.innerWidth) &&
      (top + height) > window.pageYOffset &&
      (left + width) > window.pageXOffset
    );
  }
  window.onscroll = function() {
    ibtana_visual_editor_fix_the_loader();
  };

  jQuery( '.ive-demo-step-container' ).on( 'click', '.ive-checkbox-container', function() {
    if ( jQuery( this ).hasClass( 'activated' ) ) { return; }
    if ( jQuery( this ).find( '.ive-checkbox' ).hasClass( 'active' ) ) {
      jQuery( this ).find( '.ive-checkbox' ).removeClass( 'active' );
    } else {
      jQuery( this ).find( '.ive-checkbox' ).addClass( 'active' );
    }
  });

  jQuery( '.ive-close-button' ).on( 'click', function() {
    jQuery( '.ive-plugin-popup' ).hide();
  });

}, false);


IVE_WIZARD.init();
