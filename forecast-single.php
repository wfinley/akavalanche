<?php
/**
 * The single forecast post.
 *
 */

// begins template. -------------------------------------------------------------------------
get_header();
?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
$date = get_field('akavalanche_date');
// set the archived notice
if(time() > (strtotime($date)+3600*30))
	{  $archived = true;  }
else
	{  $archived = false;  }
$date = date('D, F dS, Y', strtotime($date));
$datepost = date('m/d/y', strtotime($date));
$next_date = date('D, F dS, Y', strtotime($date .' +1 day'));
$date =  str_replace(" 0"," ",$date);
$next_date =  str_replace(" 0"," ",$next_date);
?>

<?php $dirurl = plugins_url();  ?>
<?php $dirurl = "$dirurl/"; ?>
		<table border=0 cellpadding=0 cellspacing=0 width="100%"><tr>
		<td valign="top"><h1 > <?php echo $zone1_name; ?> Forecast </h1></td>
		<td valign="top" align="right" width="40" style="white-space:nowrap"><?php
		$prev_post = get_previous_post();
		if($prev_post) {
		   $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
		   echo "\t" . '<a rel="prev" href="' . get_permalink($prev_post->ID) . '" title="PREV" class=" "><img alt="Prev" class="archives_prev" alt="prev" src="' . plugins_url( 'icons/icon_prev.png', __FILE__ ) . '"></a>' . "\n";
		}
		
		/*echo '<a class="archives" href="';
		echo get_home_url();
		echo "/forecast/";
		echo $zone1_slug;
		echo '">Archives</a>';*/

		$next_post = get_next_post();
		if($next_post) {
		   $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
		   echo "\t" . '<a rel="next" href="' . get_permalink($next_post->ID) . '" title="NEXT" class=" "><img alt="Next"  class="archives_next"  alt="prev" src="' . plugins_url( 'icons/icon_next.png', __FILE__ ) . '"></a>' . "\n";
		}
		?></td>
		</tr></table>
		

		<?php // archived notice
		if ($archived)
			{  
				echo '<div class="row"><div class="col">';
				echo "<div class='header_archive' >ARCHIVED FORECAST -  All forecasts  expire after 24 hours from the posting date/time.</div>"; 
				echo '</div></div>';
			}
		?>	

		<div class="row">
			<div class="col-md-4">
				<div class="top_meta_title">Issued</div>
				<div class="top_meta"><?php echo $date; ?> - 7:00AM</div>
			</div>
			<div class="col-md-4">
				<div class="top_meta_title">Expires</div>
				<div class="top_meta"><?php echo $next_date; ?> - 7:00AM</div>
			</div>
			<div class="col-md-4">
				<div class="top_meta_title">Forecaster</div>
				<div class="top_meta"><?php the_field('akavalanche_author') ?></div>
			</div>
		</div>
	
	<?php /// avalanche warning
	// vars	
	$akavalanche_avewarning = get_field('akavalanche_avewarning');
	// check
	if( $akavalanche_avewarning != "" ): ?>
	
	<div class="row">
		<div class="col avewarning_wrap">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td class="avewarning" width="55"><img style="margin: 0 8px; width: 55px; "  src="<?php echo plugins_url( 'icons/caution.png', __FILE__ ); ?>" ></td>
						<td class="avewarning"><div class="avewarning_header"><?php echo $akavalanche_avewarning; ?></div>
						<small>
						<?php if (get_field('akavalanche_avewarning_time') != '') {
						echo "Issued: ";
						the_field('akavalanche_avewarning_time'); 
						echo "<br>";
						}
						?>
						<strong>Travel in avalanche terrain is not recommended. Avoid being on or beneath all steep slopes.</strong></small>
						</td>
					</tr>
				</table>
		</div>
	</div>
	
	<?php endif; ?>

	<div class="row">
		<div class="col">
			<div class="bottom_line">
				<div class="bottom_line_forecast"><img style="margin: 0 8px; width: 35px; float:left; =" src="<?php echo plugins_url( 'icons/icon_btmline.png', __FILE__ ); ?>" > The Bottom Line</div>
				<?php
				// the BOTTOM LINE
				the_content();

				// hide special annoucement if X months old
				$datepost = date('y-m-d', strtotime($date));
				if(strtotime($datepost) > strtotime('2 month ago')) {						
					//special announce 
					$akavalanche_special_announcement = get_field('akavalanche_special_announcement');
					if ( $akavalanche_special_announcement != "" )  { 
						echo '<div>';
						echo '<div class="bottom_line_forecast"><img style="margin: 0 8px; width: 35px; float:left; " src="' . plugins_url( 'icons/icon_announcement.svg', __FILE__ ) . '" > Special Announcements</div>'; 
						echo $akavalanche_special_announcement;  
						echo '</div>';
					 } 
				 }
				?>
			</div>
		</div>
	</div>




