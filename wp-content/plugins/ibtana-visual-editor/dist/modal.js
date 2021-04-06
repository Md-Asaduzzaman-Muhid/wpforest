(function($) {

  function ajaxPost( endpoint, data_post, callback ) {
    $('.ibtana--modal--loader').show();
    jQuery.ajax({
      method:       "POST",
      url:          endpoint,
      data:         JSON.stringify(data_post),
      dataType:     'json',
      contentType:  'application/json',
    }).done(function( data ) {
      $('.ibtana--modal--loader').hide();
      callback( data );
    });
  }

  function ibtana_visual_editor_show_hide_modal_button() {
    var togglebtn = document.querySelector(".components-panel__body-toggle");
    if (togglebtn !== null) {
      var isbtntrue = togglebtn.getAttribute("aria-expanded");
      if (document.getElementById("ibtana-modal-btn") !== null) {
        if (isbtntrue == 'false') {
          document.getElementById("ibtana-modal-btn").style.display = "none";
        }else{
          document.getElementById("ibtana-modal-btn").style.display = "block";
        }
      }
    }
  }

  function ibtana_visual_editor_AppendOpenModalBtn() {
    var myspan = $('.edit-post-post-status');
    if(myspan.length) {
      myspan.append(
        `<div class="components-panel__row">
          <button id="ibtana-modal-btn" class="btn btn-success" type="button">
            Ibtana Blocks Templates
          </button>
        </div>`
      );
    }

    if (!$('.modal_btn_svg_icon').length) {
      var modal_btn_svg_icon = `<div class="modal_btn_svg_icon"><svg id="Layer_1" data-name="Layer 1" width="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.newcls-1{fill:#0809F0;}.newcls-2{fill:#fff;}.newcls-3{fill:#0809F0;}.newcls-4{fill:#fffdfd;}</style></defs><title>Ibtana Icon</title><circle class="newcls-1" cx="12" cy="11.97" r="11.97"/><rect class="newcls-2" x="4.88" y="4.88" width="6.8" height="6.8" rx="0.57"/><rect class="newcls-2" x="12.32" y="4.88" width="6.8" height="6.8" rx="0.57"/><rect class="newcls-2" x="4.88" y="12.26" width="6.8" height="6.8" rx="0.57"/><rect class="newcls-2" x="12.32" y="12.26" width="6.8" height="6.8" rx="0.57"/><path class="newcls-3" d="M17.16,14.22v2.89a.39.39,0,1,1-.77,0V16.05H15.06v1.06a.4.4,0,0,1-.39.39.39.39,0,0,1-.38-.39V14.22a.38.38,0,0,1,.38-.38.35.35,0,0,1,.27.11.38.38,0,0,1,.12.27v1.06h1.33V14.22a.38.38,0,0,1,.38-.38.39.39,0,0,1,.28.11A.37.37,0,0,1,17.16,14.22Z"/><rect class="newcls-3" x="6.03" y="14.52" width="4.49" height="2.3" rx="1.15"/><circle class="newcls-4" cx="7.19" cy="15.67" r="0.92"/><path class="newcls-3" d="M6.56,7.54V10H8.8V7.54Zm1.12.62a.28.28,0,1,1-.28.28A.27.27,0,0,1,7.68,8.16Zm.56,1.21H7.12v0a.56.56,0,0,1,1.12,0Z"/><rect class="newcls-3" x="8.88" y="9.56" width="1.11" height="0.43"/><rect class="newcls-3" x="8.88" y="8.55" width="1.11" height="0.43"/><rect class="newcls-3" x="8.88" y="7.98" width="1.11" height="0.43"/><rect class="newcls-3" x="8.88" y="9.13" width="1.11" height="0.28"/><rect class="newcls-3" x="8.88" y="7.54" width="1.11" height="0.3"/><rect class="newcls-3" x="6.56" y="6.57" width="2.32" height="0.75" rx="0.26"/><path class="newcls-3" d="M9.17,6.72a.35.35,0,0,0,0,.38.36.36,0,0,0,.45.09l.21.2a.09.09,0,0,0,.13,0h0a.08.08,0,0,0,0-.12l-.21-.2a.34.34,0,0,0-.58-.34ZM9.59,7a.18.18,0,0,1-.27,0,.19.19,0,0,1,0-.27.19.19,0,0,1,.28,0A.18.18,0,0,1,9.59,7Z"/><rect class="newcls-3" x="14.82" y="7.01" width="2.69" height="0.66"/><rect class="newcls-3" x="14.82" y="7.95" width="2.69" height="0.66"/><rect class="newcls-3" x="14.82" y="8.89" width="2.69" height="0.66"/><circle class="newcls-3" cx="14.27" cy="7.34" r="0.33"/><circle class="newcls-3" cx="14.27" cy="8.28" r="0.33"/><circle class="newcls-3" cx="14.27" cy="9.22" r="0.33"/></svg><span class="modal-btn-svg-text-span">Templates</span></div>`;
      $('.edit-post-header__toolbar').append(modal_btn_svg_icon);
    }
  }


  window.onclick = function(event) {
    var myUpcomingModal = document.getElementById("myUpcomingModal");
    if (event.target == myUpcomingModal) {
      myUpcomingModal.style.display = "none";
    }
    if(!document.querySelector("#ibtana-modal-btn")) {
      ibtana_visual_editor_AppendOpenModalBtn();
    }
    ibtana_visual_editor_show_hide_modal_button();
  }

  window.onload = function() {
    var active_theme = ibtana_visual_editor_modal_js.active_theme_text_domain;

    var ibtana_license_api_endpoint = ibtana_visual_editor_modal_js.IBTANA_LICENSE_API_ENDPOINT;

    var svgButtonInterval = setInterval(ibtana_visual_editor_setSVGButton, 1000);
    function ibtana_visual_editor_setSVGButton() {
      if ($('.edit-post-header__toolbar').length !== 0) {
        ibtana_visual_editor_AppendOpenModalBtn();
        ibtana_visual_editor_show_hide_modal_button();
        clearInterval(svgButtonInterval);
      }
    }

    var qtModal = document.createElement("div");
    qtModal.setAttribute("id", "myUpcomingModal");
    qtModal.setAttribute("class", "UpcomingModal");

    var themedomain = ibtana_visual_editor_modal_js.themedomain;
    var theme_slug = themedomain.replaceAll("-", "_");
    var adminUrl = ibtana_visual_editor_modal_js.adminUrl;
    var page_id = ibtana_visual_editor_modal_js.page_id;


    var html = `<div class="UpcomingModal-content"><span class="CloseUpcomingModal">×</span>
    	<div class="content-modal">
        <div class="ibtana-modal-head">
      		<div class="ibtana-row">
            <div class="ibtana-modal-logo">
              <h2>
                <img src="`+ibtana_visual_editor_modal_js.plugin_url+`/dist/images/admin-wizard/adminIcon.png">
                VW Themes
              </h2>
            </div>
        		<div class="tab-parent-head">
              <ul>
                <li>
                  <button class="tablinks active" data-tab-head="Templates"><span class="dashicons dashicons-clipboard"></span>Templates</button>
                </li>
                <li>
                  <button class="tablinks" data-tab-head="InnerPages"><span class="dashicons dashicons-clipboard"></span>Inner Pages</button>
                </li>
                <li style="display:none;">
                  <button class="tablinks" data-tab-head="fullSizeModal">
                    <span class="dashicons dashicons-clipboard"></span>
                    WooCommerce Pages
                  </button>
                </li>
              </ul>
        		</div>
          </div>
        </div>

        <div class="modal-content-reload-svg">
          <button id="reload--modal--contents">
            <span class="dashicons dashicons-update-alt"></span>
          </button>
          <input type="text" class="search-text" placeholder="Search for names..">
        </div>

        <div class="template-buy-banner">
          <span>Get All Our Premium Themes In Our WP Theme Bundle</span>
          <a href="`+ibtana_visual_editor_modal_js.IBTANA_THEME_URL+`premium/theme-bundle/" target="_blank">BUY NOW</a>
        </div>

    		<div id="Templates" class="tabcontent">

    			<div class="inner-tab-content">
            <ul>
              <li class="theme-tab-list-two active" data-template="free-template" data-template-type="wordpress"><span>Free</span></li>
              <li class="theme-tab-list-two" data-template="premium-template"><span>Premium</span></li>
            </ul>
          </div>


          <div id="free-template" class="ibtana-theme-block">
            <div class="sub-category-wrapper">
              <div class="ibtana-column-one sub-cats">

              </div>
              <div class="ibtana-column-two">
                <div class="ibtana-row themes-box-wrap">

                </div>
                <div class="load-more-wrapper">
                  <button class="button load-more-btn">Load More...</button>
                </div>
              </div>
            </div>
          </div>


          <div id="premium-template" class="ibtana-theme-block" data-template-div="template">

            <div class="sub-category-wrapper">
              <div class="ibtana-column-one sub-cats">

              </div>
              <div class="ibtana-column-two">
                <div class="ibtana-row themes-box-wrap">

                </div>
              </div>
            </div>
          </div>



    		</div>

        <div id="InnerPages" class="tabcontent">
          <div class="inner-tab-content">
            <button class="button back-to-templates">
              <span class="dashicons dashicons-arrow-left-alt"></span>
            </button>
          </div>

          <div class="ibtana-theme-block">
            <div class="sub-category-wrapper">
              <div class="ibtana-column-one sub-cats">

              </div>
              <div class="ibtana-column-two">
                <div class="ibtana-row themes-box-wrap">

                </div>
              </div>
            </div>
          </div>

        </div>

        <div id="fullSizeModal" class="tabcontent" style="display:none;">
          <div id="fullSizeModalMainWindow">
            <span class="ive-fm-collapse-btn dashicons dashicons-admin-collapse"></span>
            <div class="ive-full-modal-import-sidebar">
              <div class="ive-fm-btns">
                <span class="ive-fm-close dashicons dashicons-no-alt"></span>
                <span class="ive-fm-prev dashicons dashicons-arrow-left-alt2"></span>
                <span class="ive-fm-next dashicons dashicons-arrow-right-alt2"></span>
              </div>
              <div class="ive-fm-import-btn-wrap">
                <a id="ive-fm-import-template" href="javascript:void(0);">Import</a>
              </div>

              <div class="ive-fm-sidebar-content">
              	<a href="" class="ive-fm-go-pro-btn" target="_blank">Go Pro</a>
              	<h4>Template Name</h4>
              	<div class="ive-fm-template-img">
              		<img src="">
              	</div>
              	<div class="ive-fm-template-text">
              		<p>description</p>
              	</div>
              </div>

              <div class="ive-fm-view-icons">
              	<ul>
              		<li class="ive-fm-desk-view active"><span class="ive-fm-view-icon dashicons dashicons-desktop"></span></li>
              		<li class="ive-fm-tab-view"><span class="ive-fm-view-icon dashicons dashicons-tablet"></span></li>
              		<li class="ive-fm-mob-view"><span class="ive-fm-view-icon dashicons dashicons-smartphone"></span></li>
              	</ul>
              </div>

            </div>

            <div class="ive-full-modal-iframe-wrap">
              <iframe width="100%" height="100%"></iframe>
            </div>
          </div>
        </div>

        <div class="ive-plugin-popup">
          <div class="ive-admin-modal">
            <button class="ive-close-button">×</button>
            <div class="ive-demo-step-container">
              <div class="ive-current-step">

                <div class="ive-demo-child ive-demo-step ive-demo-step-0 active">
                  <h2>Install Base Theme</h2>
                  <p>We strongly recommend to install the base theme.</p>
                  <div class="ive-checkbox-container">
                    Install Base Theme
                    <span class="ive-checkbox active">
                      <svg width="10" height="8" viewBox="0 0 11.2 9.1">
                        <polyline class="check" points="1.2,4.8 4.4,7.9 9.9,1.2 "></polyline>
                      </svg>
                    </span>
                  </div>
                </div>

                <div class="ive-demo-plugins ive-demo-step ive-demo-step-1">
                  <h2>Install & Activate Plugins</h2>
                  <p>The following plugins are required for this template in order to work properly. Ignore if already installed.</p>
                  <div class="ive-checkbox-container activated">
                    Elementor
                    <span class="ive-checkbox active">
                      <svg width="10" height="8" viewBox="0 0 11.2 9.1">
                        <polyline class="check" points="1.2,4.8 4.4,7.9 9.9,1.2 "></polyline>
                      </svg>
                    </span>
                  </div>
                  <div class="ive-checkbox-container">
                    Gutenberg
                    <span class="ive-checkbox active">
                      <svg width="10" height="8" viewBox="0 0 11.2 9.1">
                        <polyline class="check" points="1.2,4.8 4.4,7.9 9.9,1.2 "></polyline>
                      </svg>
                    </span>
                  </div>
                </div>

                <div class="ive-demo-template ive-demo-step ive-demo-step-2">
                  <h2>Import Content</h2>
                  <p>This will import the template.</p>
                </div>

                <div class="ive-demo-install ive-demo-step ive-demo-step-3">
                  <h2>Installing...</h2>
                  <p>Please be patient and don't refresh this page, the import process may take a while, this also depends on your server.</p>
                  <div class="ive-progress-info">Required plugins<span>10%</span></div>
                  <div class="ive-installer-progress"><div></div></div>
                </div>

              </div>
              <div class="ive-demo-step-controls">
                <button class="ive-demo-btn ive-demo-back-btn">Back</button>
                <ul class="ive-steps-pills">
                  <li class="active">1</li>
                  <li class="">2</li>
                  <li class="">3</li>
                </ul>
                <button class="ive-demo-btn ive-demo-main-btn">Next</button>
              </div>
            </div>
          </div>
        </div>

    	</div>

    </div>
    <div class="ibtana--modal--loader">
      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
      <circle cx="50" cy="50" fill="none" stroke="#44a745" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"/>
      </circle>
      </svg>
    </div>`;
    document.querySelector('body').appendChild(qtModal);
    qtModal.innerHTML = html;

    get_modal_contents();


    function get_all__pages_list_by_template_type( search_key, next_page_number, will_clear = 1, template_type ) {
      var data_post = {
        "domain":             ibtana_visual_editor_modal_js.site_url,
        "limit":              9,
        "start":              next_page_number,
        "search":             search_key,
        "template_type":      template_type
      };

      ajaxPost( ibtana_visual_editor_modal_js.IBTANA_LICENSE_API_ENDPOINT + 'get_client_pages_list_by_template_type', data_post, function( data ) {

        jQuery( '#free-template .sub-cats' ).hide();

        if ( data.next_page_number ) {
          jQuery( '#free-template .load-more-btn' ).attr( 'data-next-page-number', data.next_page_number );
          jQuery( '#free-template .load-more-btn' ).show();
        } else {
          jQuery( '#free-template .load-more-btn' ).hide();
        }

        if ( will_clear === 1 ) {
          jQuery( '#free-template .ibtana-row.themes-box-wrap' ).empty();
        }

        var is_premium_theme_key_valid = data.is_key_valid;
        var template_with_inner_pages = data.data;

        jQuery('#free-template .ibtana-row.themes-box-wrap').parent().addClass('ibtana-column-full');

        for ( var k = 0; k < template_with_inner_pages.length; k++ ) {
          var template_or_inner_page  = template_with_inner_pages[k];
          var template_or_inner_page_is_premium = parseInt(template_or_inner_page.is_premium);
          var premium_badge = ``;
          if ( template_or_inner_page_is_premium ) {
            premium_badge = `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 76.65 100.86"><defs><style>.cls-1{fill:#330f48;}.cls-2{font-size:25.18px;fill:#fff;font-family:Lato-Black, Lato;font-weight:800;}.cls-3{letter-spacing:-0.02em;}</style><linearGradient id="linear-gradient" x1="38.3" y1="4.1" x2="37.36" y2="184.18" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#330f48"/><stop offset="0.05" stop-color="#35134b"/><stop offset="0.28" stop-color="#3c1f53"/><stop offset="0.5" stop-color="#3e2356"/></linearGradient></defs><g id="Layer_2" data-name="Layer 2"><g id="Ñëîé_1" data-name="Ñëîé 1"><path class="cls-1" d="M76.65,0H0c.57,1.11,1,2,1.21,2.66a28.73,28.73,0,0,1,2.2,10.25V15.3h0v85.41c4-3.95,7.9-6.47,11.85-10.42l12,10.57,11.08-9.65,11.07,9.65,12-10.57c4,3.95,7.9,6.47,11.85,10.42V15.3h0c0-.79,0-1.59,0-2.38a28.73,28.73,0,0,1,2.2-10.25C75.69,2.05,76.08,1.12,76.65,0Z"/><text class="cls-2" transform="translate(12.17 59.06)">P<tspan class="cls-3" x="16.06" y="0">R</tspan><tspan x="32.18" y="0">O</tspan></text></g></g></svg>`;
          }
          jQuery( '#free-template .ibtana-row.themes-box-wrap' ).append(
            `<div class="ibtana-column-four ibtana--card" data-page-type="` + template_or_inner_page.page_type + `">
              <div class="blog-content-inner">
                <div class="blog-content-img-inner free-content-inner">
                  `+premium_badge+`
                  <img class="blog-content-inner-image" src="` + template_or_inner_page.image + `">
                </div>
                <h2>`+template_or_inner_page.name+`</h2>
                <a class="blog-content-btn-inner preview-template" ive-template-text-domain="` + template_or_inner_page.domain + `" ive-template-type="` + template_or_inner_page.template_type + `" ive-is-premium="`+template_or_inner_page.is_premium+`" ive-template-slug="`+template_or_inner_page.slug+`">
                  PREVIEW
                  <span class="dashicons dashicons-welcome-view-site">
                  </span>
                </a>
              </div>
            </div>`
          );
        }

        if ( !template_with_inner_pages.length ) {
          $( '#free-template .ibtana-row.themes-box-wrap' ).append(
            '<h3 class="ive-coming-soon">No Results Found...</h3>'
          );
        }


      });
    }


    // On click free premium template tab
    $('#Templates').on( 'click', '.theme-tab-list-two', function() {
      $('.search-text').val('');
      var theme = $(this).attr('data-template');
      $('#Templates .theme-tab-list-two').removeClass('active');
      $(this).addClass('active');
      var mainTabId = $(this).closest('.tabcontent').attr('id');
      $('#' + mainTabId).find('.ibtana-theme-block').hide();
      $('#Templates').find('#'+theme).show();


      if ( $( this ).attr( 'data-template-type' ) !== undefined ) {
        if ( $(this).attr('data-template-type') == 'wordpress' ) {
          get_templates_list();
        } else {
          var data_template_type = $(this).attr('data-template-type');
          get_all__pages_list_by_template_type( '', 1, 1, data_template_type );
        }
      }
    });
    // On click free premium template tab END

    // On Click InnerPages Inner Tabs
    $('#InnerPages').on('click', '.theme-tab-list-two', function() {
      $('#InnerPages .theme-tab-list-two').removeClass('active');
      $(this).addClass('active');
      var inner_tab_name = $(this).attr('data-template-tab');
      $('#InnerPages .ibtana-theme-block').hide();
      $('#InnerPages .ibtana-theme-block[data-template-div="'+inner_tab_name+'"]').show();
    });
    // On Click InnerPages Inner Tabs END

    $('.tablinks').on('click',function() {
      var mainTab = $(this).attr('data-tab-head');
      $('.tablinks').removeClass('active');
      $(this).addClass('active');

      $('.tabcontent').hide();
      $('#'+mainTab).show();
    });

    // Show Modal
    $(document.body).on('click', '#ibtana-modal-btn, .modal_btn_svg_icon', function() {
      $('#myUpcomingModal').show();
    });
    // Show Modal END

    // Hide modal
    $(document.body).on('click', '.CloseUpcomingModal', function() {
      $('#myUpcomingModal').hide();
    });
    // Hide modal END

    // On click subcategory
    $('#premium-template .sub-cats').on('click', '.sub-cat-button', function() {
      $('.sub-category-wrapper .sub-cat-button').removeClass('active');
      $(this).addClass("active");
      if ($(this).index() === 0) {
        $('#premium-template .ibtana-row.themes-box-wrap [data-id]').show();
      } else {
        var data_ids = $(this).attr('data-ids');
        var id_arr = data_ids.split(',');
        $('#premium-template .ibtana-row.themes-box-wrap [data-id]').hide();
        for (var i = 0; i < id_arr.length; i++) {
          var single_id = id_arr[i];
          $('#premium-template .ibtana-row.themes-box-wrap [data-id="'+single_id+'"]').show();
        }
      }
    });
    // On click subcategory END

    // On click import json from premium theme
    $('#Templates').on('click', '#premium-template .import_json_from_premium_theme', function() {
      var page_id = ibtana_visual_editor_modal_js.page_id;
      var site_url = ibtana_visual_editor_modal_js.site_url;
      var active_theme = ibtana_visual_editor_modal_js.active_theme_text_domain;
      $('.ibtana--modal--loader').show();
      $.ajax({
        method: "GET",
        dataType: 'json',
        url: window.wpApiSettings.root + active_theme + "/v1/importJson?page_id="+page_id,
      }).done(function( data ) {
        var postid = data.msg;
        window.location.href = site_url +"/wp-admin/post.php?post="+postid+"&action=edit";
      });
    });

    // On click json import for premium template
    $('#Templates').on('click', '#free-template .import_free, #premium-template .import_premium', function() {
      var template_slug   = $(this).attr('data-theme-slug');
      var template_domain = $(this).attr('data-text-domain');
      if ($(this).hasClass('import_free')) {
        ImportFreeTemplate(template_slug);
      } else if ($(this).hasClass('import_premium')) {
        ibtana_visual_editor_importPremiumTemplate(template_slug, 'template');
      }
    });
    // On click json import for premium template END

    // InnerPage Import
    $('#InnerPages').on('click', '.import_free', function() {
      var template_slug   = $(this).attr('data-theme-slug');
      var $page_template_type_div = $(this).closest('.ibtana-theme-block');
      var page_template_type = $page_template_type_div.attr('data-template-div');
      ibtana_visual_editor_importPremiumTemplate(template_slug, page_template_type);
    });
    // InnerPage Import END

    function ImportFreeTemplate(template_slug) {
      var post_data = {
        "template_slug":      template_slug,
        "page_template_type": 'template'
      };
      $('.ibtana--modal--loader').show();
      $.ajax({
        method: "POST",
        url: ibtana_license_api_endpoint + "get_template",
        data: JSON.stringify(post_data),
        dataType: 'json',
        contentType: 'application/json',
      }).done(function( data ) {
        $('.ibtana--modal--loader').hide();
        if (data.data === null) {
          alert(data.msg);
        } else {
          var theme_json = data.data;
          var page_id = ibtana_visual_editor_modal_js.page_id;
          var path = ibtana_visual_editor_modal_js.path;
          var rest_url = ibtana_visual_editor_modal_js.rest_url;
          var data = {
            'action': 'import_template',
            'theme_json': theme_json
          };
          $('.ibtana--modal--loader').show();
          jQuery.post(ibtana_visual_editor_modal_js.adminAjax + "?page_id=" + page_id, data, function(response) {
            $('.ibtana--modal--loader').hide();
            $('#myUpcomingModal').hide();
            var response = JSON.parse(response);
            window.location.href = response.redirect_uri;
          });
        }
      });
    }

    function ibtana_visual_editor_importPremiumTemplate(template_slug, page_template_type = '') {
      var admin_user_ibtana_license_key = ibtana_visual_editor_modal_js.admin_user_ibtana_license_key;
      var site_url = ibtana_visual_editor_modal_js.site_url;
      var rest_url = ibtana_visual_editor_modal_js.rest_url;

      var post_data = {
        "domain":             site_url,
        "key":                admin_user_ibtana_license_key,
        "template_slug":      template_slug,
        "page_template_type": page_template_type
      };

      if (admin_user_ibtana_license_key != '') {
        $('.ibtana--modal--loader').show();
        $.ajax({
          method: "POST",
          url: ibtana_license_api_endpoint + "get_template",
          data: JSON.stringify(post_data),
          dataType: 'json',
          contentType: 'application/json',
        }).done(function( data ) {
          $('.ibtana--modal--loader').hide();
          if (data.data === null) {
            alert(data.msg);
          } else {
            var theme_json = data.data;
            var page_id = ibtana_visual_editor_modal_js.page_id;
            var path = ibtana_visual_editor_modal_js.path;
            var data  = {
              'action':     'import_template',
              'theme_json': theme_json
            };
            jQuery.post(ibtana_visual_editor_modal_js.adminAjax + "?page_id=" + page_id, data, function(response) {
              $('.ibtana--modal--loader').hide();
              $('#myUpcomingModal').hide();
              var response = JSON.parse(response);
              window.location.href = response.redirect_uri;
            });
          }
        });
      } else {
        alert('Please Enter License key first');
      }
    }

    $('#reload--modal--contents').on('click', function() {
      $('.search-text').val('');
      if ( jQuery('#Templates .theme-tab-list-two.active').attr('data-template-type') === undefined ) {
        get_modal_contents();
      } else {
        jQuery('#Templates .theme-tab-list-two.active').trigger('click');
      }
    });

    function get_templates_list( search_key = '', next_page_number = 1, will_clear = 1, template_type = 'wordpress', pro_cat = null ) {
      var data_post = {
        "theme_license_key":  ibtana_visual_editor_modal_js.admin_user_ibtana_license_key,
        "domain":             ibtana_visual_editor_modal_js.site_url,
        "theme_text_domain":  ibtana_visual_editor_modal_js.active_theme_text_domain,
        "limit":              9,
        "start":              next_page_number,
        "search":             search_key,
        "template_type":      template_type,
        "product_category":   pro_cat
      };
      if ( ibtana_visual_editor_modal_js.custom_text_domain != "" ) {
        data_post.theme_text_domain = ibtana_visual_editor_modal_js.custom_text_domain;
      }
      ajaxPost( ibtana_visual_editor_modal_js.IBTANA_LICENSE_API_ENDPOINT+'get_client_template_list', data_post, function( data ) {

        // Check if the tabs are already appended START
        var tabs  = data.tabs;
        if ( ibtana_visual_editor_modal_js.are_tabs_created === undefined ) {
          for (var i = 0; i < tabs.length; i++) {
            var tab  = tabs[i];
            if ( tab.option != 'wordpress' ) {
              jQuery( '#Templates .inner-tab-content ul' ).append(
                `<li class="theme-tab-list-two" data-template="free-template" data-template-type="`+tab.option+`">
                  <span>`+tab.display_string+`</span>
                </li>`
              );
            }
          }
          ibtana_visual_editor_modal_js.are_tabs_created  = true;
        }
        // Check if the tabs are already appended END

        // Check if the product categories are created or not
        jQuery( '#free-template .sub-cats' ).show();
        var data_product_categories = data.product_categories;
        if ( ibtana_visual_editor_modal_js.are_product_categories_created === undefined ) {
          $( '#free-template .sub-cats' ).empty();
          for (var i = 0; i < data_product_categories.length; i++) {
            var data_product_category = data_product_categories[i];
            $( '#free-template .sub-cats' ).append(
              `<button class="sub-cat-button" data-product-category="` + data_product_category.term_id + `">
                ` + data_product_category.name + `
                <span class="badge badge-info">` + data_product_category.product_category_tags_count + `</span>
              </button>`
            );
          }
          ibtana_visual_editor_modal_js.are_product_categories_created = true;
        }
        // Check if the product categories are created or not END


        if ( will_clear ) {
          $( '#free-template .ibtana-row.themes-box-wrap' ).empty();
        }

        jQuery('#free-template .ibtana-row.themes-box-wrap').parent().removeClass('ibtana-column-full');

        var active_theme_data = data.active_theme_data;
        if ( data.active_theme_data ) {
          jQuery( '#free-template .ibtana-row.themes-box-wrap' ).append(
            `<div class="ibtana-column-three ibtana--card card-theme-active">
              <div class="blog-content-inner">
                <div class="blog-content-img-inner free-content-inner">
                  <img class="blog-content-inner-image" src="` + active_theme_data.image + `">
                </div>
                <h2>`+active_theme_data.name+`</h2>
                <a class="blog-content-btn-inner show-inner-pages" data-template-parent-reference="` + active_theme_data.parent_reference + `" data-text-domain="` + active_theme_data.domain + `" data-theme-slug="`+ active_theme_data.slug +`">
                  VIEW
                  <span class="dashicons dashicons-welcome-view-site">
                  </span>
                </a>
              </div>
            </div>`
          );
        }

        var free_data = data.data;
        if ( free_data ) {
          for (var i = 0; i < free_data.length; i++) {
            var free_data_single = free_data[i];

            var free_card_content = ``;
            // if (active_theme === free_data_single.domain) {
            //   free_card_content += `<div class="ibtana-column-three ibtana--card card-theme-active">`;
            // } else {
              free_card_content += `<div class="ibtana-column-three ibtana--card">`;
            // }

            free_card_content += `<div class="blog-content-inner">
                <div class="blog-content-img-inner free-content-inner">
                  <img class="blog-content-inner-image" src="` + free_data_single.image + `">
                </div>
                <h2>`+free_data_single.name+`</h2>
                <a class="blog-content-btn-inner show-inner-pages" data-template-parent-reference="` + free_data_single.parent_reference + `" data-text-domain="` + free_data_single.domain + `" data-theme-slug="`+ free_data_single.slug +`">
                  VIEW
                  <span class="dashicons dashicons-welcome-view-site">
                  </span>
                </a>
              </div>
            </div>`;
            // if (active_theme === free_data_single.domain) {
            //   $(free_card_content).prependTo('#free-template .ibtana-row.themes-box-wrap');
            // } else {
              $( '#free-template .ibtana-row.themes-box-wrap' ).append(free_card_content);
            // }
          }
        }
        // Free cards END

        // Load more button next page number START
        if ( data.next_page_number ) {
          jQuery( '#free-template .load-more-btn' ).attr( 'data-next-page-number', data.next_page_number );
          jQuery( '#free-template .load-more-btn' ).show();
        } else {
          jQuery( '#free-template .load-more-btn' ).hide();
        }
        // Load more button next page number END

      });
    }
    get_templates_list();

    // Search text
    $('.search-text').on('input', function() {
      var search_keyword = $(this).val().toLowerCase().trim();
      if ( jQuery('#Templates .inner-tab-content li.active').attr('data-template-type') === undefined ) {
        var active_sub_cat = $('#premium-template .sub-cat-button.active');
        var visible_wrapper = $('.content-modal .ibtana-row.themes-box-wrap:visible');
        if (active_sub_cat.length != 0) {
          var sub_cat_pro_ids = active_sub_cat.attr('data-ids');
          var sub_cat_arr_ids = sub_cat_pro_ids.split(',');
          $('#premium-template [data-id]').hide();
          for (var i = 0; i < sub_cat_arr_ids.length; i++) {
            var sub_cat_pro_id = sub_cat_arr_ids[i];
            var pro_card = $('#premium-template [data-id='+sub_cat_pro_id+']');
            var pro_card_text = pro_card.find('h2').text().toLowerCase();
            if (pro_card_text.indexOf(search_keyword) !== -1) {
              pro_card.show();
            }
          }
        } else {
          visible_wrapper.find('.ibtana--card').hide();
          var pro_cards = visible_wrapper.find('.ibtana--card');
          $.each(pro_cards, function(key, pro_card) {
            pro_card_text = $(pro_card).find('h2').text().toLowerCase();
            if (pro_card_text.indexOf(search_keyword) !== -1) {
              $(pro_card).show();
            }
          });
        }

      } else {
        var data_template_type = $('#Templates .theme-tab-list-two.active').attr('data-template-type');
        if ( data_template_type == 'wordpress' ) {
          var product_category = jQuery('#free-template .sub-cat-button.active').attr('data-product-category');
          if ( !product_category ) {
            product_category = null;
          }
          get_templates_list(
            search_keyword,
            1,
            1,
            'wordpress',
            product_category
          );
        } else {
          get_all__pages_list_by_template_type( search_keyword, 1, 1, data_template_type );
        }
      }

    });
    // Search text END

    $( '#free-template' ).on( 'click', '.sub-cat-button', function() {
      $( '#free-template .sub-cat-button' ).removeClass( 'active' );
      $( this ).addClass( 'active' );
      var product_category  = $( this ).attr( 'data-product-category' );
      var search_keyword = $('.search-text').val().toLowerCase().trim();
      get_templates_list(
        search_keyword,
        1,
        1,
        'wordpress',
        product_category
      );
    });

    jQuery( '#free-template .load-more-btn' ).click(function() {
      var page_no = parseInt( jQuery(this).attr( 'data-next-page-number' ) );
      var search_keyword = $('.search-text').val().toLowerCase().trim();

      var data_template_type = $('#Templates .theme-tab-list-two.active').attr('data-template-type');

      if ( data_template_type == 'wordpress' ) {
        var product_category = jQuery('#free-template .sub-cat-button.active').attr('data-product-category');
        if ( !product_category ) {
          product_category = null;
        }
        get_templates_list(
          search_keyword,
          page_no,
          0,
          'wordpress',
          product_category
        );
      } else {
        get_all__pages_list_by_template_type( search_keyword, page_no, 0, data_template_type );
      }
    });

    function get_inner_pages_list( parent_reference ) {
      var data_post_inner = {
        parent_reference:   parent_reference,
        domain:             ibtana_visual_editor_modal_js.site_url,
        theme_license_key:  ibtana_visual_editor_modal_js.admin_user_ibtana_license_key,
        theme_text_domain:  ibtana_visual_editor_modal_js.themedomain
      };
      ajaxPost( ibtana_visual_editor_modal_js.IBTANA_LICENSE_API_ENDPOINT+'get_client_inner_pages_list', data_post_inner, function( data ) {

        // Create page types
        var page_types  = data.page_types;
        jQuery('#InnerPages .sub-cats').empty();
        for (var i = 0; i < page_types.length; i++) {
          var page_type = page_types[i];
          if ( page_type.page_type == 'template' ) {
            jQuery(
              `<button class="sub-cat-button" data-page-type="`+page_type.page_type+`">
                `+page_type.display_string+`
                <span class="badge badge-info">`+page_type.count+`</span>
              </button>`
            ).prependTo( '#InnerPages .sub-cats' );
          } else {
            jQuery('#InnerPages .sub-cats').append(
              `<button class="sub-cat-button" data-page-type="`+page_type.page_type+`">
                `+page_type.display_string+`
                <span class="badge badge-info">`+page_type.count+`</span>
              </button>`
            );
          }
        }
        // End of page types


        var is_premium_theme_key_valid = data.is_key_valid;
        var template_with_inner_pages = data.data;
        jQuery( '#InnerPages .ibtana-row.themes-box-wrap' ).empty();
        for ( var k = 0; k < template_with_inner_pages.length; k++ ) {
          var template_or_inner_page  = template_with_inner_pages[k];
          var template_or_inner_page_is_premium = parseInt(template_or_inner_page.is_premium);
          var premium_badge = ``;
          if ( template_or_inner_page_is_premium ) {
            premium_badge = `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 76.65 100.86"><defs><style>.cls-1{fill:#330f48;}.cls-2{font-size:25.18px;fill:#fff;font-family:Lato-Black, Lato;font-weight:800;}.cls-3{letter-spacing:-0.02em;}</style><linearGradient id="linear-gradient" x1="38.3" y1="4.1" x2="37.36" y2="184.18" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#330f48"/><stop offset="0.05" stop-color="#35134b"/><stop offset="0.28" stop-color="#3c1f53"/><stop offset="0.5" stop-color="#3e2356"/></linearGradient></defs><g id="Layer_2" data-name="Layer 2"><g id="Ñëîé_1" data-name="Ñëîé 1"><path class="cls-1" d="M76.65,0H0c.57,1.11,1,2,1.21,2.66a28.73,28.73,0,0,1,2.2,10.25V15.3h0v85.41c4-3.95,7.9-6.47,11.85-10.42l12,10.57,11.08-9.65,11.07,9.65,12-10.57c4,3.95,7.9,6.47,11.85,10.42V15.3h0c0-.79,0-1.59,0-2.38a28.73,28.73,0,0,1,2.2-10.25C75.69,2.05,76.08,1.12,76.65,0Z"/><text class="cls-2" transform="translate(12.17 59.06)">P<tspan class="cls-3" x="16.06" y="0">R</tspan><tspan x="32.18" y="0">O</tspan></text></g></g></svg>`;
          }
          jQuery( '#InnerPages .ibtana-row.themes-box-wrap' ).append(
            `<div class="ibtana-column-three ibtana--card" data-page-type="` + template_or_inner_page.page_type + `">
              <div class="blog-content-inner">
                <div class="blog-content-img-inner free-content-inner">
                  `+premium_badge+`
                  <img class="blog-content-inner-image" src="` + template_or_inner_page.image + `">
                </div>
                <h2>`+template_or_inner_page.name+`</h2>
                <a class="blog-content-btn-inner preview-template" ive-template-text-domain="` + template_or_inner_page.domain + `" ive-template-type="` + template_or_inner_page.template_type + `" ive-is-premium="`+template_or_inner_page.is_premium+`" ive-template-slug="`+template_or_inner_page.slug+`">
                  PREVIEW
                  <span class="dashicons dashicons-welcome-view-site">
                  </span>
                </a>
              </div>
            </div>`
          );
        }
        jQuery( '#InnerPages .sub-cats button[data-page-type]:first' ).trigger( 'click' );
      });
    }

    $( '#InnerPages .sub-cats' ).on( 'click', 'button[data-page-type]', function() {
      var $this           = jQuery( this );
      $( '#InnerPages .sub-cats button[data-page-type]' ).removeClass( 'active' );
      $this.addClass( 'active' );
      var data_page_type  = $this.attr( 'data-page-type' );
      if ( !data_page_type ) {
        jQuery( '#InnerPages .ibtana-row.themes-box-wrap .ibtana--card' ).show();
      } else {
        jQuery( '#InnerPages .ibtana-row.themes-box-wrap .ibtana--card' ).hide();
        jQuery( '#InnerPages .ibtana-row.themes-box-wrap .ibtana--card[data-page-type="'+data_page_type+'"]' ).show();
      }
    });

    $( '#free-template' ).on( 'click', '.show-inner-pages', function() {
      var data_template_parent_reference = $(this).attr('data-template-parent-reference');
      $( '.tabcontent' ).hide();
      $( '.modal-content-reload-svg' ).hide();
      $( '#InnerPages' ).show();
      get_inner_pages_list(data_template_parent_reference);
    });

    $( '.back-to-templates' ).on( 'click', function() {
      $( '.tabcontent' ).hide();
      $( '#Templates' ).show();
      $( '.modal-content-reload-svg' ).show();
    });

    $( '#free-template, #InnerPages' ).on( 'click', '.preview-template', function() {
      $( '#fullSizeModal' ).show();
      ibtana_visual_editor_setup_preview_popup( $( this ) );
    });

    /* --------- Responsive Template View --------- */
    jQuery( '.ive-fm-desk-view, .ive-fm-tab-view, .ive-fm-mob-view' ).on('click', function() {
      $( '.ive-fm-view-icons li' ).removeClass( 'active' );
      $( this ).addClass( 'active' );
      if ( $(this).hasClass('ive-fm-desk-view') ) {
        jQuery('.ive-full-modal-iframe-wrap iframe').css("width", "100%");
      } else if ( $(this).hasClass('ive-fm-tab-view') ) {
        jQuery('.ive-full-modal-iframe-wrap iframe').css("width", "772px");
      } else if ( $(this).hasClass('ive-fm-mob-view') ) {
        jQuery('.ive-full-modal-iframe-wrap iframe').css("width", "356px");
      }
    });

    $( '.ive-fm-collapse-btn' ).on( 'click', function() {
      if ( !$(this).hasClass('ive-fm-btn-rotate') ) {
        $( this ).addClass( 'ive-fm-btn-rotate' );
        $( '.ive-full-modal-import-sidebar' ).addClass( 'collapse' );
        $( '.ive-full-modal-iframe-wrap' ).addClass( 'fullwidth' );
      } else {
        $( this ).removeClass( 'ive-fm-btn-rotate' );
        $( '.ive-full-modal-import-sidebar' ).removeClass( 'collapse' );
        $( '.ive-full-modal-iframe-wrap' ).removeClass( 'fullwidth' );
      }
    });

    $( '.ive-fm-close' ).on( 'click', function() {
      jQuery( '.ive-full-modal-iframe-wrap iframe' ).attr( 'src', '' );
      $( '#fullSizeModal' ).hide();
    });

    function ibtana_visual_editor_setup_preview_popup( $this ) {

      var is_demo_premium_template  = parseInt( jQuery($this).attr('ive-is-premium') );
      var ive_template_type         = jQuery($this).attr( 'ive-template-type' );
      var demo_slug                 = jQuery($this).attr('ive-template-slug');

      jQuery( '.ibtana--modal--loader' ).show();

      var data_to_send  = {
        site_url:       ibtana_visual_editor_modal_js.site_url,
        template_slug:  demo_slug
      };

      if ( is_demo_premium_template == 1 ) {

        if ( ive_template_type == 'wordpress' ) {
          data_to_send.text_domain    = ibtana_visual_editor_modal_js.themedomain;
          data_to_send.license_key    = ibtana_visual_editor_modal_js.admin_user_ibtana_license_key;
          data_to_send.template_type  = ive_template_type;
        } else if ( ive_template_type == 'woocommerce' ) {
          if ( ibtana_visual_editor_modal_js.ive_add_on_keys ) {
            if ( ibtana_visual_editor_modal_js.ive_add_on_keys.hasOwnProperty( 'ibtana_ecommerce_product_addons_license_key' ) ) {
              if ( ibtana_visual_editor_modal_js.ive_add_on_keys.ibtana_ecommerce_product_addons_license_key.hasOwnProperty( 'license_key' ) ) {
                data_to_send.text_domain    = "ibtana-ecommerce-product-addons";
                data_to_send.license_key    = ibtana_visual_editor_modal_js.ive_add_on_keys.ibtana_ecommerce_product_addons_license_key.license_key;
                data_to_send.template_type  = ive_template_type;
              }
            }
          }
        }
      }

      jQuery.ajax({
        method: "POST",
        url: ibtana_visual_editor_modal_js.IBTANA_LICENSE_API_ENDPOINT + "get_client_page_info_for_import",
        data: JSON.stringify(data_to_send),
        dataType: 'json',
        contentType: 'application/json',
      }).done( function( data ) {
        jQuery( '.ibtana--modal--loader' ).hide();

        var current_theme         = ibtana_visual_editor_modal_js.custom_text_domain;
        var demo_url              = data.data.demo_url;
        var demo_image            = data.data.image;
        var demo_title            = data.data.name;
        var demo_permalink        = data.data.permalink;
        var template_text_domain  = data.data.domain;
        var demo_description      = data.data.description;
        var data_template_type    = data.data.template_type;
        console.log( 'data_template_type', data_template_type );

        var is_premium__key_valid  = data.is_key_valid;

        if ( is_demo_premium_template === 1 ) {
          jQuery('.ive-fm-import-btn-wrap a').text( 'Premium Import' );
          jQuery('.ive-fm-import-btn-wrap a').attr( 'ive-is-premium', 1 );
        } else {
          jQuery('.ive-fm-import-btn-wrap a').text( 'Free Import' );
          jQuery('.ive-fm-import-btn-wrap a').attr( 'ive-is-premium', 0 );
        }

        var ive_template_page_type    = data.data.page_type;
        var ive_template_text_domain  = jQuery($this).attr( 'ive-template-text-domain' );

        jQuery( '.ive-fm-import-btn-wrap a' ).attr( 'ive-template-type', ive_template_type );

        if ( ive_template_type == 'wordpress' ) {
          if( is_demo_premium_template == 1 && is_premium__key_valid == 1 && current_theme == ive_template_text_domain ) {
            jQuery('.ive-fm-import-btn-wrap a').css( 'display', 'block' );
          } else if( !is_demo_premium_template || is_demo_premium_template == 0 ) {
            jQuery('.ive-fm-import-btn-wrap a').css( 'display', 'block' );
          } else {
            jQuery('.ive-fm-import-btn-wrap a').hide();
          }
        } else {
          // Condition for the other template types.
          if ( ( is_demo_premium_template == 1 ) && ( is_premium__key_valid == 1 ) ) {
            jQuery('.ive-fm-import-btn-wrap a').css( 'display', 'block' );
          } else if ( is_demo_premium_template == 0 ) {
            jQuery('.ive-fm-import-btn-wrap a').css( 'display', 'block' );
          } else {
            jQuery('.ive-fm-import-btn-wrap a').hide();
          }
        }

        jQuery( '.ive-fm-import-btn-wrap a' ).attr( 'ive-template-page-type', ive_template_page_type );
        jQuery( '.ive-fm-import-btn-wrap a' ).attr( 'ive-template-page-title', demo_title );
        jQuery( '.ive-fm-import-btn-wrap a' ).attr( 'ive-template-text-domain', ive_template_text_domain );
        jQuery( '.ive-fm-template-img img' ).attr( 'src', demo_image );
        jQuery( '.ive-fm-sidebar-content h4' ).text( demo_title );
        jQuery( '.ive-fm-import-btn-wrap a' ).attr( 'ive-template-slug', demo_slug );
        jQuery( '.ive-full-modal-iframe-wrap iframe' ).attr( 'src', demo_url );
        jQuery( '.ive-fm-sidebar-content p' ).text( demo_description );
        jQuery( '.ive-fm-go-pro-btn' ).attr( 'href', demo_permalink );

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

    jQuery( '.ive-fm-prev, .ive-fm-next' ).on( 'click', function() {

      if ( jQuery(this).hasClass('ive-fm-arrow-disabled') ) {
        return;
      }

      var current_template_slug = jQuery( '.ive-fm-import-btn-wrap a' ).attr( 'ive-template-slug' );

      var $current_cards_row = $('.ibtana-row.themes-box-wrap:visible');

      var $current_preview_btn_card = $current_cards_row.find( '.preview-template[ive-template-slug="'+current_template_slug+'"]' ).closest( '.ibtana--card' );

      var current_card_index  = $current_preview_btn_card.index();

      var next_or_prev_card_index = null;
      var next_or_prev_card_index_after_one_card = null;

      if ( jQuery(this).hasClass( 'ive-fm-prev' ) ) {
        next_or_prev_card_index = current_card_index - 1;

        // Code to check if next or previous after one card is available or not.
        next_or_prev_card_index_after_one_card  =  next_or_prev_card_index - 1;
      } else if ( jQuery(this).hasClass( 'ive-fm-next' ) ) {
        next_or_prev_card_index = current_card_index + 1;

        // Code to check if next or previous after one card is available or not.
        next_or_prev_card_index_after_one_card  =  next_or_prev_card_index + 1;
      }

      var $next_or_prev_card = $current_cards_row.find( '.ibtana--card' ).eq( next_or_prev_card_index );
      var $next_or_prev_card_btn = $next_or_prev_card.find( '.preview-template[ive-template-slug]' );
      ibtana_visual_editor_setup_preview_popup( $next_or_prev_card_btn );

      // Code to check if next or previous after one card is available or not.
      jQuery( '.ive-preview-close-btn .prev' ).removeClass( 'ive-fm-arrow-disabled' );
      jQuery( '.ive-preview-close-btn .next' ).removeClass( 'ive-fm-arrow-disabled' );
      if ( ( next_or_prev_card_index_after_one_card < 0 ) || $current_cards_row.find( '.ibtana--card' ).eq( next_or_prev_card_index_after_one_card ).length == 0 ) {
        jQuery( this ).addClass( 'ive-fm-arrow-disabled' );
      }
    });

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
        wpnonce:        ibtana_visual_editor_modal_js.wpnonce,
        is_pro_or_free: is_pro_or_free
      };

      jQuery.post(
        ibtana_visual_editor_modal_js.adminAjax,
        params,
        function( response ) {
          console.log( 'response', response );
          if ( response.home_page_url != "" ) {
            location.href = response.home_page_url;
          }
        }
      );
    }

    $( '#ive-fm-import-template' ).on( 'click', function(e) {
      e.preventDefault();
      var ive_template_text_domain = $( this ).attr( 'ive-template-text-domain' );
      var $this = $( this );
      jQuery( '.ive-demo-child .ive-checkbox-container' ).attr( 'ive-template-text-domain', ive_template_text_domain );

      // Check if the theme is activated
      if ( ( ive_template_text_domain == ibtana_visual_editor_modal_js.active_theme_text_domain ) || ( ive_template_text_domain == ibtana_visual_editor_modal_js.custom_text_domain ) ) {
        jQuery( '.ive-demo-child .ive-checkbox-container' ).addClass( 'activated' );
      }
      $( '.ive-plugin-popup' ).show();
      activate_first_step_in_step_popup();
    });

    $( '.ive-demo-step-container' ).on( 'click', '.ive-checkbox-container', function() {
      if ( $( this ).hasClass( 'activated' ) ) { return; }
      if ( $( this ).find( '.ive-checkbox' ).hasClass( 'active' ) ) {
        $( this ).find( '.ive-checkbox' ).removeClass( 'active' );
      } else {
        $( this ).find( '.ive-checkbox' ).addClass( 'active' );
      }
    });

    $( '.ive-close-button' ).on( 'click', function() {
      $('.ive-plugin-popup').hide();
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
        ibtana_visual_editor_importThemeTemplateJson( jQuery('#ive-fm-import-template') );
      } else {
        if ( theme_text_domain != '' ) {
          install_or_activate_theme( theme_text_domain, function() {
            --total_progress_count;
            if ( total_progress_count === 0 ) {
              set_installation_progress_status( 100 );
              ibtana_visual_editor_importThemeTemplateJson( jQuery('#ive-fm-import-template') );
            }
            for (var i = 0; i < plugins_array.length; i++) {
              var plugin_single = plugins_array[i];
              install_or_activate_plugin( plugin_single, function( result ) {
                console.log( 'result', result );
                --total_progress_count;
                console.log( 'total_progress_count', total_progress_count );
                if ( total_progress_count == 0 ) {
                  set_installation_progress_status( 100 );
                  ibtana_visual_editor_importThemeTemplateJson( jQuery('#ive-fm-import-template') );
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
                ibtana_visual_editor_importThemeTemplateJson( jQuery('#ive-fm-import-template') );
              }
            });
          }
        }
      }

    }

    function install_or_activate_plugin( plugin_details, callback ) {
      jQuery.ajax({
        url:   ibtana_visual_editor_modal_js.adminAjax,
        type:  "POST",
        data: {
          "action"         : "ive_install_and_activate_plugin",
          "plugin_details" : plugin_details,
          "nonce"          : ibtana_visual_editor_modal_js.wpnonce,
        },
      }).done(function ( result ) {
        callback( result );
      });
    }

    function install_or_activate_theme( ive_template_text_domain, callback ) {
      jQuery.ajax({
        url:   ibtana_visual_editor_modal_js.adminAjax,
        type:  "POST",
        data: {
          "action" : "ive-get-installed-theme",
          "slug"   : ive_template_text_domain,
          "nonce"  : ibtana_visual_editor_modal_js.wpnonce,
        },
      }).done(function (result) {
        if( result.success ) {
          if ( result.data.install_status === true ) {
            // Theme is already installed and ready to active

            // Activation Script START
            setTimeout( function() {
              jQuery.ajax({
                url:   ibtana_visual_editor_modal_js.adminAjax,
                type:  "POST",
                data: {
                  "action" : "ive-theme-activate",
                  "slug"   : ive_template_text_domain,
                  "nonce"  : ibtana_visual_editor_modal_js.wpnonce,
                },
              }).done(function (result) {
                if( result.success ) {
                  ibtana_visual_editor_modal_js.active_theme_text_domain = ive_template_text_domain;
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
                  url:   ibtana_visual_editor_modal_js.adminAjax,
                  type:  "POST",
                  data: {
                    "action" : "ive-theme-activate",
                    "slug"   : ive_template_text_domain,
                    "nonce"  : ibtana_visual_editor_modal_js.wpnonce,
                  },
                }).done(function (result) {
                  if( result.success ) {
                    ibtana_visual_editor_modal_js.active_theme_text_domain = ive_template_text_domain;
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

    function get_modal_contents() {
      var data_post = {
        "active_theme_text_domain": active_theme,
        "custom_text_domain": ibtana_visual_editor_modal_js.custom_text_domain
      };

      $('.ibtana--modal--loader').show();
      $( ".content-modal" ).addClass( "content-modal-show" );
      $.ajax({
        method: "POST",
        url: ibtana_license_api_endpoint + "get_modal_contents",
        data: JSON.stringify(data_post),
        dataType: 'json',
        contentType: 'application/json',
      }).done(function( data ) {

        var theme_text_domains_obj = data.data.theme_text_domains;

        var is_ibtana_theme = false;
        $.each(theme_text_domains_obj, function( key, ibtana_theme ) {
          if (ibtana_theme === active_theme) {
            is_ibtana_theme = true;
          }
        });

        var is_key_valid = data.data.is_key_valid;

        $('.ibtana--modal--loader').hide();
        $( ".content-modal" ).removeClass( "content-modal-show" );
        // Free cards
        /*
        var free_data = data.data.free;
        $('#free-template .ibtana-row.themes-box-wrap').empty();
        for (var i = 0; i < free_data.length; i++) {
          var free_data_single = free_data[i];

          var free_card_content = ``;
          if (active_theme === free_data_single.domain) {
            free_card_content += `<div class="ibtana-column-four ibtana--card card-theme-active">`;
          } else {
            free_card_content += `<div class="ibtana-column-four ibtana--card">`;
          }

          free_card_content += `<div class="blog-content-inner">
              <div class="blog-content-img-inner free-content-inner">
                <img class="blog-content-inner-image" src="` + free_data_single.image + `">
              </div>
              <h2>`+free_data_single.name+`</h2>
              <a class="import_free blog-content-btn-inner" data-text-domain="`+free_data_single.domain+`" data-theme-slug="`+ free_data_single.slug +`">
              IMPORT
              <span class="dashicons dashicons-download">
              </span>
              </a>
            </div>
          </div>`;
          if (active_theme === free_data_single.domain) {
            $(free_card_content).prependTo('#free-template .ibtana-row.themes-box-wrap');
          } else {
            $('#free-template .ibtana-row.themes-box-wrap').append(free_card_content);
          }

        }
        if ((0==free_data.length) && (0==$('#free-template .ive-coming-soon').length)) {
          $('#free-template .ibtana-row.themes-box-wrap').append(
            '<h3 class="ive-coming-soon">Coming Soon...</h3>'
          );
        }
        // Free cards END
        */

        if (!is_key_valid) {
          if ('sub' in data.data) {
            var subcategories_data = data.data.sub;
            var sub_cat_html = ``;
            for (var i = 0; i < subcategories_data.length; i++) {
              var subcategory_data = subcategories_data[i];
              var product_ids = subcategory_data.product_ids;
              sub_cat_html += `<button class="sub-cat-button" data-ids="`+product_ids+`">`+subcategory_data.name+` <span class="badge badge-info">`+product_ids.length+`</span></button>`;
            }
            $('#premium-template .sub-cats').empty();
            $('#premium-template .sub-cats').append(sub_cat_html);
          }
          var premium_data = data.data.products;
          $('#premium-template .ibtana-row.themes-box-wrap').empty();
          for (var i = 0; i < premium_data.length; i++) {
            var premium_product = premium_data[i];
            var paid_card_content = `<div class="ibtana-column-three ibtana--card" data-id="`+premium_product.id+`">
                                      <div class="blog-content-inner">
                                        <div class="blog-content-img-inner">
                                          <img class="blog-content-inner-image" src="`+premium_product.image+`">
                                        </div>
                                        <h2>`+premium_product.title+`</h2>`;
            if (themedomain == premium_product.domain) {
              var href = adminUrl+'themes.php?page='+theme_slug+'_guide&tab=gutenberg_import&page_id='+page_id;
              paid_card_content += `<a href="`+href+`" class="blog-content-btn-inner">Get Started</a>`;
            } else {
              paid_card_content += `<a href="`+premium_product.permalink+`" target="_blank" class="blog-content-btn-inner">Buy Now</a>
                                    <a href="`+premium_product.demo_url+`" target="_blank" class="blog-content-btn-inner">Demo</a>
                                  </div>
                                </div>`;

            }
            $('#premium-template .ibtana-row.themes-box-wrap').append(paid_card_content);
          }
          if (!data.data.inner_page.length) {
            jQuery('button[data-tab-head="InnerPages"]').hide();
          }
        } else {
          var premium_data = data.data.premium;
          $('#premium-template .ibtana-row.themes-box-wrap').empty();
          for (var i = 0; i < premium_data.length; i++) {
            var premium_product = premium_data[i];
            var card_content = ``;
            if (active_theme === premium_product.domain) {
              card_content = `<div class="ibtana-column-four ibtana--card card-theme-active">`;
              card_content += `<div class="blog-content-inner">
                                      <div class="blog-content-img-inner">
                                        <img class="blog-content-inner-image" src="`+premium_product.image+`">
                                      </div>
                                      <h2>`+premium_product.name+`</h2>
                                      <a class="import_premium blog-content-btn-inner" data-theme-slug="`+ premium_product.slug +`">IMPORT<span class="dashicons dashicons-download"></span></a>
                                    </div>
                                  </div>`;
              $('#premium-template .ibtana-row.themes-box-wrap').append(card_content);
            } else {
              card_content = `<div class="ibtana-column-four ibtana--card">`;
              card_content += `<div class="blog-content-inner">
                                      <div class="blog-content-img-inner">
                                        <img class="blog-content-inner-image" src="`+premium_product.image+`">
                                      </div>
                                      <h2>`+premium_product.name+`</h2>
                                      <a href="`+premium_product.permalink+`" target="_blank" class="blog-content-btn-inner" data-theme-slug="`+ premium_product.slug +`">Buy Now<span class="dashicons dashicons-download"></span></a>
                                    </div>
                                  </div>`;
              $('#premium-template .ibtana-row.themes-box-wrap').append(card_content);
            }

          }
          if ((0==premium_data.length) && (0==$('#premium-template .ive-coming-soon').length)) {
            $('#premium-template .ibtana-row.themes-box-wrap').append(
              '<h3 class="ive-coming-soon">Coming Soon...</h3>'
            );
          }

          // Inner Pages
          var inner_page_object = data.data.inner_page;
          if (!jQuery.isEmptyObject(inner_page_object)) {
            var inner_pages_sub_cats = inner_page_object.inner_pages_sub_cats;
            $('#InnerPages .inner-tab-content ul').empty();
            $('#InnerPages .inner-pages-divs-wrapper').empty();
            for (var i = 0; i < inner_pages_sub_cats.length; i++) {
              var inner_pages_sub_cat = inner_pages_sub_cats[i];
              var _inner_pages_sub_cat = inner_pages_sub_cat.replace('_', ' ');
              if (i === 0) {
                $('#InnerPages .inner-tab-content ul').append('<li class="theme-tab-list-two active" data-template-tab="'+inner_pages_sub_cat+'"><span>'+_inner_pages_sub_cat+'</span></li>');
                $('#InnerPages .inner-pages-divs-wrapper').append(
                  `<div class="ibtana-theme-block" data-template-div="`+inner_pages_sub_cat+`">
                    <div class="ibtana-row themes-box-wrap">
                    </div>
                  </div>`
                );
              } else {
                $('#InnerPages .inner-tab-content ul').append('<li class="theme-tab-list-two" data-template-tab="'+inner_pages_sub_cat+'"><span>'+_inner_pages_sub_cat+'</span></li>');
                $('#InnerPages .inner-pages-divs-wrapper').append(
                  `<div class="ibtana-theme-block" data-template-div="`+inner_pages_sub_cat+`" style="display:none;">
                    <div class="ibtana-row themes-box-wrap">
                    </div>
                  </div>`
                );
              }
            }

            // Append InnerPages Cards
            var inner_pages = inner_page_object.inner_pages;
            for (var i = 0; i < inner_pages.length; i++) {
              var inner_page_single = inner_pages[i];
              $('#InnerPages .ibtana-theme-block[data-template-div="'+inner_page_single.page_type+'"] .ibtana-row.themes-box-wrap').append(`<div class="ibtana-column-four ibtana--card">
                  <div class="blog-content-inner">
                    <div class="blog-content-img-inner free-content-inner">
                      <img class="blog-content-inner-image" src="` + inner_page_single.image + `">
                    </div>
                    <h2>`+inner_page_single.name+`</h2>
                    <a class="import_free blog-content-btn-inner" data-text-domain="`+inner_page_single.domain+`" data-theme-slug="`+ inner_page_single.slug +`">
                    IMPORT
                    <span class="dashicons dashicons-download">
                    </span>
                    </a>
                  </div>
                </div>`
              );
            }
            // Append InnerPages Cards END
          }
          // Inner Pages END
        }
      });
    }

  }
})(jQuery);
