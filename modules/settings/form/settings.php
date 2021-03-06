<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class FormLift_Settings
{

    public static function admin_settings()
    {
        $fields = array();

        $fields["opt_out_of_usage_stats"] = new FormLift_Setting_Field(FORMLIFT_CHECKBOX, 'opt_out_of_usage_stats', "Opt of Usage Stats collection.");
        $fields[] = "<hr>";
        $fields["disable_utm_removal"] = new FormLift_Setting_Field(FORMLIFT_CHECKBOX, 'disable_utm_removal', 'Disable PII Query Removal');
        $fields[] = "<p>This will stop FormLift from removing PII Variables from the url query string. This may cause issues regarding google adwords policies and put your user's information at risk to external scripts.</p>";
        $fields["exclude_from_utm_removal"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'exclude_from_utm_removal', 'Exclude UTM Variables From Removal');
        $fields[] = "<p>Enter 1 variable per line. FormLift strips PII (Personal Identifiable Infortmation) from the URL query string to protect user data from external scripts. Add UTM variables here to exclude them from this functionality.</p>";
	    $fields[] = "<hr>";
	    if ( FormLift_Module_Manager::has_modules() ){
		    $fields["disable_credit"] = new FormLift_Setting_Field(FORMLIFT_CHECKBOX, 'disable_credit', "Disable the \"&#9889 by FormLift\" credit. (It helps us out a LOT if you leave it &#9786)");
	    }
	    $fields[] = "<hr>";
        $fields["reset_button"] = new FormLift_Setting_Field( FORMLIFT_BUTTON, "reset_style_to_defaults", "Reset All Style Settings To Their Defaults", "RESET TO DEFAULTS");

        return apply_filters( 'formlift_admin_settings', $fields );
    }

    public static function import_export()
    {
	    $fields = array();
	    $fields[] = "<h2>Style Settings</h2>";
	    $fields["import_style_settings"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'import_style_settings', 'Paste your settings here...');
	    $fields["import_style"] = new FormLift_Setting_Field( FORMLIFT_BUTTON, "import_style", "Click to import...", "IMPORT NOW");
	    $fields["export_style"] = new FormLift_Setting_Field( FORMLIFT_BUTTON, "export_style", "Export your settings", "EXPORT NOW");
	    $fields[] = "<hr>";
	    $fields[] = "<h2>Plugin Settings</h2>";
	    $fields["import_plugin_settings"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'import_plugin_settings', 'Paste your settings here...');
	    $fields["import_plugin"] = new FormLift_Setting_Field( FORMLIFT_BUTTON, "import_plugin", "Click to import...", "IMPORT NOW");
	    $fields["export_plugin"] = new FormLift_Setting_Field( FORMLIFT_BUTTON, "export_plugin", "Export your settings", "EXPORT NOW");

	    return apply_filters( 'formlift_import_export_settings', $fields );
    }

    public static function submission_settings()
    {
        $fields = array();
        $fields["post_url"] = new FormLift_Setting_Field(FORMLIFT_INPUT, 'post_url', 'Infusionsoft Post URL');
        $fields[] = "<hr>";
        $fields["target_blank"] = new FormLift_Setting_Field(FORMLIFT_CHECKBOX, 'target_blank', 'Submit To Blank Page');
        $fields[] = "<div class=\"formlift-error\">Enabling this will open up a new page upon a form submission.</div>";
        $fields[] = "<hr>";
        $fields["show_post_url"] = new FormLift_Setting_Field(FORMLIFT_CHECKBOX, 'show_post_url', 'Show Post URL');
        $fields[] = "<div class=\"formlift-error\">Enabling this will turn off validation and open you up to spam.</div>";
        $fields[] = "<hr>";
        //$fields["submit_via_ajax"] = new FormLift_Setting_Field( FORMLIFT_CHECKBOX, 'submit_via_ajax', 'Don\'t send to thank you page.' );
        $fields["enable_compatibility_mode"] = new FormLift_Setting_Field( FORMLIFT_CHECKBOX, 'enable_compatibility_mode', 'Enable compatibility mode.' );

        return apply_filters( 'formlift_submission_settings', $fields );
    }

    /**
     * Returns a list of FormLift_Setting_Fields for the Button Settings Section
     *
     * @return array
     */
    public static function error_settings()
    {
        $fields = array();

        $fields["success_message"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'success_message', 'Success Message');
        $fields["please_wait_text"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'please_wait_text', 'Please Wait Text...');
        $fields["invalid_data_error"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'invalid_data_error', 'Invalid Data Error');
        $fields["required_error"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'required_error', 'Required Field Error');
        $fields["email_error"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'email_error', 'Invalid Email Error');
        $fields["phone_error"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'phone_error', 'Invalid Phone Error');
        $fields["date_error"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'date_error', 'Invalid Date Error');
        //$fields["captcha_error"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'captcha_error', 'Captcha Error');
        $fields["url_error"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'url_error', 'Invalid Url Error');
        $fields["password_error"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'password_error', 'Mismatched Passwords Error');
        //$fields["logged_in_error"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'logged_in_error', 'Logged In Error');

        return apply_filters( 'formlift_error_settings', $fields );
    }

    /**
     * Returns a list of FormLift_Setting_Fields for the tracking settings section
     *
     * @return array
     */
    public static function tracking_settings()
    {
        $fields = array();
        if ( !is_ssl() ){
           $fields[] = "<p style='color:#ff0000'>The below settings will have no affect because you do not have an SSL certificate installed. Session tracking and other features will not work as designed until you install an SSL Certificate.</p>";
        }
        $fields["disable_session_storage"] = new FormLift_Setting_Field( FORMLIFT_CHECKBOX, 'disable_session_storage', "Disable Session Storage");
        $fields[] = "<p>Enable this to turn OFF the storage of Personal Identifiable Information on FormLift between pages.</p>";
        $fields["time_to_live"] = new FormLift_Setting_Field( FORMLIFT_NUMBER, 'time_to_live', "PII Session Storage Time in Days");
        $fields[] = "<p>The number of days you'd like FormLift to store PII after a user's LAST successful submission so that it will auto populate forms and replacement codes.</p>";
        $fields["delete_all_sessions"] = new FormLift_Setting_Field( FORMLIFT_BUTTON, "delete_all_sessions", "Delete all currently stored user sessions", "DELETE SESSIONS");

        return apply_filters( 'formlift_get_tracking_settings', $fields );
    }

    /**
     * Returns a list of FormLift_Setting_Fields for the Infusionsoft API settings
     *
     * @return array
     */
    public static function infusionsoft_settings()
    {
        $status = get_option( 'oauth_last_status' );

        $fields = array();
        $fields[] = new FormLift_Setting_Field(FORMLIFT_BUTTON, 'activate_OAuth', 'Connect To Infusionsoft', "CONNECT");
        $fields[] = new FormLift_Setting_Field(FORMLIFT_BUTTON, 'refresh_OAuth', 'Refresh Infusionsoft Connection', "REFRESH");
        $fields[] = new FormLift_Setting_Field(FORMLIFT_BUTTON, 'disconnect_Oauth', 'Disconnect From Infusionsoft', "DISCONNECT");
        $fields[] = "<p>Current Status: $status<p>";
        $fields[] = "<hr>";
        $fields[] = "<h1>Experiencing issues? Try using legacy... </h1>";
        $fields[] = new FormLift_Setting_Field(FORMLIFT_INPUT, 'infusionsoft_app_name', 'Infusionsoft App Name (e.g xx123)');
        $fields[] = new FormLift_Setting_Field(FORMLIFT_SECRET, 'infusionsoft_api_key', 'Infusionsoft API Key');

        return apply_filters( 'formlift_infusionsoft_settigns', $fields);
    }

    /**
     * Returns a list of FormLift_Setting_Fields for the form import settings
     *
     * @return array
     */
    public static function import_settings()
    {
        
        $fields = array();
        $fields["infusionsoft_form_id"] = new FormLift_Setting_Field(FORMLIFT_SELECT, 'infusionsoft_form_id', 'Import From Infusionsoft', formlift_get_infusionsoft_webforms() );
        $fields["form_refresh"] = new FormLift_Setting_Field(FORMLIFT_BUTTON, 'form_refresh', 'Replace Form Code', "REPLACE");
        $fields[] = "<p>This will completely replace your form code, all changes made in the editor will be lost.</p>";
	    $fields["form_sync"] = new FormLift_Setting_Field(FORMLIFT_BUTTON, 'form_sync', 'Sync Form Code', "SYNC");
	    $fields[] = "<p>This will update your form with any changes you made in Infusionsoft, like adding new fields.</p>";
	    $fields["formlift_update_webform_list"] = new FormLift_Setting_Field(FORMLIFT_BUTTON, 'formlift_update_webform_list', 'Refresh Form List', "REFRESH");

        $fields[] = "<hr>";
        $fields["infusionsoft_form_original_html"] = new FormLift_Setting_Field(FORMLIFT_TEXT, 'infusionsoft_form_original_html', 'Use Form Html');
        $fields["parse_original_html"] = new FormLift_Setting_Field(FORMLIFT_BUTTON, 'parse_original_html', 'Parse Form Html', "IMPORT");

        return apply_filters( 'formlift_import_settings', $fields );
    }

    /**
     * Function that saves the default settings
     *
     * @param $options
     */
    public static function save_settings()
    {
        if ( isset( $_POST['formlift_options'] ) && wp_verify_nonce( $_POST['formlift_options'], 'update' ) && current_user_can('manage_options')){
            
            $options = $_POST[ FORMLIFT_SETTINGS ];

            $options = apply_filters( 'formlift_sanitize_form_settings', $options );

            update_option( FORMLIFT_SETTINGS, $options);
        }
    }

    /**
     * Cleans the settings so no one can break the form.
     *
     * @param $array array
     * @return array
     */
    public static function clean_settings( $array )
    {
        foreach ( $array as $option => $value )
        {
            if ( is_string( $value ) ){
                $array[ $option ] = sanitize_textarea_field( stripslashes( $value ) );
            } elseif ( ( is_array( $value ) ) ){
                $array[ $option ] = self::clean_settings($value);
            }
        }

        return $array;
    }

	public static function export_settings()
	{
		if ( isset( $_POST[FORMLIFT_SETTINGS]['export_plugin'] ) && wp_verify_nonce( $_POST['formlift_options'], 'update' ) && current_user_can('manage_options') ){
			$filename = "formlift_plugin_settings_".date("Y-m-d_H-i",time() );

			header("Content-type: text/plain");
			//header("Content-disposition: csv" . date("Y-m-d") . ".csv");
			header( "Content-disposition: attachment; filename=".$filename.".txt");
			// do not cache the file
			//header('Pragma: no-cache');
			//header('Expires: 0');

			$file = fopen('php://output', 'w');

			fputs($file, json_encode( get_option( FORMLIFT_SETTINGS ) ) );

			// output each row of the data

			fclose($file);

			exit();
		}
	}

	public static function import()
	{
		if ( isset( $_POST[FORMLIFT_SETTINGS]['import_plugin'] ) && wp_verify_nonce( $_POST['formlift_options'], 'update' ) && current_user_can('manage_options') ){

			$options = stripslashes( $_POST[ FORMLIFT_SETTINGS ]['import_plugin_settings'] );

			if ( empty( $options ) ){
				FormLift_Notice_Manager::add_error('bad_import', "No settings to import..." );
				return;
			}

			$options = apply_filters( 'formlift_sanitize_form_settings', json_decode( $options, true ) );
			update_option( FORMLIFT_SETTINGS, $options );

		}
	}
}

add_action( 'init' , array('FormLift_Settings', 'save_settings') );
add_filter( 'formlift_sanitize_form_settings', array( 'FormLift_Settings', 'clean_settings') );
add_action( 'init' , array( 'FormLift_Settings', 'export_settings' ) );
add_action( 'init' , array( 'FormLift_Settings', 'import' ) );