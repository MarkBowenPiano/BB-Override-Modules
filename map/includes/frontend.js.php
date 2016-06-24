(function($){

  $(function() {

    var map_center = new google.maps.LatLng(<?php echo $settings->address_location; ?>),

    map = new google.maps.Map($('.fl-node-<?php echo $id; ?> .locations-map')[0], {
      zoom: <?php echo ($settings->zoom) ? $settings->zoom : '10'; ?>,
      scrollwheel: false,
      center: map_center
      <?php if($settings->map_style) : ?>
      ,styles: <?php echo trim(stripslashes(json_encode($settings->map_style)), '"'); ?>
      <?php endif; ?>
    }),

    <?php if($settings->marker == 'icon') : ?>
    marker = new MarkerWithLabel({
      position: map_center,
      icon: ' ',
      map: map,
      labelContent: '<i class="<?php echo $settings->marker_icon; ?>"></i>',
      labelAnchor: new google.maps.Point(<?php echo $settings->marker_offset_x; ?>, <?php echo $settings->marker_offset_y; ?>),
      labelClass: 'marker_icon'
    });
    google.maps.event.addListener(marker, "click", function (e) {
      window.open('https://maps.google.com/?daddr=<?php echo urlencode($settings->address); ?>','_newtab');
    });
    <?php else : ?>
    marker = new google.maps.Marker({
      position: map_center,
      map: map,
      url: 'https://maps.google.com/?daddr=<?php echo urlencode($settings->address); ?>',
      <?php if($settings->marker == 'photo' && $settings->marker_photo) : ?>
      ,icon: {
        url: '<?php echo $settings->marker_photo_src; ?>',
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(<?php echo $settings->marker_offset_x; ?>, <?php echo $settings->marker_offset_y; ?>),
      }
      <?php endif; ?>
    });
    <?php endif; ?>

  });

})(jQuery);
