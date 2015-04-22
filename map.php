<?php
/**
Template Name: Map


*/
?>
<style>
.sidebar-wrap {
display:none;

}
#comments {
display: none;

}

  html { height: 100% }
  body { height: 100%; margin: 0; padding: 0 }
  
  #map-header {
  margin-bottom: 10px;
  width: 500px;
  
  }
  
  #adddata {
  margin-left: 40px;
  margin-bottom: 10px;
  
  }

@media (min-width: 1200px)
.container {
 // width: 100%;
}
</style>
<div id="map-header" style="display:inline">
<h2 style="display:inline">Data Points</h2>
<button id="adddata" class="btn btn-primary" style="display:inline;">Update data</button>
</div>
<?php get_template_part('widget_map'); ?>
<script>
jQuery(document).ready(function($){
  var data = [
              [71.283, -156.790, "6EF569"],
              [71.273, -156.761, "FE75F9"],
              [71.253, -156.810, "6E5F69"],
              [71.223, -156.851, "BEF5F2"]
          ];
  var mapProp = {
      center : new google.maps.LatLng(71.275044, -155.2818778),
      zoom : 10,
      mapTypeId : google.maps.MapTypeId.ROADMAP
    };
    window.ait.makeMap(data,mapProp);
});


</script>