<?php

class acf_field_place extends acf_field
{
	// vars
	var $settings, // will hold info such as dir / path
		$defaults; // will hold default field options
		
		
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct()
	{
		// vars
		$this->name = 'place-field';
		$this->label = __('Place Map','acf-place-field');
		$this->category = __('Content','acf');
		$this->defaults = array(
			'mapheight'	=>	'300',
			'center' => '48.856614,2.3522219000000177',
			'zoom'	=>	10,			
			'scrollwheel'	=>	1,
			'mapTypeControl'	=>	1,
			'streetViewControl'	=>	1,
			'PointOfInterest'	=>	1,
		);
		
		
		// do not delete!
    	parent::__construct();
    	
    	
    	// settings
		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);
		

	}
	
	
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add css + javascript to assist your create_field() action.
	*
	*  $info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function input_admin_enqueue_scripts()
	{
		// register acf scripts
		//wp_register_script( 'acf-input-location', $this->settings['dir'] . 'js/input.js', array('acf-input'), $this->settings['version'] );
		wp_register_style( 'acf-input-place', $this->settings['dir'] . 'css/input.css', array('acf-input'), $this->settings['version'] ); 
		
		
		// scripts
		wp_enqueue_script(array(
			//'acf-input-location',	PHP in JS? What the?
		));

		// styles
		wp_enqueue_style(array(
			'acf-input-place',	
		));
		
	}
	
	
	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add css and javascript to assist your create_field() action.
	*
	*  @info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_head
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function input_admin_head()
	{
		echo '<script src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&region=es&language=es" type="text/javascript"></script>';
	}
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field )
	{
		// defaults
		$field = array_merge($this->defaults, $field);
		
		
		// key is needed in the field names to correctly save the data
		$key = $field['name'];
		
		
		// Create Field Options HTML
		?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e('Map height','acf-place-field'); ?></label>
		<p class="description"><?php _e('Height of the map. Minimum height is 150px','acf-place-field'); ?></p>
	</td>
	<td>
		<?php
		if( $field['mapheight'] <= '150' )
		{
			$field['mapheight'] = '150';
		}

		do_action('acf/create_field', array(
			'type'	=>	'number',
			'name'	=>	'fields['.$key.'][mapheight]',
			'value'	=>	$field['mapheight']
		));
		?> px
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e('Map center','acf-place-field'); ?></label>
		<p class="description"><?php _e('Latitude and longitude to center the initial map','acf-place-field'); ?></p>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields['.$key.'][center]',
			'value'	=>	$field['center']
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e('Map zoom','acf-place-field'); ?></label>
		<p class="description"></p>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'	=>	'number',
			'name'	=>	'fields['.$key.'][zoom]',
			'value'	=>	$field['zoom']
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e('Map Scrollwheel','acf-place-field'); ?></label>
		<p class="description"><?php _e('Allows scrollwheel zooming on the map field','acf-place-field'); ?></p>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type' => 'radio',
			'name' => 'fields['.$key.'][scrollwheel]',
			'value' => $field['scrollwheel'],
			'layout' => 'horizontal',
			'choices' => array(
				1 => __('Yes', 'acf-place-field'),
				0 => __('No', 'acf-place-field')
			)
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e('Map Type Control','acf-place-field'); ?></label>
		<p class="description"><?php _e('Show controls for Map Type (Satellite, Hybrid)','acf-place-field'); ?></p>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type' => 'radio',
			'name' => 'fields['.$key.'][mapTypeControl]',
			'value' => $field['mapTypeControl'],
			'layout' => 'horizontal',
			'choices' => array(
				1 => __('Yes', 'acf-place-field'),
				0 => __('No', 'acf-place-field')
			)
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e('Street View Control','acf-place-field'); ?></label>
		<p class="description"><?php _e('Show controls for Street View','acf-place-field'); ?></p>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type' => 'radio',
			'name' => 'fields['.$key.'][streetViewControl]',
			'value' => $field['streetViewControl'],
			'layout' => 'horizontal',
			'choices' => array(
				1 => __('Yes', 'acf-place-field'),
				0 => __('No', 'acf-place-field')
			)
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e('Point Of Interest','acf-place-field'); ?></label>
		<p class="description"><?php _e('Show places on the map','acf-place-field'); ?></p>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type' => 'radio',
			'name' => 'fields['.$key.'][PointOfInterest]',
			'value' => $field['PointOfInterest'],
			'layout' => 'horizontal',
			'choices' => array(
				1 => __('Yes', 'acf-place-field'),
				0 => __('No', 'acf-place-field')
			)
		));
		?>
	</td>
