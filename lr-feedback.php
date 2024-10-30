<?php 
/*
Plugin Name: LR Feedback
Plugin URI: http://www.logicrays.com/
Description: This is just a plugin,For giving Feedback form popup you need to put any form shortcode.
Author: LogicRays WordPress Team
Version: 1.0
*/
define('lrf_feedbackpath', plugins_url('', __FILE__));

function lrf_wp_enqueue_scripts() {
	wp_enqueue_style('custom-css', lrf_feedbackpath.'/assets/css/custom.css' );
	wp_enqueue_script('custom-js', lrf_feedbackpath.'/assets/js/custom.js');
}
add_action('wp_enqueue_scripts','lrf_wp_enqueue_scripts');
add_action('admin_menu', 'lrf_feedback_menu');

function lrf_feedback_menu() {
    add_menu_page('Lr Feedback Settings',
            'Feedback',
            'manage_options',
            'lrf-feedback',
            'lrf_feedback_settings'
    );
}
function lrf_feedback_settings(){?>
<div class="wrap">
<form action="options.php" method="post">
<?php settings_fields("section");?>
<p class="shortcode"><strong>Use Shortcode: [LR_FEEDBACK] in any of the page,post.</strong></p>
<?php
do_settings_sections("feedback-options");
submit_button();
?>
</form>
</div>
<?php
}
function lrf_feedback_fields()
{
	add_settings_section("section", "All Settings", null, "feedback-options");	
	add_settings_field("lrf_feedbacktitle", "Feedback title", "lrf_feedbacktitle_element", "feedback-options", "section");
	add_settings_field("lrf_formshortcode", "Form Shortcode", "lrf_formshortcode_element", "feedback-options", "section");
	add_settings_field("lrf_formposition", "Form Position", "lrf_formposition_element", "feedback-options", "section");

    register_setting("section", "lrf_feedbacktitle");
	register_setting("section", "lrf_formshortcode");
	register_setting("section", "lrf_formposition");
}
add_action("admin_init", "lrf_feedback_fields");

function lrf_feedbacktitle_element()
{
?>
<input type="text" name="lrf_feedbacktitle" size='40' id="lrf_feedbacktitle" 
value="<?php echo esc_attr(get_option('lrf_feedbacktitle')); ?>" />
<p class="description"><?php _e( 'Please enter Feedback Title.' ); ?></p>
<?php
}
function lrf_formshortcode_element()
{
?>
<input type="text" name="lrf_formshortcode" size='40' id="lrf_formshortcode" value="<?php echo esc_attr(get_option('lrf_formshortcode')); ?>" />
<p class="description"><?php _e( 'Please enter form shortcode Eg. contact form 7 shortcode etc.' ); ?></p>
<?php
}
function lrf_formposition_element()
{	$options = get_option('lrf_formposition');
?>
<select id="lrf_formposition" name='lrf_formposition[lrf_formposition]'>
<option value='left' <?php selected( $options['lrf_formposition'], 'left' ); ?>><?php _e( 'Left', 'lrf-feedback' ); ?></option>
<option value='right' <?php selected( $options['lrf_formposition'], 'right' ); ?>><?php _e( 'Right', 'lrf-feedback' ); ?></option>
</select>
<p class="description"><?php _e( 'Please select form Postion Eg. Left, Right', 'lrf-feedback' ); ?></p>
<?php
} 
function lrf_feedback_output(){
ob_start();
	$lrf_feedbacktitle = get_option('lrf_feedbacktitle');	
	$lrf_formshortcode = get_option('lrf_formshortcode');
	$lrf_formposition =  get_option('lrf_formposition');
	
	$lrf_shortcode = do_shortcode( $lrf_formshortcode );
	
	echo '<a href="#" id="rum_sst_tab" class="rum_sst_contents rum_sst_left btn" data-popup-open="popup-1">feedback</a>';echo '<div class="popup" data-popup="popup-1">
	<div class="popup-inner">
	<h2>'.$lrf_feedbacktitle.'</h2>
	'.$lrf_shortcode.'
	<a class="popup-close" data-popup-close="popup-1" href="#">x</a>
	</div>
	</div>';
	if($lrf_formposition['lrf_formposition'] == 'left'){
	$lrf_custom_css ="
	.rum_sst_left{
		left: -25px;
		right:inherit;
		-webkit-transform:rotate(270deg);
		-moz-transform: rotate(270deg);
		-ms-transform: rotate(270deg);}";
	}
	if($lrf_formposition['lrf_formposition'] == 'right')
	{
	$lrf_custom_css="
	.rum_sst_left{
		left:inherit;
		-webkit-transform: rotate(90deg);
		-moz-transform: rotate(90deg);
		-ms-transform: rotate(90deg);
		right:-25px;}";
	}
	?>
<style>
.shortcode {font-size: 16px;}
<?php echo $lrf_custom_css;?>
</style>
<?php 
return ob_get_clean();}
add_shortcode('LR_FEEDBACK', 'lrf_feedback_output');