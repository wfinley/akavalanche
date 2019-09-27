<style>
	.riding_open { font-weight: bold; background: green; padding: 5px; border-radius: 5px; text-align: center; color: #fff; }
	.riding_closed { font-weight: bold; background: red; padding: 5px; border-radius: 5px; text-align: center; color: #fff; }
	.riding_district { text-transform: uppercase; font-size: 1.2em; background-color: #ccc; padding 3px 0;}
	.table-striped .thead-dark th {
	    color: #fff;
	    background-color: #212529;
	    border-color: #32383e;
	}
</style>
<?php 
$sql= "Select updatetime FROM ".$wpdb->prefix."area_update order by updatetime desc limit 1";
$rs_result = $wpdb->get_results($sql);
foreach( $rs_result as $results ) {
	$updated = $results->updatetime;
	$updated = date('l, F dS, Y', strtotime($updated));
}
echo"<p><strong>Updated: $updated</strong></p>";
?>
<table class="table-striped " cellpadding="5" width="100%">
<thead class="thead-dark">
<tr>
<th>Area</th>
<th>Status</th>
<th>Weather &amp; Riding Conditions</th>
</tr>
</thead>
<tr ><td  colspan='3' class="riding_district"><strong>Glacier District</strong3></td></tr>
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
	echo '<td width="25%"><strong>'.$area.'</strong></td>';
		$sql= "Select district, openstatus, snowcond from ".$wpdb->prefix."area_update where area = '".$area."' order by updatetime DESC limit 1";
		$rs_result = $wpdb->get_results($sql);
	    foreach( $rs_result as $results ) 
	    	{
			$district = $results->district;
			$openstatus = $results->openstatus;
			$snowcond = $results->snowcond;
			if ($openstatus == 'Open') { echo '<td><div class="riding_open">'.$openstatus.'</div></td>'; }
			else { echo '<td><div class="riding_closed">'.$openstatus.'</div></td>';   }
			
			echo '<td>'.$snowcond.'</td>';
			}
	echo '</tr>';  
$i++;
}  
?>
<tr ><td  colspan='3' class="riding_district"><strong>Seward District</strong></td></tr>

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
			if ($openstatus == 'Open') { echo '<td><div class="riding_open">'.$openstatus.'</div></td>'; }
			else { echo '<td><div class="riding_closed">'.$openstatus.'</div></td>';   } 
			echo '<td>'.$snowcond.'</td>';
			}
	echo '</tr>';  
$i++;
}      

?>
</table>
