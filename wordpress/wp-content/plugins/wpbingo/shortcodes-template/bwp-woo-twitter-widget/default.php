<?php $tag_id = 'twitter_' .rand().time(); ?>
<?php 	
	$chrome = '';
	if (isset($show_header) && $show_header == 0) {
		$chrome .= 'noheader ';
	}
	if ($show_footer == 0) {
		$chrome .= 'nofooter ';
	}
	if ($show_border == 0) {
		$chrome .= 'noborders ';
	}
	if ($transparent == 0) {
		$chrome .= 'transparent';
	}
	
	$js_twitter = '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
?>

<?php if(isset($twitter_name) && $twitter_name) : ?>
<div id="<?php echo $tag_id; ?>" class="bwp-twitter ">
 <div class="block">
  <?php if(isset($show_title) && $show_title == 1 && isset($title) && !empty($title)) : ?>
   <h4 class="title_block">
    <span><?php echo $title; ?></span>
   </h4>
  <?php endif; ?>
  <div class="block_content">
		<div class="bwp-twitter">
			<a class="twitter-timeline" width="<?php echo $width; ?>" height="<?php echo $height; ?>" data-chrome="<?php echo $chrome; ?>" data-dnt="true"   data-link-color="<?php echo $link_color; ?>"  data-border-color="<?php echo $border_color; ?>"  data-tweet-limit="<?php echo $limit; ?>" data-link-color="<?php echo $link_color; ?>"  data-show-replies="<?php echo $show_replies; ?>" href="https://twitter.com/<?php echo $twitter_name; ?>"  data-widget-id="<?php echo $twitter_id; ?>"  >Tweets by @<?php echo $twitter_name; ?></a>
			<?php echo $js_twitter; ?>
		</div>	
  </div>
 </div>
</div>
<?php endif; ?>
