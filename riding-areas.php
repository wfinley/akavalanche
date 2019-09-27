<?php
// **************************************************** \\
// ----------- insert new ----------------------\\
// **************************************************** \\	
global $wpdb; 
if( isset($_POST['submit']) )
{
    $updatetime = current_time( 'mysql' ); 
	$length = count($_POST['area']);
	for ($i = 0; $i < $length; $i++) {
	   
	   $district = $_POST['district'][$i];
	   $area = $_POST['area'][$i];
	   $openstatus =  $_POST['openstatus'][$i];
	   $snowcond =  $_POST['snowcond'][$i];
	   
	   $district = sanitize_text_field( $district );
	   $area = sanitize_text_field( $area );
	   $openstatus = sanitize_text_field( $openstatus );
	   $snowcond = sanitize_text_field( $snowcond );

	   $table = "".$wpdb->prefix."area_update";
	   $wpdb->insert( 
		    $table, 
		    array( 
		        'district' => $district, 
		        'area' => $area,
		        'openstatus' => $openstatus,
		        'snowcond' => $snowcond,
		        'updatetime'  => $updatetime
		    ), 
		    array( 
		        '%s', 
		        '%s',
		        '%s',
		        '%s',
		        '%s'
		    ) 
		 );
 
	}
echo "<strong>Updating...</strong>";
echo ' <meta http-equiv="refresh"  content="0; url=admin.php?page=akavalanches_riding">';
exit;
}


// **************************************************** \\
// ----------- last updated ----------------------\\
// **************************************************** \\
global $wpdb; 
$sql= "Select updatetime FROM ".$wpdb->prefix."area_update order by updatetime desc limit 1";
$rs_result = $wpdb->get_results($sql);
foreach( $rs_result as $results ) {
	$updated = $results->updatetime;
}
echo"<p><em><strong>(Last Updated: $updated)</strong></em></p>";



?>

<style>
	.widefat td { border-bottom: 1px solid #eee; }
</style>
<table class="widefat " cellpadding="5" width="100%">

<tr ><td  colspan='3' style="background: #ccc;"><h3 style="padding:0; margin:0;">Glacier District</h3></td></tr>
<tr>
<th style="background: #eee;"><strong>Area</strong></th>
<th style="background: #eee;"><strong>Status</strong></th>
<th style="background: #eee;"><strong>Weather &amp; Riding Conditions</strong></th>
</tr>
<form method="post" action="admin.php?page=akavalanches_riding">
<?php
// **************************************************** \\
// ----------- get glacier district ----------------------\\
// **************************************************** \\

$i = 0;
$sql= "Select distinct area FROM ".$wpdb->prefix."area_update where district = 'glacier' group by area";
$rs_result = $wpdb->get_results($sql);
foreach( $rs_result as $results ) {
	$area= $results->area;
	echo '<tr>';
	echo '<td><strong>'.$area.'</strong></td>';
		$sql= "Select district, openstatus, snowcond from ".$wpdb->prefix."area_update where area = '".$area."' order by updatetime DESC limit 1";
		$rs_result = $wpdb->get_results($sql);
	    foreach( $rs_result as $results ) 
	    	{
			$district = $results->district;
			$openstatus = $results->openstatus;
			$snowcond = $results->snowcond;
			if ($openstatus = "Closed") { echo '<td><input name="openstatus['.$i.']" type="radio" value="Closed" checked> Closed  <br><input name="openstatus['.$i.']" type="radio" value="Open"> Open</td>'; }
			else { echo '<td><input name="openstatus['.$i.']" type="radio" value="Closed" > Closed  <br><input name="openstatus['.$i.']" type="radio" value="Open" checked> Open</td>';  }
			echo '<td><textarea name="snowcond['.$i.']" style="width:80%;" rows="2">'.$snowcond.'</textarea></td>';
			echo '<input type="hidden" name="area['.$i.']" value="'.$area.'">';
			echo '<input type="hidden" name="district['.$i.']" value="'.$district.'">';
			}
	echo '</tr>';  
$i++;
}  
?>
<tr ><td  colspan='3' style="background: #ccc;"><h3 style="padding:0; margin:0;">Seward District</h3></td></tr>
<tr>
<th style="background: #eee;"><strong>Area</strong></th>
<th style="background: #eee;"><strong>Status</strong></th>
<th style="background: #eee;"><strong>Weather &amp; Riding Conditions</strong></th>
</tr>
<?php 
$sql= "Select distinct area FROM ".$wpdb->prefix."area_update where district = 'seward' group by area";
$rs_result = $wpdb->get_results($sql);
foreach( $rs_result as $results ) {
	$area= $results->area;
	echo '<tr>';
	echo '<td><strong>'.$area.'<input type="hidden" name="area['.$i.']" value="'.$area.'"></strong></td>';
		$sql= "Select openstatus, snowcond from ".$wpdb->prefix."area_update where area = '".$area."' order by updatetime DESC limit 1";
		$rs_result = $wpdb->get_results($sql);
	    foreach( $rs_result as $results ) 
	    	{
			$openstatus = $results->openstatus;
			$snowcond = $results->snowcond;
			if ($openstatus = "Closed") { echo '<td><input name="openstatus['.$i.']" type="radio" value="Closed" checked> Closed  <br><input name="openstatus['.$i.']" type="radio" value="Open"> Open</td>'; }
			else { echo '<td><input name="openstatus['.$i.']" type="radio" value="Closed" > Closed  <br><input name="openstatus['.$i.']" type="radio" value="Open" checked> Open</td>';  }
			echo '<td><textarea name="snowcond['.$i.']" style="width:80%;" rows="2">'.$snowcond.'</textarea></td>';
			echo '<input type="hidden" name="area['.$i.']" value="'.$area.'">';
			echo '<input type="hidden" name="district['.$i.']" value="'.$district.'">';
			}
	echo '</tr>';  
$i++;
}      

?>
</table>
<br>
<input type="submit" name="submit" value="Update" class="button button-primary button-large">
</form>