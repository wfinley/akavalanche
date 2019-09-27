<?php
/*
Template Name:  The single forecast tempalte.
*/
get_header(); ?>
		
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php 
	$date = get_field('cnfaic_accidents_date', false, false);
	$date = date('D, F dS, Y', strtotime($date)) ; 
	$date =  str_replace(" 0"," ",$date);
	$fatal = get_field('cnfaic_accidents_killed'); 
	$activity = get_field('cnfaic_accidents_activity'); 
	$region = get_field('cnfaic_accidents_region'); 
	 $report = get_field('cnfaic_accidents_report'); 
	?>
	<h1><?php if ($fatal != 0) { echo "Accident: "; }  else { echo "Near Miss:"; } ?> <?php echo $region; ?></h1>
	<h2>Location: <?php the_title(); ?></h2>

	<div class="row">
		<div class="col-md-4">
			<div class="top_meta_title">Date</div>
			<div class="top_meta"><?php echo $date; ?></div>
		</div>
		<div class="col-md-4">
			<div class="top_meta_title">Activity</div>
			<div class="top_meta"><?php echo $activity; ?></div>
		</div>
		<div class="col-md-4">
			<div class="top_meta_title">Fatalities</div>
			<div class="top_meta"><?php echo $fatal; ?></div>
		</div>
	</div>
	<div class="headerbar">Accident Report</div>
	<div class="textfield">
		<?php 
		// if there is an actual report
		 if ( $report ) {
	        $link =  $report['url'];
	        echo '<h4><a href="'.$link.'">Download Accident Report</a></h4>';
        }
			
		the_content();
		// get images
		$images = get_field('cnfaic_accidents_gallery');
		
		if( $images ): ?>
		
		<div class="headerbar">Photos</div>
	        <?php foreach( $images as $image ): ?>
				<div align="center"><img class="gallery-image" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></div>
				<p align="center" class="gallery-caption"><?php echo $image['caption']; ?></p>
	        <?php endforeach; ?>
		<?php endif; ?>

	</div>
	<?php endwhile; ?>
	<?php else : ?>
	<?php
		echo "<h2>Not found</h2>";
		get_search_form();
	?>
<?php endif; ?>








<?php get_footer(); ?>