<!-- start the tabs -->

<?php
$problem1 = get_field('akavalanche_problem1_icon');
if ( $problem1 == "NOICON.gif" ) { $problem1 = ""; }
$problem2 = get_field('akavalanche_problem2_icon');
if ( $problem2 == "NOICON.gif" ) { $problem2 = ""; }
$problem3  = get_field('akavalanche_additional_icon');
if ( $problem3 == "NOICON.gif" ) { $problem3 = ""; }
$problemweather = get_field('akavalanche_weather');

?>

<div class="row">
	<div class="col">
	<nav class="forecast">
		<div class="nav nav-tabs" id="nav-tab" role="tablist">
			<a class="nav-item nav-link active" data-toggle="tab" href="#forecast" role="tab"  aria-selected="true">Avalanche Forecast</a>
			<?php if ( $problemweather != "" ) { ?><a class="nav-item nav-link" data-toggle="tab" href="#weather" role="tab" aria-selected="false">Weather</a> 	     <?php } ?>			    
			<a class="nav-item nav-link"  data-toggle="tab" href="#riding" role="tab"  aria-selected="false">Riding Areas</a>
		</div>
	</nav>
	</div>
</div>


<?php // ***************** the FORECAST TABLE ***************** \\ ?>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="forecast" role="tabpanel" aria-labelledby="forecast-tab">
	<div class="row">
		<div class="col">
			<div class="content_forecast">Avalanche Danger</div>
			<div style="margin-bottom:5px;"><strong><?php echo $date; ?>:</strong></div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="forecast_bkg">
				 <div class="forcast_path"> <?php  echo '<img  src="' . plugins_url( 'icons/mountain/paths.png', __FILE__ ) . '" > '; ?></div>
				 <?php
				// ALPINE RATING SETUP
				$rating = get_field('akavalanche_rating_high');
				include("assets/inc_rating.php"); 
				$zone_alpine = $ratinglevel;
				?>
				 <div class="forcast_alpine_des">
					 <span class="forcast_zone">Alpine</span><br>
					 <span class="forcast_ele">Above 2,500'</span>
				 </div>
				 <?php  echo '<img  class="forecast_alpine" alt="Avalanche risk" src="' . plugins_url( 'icons/mountain/top_'.$ratinglevel.'.png', __FILE__ ) . '" > '; ?>
				 <div class="forcast_alpine_risk">
					 <div class="risk-rating"><?php echo $rating; ?> (<?php echo $ratinglevel; ?>)</div>      
					 <?php  echo '<img  class="risk-icon" alt="Avalanche risk" src="' . plugins_url( 'icons/hazard_ratings/'.$ratinglevel.'.png', __FILE__ ) . '" > '; ?>
				 </div>
				 <?php
				// TREELINE RATING SETUP
				$rating = get_field('akavalanche_rating_middle');
				include("assets/inc_rating.php"); 
				$zone_treeline = $ratinglevel;?>
				 <div class="forcast_treeline_des">
					 <span class="forcast_zone">Treeline</span><br>
					 <span class="forcast_ele">1,000'-2,500'</span>
				 </div>
				 <?php  echo '<img  class="forecast_treeline" alt="Avalanche risk" src="' . plugins_url( 'icons/mountain/mid_'.$ratinglevel.'.png', __FILE__ ) . '" > '; ?>
				   <div class="forcast_treeline_risk">
					 <div class="risk-rating"><?php echo $rating; ?> (<?php echo $ratinglevel; ?>)</div>	      
					 <?php  echo '<img  class="risk-icon" alt="Avalanche risk" src="' . plugins_url( 'icons/hazard_ratings/'.$ratinglevel.'.png', __FILE__ ) . '" > '; ?>
				 </div>

				 <?php
				// BELOW TREELINE RATING SETUP
				$rating = get_field('akavalanche_rating_low');
				include("assets/inc_rating.php"); 
				$zone_below = $ratinglevel;?>
				 <div class="forcast_below_des">
					 <span class="forcast_zone">Below<br>Treeline</span><br>
					 <span class="forcast_ele"> Below 1,000'</span>
				 </div>
				 <?php  echo '<img  class="forecast_below" alt="Avalanche risk" src="' . plugins_url( 'icons/mountain/btm_'.$ratinglevel.'.png', __FILE__ ) . '" > '; ?>
				 <div class="forcast_below_risk">
					 <div class="risk-rating"><?php echo $rating; ?> (<?php echo $ratinglevel; ?>)</div>	 
					 <?php  echo '<img  class="risk-icon" alt="Avalanche risk" src="' . plugins_url( 'icons/hazard_ratings/'.$ratinglevel.'.png', __FILE__ ) . '" > '; ?>
				 </div>
			</div>
			<div class="forecast_bkg_mobile">
				<table cellpadding="5" width="100%">
					 <?php
					// ALPINE RATING SETUP
					$rating = get_field('akavalanche_rating_high');
					include("assets/inc_rating.php"); ?>
					<tr style="border-bottom: 1px solid #333; background-color: #eee">
						<td width="20%"><span class="forcast_zone">Alpine</span><br><span class="forcast_ele">Above&nbsp;2,500'</span></td>	
						<td  width="10%"> <?php  echo '<img   alt="Avalanche risk" src="' . plugins_url( 'icons/hazard_ratings/'.$ratinglevel.'.png', __FILE__ ) . '" > '; ?></td>
						<td><div class="risk-rating"><?php echo $rating; ?> (<?php echo $ratinglevel; ?>)</div></td>
					</tr>
					 <?php
					// TREELINE RATING SETUP
					$rating = get_field('akavalanche_rating_middle');
					include("assets/inc_rating.php"); ?>
					<tr style="border-bottom: 1px solid #333; background-color: #eee">
						<td> <span class="forcast_zone">Treeline</span><br><span class="forcast_ele">1,000'-2,500'</span></td>
						<td> <?php  echo '<img   alt="Avalanche risk" src="' . plugins_url( 'icons/hazard_ratings/'.$ratinglevel.'.png', __FILE__ ) . '" > '; ?></td>
						<td><div class="risk-rating"><?php echo $rating; ?> (<?php echo $ratinglevel; ?>)</div></td>	
					</tr>
					 <?php
					// BELOW TREELINE RATING SETUP
					$rating = get_field('akavalanche_rating_low');
					include("assets/inc_rating.php"); ?>
					<tr style="background-color: #eee">
						<td><span class="forcast_zone">Below Treeline</span><br><span class="forcast_ele"> Below&nbsp;1,000'</span></td>
						<td> <?php  echo '<img   alt="Avalanche risk" src="' . plugins_url( 'icons/hazard_ratings/'.$ratinglevel.'.png', __FILE__ ) . '" > '; ?></td>	
						<td><div class="risk-rating"><?php echo $rating; ?> (<?php echo $ratinglevel; ?>)</div></td>
					</tr>
				</table>
			</div>
			<div style="max-width: 680px;">
				<?php 
				$akavalanche_rating_map  = get_field('akavalanche_rating_map');
				include("assets/inc_rating-high.php"); 
				echo '<table cellpadding=0 border=0 cellspacing=0><tr><td><img  style="vertical-align:middle; padding: 5px;" alt="Avalanche risk" src="' . plugins_url( 'icons/hazard_ratings/'.$ratinglevel.'.png', __FILE__ ) . '" ></td> ';
				echo '<td><small><strong>TRAVEL ADVICE: ';
				echo $traveladvice;
				echo '</strong></small></td></tr></table>';
				 ?>

				<table width="100%">
					<tr>
						<td class="ratingscale" valign="top"><strong>Danger Scale:</strong></td>
						<td width="14%" class="norating"><div class="bg-gray"></div><div class="ratingtext">No Rating (0)</div></td>
						<td width="14%"><div class="bg-green"></div><div class="ratingtext">Low (1)</div></td>
						<td width="14%"><div class="bg-yellow"></div><div class="ratingtext">Moderate (2)</div></td>
						<td width="14%"><div class="bg-orange"></div><div class="ratingtext">Considerable (3)</div></td>
						<td width="14%"><div class="bg-red"></div><div class="ratingtext">High (4)</div></td>
						<td width="14%"><div class="bg-black"></div><div class="ratingtext">Extreme (5)</div></td>
					</tr>
				</table>
			</div>   
		</div>
	  </div>

  	
	<?php
