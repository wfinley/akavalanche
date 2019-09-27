<?php
/** 
 * The forecast archive post.
 */

// begins template. -------------------------------------------------------------------------
get_header();
?> 

<h1> <?php echo $zone1_name; ?> Forecast Archives</h1>
     
<nav class="forecast">
	<div class="nav nav-tabs" id="nav-tab" role="tablist">
			<a class="nav-item nav-link active" data-toggle="tab" href="#view_list" role="tab"  aria-selected="true">List View</a>
			<a class="nav-item nav-link"  data-toggle="tab" href="#view_table" role="tab"  aria-selected="false">Chart View</a>
	</div>
</nav>
<br>

<div class="tab-content" id="myTabContent">
<div class="tab-pane fade show active" id="view_list" role="tabpanel" aria-labelledby="view_list-tab">	
	
 

	<table class="table-striped" width="100%">
	<thead>
		<th class="adv_tableheader">Date</th>
		<th class="adv_tableheader">Rating</th>
		<th class="adv_tableheader adv_table_problem" nowrap>Problem #1</th>
		<th class="adv_tableheader adv_table_problem" nowrap>Problem #2</th>
		<th class="adv_tableheader adv_table_btmline">The Bottom Line</th>	
	</thead>
	<?php    $loop = new WP_Query( array( 'post_type' => array('forecast_zone1','forecast_zone2','forecast_zone3'), 'paged' => $paged, 'posts_per_page' => '50', ) );
	    // BEGIN THE ARCHIVE LOOP
	    if ( $loop->have_posts() ) :
	        while ( $loop->have_posts() ) : $loop->the_post();  ?>
	            <tr>  
		            <!-- GET BASE LEVEL --->
		            <?php
			          	// DATE
			          	$date = get_field('akavalanche_date');
			          	$date = date('D, F dS, Y', strtotime($date)) ; 
			          	$date =  str_replace(" 0"," ",$date);
					  	// HIGHEST RATING
						$akavalanche_rating_map  = get_field('akavalanche_rating_map');
						include("assets/inc_rating-high.php"); 
						// the bottom line
						$excerpt = get_the_excerpt();
			         ?>
		            <td nowrap onclick="window.location='<?php the_permalink(); ?>'" style="cursor: pointer;">
			            <span class="align-middle header_author"><a href="<?php the_permalink(); ?>"><?php echo $date; ?></a></span>
			        </td>
			        <td onclick="window.location='<?php the_permalink(); ?>'" style="cursor: pointer;">

				            <div class="forecast_bkg_archive">
								<div class="forcast_path_archive"> <?php  echo '<img width="60" src="' . plugins_url( 'icons/mountain/paths.png', __FILE__ ) . '" > '; ?></div>
								<?php
								// ALPINE RATING SETUP
								$rating = get_field('akavalanche_rating_high');
								include("assets/inc_rating.php"); 
								$zone_alpine = $ratinglevel;
								echo '<img  width="60" class="forecast_alpine_archive" alt="Avalanche risk" src="' . plugins_url( 'icons/mountain/top_'.$ratinglevel.'.png', __FILE__ ) . '" > '; 	

								// TREELINE RATING SETUP
								$rating = get_field('akavalanche_rating_middle');
								include("assets/inc_rating.php"); 
								$zone_treeline = $ratinglevel;
								echo '<img  width="60" class="forecast_treeline_archive" alt="Avalanche risk" src="' . plugins_url( 'icons/mountain/mid_'.$ratinglevel.'.png', __FILE__ ) . '" > '; 

								// BELOW TREELINE RATING SETUP
								$rating = get_field('akavalanche_rating_low');
								include("assets/inc_rating.php"); 
								$zone_below = $ratinglevel;
								echo '<img  width="60" class="forecast_below_archive" alt="Avalanche risk" src="' . plugins_url( 'icons/mountain/btm_'.$ratinglevel.'.png', __FILE__ ) . '" > '; 
								 ?>
							</div>
		            </td>
		            
			        <td class="adv_table_problem" nowrap onclick="window.location='<?php the_permalink(); ?>'" style="cursor: pointer;">
				        <div class="adv_archive_icon" nowrap>
				        <?php  
					        // AVE PROBLEM 1
							$akavalanche_problemicon = get_field('akavalanche_problem1_icon');	
							include("assets/inc_aveproblem.php");
					        if ($akavalanche_problemicon != "" ) {
					        echo '<img  alt="'.$descriptor.'" src="' . plugins_url( 'icons/'.$akavalanche_problemicon.'', __FILE__ ) . '" > ';
					        } 
					    ?>
				        </div>
				        <div class="adv_archive_label"><?php  if ($akavalanche_problemicon != "" ) { echo $descriptor; } ?></div>
			        </td>
			        <td class="adv_table_problem" nowrap onclick="window.location='<?php the_permalink(); ?>'" style="cursor: pointer;">
				        <div class="adv_archive_icon" nowrap>
				        <?php  
					        $akavalanche_problemicon = get_field('akavalanche_problem2_icon');
					        include("assets/inc_aveproblem.php"); 
					        if ($akavalanche_problemicon != "" ) {
					        echo '<img  alt="'.$descriptor.'" src="' . plugins_url( 'icons/'.$akavalanche_problemicon.'', __FILE__ ) . '" > '; 
					        }
					        ?>
				        </div>
				        <div class="adv_archive_label"><?php  if ($akavalanche_problemicon != "" ) { echo $descriptor; } ?></div>
			        </td>
			        <td class="adv_table_btmline" onclick="window.location='<?php the_permalink(); ?>'" style="cursor: pointer;">
					        <?php  echo $excerpt; ?>
					       <a href="<?php the_permalink(); ?>">[Read More]</a>
			        </td>
	            </tr>      
	<?php endwhile; 
	endif;
	wp_reset_postdata(); ?>
	</table>
	
		<?php
		    $loop = new WP_Query( array( 'post_type' =>  array('forecast_zone1','forecast_zone2','forecast_zone3'), 'paged' => $paged ) );
		    if ( $loop->have_posts() ) :
		        while ( $loop->have_posts() ) : $loop->the_post(); ?>
		  
		        <?php endwhile;
		        if (  $loop->max_num_pages > 1 ) : ?>
		            <div class="adv_archive_navigation">
		                <div class="adv_previous"><?php next_posts_link( __( 'Prev', 'domain' ) ); ?></div>
		                <div class="adv_next"><?php previous_posts_link( __( 'Next ', 'domain' ) ); ?></div>
		            </div>
		        <?php endif;
		    endif;
		    wp_reset_postdata();
		?>
	

