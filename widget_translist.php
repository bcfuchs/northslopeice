<?php
/**
Template Name: Widget Translist
*/
?>
<style>
#kestrel-list img {
width: 100px;

}
</style>
<h2>Kestrel list</h2>
<p>Just a list to see what we've got</p>

<?php
/** widget to display a list of kestrels with info when it is available 
* To get the images: 
* global $wpdb;
$query = 'select guid  from wp_posts inner join wp_postmeta on wp_posts.id=wp_postmeta.post_id where wp_postmeta.meta_key="be_kestrel_transcribe" and wp_postmeta.meta_value=1';
$res = $wpdb->get_results($query);

* To get the readings: 

select * from wp_kestrel_readings where image=$imageurl;
* 
* Better way to do this:
* 1. get all the available kestrels
* 2. List all the transciptions for that kestrel
* 3. Put in list-groups inside a list-group
*  
*/
?>
<table id="kestrel-list" class="table">
<tr>
<td>Image</td>
<td>Location</td>
<td>Wind Direction</td>
<td>Wind Speed</td>
<td>Temperature</td>
</tr>
<?php
global $wpdb;
$query = 'select * from wp_kestrel_readings';
$res = $wpdb->get_results($query);
// there will be more than two readings for a kestrel!

foreach ($res as $img) {
$lat = stripslashes($img->lat);
$lon = stripslashes($img->lon);
$out = <<<END

<tr>

<td  class="kestrel-image"><img src="$img->image"/></td>
<td class="kestrel-location">$lat, $lon</td>
<td class="kestrel-wd">$img->wind_direction</td>
<td class="kestrel-ws">$img->wind_speed</td>
<td class="kestrel-temp">$img->temperature</td>
</tr>
END;
echo $out;
}


?>

</table>


  