</tr>


		<?php
		
	}
	
	
	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function create_field( $field )
	{
		// defaults
		$field = array_merge($this->defaults, $field);
		
		// Build an unique id based on ACF's one.
		$pattern = array('/\[/', '/\]/');
		$replace = array('_', '');
		$uid = preg_replace($pattern, $replace, $field['name']);
		// Retrieve options value
		$zoom = $field['zoom'];
		$center = explode(',', $field['center']);
		$scrollwheel = $field['scrollwheel'];
		$mapTypeControl = $field['mapTypeControl'];
		$streetViewControl = $field['streetViewControl'];
		$PointOfInterest = $field['PointOfInterest'];
		$mapheight = $field['mapheight'];
		?>
<script type="text/javascript">
	function location_init(uid){
		function addMarker(position,address){
			if(marker){marker.setMap(null)}
			marker = new google.maps.Marker({map:map,position:position,title:address,draggable:true});
			map.setCenter(position);
			dragdropMarker()
		}
		function dragdropMarker(){
			google.maps.event.addListener(marker,'dragend',function(mapEvent){
				coordinates = mapEvent.latLng.lat()+','+mapEvent.latLng.lng();
                                locateByCoordinates(coordinates)})
		}
		
                function locateByPlace(place)
                {
                    // Send over the address to get coordinates
                    places.textSearch({'query': place}, function(results, status)
                    {
                        // If Google has a result
                        if (status == google.maps.places.PlacesServiceStatus.OK)
                        {
                            places.getDetails({reference: results[0].reference}, function(place, status) {
                                if (status == google.maps.places.PlacesServiceStatus.OK) {
                                    var address = place.formatted_address;
                                    // Add the marker
                                    addMarker(place.geometry.location, address);
                                    // Update the coordinates
                                    coordinates = place.geometry.location.lat() + ',' + place.geometry.location.lng();
                                    
                                    // Update the definition list
                                    ddAddress.innerHTML = address;
                                    ddCoordinates.innerHTML = coordinates;
                                    console.log(place);
                                    
                                    if (place.vicinity) {
                                        editedAddressInput.value = place.vicinity;
                                    }else{
                                        editedAddressInput.value = '';
                                    }
                                    
                                    if (place.international_phone_number) {
                                        phoneInput.value = place.international_phone_number;
                                    }else{
                                        phoneInput.value = '';
                                    }                                    
                                    if (place.website) {
                                        webInput.value = place.website;
                                    }else{
                                        webInput.value = '';
                                    }
                                    
                                    coordinatesAddressInput.value = JSON.stringify( {
                                        coordinates: coordinates,
                                        address: address,
                                        editedAddress: editedAddressInput.value,
                                        phone: phoneInput.value,
                                        web: webInput.value
                                    });
                                    console.log(coordinatesAddressInput.value);
                                }
                                else
                                {
                                    alert("<?php _e("This address couldn't be found: ", 'acf-location-field'); ?>" + status);
                                }
                            });
                        }
                        else
                        {
                            alert("<?php _e("This address couldn't be found: ", 'acf-location-field'); ?>" + status);
                        }
                    });
                }
		function locateByCoordinates(coordinates){
			latlngTemp = coordinates.split(',',2);
			lat = parseFloat(latlngTemp[0]);
			lng = parseFloat(latlngTemp[1]);
			latlng = new google.maps.LatLng(lat,lng);
			geocoder.geocode({'latLng':latlng},function(results,status){
				if(status == google.maps.GeocoderStatus.OK){
					address = results[0].formatted_address;
                                        addMarker(latlng,address);
                                        editedAddressInput.value = address;
					coordinatesAddressInput.value = JSON.stringify( {
                                            coordinates: coordinates,
                                            address: address,
                                            editedAddress: address,
                                            phone: phoneInput.value,
                                            web: webInput.value
                                        });
                                        ddAddress.innerHTML=address;
                                        ddCoordinates.innerHTML=coordinates
                                        
                                        
				}
				else{
					alert("<?php _e("This place could not be found: ",'acf-place-field');?>"+status)
				}
			})
		}
                
                function onBlur(){
                                coordinatesAddressInput.value = JSON.stringify( {
                                        coordinates: coordinates,
                                        address: address,
                                        editedAddress: editedAddressInput.value,
                                        phone: phoneInput.value,
                                        web: webInput.value
                                    });
                                    ddAddress.innerHTML=address;
                                    ddCoordinates.innerHTML=coordinates;
                       
		}
                
		var map,lat,lng,latlng,marker,coordinates,address,val;
		var geocoder = new google.maps.Geocoder();
		var ddAddress = document.getElementById('location_dd-address_'+uid);
		var dtAddress = document.getElementById('location_dt-address_'+uid);
		var ddCoordinates = document.getElementById('location_dd-coordinates_'+uid);
		var locationInput = document.getElementById('location_input_'+uid);
		var location = locationInput.value;
		var coordinatesAddressInput = document.getElementById('location_coordinates-address_'+uid);                
                var editedAddressInput = document.getElementById('location_input_address_'+uid);
                var phoneInput = document.getElementById('location_input_phone_'+uid);
                var webInput = document.getElementById('location_input_web_'+uid);
                
                editedAddressInput.onblur = onBlur;
                phoneInput.onblur = onBlur;
                webInput.onblur = onBlur;
                
		var coordinatesAddress = coordinatesAddressInput.value;
		if(coordinatesAddress){
                        coordinatesAddress = jQuery.parseJSON(coordinatesAddress);			
			coordinates = coordinatesAddress.coordinates;
			address = coordinatesAddress.address;
                        editedAddressInput.value = coordinatesAddress.editedAddress;
                        phoneInput.value = coordinatesAddress.phone;
                        webInput.value = coordinatesAddress.web;
		}
                if(address){
			ddAddress.innerHTML = address;
		}
		if(coordinates){
			ddCoordinates.innerHTML = coordinates;
			var latlngTemp = coordinates.split(',',2);
			lat = parseFloat(latlngTemp[0]);
			lng = parseFloat(latlngTemp[1])
		}else{
			lat = <?php echo $center[0];?>;
			lng = <?php echo $center[1];?>
		}
		latlng = new google.maps.LatLng(lat,lng);
		
		// Enable the visual refresh
		google.maps.visualRefresh = true;

		var mapOptions = {
			zoom:<?php echo $zoom;?>,
			mapTypeControl: <?php echo $mapTypeControl; ?>,
			streetViewControl: <?php echo $streetViewControl; ?>,
			center:latlng,
			mapTypeId:google.maps.MapTypeId.ROADMAP,scrollwheel: <?php echo $scrollwheel; ?>,
			styles:[{
				featureType:"poi",
				elementType:"labels",
				stylers:[{
					visibility:"<?php if ($PointOfInterest == true) echo 'on'; else echo 'off' ?>"
					}]
				}]
		};
		map = new google.maps.Map(document.getElementById('location_map_'+uid),mapOptions);
                var places = new google.maps.places.PlacesService(map);
		var mapdiv = document.getElementById('location_map_'+uid);
		mapdiv.style.height = '<?php echo $mapheight; ?>px';
		if(coordinates){
			addMarker(map.getCenter())
		}
		google.maps.event.addListener(map,'click',function(point){
			locateByCoordinates(point.latLng.lat()+','+point.latLng.lng())
		});
		locationInput.addEventListener('keypress',function(event){
			if(event.keyCode == 13){
				location=locationInput.value;
				var regexp = new RegExp('^\-?[0-9]{1,3}\.[0-9]{6,},\-?[0-9]{1,3}\.[0-9]{6,}$');
				if(location){
					if(regexp.test(location)){
						locateByCoordinates(location)
					}
					else{
						locateByPlace(location)}
					}
					event.stopPropagation();
					event.preventDefault();
					return false
				}
			},false);
		dtAddress.addEventListener('click',function(){
			if(coordinates){
				locateByCoordinates(coordinates)
			}
		},false)
	};

	jQuery(document).ready(function(){
		location_init("<?php echo $uid;?>");
	});
	var mapids = Array();
	jQuery(document).on('acf/setup_fields',function(e){
		var new_uid = jQuery(".repeater .row input[id*=location_coordinates]").not(".exsist").last().attr("id");

		if(new_uid) {
			new_uid = new_uid.replace("location_coordinates-address_","");
			location_init(new_uid);
			jQuery(".repeater .row input[id*=location_coordinates]").addClass("exsist");
		}
	});
</script>
<input type="hidden" value="<?php echo esc_attr($field['value']); ?>" id="location_coordinates-address_<?php echo $uid; ?>" name="<?php echo $field['name']; ?>"/>
<input type="text" id="location_input_<?php echo $uid; ?>" placeholder="<?php _e('Search for a location','acf-place-field'); ?>" />
<dl class="location_dl">
	<dt class="location_dt-address" id="location_dt-address_<?php echo $uid; ?>" role="button" title="<?php _e('Find the complete address','acf-place-field'); ?>"><?php _e('Address: ','acf-place-field'); ?></dt>
	<dd class="location_dd" id="location_dd-address_<?php echo $uid; ?>">&nbsp;</dd>
	<dt class="location_dt-coordinates"><?php _e('Coordinates: ','acf-place-field'); ?></dt>
	<dd class="location_dd" id="location_dd-coordinates_<?php echo $uid; ?>">&nbsp;</dd>
</dl>
<div class="location_map-container">
	<div class="location_map" id="location_map_<?php echo $uid; ?>"></div>
</div>
<p class="label"><label for="location_input_address_<?php echo $uid; ?>"><?php _e('Edited address','acf-place-field'); ?></label></p>
<input type="text" id="location_input_address_<?php echo $uid; ?>" placeholder="C/..."/>
<p class="label"><label for="location_input_phone_<?php echo $uid; ?>"><?php _e('Phone','acf-place-field'); ?></label></p>
<input type="text" id="location_input_phone_<?php echo $uid; ?>" placeholder="+34 555..."/>
<p class="label"><label for="location_input_web_<?php echo $uid; ?>"><?php _e('Web','acf-place-field'); ?></label></p>
<input type="text" id="location_input_web_<?php echo $uid; ?>" placeholder="http://..." />
		<?php
	}

	/*
	*  format_value_for_api()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed back to the api functions such as the_field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/
	
	function format_value_for_api( $value, $post_id, $field )
	{
		// defaults
		$field = array_merge($this->defaults, $field);        
		// format value
		$value = json_decode($value,true);		                                
                return $value;
        }
}

// create field
new acf_field_place();