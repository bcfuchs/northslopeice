<?php
/**
Template Name: Widget Translist
*/
?>
<h2>Kestrel list</h2>
<?php
/** widget to display a list of kestrels with info when it is available 
* To get the images: 
* global $wpdb;
$query = 'select guid  from wp_posts inner join wp_postmeta on wp_posts.id=wp_postmeta.post_id where wp_postmeta.meta_key="be_kestrel_transcribe" and wp_postmeta.meta_value=1';
$res = $wpdb->get_results($query);

* To get the readings: 
*  
*/


?>
<table id="kestrel-list" class="table">
<th>
<td>Name</td>
<td>Image</td>
<td>Location</td>
<td>Wind Direction</td>
<td>Wind Speed</td>
<td>Temperature</td>
</th>
<tr>
<td  class="kestrel-name"></td>
<td  class="kestrel-image"></td>
<td class="kestrel-location"></td>
<td class="kestrel-wd"></td>
<td class="kestrel-ws"></td>
<td class="kestrel-temp"></td>
</tr>
</table>


  