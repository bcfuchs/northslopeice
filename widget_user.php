
<?php
/** Template Name: Widget_User */
get_currentuserinfo();
global $current_user;
$you = $wpdb->get_results( 
"SELECT COUNT(*) FROM wp_kestrel_readings where author = $current_user->id;" 
);
$other = $wpdb->get_results( 
"SELECT COUNT(*) FROM wp_kestrel_readings;" 
);
?>
<!--  TODO update this on submit -->
<div id="user-widget" class="panel panel-primary page-info">
	<div class="panel-heading">
		<h2 class="panel-title">
			Hi,
			<?php echo $current_user->user_firstname;?>
			!
		</h2>
	</div>
	<div class="panel-body">
		<div id="user-data">
			<ul class="list-group">
				<li class="list-group-item">Total kestrels transcribed: <span id="total-kestrels-tr"><?php echo $other[0]->{"COUNT(*)"} ?></span>
				</li>
				<li class="list-group-item">Kestrels transcribed by you: <span id="you-kestrels-tr"><?php echo $you[0]->{"COUNT(*)"} ?></span>
				</li>
			</ul>
		</div>
	</div>
</div>