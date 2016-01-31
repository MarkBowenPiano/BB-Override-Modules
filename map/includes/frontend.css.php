.fl-node-<?php echo $id; ?> .locations-map {
	height: <?php echo $settings->height; ?>px;
}

.fl-node-<?php echo $id; ?> .marker_icon i {
	color: rgba(<?php echo implode(',', FLBuilderColor::hex_to_rgb($settings->marker_icon_color)) ?>, <?php echo $settings->marker_icon_opacity/100; ?>);
	font-size: <?php echo $settings->marker_icon_size; ?>px;
}
