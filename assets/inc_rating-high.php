<?php
	
	// Logic to figure out the highest danger rating if it hasn't actually been set
	$ratinghigh = get_field('akavalanche_rating_high'); 
	$ratingmiddle = get_field('akavalanche_rating_middle'); 
	$ratinglow = get_field('akavalanche_rating_low'); 
	
	if ($ratinghigh == "Extreme" || $ratingmiddle == "Extreme" || $ratinglow == "Extreme" )
	{ 
		$akavalanche_rating_map = "Extreme  Avalanche Danger";
		$ratinglevel = "5";
		$traveladvice = "  <u>Avoid all avalanche terrain.</u> ";
	}
	elseif ($ratinghigh == "High" || $ratingmiddle == "High" || $ratinglow == "High" )
	{ 
		$akavalanche_rating_map = "High  Avalanche Danger"; 
		$ratinglevel = "4";
		$traveladvice = "  Very dangerous avalanche conditions. Travel in avalanche terrain <u>not</u>  recommended.";
	}
	elseif ($ratinghigh == "Considerable" || $ratingmiddle == "Considerable" || $ratinglow == "Considerable" )
	{ 
		$akavalanche_rating_map = "Considerable  Avalanche Danger"; 
		$ratinglevel = "3";
		$traveladvice = "  Dangerous avalanche conditions. Careful snowpack evaluation, cautious route-finding and conservative decision-making essential.";
	}
	elseif ($ratinghigh == "Moderate" || $ratingmiddle == "Moderate" || $ratinglow == "Moderate" )
	{ 
		$akavalanche_rating_map = "Moderate  Avalanche Danger"; 
		$ratinglevel = "2";
		$traveladvice = "  Heightened avalanche conditions on specific terrain features. Evaluate snow and terrain carefully; identify features of concern.";
	}
	elseif ($ratinghigh == "Low" || $ratingmiddle == "Low" || $ratinglow == "Low" )
	{ 
		$akavalanche_rating_map = "Low  Avalanche Danger"; 
		$ratinglevel = "1";
		$traveladvice = "Generally safe avalanche conditions. Watch for unstable snow on isolated terrain features.";
	}
	elseif ($ratinghigh == "No Rating" || $ratingmiddle == "No Rating" || $ratinglow == "No Rating" )
	{ 
		$akavalanche_rating_map = "No Rating"; 
		$ratinglevel = "0";
		$traveladvice = "A current avalanche advisory has not been issued.";
	}
		
	/*	
	// this  sets the color of the highest rating.  Used on archives page and at top of advisory
	if ($akavalanche_rating_map == "Extreme  Avalanche Danger" )
	{
		$ratinglevel = "5";
		$traveladvice = "<u>Avoid all avalanche terrain.</u> ";
	}
	elseif ($akavalanche_rating_map == "High  Avalanche Danger" )
	{
		$ratinglevel = "4";
		$traveladvice = "Very dangerous avalanche conditions. Travel in avalanche terrain <u>not</u> recommended.";
	}
	elseif ($akavalanche_rating_map == "Considerable  Avalanche Danger" )
	{
		$ratinglevel = "3";
		$traveladvice = "Dangerous avalanche conditions. Careful snowpack evaluation, cautious route-finding and conservative decision-making essential.";
	}
	elseif ($akavalanche_rating_map == "Moderate  Avalanche Danger" )
	{
		$ratinglevel = "2";
		$traveladvice = "Heightened avalanche conditions on specific terrain features. Evaluate snow and terrain carefully; identify features of concern.";
	}
	elseif ($akavalanche_rating_map == "Low  Avalanche Danger" )
	{
		$ratinglevel = "1";
		$traveladvice = "Generally safe avalanche conditions. Watch for unstable snow on isolated terrain features.";
	}
	elseif  ($akavalanche_rating_map == "No Rating" )
	{
		// Logic to figure out the highest danger rating if it hasn't actually been set
		$ratinghigh = get_field('akavalanche_rating_high'); 
		$ratingmiddle = get_field('akavalanche_rating_middle'); 
		$ratinglow = get_field('akavalanche_rating_low'); 
		
		if ($ratinghigh == "Extreme" || $ratingmiddle == "Extreme" || $ratinglow == "Extreme" )
		{ 
			$akavalanche_rating_map = "Extreme  Avalanche Danger";
			$ratinglevel = "5";
			$traveladvice = "  <u>Avoid all avalanche terrain.</u> ";
		}
		elseif ($ratinghigh == "High" || $ratingmiddle == "High" || $ratinglow == "High" )
		{ 
			$akavalanche_rating_map = "High  Avalanche Danger"; 
			$ratinglevel = "4";
			$traveladvice = "  Very dangerous avalanche conditions. Travel in avalanche terrain <u>not</u>  recommended.";
		}
		elseif ($ratinghigh == "Considerable" || $ratingmiddle == "Considerable" || $ratinglow == "Considerable" )
		{ 
			$akavalanche_rating_map = "Considerable  Avalanche Danger"; 
			$ratinglevel = "3";
			$traveladvice = "  Dangerous avalanche conditions. Careful snowpack evaluation, cautious route-finding and conservative decision-making essential.";
		}
		elseif ($ratinghigh == "Moderate" || $ratingmiddle == "Moderate" || $ratinglow == "Moderate" )
		{ 
			$akavalanche_rating_map = "Moderate  Avalanche Danger"; 
			$ratinglevel = "2";
			$traveladvice = "  Heightened avalanche conditions on specific terrain features. Evaluate snow and terrain carefully; identify features of concern.";
		}
		elseif ($ratinghigh == "Low" || $ratingmiddle == "Low" || $ratinglow == "Low" )
		{ 
			$akavalanche_rating_map = "Low  Avalanche Danger"; 
			$ratinglevel = "1";
			$traveladvice = "Generally safe avalanche conditions. Watch for unstable snow on isolated terrain features.";
		}
		elseif ($ratinghigh == "No Rating" || $ratingmiddle == "No Rating" || $ratinglow == "No Rating" )
		{ 
			$akavalanche_rating_map = "No Rating"; 
			$ratinglevel = "0";
			$traveladvice = "A current avalanche advisory has not been issued.";
		}
	}*/
?>