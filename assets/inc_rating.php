<?php
	// this sets the color of the rating for all 3 levels
	if ($rating == "Extreme" )
	{
		$ratinglevel = "5";
		$traveladvice = " Avoid all avalanche terrain. ";
	}
	elseif ($rating == "High" )
	{
		$ratinglevel = "4";
		$traveladvice = " Very dangerous avalanche conditions. Travel in avalanche terrain not recommended.";
	}
	elseif ($rating == "Considerable" )
	{
		$ratinglevel = "3";
		$traveladvice = "  Dangerous avalanche conditions. Careful snowpack evaluation, cautious route-finding and conservative decision-making essential.";
	}
	elseif ($rating == "Moderate" )
	{
		$ratinglevel = "2";
		$traveladvice = "  Heightened avalanche conditions on specific terrain features. Evaluate snow and terrain carefully; identify features of concern.";
	}
	elseif ($rating == "Low" )
	{
		$ratinglevel = "1";
		$traveladvice = "  Generally safe avalanche conditions. Watch for unstable snow on isolated terrain features.";
	}
	elseif ($rating == "No Rating" )
	{
		$ratinglevel = "0";
		$traveladvice = "";
	}
?>