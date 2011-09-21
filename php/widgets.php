<?php

/**
 * Twitter widget displaying ONA tweets depending on context
 */
class ONA11_Twitter_Widget extends WP_Widget
{
	
	function ONA11_Twitter_Widget() {
		
		parent::WP_Widget( $id = 'ona11_twitter_widget', $name = 'ONA11 Twitter Widget', $options = array( 'description' => 'Show ONA11 tweets based on page' ) );
		
	}
	
	function widget( $args, $instance ) {
		extract( $args );		
		$title = 'Twitter: #ONA11';
		echo $before_widget;
		?>
		<?php if ( is_home() ): ?>
		<script type="text/javascript">
			var ona11_twitter_url = 'http://twitter.com/search.json?q=ONAConf&rpp=3&callback=?';
			var ona11_twitter_more_text = '<a href="http://twitter.com/onaconf">More tweets from @ONAConf &#0187;</a>';
		</script>
		<?php $title = 'Twitter: @ONAConf'; ?>
		<?php else: ?>
		<script type="text/javascript">
			var ona11_twitter_url = "http://twitter.com/search.json?q=ona11&rpp=5&callback=?";
			var ona_twitter_more_text = '<a href="https://twitter.com/search/ona11">More #ONA11 tweets &#0187;</a>';
		</script>	
		<?php endif; ?>
			<h4 class="orange-callout"><?php echo $title; ?></h4>
			<div class="inner">
			<div id="ttweets" class="tstream"></div> 
			<p id="tmore" class="more"></p>
		<script type="text/javascript">		
			jQuery(document).ready(function(){
				ona11_load_tweets( ona11_twitter_url, ona11_twitter_more_text );
			});
		</script>
			</div>
	<?php
		echo $after_widget;
	}
	
}

class ONA11_Location_Widget extends WP_Widget
{
	
	function ONA11_Location_Widget() {
		parent::WP_Widget( $id = 'ona11_location_widget', $name = 'ONA11 Hotel Location Widget', $options = array( 'description' => 'Show details about the hotel location' ) );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		?>
		<h4 class="orange-callout"><?php _e( 'Conference Location' ); ?></h4>
		<div class="inner">
			<h5 class="hotel-name">Boston Marriott Copley Place</h5>				
			<a href="http://maps.google.com/maps/place?q=boston+marriott+copley+place&hl=en&cid=14451641451303691549"><img class="hotel-map" src="<?php bloginfo('template_directory'); ?>/images/ona11-hotel-map.jpg" width="250px" height="142px" /></a>
			<p><span class="label float-left">Address:</span> <span class="value"><a href="http://maps.google.com/maps/place?q=boston+marriott+copley+place&hl=en&cid=14451641451303691549">110 Huntington Ave.,<br />Boston, MA 02116</a></span></p>
			<p><span class="label float-left">Phone:</span> <span class="value">(617) 236-5800</span></p>
		</div>
		<?php
		echo $after_widget;
	}
	
}