<?php
// this includes the avalanche problem icons and descriptions
if ( $akavalanche_problemicon == "NOICON.gif" ) { $akavalanche_problemicon = ""; }
if ($akavalanche_problemicon != "" ) {
	if ($akavalanche_problemicon == "Cornice.png"  ) {
		 $descriptor = "Cornice";
		 $descriptorpopup = "Cornice Fall is the release of an overhanging mass of snow that forms as the wind moves snow over a sharp terrain feature, such as a ridge, and deposits snow on the downwind (leeward) side. Cornices range in size from small wind drifts of soft snow to large overhangs of hard snow that are 30 feet (10 meters) or taller. They can break off the terrain suddenly and pull back onto the ridge top and catch people by surprise even on the flat ground above the slope. Even small cornices can have enough mass to be destructive and deadly. Cornice Fall can entrain loose surface snow or trigger slab avalanches.";
	 }
	elseif ($akavalanche_problemicon == "DeepPersistentSlabs.png" ) {
		 $descriptor = "Deep Persistent Slabs";
		 $descriptorpopup = "Deep Persistent Slab avalanches are the release of a thick cohesive layer of hard snow (a slab), when the bond breaks between the slab and an underlying persistent weak layer deep in the snowpack. The most common persistent weak layers involved in deep, persistent slabs are depth hoar or facets surrounding a deeply buried crust. Deep Persistent Slabs are typically hard to trigger, are very destructive and dangerous due to the large mass of snow involved, and can persist for months once developed. They are often triggered from areas where the snow is shallow and weak, and are particularly difficult to forecast for and manage.";
	 }
	elseif ($akavalanche_problemicon == "Glide.png" ) {
		 $descriptor = "Glide Avalanches";
		 $descriptorpopup = "Glide Avalanches  are the release of the entire snow cover as a result of gliding over the ground. Glide avalanches can be composed of wet, moist, or almost entirely dry snow. They typically occur in very specific paths, where the slope is steep enough and the ground surface is relatively smooth. The are often proceeded by full depth cracks (glide cracks), though the time between the appearance of a crack and an avalanche can vary between seconds and months. Glide avalanches are unlikely to be triggered by a person, are nearly impossible to forecast, and thus pose a hazard that is extremely difficult to manage.";
	 } 
	elseif ($akavalanche_problemicon == "LooseDry.png" ) {
		 $descriptor = "Dry Loose";
		 $descriptorpopup = "Dry Loose   avalanches are the release of dry unconsolidated snow and typically occur within layers of soft snow near the surface of the snowpack. These avalanches start at a point and entrain snow as they move downhill, forming a fan-shaped avalanche. Other names for loose-dry avalanches include point-release avalanches or sluffs.";
	 } 
	elseif ($akavalanche_problemicon == "LooseWet.png" ) {
		 $descriptor = "Wet Loose";
		 $descriptorpopup = "Wet Loose  avalanches are the release of wet unconsolidated snow or slush. These avalanches typically occur within layers of wet snow near the surface of the snowpack, but they may quickly gouge into lower snowpack layers. Like Loose Dry Avalanches, they start at a point and entrain snow as they move downhill, forming a fan-shaped avalanche. Other names for loose-wet avalanches include point-release avalanches or sluffs. Loose Wet avalanches can trigger slab avalanches that break into deeper snow layers.";
	 }  
	elseif ($akavalanche_problemicon == "PersistentSlabs.png" ) {
		 $descriptor = "Persistent Slabs";
		 $descriptorpopup = "Persistent Slab  avalanches are the release of a cohesive layer of snow (a slab) in the middle to upper snowpack, when the bond to an underlying persistent weak layer breaks. Persistent layers include: surface hoar, depth hoar, near-surface facets, or faceted snow. Persistent weak layers can continue to produce avalanches for days, weeks or even months, making them especially dangerous and tricky. As additional snow and wind events build a thicker slab on top of the persistent weak layer, this avalanche problem may develop into a Deep Persistent Slab. ";
	 } 
	elseif ($akavalanche_problemicon == "StormSlabs.png" ) {
		 $descriptor = "Storm Slabs";
		 $descriptorpopup = "Storm Slab  avalanches are the release of a cohesive layer (a slab) of new snow that breaks within new snow or on the old snow surface. Storm-slabs typically last between a few hours and few days (following snowfall). Storm-slabs that form over a persistent weak layer (surface hoar, depth hoar, or near-surface facets) may be termed Persistent Slabs or may develop into Persistent Slabs. ";
	 } 
	elseif ($akavalanche_problemicon == "WetSlabs.png" ) {
		 $descriptor = "Wet Slab";
		 $descriptorpopup = "Wet Slab  avalanches are the release of a cohesive layer of snow (a slab) that is generally moist or wet when the flow of liquid water weakens the bond between the slab and the surface below (snow or ground). They often occur during prolonged warming events and/or rain-on-snow events. Wet Slabs can be very unpredictable and destructive. ";
	 } 
	elseif ($akavalanche_problemicon == "WindSlabs.png" ) {
		 $descriptor = "Wind Slabs";
		 $descriptorpopup = "Wind Slab  avalanches are the release of a cohesive layer of snow (a slab) formed by the wind. Wind typically transports snow from the upwind sides of terrain features and deposits snow on the downwind side. Wind slabs are often smooth and rounded and sometimes sound hollow, and can range from soft to hard. Wind slabs that form over a persistent weak layer (surface hoar, depth hoar, or near-surface facets) may be termed Persistent Slabs or may develop into Persistent Slabs. ";
		}
	elseif ($akavalanche_problemicon == "Springtime-high-low.png" ) {
		 $descriptor = "Spring Conditions";
		 $descriptorpopup = "Warmth has a tricky effect on snow. On the one hand it speeds up the stabilization of the snowpack (reduces the chance of slab avalanches). But a SUDDEN rise of temperature increases the chance of slab avalanches considerably. When this warm period is followed by cooling down, then the chance of slab avalanches reduces. Even more so: the more often the temperature changes, the more stable the snowpack becomes when looking at slab avalanches. Once the temperature becomes too warm we have to deal with wet snow avalanches.";
	 }  
	 elseif ($akavalanche_problemicon == "icon-low.gif" ) {
		 $descriptor = "Normal Caution";
		 $descriptorpopup = "Normal Caution means triggering an avalanche is unlikely but not impossible. ";
	 } 
	 else {
		$descriptor = "Announcement";
		$descriptorpopup = ""; 
	 }	
 }
	
?>