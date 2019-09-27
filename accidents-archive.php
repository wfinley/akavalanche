<?php
$title = "<h1>Accidents";
if(isset($_GET['regions'])) {
	$region = $_GET['regions'];
	$title.= " for ";
	$title.= $region;
}
else {
	$title.= " for All regions";
}
$title.= "</h1>";
echo $title;	

// Creates the top selection tool
global $wp;
$theurl= home_url( $wp->request );
$field = get_field_object('field_5d894e1ff330e');
echo "<select name='cat' id='cat' class='nav-postform'>n";
echo "<option value=''>Select Region</option>n";
echo "<option value=''>Display All</option>n"; 
if( $field['choices'] ): 
     foreach( $field['choices'] as $value => $label ): 
        echo "<option value='?regions=".$label."'>".$label."</option>";  
     endforeach; 
 endif; 
echo "</select>";
echo '<script type="text/javascript"><!--
    var dropdown = document.getElementById("cat");
    function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value != "0" ) {
			location.href = "'.$theurl.'/"+dropdown.options[dropdown.selectedIndex].value;
		}
    }
    dropdown.onchange = onCatChange;
--></script>';
?>


<table class="table-striped" >
	<thead class="thead-dark">
		<tr class="cnfaic_obs-table-header-row">
			<th class="cnfaic_obs-table-th cnfaic_obs-table-th-observation_datetime">Date</th>
			<th class="cnfaic_obs-table-th cnfaic_obs-table-th-region_location">Region</th>
			<th class="cnfaic_obs-table-th cnfaic_obs-table-th-specific_location">Location</th>
			<th class="cnfaic_obs-table-th cnfaic_obs-table-th-trigger">Trigger</th>
			<th class="cnfaic_obs-table-th cnfaic_obs-table-th-fatalities">Fatalities</th>
		</tr>
	</thead>
	<tbody>
<?php
// BEGIN THE accidents LOOP

if(isset($_GET['regions'])) {
	$region = $_GET['regions'];
	$args = array(
	  'post_type' => 'forecast_acccidents',
	  'paged' => $paged, 
	  'posts_per_page' => '100',
	  
	  'meta_query' => array(
	    array(
	      'key' => 'cnfaic_accidents_region',
	      'value' => $region,
	      'compare' => 'LIKE'
	    ),

         array(
            'meta_key' => 'cnfaic_accidents_date',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        )
	  )
	);
	$loop = new WP_Query( $args );
	
}
else {
	$loop = new WP_Query( 
	array( 
	'post_type' => array('forecast_acccidents'), 
	'paged' => $paged, 
	'posts_per_page' => '100', 
	array(
            'meta_key' => 'cnfaic_accidents_date',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        )
	) );
}




if ( $loop->have_posts() ) :
    while ( $loop->have_posts() ) : $loop->the_post();  ?>
    <?php
      // DATE
	  $date = get_field('cnfaic_accidents_date', false, false);
	  $date = new DateTime($date);
	  $fatal = get_field('cnfaic_accidents_killed'); 
	  $report = get_field('cnfaic_accidents_report'); 
	?>
    <?php
	   if ( $report ) {
	        $link =  $report['url'];
        }
        else {
	        $link = get_permalink();
	        
        }  
        echo ' <tr onclick="document.location=\''.$link.'\'">';  
	?>
   
        <td class="cnfaic_obs-table-td cnfaic_obs-table-td-observation_datetime"><?php echo $date->format('m/d/y'); ?></td>
        <td class="cnfaic_obs-table-td cnfaic_obs-table-td-region_location"><?php echo the_field('cnfaic_accidents_region'); ?></td>
        <td class="cnfaic_obs-table-td cnfaic_obs-table-td-specific_location">
	        <?php 
		        if ( $report ) {
			        echo '<a target=_blank" href="'.$report['url'].'">';
		        }
		        else {
			        $link = get_permalink();
			        echo '<a href="'.$link.'">'; 
		        }
		        
		        if ($fatal != 0) { echo "<strong>Accident:</strong> "; }
		        else { echo "<strong>Near Miss:</strong> "; }
		        the_title(); 
		         if ( $report ) { echo "</a>"; }
		    ?>
		</td>
        <td class="cnfaic_obs-table-td cnfaic_obs-table-td-trigger"><?php echo the_field('cnfaic_accidents_activity'); ?></td>
        <td class="cnfaic_obs-table-td cnfaic_obs-table-td-fatalities">
	        <?php 
		        if ($fatal != 0) { echo $fatal; }
		    ?>
		 </td>
    </tr>
    
	

    <?php endwhile; 
	endif;
	wp_reset_postdata(); ?>
	</tbody>
</table>