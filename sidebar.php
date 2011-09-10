<div id="sidebar" class="sidebar">
	<ul class="xoxo">
		
		<li id="updates">
			<p><img src="<?php echo get_bloginfo('template_directory'); ?>/images/ona11-latest-updates.gif"></p>
				
			<ul>
				<?php global $post; $myposts = get_posts('numberposts=4&cat_name=updates'); foreach($myposts as $post) : setup_postdata($post); ?>
					<h5 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					<div class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time('M. j, Y') ?> &ndash; <?php the_time('g:i a') ?></abbr></div>
			 	<?php endforeach; ?>
 
 				<p class="frontpagejump"><a href="<?php bloginfo('url'); ?>/category/updates/"><strong>More updates &#0187;</strong></a></p>

			</ul>
		</li>
		<li id="sponsors">
			<p><img src="<?php echo get_bloginfo('template_directory'); ?>/images/ona11-sponsors-exhibitors.gif"></p>
			<ul id="sidebar-sponsors">
				<li>
					<p class="sponsorlogo"><a href="http://espn.com/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_espn_bw_176.jpg"></a></p></li>
				<li><p class="sponsorlogo"><a href="http://npr.org/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_npr_bw_176.jpg"></a></p></li>
				<li><p class="sponsorlogo"><a href="http://pbs.org/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_pbs_bw_176.jpg"></a></p></li>
				<li><p class="sponsorlogo"><a href="http://bu.edu/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_bu_bw_176.jpg"></a></p></li>	
				<li><p class="sponsorlogo"><a href="http://wbur.org/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_wbur_bw_176.jpg"></a></p></li>	
				<li><p class="sponsorlogo"><a href="http://english.aljazeera.net/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_aljazeera_bw_176.jpg"></a></p></li>
				<li><p class="sponsorlogo"><a href="http://google.com/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_google_bw_88.jpg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://cnn.com/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_cnn2_bw_88.jpg"></a></p></li>
				<li><p class="sponsorlogo"><a href="http://msn.com/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_msn_bw_88.jpg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://marketwire.com/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_marketwire_bw_88.jpg"></a></p></li>
				<li><p class="sponsorlogo"><a href="http://gannettfoundation.org/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_gannett_foundation_bw_88.jpg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://thomsonreuters.com/products_services/media/reuters_america_for_publishers/"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/sponsors/ona11_sponsor_reuters_bw_88.jpg"></a></p></li>
				<li><p class="frontpage">Reach the largest audience of digital journalists in the world at ONA11, hosted by the fastest-growing membership organization of online media.</p>
<p class="frontpagejump"><a href="/overview"><strong>Learn more &#0187;</strong></a></p></li>
				</ul>
			</li>
			<li id="tweets">
				<p><img src="<?php echo get_bloginfo('template_directory'); ?>/images/ona11-twitter.gif"></p>
				<div id="ttweets" class="tstream"></div> 
				<p id="tmore" class="frontpagejump"></p>
			</li><!-- #tweets -->
		</ul>
</div><!-- #sidebar .sidebar -->