</div>
<!-- #view-table -->
<div class="tab-pane fade" id="view_table" role="tabpanel" aria-labelledby="view_table-tab">
<p>Below are archived forecasts for the past five years with the highest danger rating and Avalanche Problem 1 displayed in the chart. Click on a table cell to read the forecast for that day.</p>	
	<table  width="100%" border="1" cellpadding="3" cellspacing="1" >
	  <tr>
	  <th align=center class="color_header" width="5%"><strong>Date</strong></th>
		<?php
		$thismonth = date("m");
		$year = date("y");
		if ($thismonth > 10 ) {
		$year = $year - 1;
		}
		$endyear = $year-5;
		$i = $year;
		while($i>$endyear) {
		  $i--;
		  $displayyear = $i+1;
		  echo '<th width="19%" class="color_header" align=center width="18%"><strong>'.$i.'/'.$displayyear.'</strong></th>';
		}
		?>
	  </tr>
	<?php
	// winterlogic: if this month is between january and october then year is last year; otherwise it's this year
	$thismonth = date("m");
	$year = date("Y");
	if ($thismonth < 10 ) {
		$year = $year - 1;
	}
	$start_date = "$year-11-25";
	$year = $year + 1;
	$end_date = "$year-04-20";
	while(strtotime($start_date) <= strtotime($end_date))
	{
		// echo date in first column
		$newDate = date("m/d", strtotime($start_date));
		echo " <td class=none >$newDate</td>"; 
		
		// ************ this is the actual query for the 1st results column ************ \\
		$season = date ("Y-m-d", strtotime($start_date));
		$args1 = array(
		    'post_type' => 'forecast_zone1',
		    'post_date' => $start_date,
			'posts_per_page' => 1,
			'date_query' => array(
		        array(
		            'after'     => $season,
		            'before'    => $season,
		            'inclusive' => true,
		        ),
			),
		);
		$query = new WP_Query( $args1 );
		  if ( $query->have_posts() ) :
	        while ( $query->have_posts() ) : $query->the_post(); 
	        // HIGHEST RATING
			$akavalanche_rating_map  = get_field('akavalanche_rating_map');
			include("assets/inc_rating-high.php"); 
	
	        ?>
	        <td class="rating_<?php echo $ratinglevel; ?>"><a href="<?php the_permalink(); ?>">
		        <?php  $akavalanche_problemicon = get_field('akavalanche_problem2_icon');
		         // AVE PROBLEM 1
				$akavalanche_problemicon = get_field('akavalanche_problem1_icon');	
				include("assets/inc_aveproblem.php");
		        if ($akavalanche_problemicon != "" ) {
		        echo $descriptor;
		        } 
		        else { echo $akavalanche_rating_map; }
				?>
		      </a></td>
	        <?php
	        endwhile; 
	      else :
	       echo "<td class='rating_0'>No Rating</td>";
		 endif;
		 
		 
		 // ************ first column -1 year for 2nd results column ************ \\
		$season = date ("Y-m-d", strtotime("-1 year", strtotime($start_date)));
		$args1 = array(
		    'post_type' => 'forecast_zone1',
		    'post_date' => $start_date,
			'posts_per_page' => 1,
			'date_query' => array(
		        array(
		            'after'     => $season,
		            'before'    => $season,
		            'inclusive' => true,
		        ),
			),
		);
		$query = new WP_Query( $args1 );
		  if ( $query->have_posts() ) :
	        while ( $query->have_posts() ) : $query->the_post(); 
	        // HIGHEST RATING
			$akavalanche_rating_map  = get_field('akavalanche_rating_map');
			include("assets/inc_rating-high.php"); 
	
	        ?>
	        <td class="rating_<?php echo $ratinglevel; ?>"><a href="<?php the_permalink(); ?>">
		        <?php  $akavalanche_problemicon = get_field('akavalanche_problem2_icon');
		         // AVE PROBLEM 1
				$akavalanche_problemicon = get_field('akavalanche_problem1_icon');	
				include("assets/inc_aveproblem.php");
		        if ($akavalanche_problemicon != "" ) {
		        echo $descriptor;
		        } 
		        else { echo $akavalanche_rating_map; }
				?>
		      </a></td>
	        <?php
	        endwhile; 
	      else :
	       echo "<td class='rating_0'>No Rating</td>";
		 endif;
		 
		 
		 // ************ first column -2 year for 3rd results column ************ \\
		$season = date ("Y-m-d", strtotime("-2 year", strtotime($start_date)));
		$args1 = array(
		    'post_type' => 'forecast_zone1',
		    'post_date' => $start_date,
			'posts_per_page' => 1,
			'date_query' => array(
		        array(
		            'after'     => $season,
		            'before'    => $season,
		            'inclusive' => true,
		        ),
			),
		);
		$query = new WP_Query( $args1 );
		  if ( $query->have_posts() ) :
	        while ( $query->have_posts() ) : $query->the_post(); 
	        // HIGHEST RATING
			$akavalanche_rating_map  = get_field('akavalanche_rating_map');
			include("assets/inc_rating-high.php"); 
	
	        ?>
	        <td class="rating_<?php echo $ratinglevel; ?>"><a href="<?php the_permalink(); ?>">
		        <?php  $akavalanche_problemicon = get_field('akavalanche_problem2_icon');
		         // AVE PROBLEM 1
				$akavalanche_problemicon = get_field('akavalanche_problem1_icon');	
				include("assets/inc_aveproblem.php");
		        if ($akavalanche_problemicon != "" ) {
		        echo $descriptor;
		        } 
		         else { echo $akavalanche_rating_map; }
				?>
		      </a></td>
	        <?php
	        endwhile; 
	      else :
	       echo "<td class='rating_0'>No Rating</td>";
		 endif;
		 
		 
		 // ************ first column -3 year for 4th results column ************ \\
		$season = date ("Y-m-d", strtotime("-3 year", strtotime($start_date)));
		$args1 = array(
		    'post_type' => 'forecast_zone1',
		    'post_date' => $start_date,
			'posts_per_page' => 1,
			'date_query' => array(
		        array(
		            'after'     => $season,
		            'before'    => $season,
		            'inclusive' => true,
		        ),
			),
		);
		$query = new WP_Query( $args1 );
		  if ( $query->have_posts() ) :
	        while ( $query->have_posts() ) : $query->the_post(); 
	        // HIGHEST RATING
			$akavalanche_rating_map  = get_field('akavalanche_rating_map');
			include("assets/inc_rating-high.php"); 
	
	        ?>
	        <td class="rating_<?php echo $ratinglevel; ?>"><a href="<?php the_permalink(); ?>">
		        <?php  $akavalanche_problemicon = get_field('akavalanche_problem2_icon');
		         // AVE PROBLEM 1
				$akavalanche_problemicon = get_field('akavalanche_problem1_icon');	
				include("assets/inc_aveproblem.php");
		        if ($akavalanche_problemicon != "" ) {
		        echo $descriptor;
		        } 
		         else { echo $akavalanche_rating_map; }
				?>
		      </a></td>
	        <?php
	        endwhile; 
	      else :
	       echo "<td class='rating_0'>No Rating</td>";
		 endif;
		 
		 // ************ first column -4 year for 5th results column ************ \\
		$season = date ("Y-m-d", strtotime("-4 year", strtotime($start_date)));
		$args1 = array(
		    'post_type' => 'forecast_zone1',
		    'post_date' => $start_date,
			'posts_per_page' => 1,
			'date_query' => array(
		        array(
		            'after'     => $season,
		            'before'    => $season,
		            'inclusive' => true,
		        ),
			),
		);
		$query = new WP_Query( $args1 );
		  if ( $query->have_posts() ) :
	        while ( $query->have_posts() ) : $query->the_post(); 
	        // HIGHEST RATING
			$akavalanche_rating_map  = get_field('akavalanche_rating_map');
			include("assets/inc_rating-high.php"); 
	
	        ?>
	        <td class="rating_<?php echo $ratinglevel; ?>"><a href="<?php the_permalink(); ?>">
		        <?php  $akavalanche_problemicon = get_field('akavalanche_problem2_icon');
		         // AVE PROBLEM 1
				$akavalanche_problemicon = get_field('akavalanche_problem1_icon');	
				include("assets/inc_aveproblem.php");
		        if ($akavalanche_problemicon != "" ) {
		        echo $descriptor;
		        } 
		         else { echo $akavalanche_rating_map; }
				?>
		      </a></td>
	        <?php
	        endwhile; 
	      else :
	       echo "<td class='rating_0'>No Rating</td>";
		 endif;
			 
		 
	
		// increase date by 1 day
		$start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
		echo "</tr>";
	}
	?>
	</table>	
</div><!-- / #view-table -->

</div><!-- / tab-content -->
</div><!-- /tab-pane -->
</div><!-- /col -->




<?php get_footer(); ?>