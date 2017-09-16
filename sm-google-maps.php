<?php 
/*
Plugin Name: SM Google Maps
Plugin URI: https://github.com/engrmahabub/wordpress-youtube-video-iframe
Author: Mahabubur Rahman
Author URI: http://mahabub.me
Description: Google Maps plugin for wordpress
Version: 1.0.0
*/

class SMGoogleMaps_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'SMGoogleMaps_Widget',
			'description' => 'SM Google Maps',
		);
		parent::__construct( 'SMGoogleMaps_Widget', 'SM Google Maps', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );
     
	    $title      	= apply_filters( 'widget_title', $instance['title'] );
        $apiKey    	    = ($instance['apiKey '])?$instance['apiKey ']:'AIzaSyCmuta_GJgN8ccgPFfK0ar284fIBUA1JU8';
	    $lat    		= ($instance['lat'])?$instance['lat']: -34.397;
	    $lng    		= ($instance['lng'])?$instance['lng']: 150.644;
        $marker    		= ($instance['marker'])?$instance['marker']: 0;
        $mapTypeId   	= ($instance['mapTypeId'])?$instance['mapTypeId']: 'roadmap';
	    echo $before_widget;
	    if ( $title ) {
	        echo $before_title . $title . $after_title;
	    }	                         
	    // echo $theme;	    
		?>
        <style>
            #map {
                height: 400px;
                width: 100%;
            }
        </style>
        <div id="map"></div>
        <!-- Replace the value of the key parameter with your own API key. -->
        <script src="https://maps.googleapis.com/maps/api/js?key=<?=$apiKey;?>&callback=initMap" async defer></script>
        <script>
            var map;
            function initMap() {
                var uluru = {lat: <?=$lat;?>, lng: <?=$lng;?>};
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 8,
                    center: uluru,
                    mapTypeId: '<?=$mapTypeId;?>',
                });
                <?php if($marker):?>
                var marker = new google.maps.Marker({
                    position: uluru,
                    map: map
                });
                <?php endif;?>
            }
        </script>
		<?php
		echo $after_widget;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		$title      	= esc_attr( $instance['title'] );
        $apiKey    	    = esc_attr( $instance['apiKey'] );
    	$lat    	    = esc_attr( $instance['lat'] );
    	$lng    	    = esc_attr( $instance['lng'] );
        $marker    	    = esc_attr( $instance['marker'] );

        $mapTypeId      = $instance['mapTypeId'] ? esc_attr($instance['mapTypeId']): 'roadmap';;
        echo $marker;
    	?>
    	<p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id('apiKey'); ?>"><?php _e('API Key'); ?></label>
	        <input class="widefat" id="<?php echo $this->get_field_id('apiKey'); ?>" name="<?php echo $this->get_field_name('apiKey'); ?>" type="text" value="<?php echo $apiKey; ?>"/>
	    </p>
        <p>
	        <label for="<?php echo $this->get_field_id('lat'); ?>"><?php _e('Latitude'); ?></label>
	        <input class="widefat" id="<?php echo $this->get_field_id('lat'); ?>" name="<?php echo $this->get_field_name('lat'); ?>" type="text" value="<?php echo $lat; ?>"/>
	    </p>
        <p>
	        <label for="<?php echo $this->get_field_id('lng'); ?>"><?php _e('Longitude'); ?></label>
	        <input class="widefat" id="<?php echo $this->get_field_id('lng'); ?>" name="<?php echo $this->get_field_name('lng'); ?>" type="text" value="<?php echo $lng; ?>"/>
	    </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance[ 'marker' ], '1' ); ?> id="<?php echo $this->get_field_id( 'marker' ); ?>" name="<?php echo $this->get_field_name( 'marker' ); ?>" value="1" />
            <label for="<?php echo $this->get_field_id( 'marker' ); ?>">Marker Show</label>
        </p>


        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>">
                <?php _e('Choose posts list type:', 'fabulous'); ?>
            </label>
            <select name="<?php echo $this->get_field_name('mapTypeId'); ?>" id="<?php echo $this->get_field_id('mapTypeId'); ?>" class="widefat">
                <?php
                $mapTypeIds = array (
                    'hybrid'=>'HYBRID',
                    'roadmap'=>'ROADMAP',
                    'satellite'=>'SATELLITE',
                    'terrain'=>'TERRAIN'
                );
                foreach ($mapTypeIds as $key => $option) {
                    echo '<option value="' . $key . '" id="' . $key . '"', $mapTypeId == $key ? ' selected="selected"' : '', '>', $option, '</option>';
                }?>
            </select>
        </p>


	    <?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;
     
	    $instance['title'] 		= strip_tags( $new_instance['title'] );
	    $instance['videoId']    = strip_tags( $new_instance['videoId']);
	    $instance['height'] 	= strip_tags( $new_instance['height'] );
	    $instance['width'] 		= strip_tags( $new_instance['width'] );
	    $instance['marker'] 	= strip_tags( $new_instance['marker'] );
	    $instance['mapTypeId'] 	= strip_tags( $new_instance['mapTypeId'] );

	     
	    return $instance;
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'SMGoogleMaps_Widget' );
});