<?php

/**
 * Widget shows daily unreached people group.
 *
 *
 * @package    JP_WP
 * @subpackage JP_WP/widget
 * @author     JP Workshop
 */
class JP_WP_Widget extends WP_Widget
{

	/**
	 * Constructor for the widget
	 *
	 * @since    1.1.0
	 */
	public function __construct()
	{
		parent::__construct(
			'jp-wp-daily-unreached-widget', // Base ID
			'Daily Unreached Widget', // Name
			array(
				'description' => __('Widget shows daily unreached people group', 'jp-wp-daily-unreached-widget')
			) // Args
		);
	}

	/**
	 * Admin form in the widget area
	 *
	 * @since    1.0.0
	 */
	public function form($instance)
	{
		$api_key = (isset($instance['api_key'])) ? strip_tags($instance['api_key']) : '';
?>
		<p>
			<label for="<?php echo $this->get_field_id('api_key'); ?>"><?php _e('API Key:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('api_key'); ?>" name="<?php echo $this->get_field_name('api_key'); ?>" type="text" value="<?php echo esc_attr($api_key); ?>" />
			<label for="<?php echo $this->get_field_id('caption'); ?>"><?php _e('Caption:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('caption'); ?>" name="<?php echo $this->get_field_name('caption'); ?>" type="text" value="<?php echo esc_attr($caption); ?>" />
		</p>

	<?php
	}

	/**
	 * Update function for the widget
	 *
	 * @since    1.0.0
	 */
	public function update($new_instance, $old_instance)
	{
		// processes widget options to be saved
		$instance          = $old_instance;
		$instance['api_key'] = strip_tags($new_instance['api_key']);
		$instance['caption'] = strip_tags($new_instance['caption']);
		return $instance;
	}

	/**
	 * Outputs the widget with the selected settings
	 *
	 * @since    1.0.0
	 */
	public function widget($args, $instance)
	{
		extract($args);
		$api_key = apply_filters('widget_api_key', empty($instance['api_key']) ? '' : $instance['api_key'], $instance, $this->id_base);
		$caption = apply_filters('widget_caption', empty($instance['caption']) ? '' : $instance['caption'], $instance, $this->id_base);

		/*
		* The content of the widget
		*/
		echo $before_widget;

		if (!empty($api_key)) {
			$month = date("m");
			$day = date("d");
			$curl = curl_init();
			$url = "http://api.joshuaproject.net/v1/people_groups/daily_unreached.json?api_key=$api_key&day=$day&month=$month";
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				//Only show errors while testing
				echo "Service is unavailable now: " . $err;
			} else {
				//The API returns data in JSON format, so first convert that to an array of data objects
				$responseObj = json_decode($response);
				//Gather the air quality value and timestamp for the first and last elements
				$peopleGroup = $responseObj[0]->PeopNameInCountry;
				$region = $responseObj[0]->RegionName;
				$image = $responseObj[0]->PeopleGroupPhotoURL;
				$link = $responseObj[0]->PeopleGroupURL;

				//This is the content that gets populated into the widget on your site
				echo "<div class='jp-wrap'>" .
					"<div class='caption'>$caption</div>" .
					"<div class='entry'><span class='title'>People Group: </span><span class='val'>$peopleGroup</span></div>" .
					"<div class='entry'><span class='title'>Region: </span><span class='val'>$region</span></div>" .
					"<div class='entry'><a href='$link' targe='_blank'><img alt='PG Photo' src='$image' /></a></div>" .
					"<div class='entry'>From <a href='$link' targe='_blank'>Joshua Project</a></div>" . 
					"</div>";
			}
		} else {
			echo "Please provide API key in configuration";
		}
	?>
<?php

		echo $after_widget;
	}
}
?>