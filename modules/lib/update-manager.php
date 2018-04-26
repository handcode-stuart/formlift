<?php

function formlift_db_update_7_4()
{
    /*
     * 1. We need to change the meta name for FORMLIFT_FIELDS to the new one.
     * 2. We need to change the settings options to the new naming conventions
     * 3. The field name type for captcha has been changed to reCaptcha
     */

    global $wpdb;

    /* OPTIONS TABLE - option_name */
    $wpdb->query(
        $wpdb->prepare(
            "
            UPDATE `$wpdb->options`
            set `option_name` = replace( option_name, '%s', '%s' )
    ", 'flp_', 'formlift_')
    );

    /* POST_META TABLE - meta_key */
    $wpdb->query(
        $wpdb->prepare(
            "
            UPDATE `$wpdb->postmeta`
            set `meta_key` = replace( meta_key, '%s', '%s' )
    ", 'flp_', 'formlift_')
    );

    /* GLOBAL OPTIONS - OPTIONS TABLE */
    $styleOptions = get_option( FORMLIFT_STYLE );
    $newStyleOptions = array();
    foreach ( $styleOptions as $styleClass => $attributes ) {
        $newClass = str_replace('flp', 'formlift', $styleClass);
        $newStyleOptions[$newClass] = $attributes;
    }
    update_option( FORMLIFT_STYLE, $newStyleOptions );
    /* GLOBAL STYLE SETTINGS - OPTIONS TABLE */
    $settings = get_option( FORMLIFT_SETTINGS );
    $newSettings = array();
    foreach ( $settings as $settingName => $options ) {
        $newSettingName = str_replace('flp', 'formlift', $settingName);
        $newSettings[$newSettingName] = $options;
    }
    update_option( FORMLIFT_SETTINGS, $newSettings );

    /* SETTINGS - POST META TABLE */
    $forms = get_all_formlift_forms();
    foreach ( $forms as $form ){
        /* STYLE */
        $styleOptions = get_post_meta( $form->ID, FORMLIFT_STYLE, true );
        $newStyleOptions = array();
        if ( !empty( $styleOptions ) ){
            foreach ( $styleOptions as $styleClass => $attributes ) {
                $newClass = str_replace('flp', 'formlift', $styleClass);
                $newStyleOptions[$newClass] = $attributes;
            }
            update_post_meta(  $form->ID,FORMLIFT_STYLE, $newStyleOptions );
        }

        /* OPTIONS */
        $settings = get_post_meta( $form->ID, FORMLIFT_SETTINGS, true );
        $newSettings = array();
        foreach ( $settings as $settingName => $options ) {
            $newSettingName = str_replace('flp', 'formlift', $settingName );
            $newSettings[$newSettingName] = $options;
        }
        update_post_meta(  $form->ID,FORMLIFT_SETTINGS, $newSettings );
        /* FIELDS */
        $fields = array_reverse( get_post_meta( $form->ID, FORMLIFT_FIELDS, true ) );
        foreach ( $fields as $fieldId => $options )
        {
            if ( $options['type'] === 'captcha' )
            {
                $fields[$fieldId]['type'] = 'reCaptcha';
            }
        }
        update_post_meta( $form->ID, FORMLIFT_FIELDS, array_reverse( $fields ) );
    }

    update_option( FORMLIFT_VERSION_KEY, FORMLIFT_VERSION );
}

function formlift_update_notice()
{

    if ( isset( $_POST['formlift_db_upgrade'] ) && isset( $_POST['formlift_db_upgrade_nonce'] ) && wp_verify_nonce( $_POST['formlift_db_upgrade_nonce'], 'formlift_db_upgrade' ) && current_user_can('manage_options' ) )
        formlift_db_update_7_4();

    $version = get_option( FORMLIFT_VERSION_KEY );

    if ( version_compare( $version , FORMLIFT_VERSION, '!=' ) || empty( $version ) )
    {
        $nonceField = wp_nonce_field('formlift_db_upgrade', 'formlift_db_upgrade_nonce', null, false );
        FormLift_Notice_Manager::add_error( 'update-required', "Click here to upgrade your database to continue using FormLift. We recommend you perform a database backup first! <form method='post'>{$nonceField}<input type='submit' class='button' name='formlift_db_upgrade' value='Upgrade My Database Now!'/></form>" );
    } else {
        FormLift_Notice_Manager::remove_notice( 'update-required' );
    }
}

add_action( 'admin_init', 'formlift_update_notice' );