// include tab is an ave problem is around
 //////////////////////////////// Avalanche Problem 1 \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
$akavalanche_problemicon = get_field('akavalanche_problem1_icon');
$akavalanche_problemicon = trim($akavalanche_problemicon);
$akavalanche_problem1_chance = get_field('akavalanche_problem1_chance');
$akavalanche_problem1_size = get_field('akavalanche_problem1_size');
$akavalanche_problem1 = get_field('akavalanche_problem1');
if ( $akavalanche_problem1 != "" ) { include("assets/inc_aveproblem.php");


?>
	
	
	  		<div class="row">
				<div class="col">
					<div class="content_forecast">Avalanche Problem 1</div>
				</div>
			</div>


	  		<div class="row">
				<div class="adv_wrap">
					<ul>
				      <li id="adv_type_icon" >
						<?php  echo '<img   alt="'.$descriptor.'" src="' . plugins_url( 'icons/'.$akavalanche_problemicon.'', __FILE__ ) . '" > '; ?>
						 <div class="adv_type_label"><?php echo $descriptor; ?></div>
				      </li>
				      <?php if ($akavalanche_problem1_chance != "0") {  ?>
				      <li id="adv_type" >
				        <div class="adv_chance">
							<div class="chance-bar-5 <?php if ($akavalanche_problem1_chance == "5") { echo "bold"; } ?>">Almost Certain</div>
							<div class="chance-bar-4 <?php if ($akavalanche_problem1_chance == "4") { echo "bold"; } ?>">Very Likely</div>
							<div class="chance-bar-3 <?php if ($akavalanche_problem1_chance == "3") { echo "bold"; } ?>">Likely</div>
							<div class="chance-bar-2 <?php if ($akavalanche_problem1_chance == "2") { echo "bold"; } ?>">Possible</div>
							<div class="chance-bar-1 <?php if ($akavalanche_problem1_chance == "1") { echo "bold"; } ?>">Unlikely</div>
							<a href="#chance1" class="probabilitydef_open">
								<?php  echo '<img   src="' . plugins_url( 'icons/chance-size-graphics/chance'.$akavalanche_problem1_chance.'', __FILE__ ) . '.png" > '; ?>
							</a>
				        </div>
				        <div class="adv_type_label">Likelihood</div>
				      </li>
				      <?php } ?>
				      <?php  if ($akavalanche_problem1_size != "0") {  ?>
				       <li id="adv_type" >
				        
				         <div class="adv_size">
							<div class="size-bar-4 <?php if ($akavalanche_problem1_size == "4" or $akavalanche_problem1_size == "34") { echo "bold"; } ?>">Historic</div>
							<div class="size-bar-3 <?php if ($akavalanche_problem1_size == "3" or $akavalanche_problem1_size == "23" or $akavalanche_problem1_size == "34") { echo "bold"; } ?>">Very Large</div>
							<div class="size-bar-2 <?php if ($akavalanche_problem1_size == "2" or $akavalanche_problem1_size == "12" or $akavalanche_problem1_size == "23") { echo "bold"; } ?>">Large</div>
							<div class="size-bar-1 <?php if ($akavalanche_problem1_size == "1" or $akavalanche_problem1_size == "12") { echo "bold"; } ?>">Small</div>
							<a href="#size1" class="sizedef_open">
							<?php  echo '<img   src="' . plugins_url( 'icons/chance-size-graphics/size'.$akavalanche_problem1_size.'', __FILE__ ) . '.png" > '; ?>
							</a>
				        </div>
				        <div class="adv_type_label">Size</div>
				      </li>
				       <?php } ?>
					</ul>
				</div><!-- / adv_wrap	-->
			</div><!-- / row (note row - removes centering	-->
		<!---<div class="row">
			  	<div class="header-gray-wrap">
		  			<div class="header-gray-header"><?php echo $descriptor; ?></div>
		  			<div class="header-gray-info addReadMore showlesscontent"><?php echo $descriptorpopup ?></div>
		  		</div>
	  		</div>--->

		<div class="row">
			<div class="col textfield">
				<?php  the_field('akavalanche_problem1');  ?>
			</div>
		</div>


  	<?php
	} // end no problem 1
	
	//////////////////////////////// Avalanche Problem 2 \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	$akavalanche_problemicon = get_field('akavalanche_problem2_icon');
	$akavalanche_problem2_chance = get_field('akavalanche_problem2_chance');
	$akavalanche_problem2_size = get_field('akavalanche_problem2_size');
	if ( $akavalanche_problemicon == "NOICON.gif" ) { $akavalanche_problemicon = ""; }
	if ( $akavalanche_problemicon != "" ) {
		include("assets/inc_aveproblem.php");
	?>

	
		<div class="row">
			<div class="col">
				<div class="content_forecast">Avalanche Problem 2</div>
			</div>
		</div>

		<div class="row">
		<div class="adv_wrap">
			<ul>
		      <li id="adv_type_icon" >
				<?php  echo '<img class=""  alt="'.$descriptor.'" src="' . plugins_url( 'icons/'.$akavalanche_problemicon.'', __FILE__ ) . '" > '; ?>
				 <div class="adv_type_label"><?php echo $descriptor; ?></div>
		      </li>
		      <?php if ($akavalanche_problem2_chance != "0") {  ?>
		      <li id="adv_type" >
		         <div class="adv_chance">
					<div class="chance-bar-5 <?php if ($akavalanche_problem2_chance == "5") { echo "bold"; } ?>">Almost Certain</div>
					<div class="chance-bar-4 <?php if ($akavalanche_problem2_chance == "4") { echo "bold"; } ?>">Very Likely</div>
					<div class="chance-bar-3 <?php if ($akavalanche_problem2_chance == "3") { echo "bold"; } ?>">Likely</div>
					<div class="chance-bar-2 <?php if ($akavalanche_problem2_chance == "2") { echo "bold"; } ?>">Possible</div>
					<div class="chance-bar-1 <?php if ($akavalanche_problem2_chance == "1") { echo "bold"; } ?>">Unlikely</div>
					<a href="#chance1" class="probabilitydef_open">
						<?php  echo '<img   src="' . plugins_url( 'icons/chance-size-graphics/chance'.$akavalanche_problem2_chance.'', __FILE__ ) . '.png" > '; ?>
					</a>
		        </div>
		         <div class="adv_type_label">Likelihood</div>
		      </li>
		      <?php } ?>
		      <?php  if ($akavalanche_problem2_size != "0") {  ?>
		       <li id="adv_type" >
		         <div class="adv_size">
					<div class="size-bar-4 <?php if ($akavalanche_problem2_size == "4" or $akavalanche_problem2_size == "34") { echo "bold"; } ?>">Historic</div>
					<div class="size-bar-3 <?php if ($akavalanche_problem2_size == "3" or $akavalanche_problem2_size == "23" or $akavalanche_problem2_size == "34") { echo "bold"; } ?>">Very Large</div>
					<div class="size-bar-2 <?php if ($akavalanche_problem2_size == "2" or $akavalanche_problem2_size == "12" or $akavalanche_problem2_size == "23") { echo "bold"; } ?>">Large</div>
					<div class="size-bar-1 <?php if ($akavalanche_problem2_size == "1" or $akavalanche_problem2_size == "12") { echo "bold"; } ?>">Small</div>
					<a href="#size1" class="sizedef_open">
					<?php  echo '<img   src="' . plugins_url( 'icons/chance-size-graphics/size'.$akavalanche_problem2_size.'', __FILE__ ) . '.png" > '; ?>
					</a>
		        </div>
		        <div class="adv_type_label">Size</div>
		      </li>
		       <?php } ?>
			</ul>
		</div><!-- / adv_wrap	-->
	</div><!-- / row (note row - removes centering	-->


	<div class="row">
		<div class="col textfield">
			<?php  the_field('akavalanche_problem2'); ?>
		</div>
	</div>



 	<?php
	} // end no problem 2
	 //////////////////////////////// Additional Concern  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	$akavalanche_problemicon = get_field('akavalanche_additional_icon');
	if ( $akavalanche_problemicon == "NOICON.gif" ) { $akavalanche_problemicon = ""; }
	if ( $akavalanche_problemicon != "" ) {
		include("assets/inc_aveproblem.php");
	?>
	
	<div class="row">
			<div class="col">
				<div class="content_forecast">Additional Concern</div>
			</div>
		</div>
		<div class="adv_wrap">
		<ul>
	      <li id="adv_type_icon" >
			<?php  echo '<img class=""  alt="'.$descriptor.'" src="' . plugins_url( 'icons/'.$akavalanche_problemicon.'', __FILE__ ) . '" > '; ?>
			  <div class="adv_type_label"><?php echo $descriptor; ?></div>
	      </li>
		</ul>
	</div><!-- / adv_wrap	-->
	<div class="row">
		<div class="col textfield">
			<?php  the_field('akavalanche_additional'); ?>
		</div>
	</div>

	
	<?php } // end no problem 2
	echo "</div>";  // end of ave discussion tab

	$akavalanche_weather = get_field('akavalanche_weather');
	if ( $akavalanche_weather != "" ) {
	?>
	<div class="tab-pane fade" id="weather" role="tabpanel" aria-labelledby="weather-tab">

	
  		<div class="row">
			<div class="col">
				<div class="content_forecast">Mountain Weather</div>
			</div>
		</div>

		<div class="row">
			<div class="col textfield">
				<?php echo $akavalanche_weather; ?>
			</div>
		</div>
		
	</div>
	<?php } // end no weather ?>
	
	<div class="tab-pane fade" id="riding" role="tabpanel" aria-labelledby="riding-tab">

  		<div class="row">
			<div class="col">
				<div class="content_forecast">Riding Areas</div>
			</div>
		</div>
		<div class="row">
			<div class="col textfield">
				<p><em>Riding status is not associated with avalanche danger. An area will be open to motorized use in accordance to the Forest Management Plan 
					when snow coverage is adequate to protect underlying vegetation. Backcountry hazards including avalanche hazard are always present 
					regardless of the open status of motorized use areas.</em></p>
				<?php  include 'assets/inc_areas.php'; ?>
			</div>
		</div>
	
	</div>
  
  </div>

<script>
	// strip width height from image
	$('.textfield img').removeAttr('width').removeAttr('height');
</script>

<?php endwhile; ?>
<?php endif; ?>
<?php get_footer();