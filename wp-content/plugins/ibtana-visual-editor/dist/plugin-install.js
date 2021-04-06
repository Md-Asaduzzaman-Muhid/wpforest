jQuery(document).ready(function($) {
    'use strict';
    var this_obj = ibtana_plugin_activation_script;

    $(document).on('click', '.ive-plugin-install', function(event) {

        event.preventDefault();
        var button = $(this);
        var slug = button.data('slug');
        button.text(this_obj.installing + '...').addClass('updating-message');
        wp.updates.installPlugin({
            slug: slug,
            success: function(data) {
                button.attr('href', data.activateUrl);
                button.text(this_obj.activating + '...');
                button.removeClass('button-secondary updating-message ive-plugin-install');
                button.addClass('button-primary ive-plugin-activate');
                button.trigger('click');
            },
            error: function(data) {
                button.removeClass('updating-message');
                button.text(this_obj.error);
            },
        });
    });

    $(document).on('click', '.ive-plugin-activate', function(event) {
        event.preventDefault();
        var button = $(this);
        var url = button.attr('href');
        if (typeof url !== 'undefined') {
            // Request plugin activation.
            jQuery.ajax({
                async: true,
                type: 'GET',
                url: url,
                beforeSend: function() {
                    button.text(this_obj.activating + '...');
                    button.removeClass('button-secondary');
                    button.addClass('button-primary activate-now updating-message');
                },
                success: function(data) {
                   location.reload();
                }
            });
        }
    });

    jQuery('.ive-tab-content-box.ive-admin-main-tab-content2').on('click', '.ive-plugin-btn.ive-plugin-go-pro-btn', function() {
      var add_on_slug = jQuery(this).attr('data-slug');
      jQuery.ajax({
        method: "POST",
        url: ibtana_plugin_activation_script.ajax_url,
        data: {
          'action':             'install_ibtana_addon',
          'add_on_slug':        add_on_slug
        },
        dataType: 'json',
      }).done(function( data ) {
        location.reload();
      });
    });

    $('form[id="ibtana_license_key_form"]').submit(function(e) {
      e.preventDefault();
      jQuery.ajax({
        method: 'POST',
        url: ibtana_plugin_activation_script.ajax_url,
        dataType: "json",
        data: {
          action: 'activate_license_ibtana_client',
          key: jQuery('form[id="ibtana_license_key_form"]').find('input[name="ibtana_license_key"]').val()
        },
        success:function(data) {
          if (data.status) {
            alert(data.msg);
          } else {
            alert(data.msg);
          }
        },
        error: function(data) {
        }
      });
    });

    /* -------- Addon Activation ------- */

    jQuery('.ive-get-started-addon-button a.ive-activate-addon').click(function() {
        let plugin_slug= jQuery(this).attr('ive-addon-slug');
        jQuery('.ive-get-started-addon-button a .spinner').css('display','inline-block');
        jQuery.ajax({
            method: "POST",
            url: ibtana_plugin_activation_script.ajax_url,
            dataType: 'json',
            data: {
              'action': 'ibtana_visual_editor_activate_plugin',
              'ive-addon-slug': plugin_slug
            },
            success:function(data) {
                jQuery('.ive-get-started-addon-button a .spinner').css('display','none');
                location.reload();
            },
            error: function(error) {
                jQuery('.ive-get-started-addon-button a .spinner').css('display','none');
                location.reload();
            }
            
        });
    });

    /* -------- Addon Deactivation ------- */

    jQuery('.ive-get-started-addon-button a.ive-deactivate-addon').click(function() {
        let plugin_slug= jQuery(this).attr('ive-addon-slug');
        jQuery('.ive-get-started-addon-button a .spinner').css('display','inline-block');
        jQuery.ajax({
            method: "POST",
            url: ibtana_plugin_activation_script.ajax_url,
            dataType: 'json',
            data: {
              'action': 'ibtana_visual_editor_deactivate_plugin',
              'ive-addon-slug': plugin_slug
            },
            success:function(data) {
                jQuery('.ive-get-started-addon-button a .spinner').css('display','none');
                location.reload();
            },
            error: function(error) {
                jQuery('.ive-get-started-addon-button a .spinner').css('display','none');
                location.reload();
            }
            
        });
    });

});
