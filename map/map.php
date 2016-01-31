<?php

class FLMapModule extends FLBuilderModule {

	public function __construct()
	{
		parent::__construct(array(
			'name'          => __('Map', 'zestsms'),
			'description'   => __('Display a Google map with custom styling.', 'zestsms'),
			'category'      => __('Advanced Modules', 'zestsms')
		));

		$this->add_js('googlemaps-api', '//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places', array(), NULL, true);
		add_filter('fl_builder_render_settings_field', array($this, 'zestsms_extended_map_filters'), 10, 3);
	}

	public function enqueue_scripts() {
		if($this->settings->marker == 'icon' || FLBuilderModel::is_builder_active()) {
			$this->add_js('geocomplete', '//cdnjs.cloudflare.com/ajax/libs/geocomplete/1.6.5/jquery.geocomplete.min.js', array('jquery'), '1.6.5', true);
			$this->add_js('marker-with-label', '//google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel.js', array('googlemaps-api'), NULL, true);
		}
	}

	public function zestsms_extended_map_filters( $field, $name, $settings ) {
		if($name == 'map_style' && $settings->map_style) {
			$settings->map_style = trim(stripslashes(json_encode($settings->map_style)), '"');
		}

		return $field;
	}
}

if(!function_exists('zestsms_location')) :
function zestsms_location( $name, $value, $field, $settings ) { ?>
	<input type="hidden" data-geo="location" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
<?php }
add_action( 'fl_builder_control_zestsms-location', 'zestsms_location', 1, 4 );
endif;

FLBuilder::register_module('FLMapModule', array(
	'general'       => array(
		'title'         => __('General', 'zestsms'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'address_location'	=> array(
						'type'					=> 'zestsms-location',
					),
					'address'       => array(
						'type'          => 'text',
						'label'         => __('Address', 'zestsms')
					),
					'height'        => array(
						'type'          => 'text',
						'label'         => __('Height', 'zestsms'),
						'default'       => '400',
						'size'          => '5',
						'description'   => 'px'
					),
					'zoom'        => array(
						'type'          => 'text',
						'label'         => __('Zoom Level', 'zestsms'),
						'default'       => '10',
						'size'          => '2'
					)
				)
			),
			'marker'		=> array(
				'title'			=> __('Marker', 'zestsms'),
				'fields'		=> array(
					'marker'		=> array(
						'type'			=> 'select',
						'label'			=> __('Marker', 'zestsms'),
						'default'		=> 'default',
						'options'		=> array(
							'default'		=> __('Default', 'zestsms'),
							'photo'		=> __('Photo', 'zestsms'),
							'icon'		=> __('Icon', 'zestsms')
						),
						'toggle'		=> array(
							'default'		=> array(),
							'photo'		=> array(
								'fields'		=> array('marker_photo', 'marker_offset_x', 'marker_offset_y')
							),
							'icon'		=> array(
								'fields'		=> array('marker_icon', 'marker_icon_color', 'marker_icon_size', 'marker_icon_opacity', 'marker_offset_x', 'marker_offset_y')
							)
						)
					),
					'marker_photo'			=> array(
						'type'			=> 'photo',
						'label'			=> __('Marker Photo', 'zestsms')
					),
					'marker_icon'				=> array(
						'type'			=> 'icon',
						'label'			=> __('Marker Icon', 'zestsms')
					),
					'marker_icon_color' 	=> array(
						'type'			=> 'color',
						'label'			=> __('Color', 'zestsms'),
						'default'		=> '000000'
					),
					'marker_icon_size'		=> array(
						'type'			=> 'text',
						'label'			=> __('Size', 'zestsms'),
						'default'       => '24',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px'
					),
					'marker_icon_opacity'		=> array(
						'type'			=> 'text',
						'label'			=> __('Opacity', 'zestsms'),
						'default'       => '100',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => '%'
					),
					'marker_offset_x'			=> array(
						'type'			=> 'text',
						'label'			=> __('Offset X', 'zestsms'),
						'default'       => '0',
						'maxlength'     => '3',
						'size'          => '4'
					),
					'marker_offset_y'			=> array(
						'type'			=> 'text',
						'label'			=> __('Offset Y', 'zestsms'),
						'default'       => '0',
						'maxlength'     => '3',
						'size'          => '4'
					)
				)
			)
		)
	),
	'map_style'			=> array(
		'title'			=> __('Style', 'zestsms'),
		'description'	=> 'Paste a style from <a href="http://snazzymaps.com" target="_blank">Snazzymaps</a> or <a href="http://www.mapstylr.com/" target="_blank">MapStylr</a>.',
		'sections'	=> array(
			'map_style'			=> array(
				'title'			=> __('Style Code', 'zestsms'),
				'fields'		=> array(
					'map_style'				=> array(
						'type'					=> 'textarea',
						'rows'					=> '15',
					)
				)
			)
		)
	)
));
