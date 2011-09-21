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
		$title = 'Twitter: #ONA11';
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
		
		<div id="tweets" class="widget">
			<h4 class="orange-callout"><?php echo $title; ?></h4>
			<div id="ttweets" class="tstream"></div> 
			<p id="tmore" class="more"></p>
		</div><!-- #tweets -->
		<script type="text/javascript">		
			jQuery(document).ready(function(){
				console.log( ona11_twitter_url, ona11_twitter_more_text );
				ona11_load_tweets( ona11_twitter_url, ona11_twitter_more_text );
			});
		</script>
		
	<?php
	}
	
}

class ONA11_Location_Widget extends WP_Widget
{
	
	function ONA11_Location_Widget() {
		
	}
	
	function widget( $args, $instance ) {
		
	}
	
}