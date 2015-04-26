<?php
add_action ( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style ( 'parent-style', get_template_directory_uri () . '/style.css' );
	wp_enqueue_style ( 'parent-style', get_template_directory_uri () . '/rtl.css' );
}
// use tags to make the functional bits in pages
add_shortcode ( 'add_map_widget', 'add_map_widget' );
function add_map_widget() {
	return get_template_part ( 'map' );
}

add_shortcode ( 'transcriber', 'add_transcriber_page' );
function add_transcriber_page() {
	return get_template_part ( 'transcriber' );
}

add_shortcode ( 'kestrel_page', 'add_kestrel_page' );
function add_kestrel_page() {
	return get_template_part ( 'kestrel_page' );
}

add_shortcode ( 'kestrel_list', 'add_translist_widget' );
function add_translist_widget() {
	return get_template_part ( 'widget_translist' );
}

add_shortcode('test_kestrel','test_kestrel_table');
function test_kestrel_table() {
	/**
	 * +----------------+---------------------+------+-----+---------------------+----------------+
| Field          | Type                | Null | Key | Default             | Extra          |
+----------------+---------------------+------+-----+---------------------+----------------+
| id             | bigint(20) unsigned | NO   | PRI | NULL                | auto_increment |
| wind_direction | varchar(200)        | NO   |     |                     |                |
| wind_speed     | varchar(200)        | NO   |     |                     |                |
| temperature    | varchar(200)        | NO   |     |                     |                |
| date           | datetime            | NO   |     | 0000-00-00 00:00:00 |                |
| lat            | varchar(200)        | NO   |     |                     |                |
| lon            | varchar(200)        | NO   |     |                     |                |
| author         | bigint(20) unsigned | YES  | MUL | NULL                |                |
| comment        | text                | YES  |     | NULL                |                |
| image          | text                | NO   |     | NULL                |                |
+----------------+---------------------+------+-----+---------------------+----------------+
	 */
	
	kestrel_insert_reading("SSW","55","45","5.678","5.43","a/b.jpg");
	
	
}

function kestrel_insert_reading($wd,$ws,$temp,$lat,$lon,$img) {
	global $wpdb;
	$table_name = $wpdb->prefix .'kestrel_readings';
	$wpdb->insert(
			$table_name,
			array(
					'wind_direction' => $wd,
					'wind_speed' => $ws,
					'temperature' => $temp,
					'date'=>current_time( 'mysql' ),
					'lat'=>$lat,
					'lon'=>$lon,
					'author'=> get_current_user_id(),
					'image'=>$img
			)
	);
	
	
	
	
	
	

}

add_action( 'wp_ajax_save_kestrel_data', 'save_kestrel_data' );

function save_kestrel_data() {
	error_log('save_kestrel_data');
	error_log(serialize($_POST));
	error_log(serialize($_GET));
	$lat = $_POST['lat'];
	$lon = $_POST['lon'];
	$img = $_POST['img'];
	$temp = $_POST['temp'];
	$wd = $_POST['wind_direction'];
	$ws = $_POST['wind_speed'];
	error_log($img);
	// TODO exception --fail!
	kestrel_insert_reading($wd,$ws,$temp,$lat,$lon,$img);
	

	wp_die(); // this is required to terminate immediately and return a proper response
}

/**
 * Add transcribe checkbox field
* http://code.tutsplus.com/articles/creating-custom-fields-for-attachments-in-wordpress--net-13076
* 
* To get the urls do a join between postmeta and posts;
* select guid from wp_posts inner join wp_postmeta on wp_posts.id=wp_postmeta.post_id 
* 	where wp_postmeta.meta_key="be_kestrel_transcribe" and wp_postmeta.meta_value=1;
*  
 */

function be_attachment_kestrel_transcribe( $form_fields, $post ) {
	$checked = "";
	// set to checked if value ==1 
	if (get_post_meta( $post->ID, 'be_kestrel_transcribe', true )) 
		$checked = "checked";
	$form_fields['be_kestrel_transcribe'] = array(
			'label' => '<span style="color:red;" id="transcribe-invite">Transcribe this kestral</span>',
			'input' => 'html',
			'value' => get_post_meta( $post->ID, 'be_kestrel_transcribe', true ),
			'helps' => 'check if you want this kestrel to be transcribed',
			'html'=>"<input type='checkbox' value='1' $checked
    		name='attachments[{$post->ID}][be_kestrel_transcribe]'
    		id='attachments[{$post->ID}]' />"
	);


	return $form_fields;
}
	
add_filter( 'attachment_fields_to_edit', 'be_attachment_kestrel_transcribe', 10, 2 );

/**
 * Save transcribe checkbx. 
*/

function be_attachment_kestrel_transcribe_save($post, $attachment ) {

	if( isset( $attachment['be_kestrel_transcribe'] ) )
		
		update_post_meta( $post['ID'], 'be_kestrel_transcribe', $attachment['be_kestrel_transcribe'] );
	
	return $post;
}

add_filter( 'attachment_fields_to_save', 'be_attachment_kestrel_transcribe_save', 10, 2 );


add_action( 'wp_ajax_download_data', 'download_data' );

function download_data() {
	error_log('download_data');
	global $wpdb;
	$results = $wpdb->get_results( 'SELECT * FROM wp_kestrel_readings', OBJECT );
	$out = array();
	foreach ($results as $r) {
		$out[] = $r;
	}
	echo stripslashes(json_encode($out));
	wp_die();
}

add_action('k_get_spinner','k_get_spinner',10,3);
function k_get_spinner($label, $id, $v) {
		error_log($label);
		error_log($id);
		set_query_var( 'number_spinner_label',$label);
		set_query_var( 'number_spinner_id',$id);
		set_query_var( 'number_spinner_default_value',$v);
		get_template_part('number_spinner');
}
// redirect to home page
add_filter( 'login_redirect', create_function( '$url,$query,$user', 'return home_url();' ), 10, 3 );
?>
