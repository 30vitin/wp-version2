<?php 	
include_once('twitteroauth/twitteroauth.php');
	$tag_id = 'twitter_slider_'.rand().time();
	$connection = new TwitterOAuth($twitter_customer_key, $twitter_customer_secret, $twitter_access_token, $twitter_access_token_secret);
	$my_tweets = $connection->get('statuses/user_timeline', array('screen_name' => $twitter_name, 'count' => $limit));	 
?>

<?php if($my_tweets) : ?>
<div class="bwp-twitter-slider">
 <div class="block">
  <?php if(isset($title) && $title) : ?>
   <div class="title-block">
    <h2><?php echo $title; ?></h2>
   </div>
  <?php endif; ?>
  <div class="block-content">		
	<div id="<?php echo $tag_id; ?>" class="slick-carousel" data-columns4="<?php echo $columns4; ?>" data-columns3="<?php echo $columns3; ?>" data-columns2="<?php echo $columns2; ?>" data-columns1="<?php echo $columns1; ?>" data-columns="<?php echo $columns; ?>">
		<?php foreach($my_tweets as $tweet) {?>
			<div class="item">
				<?php if(isset($tweet->created_at) && $tweet->created_at){?>
					<span><?php echo wp_trim_words( $tweet->text, $max_length, '...')?></span>
				<?php } ?>
				<?php if(isset($tweet->entities->urls[0]->url) && $tweet->entities->urls[0]->url){?>
					<div class="read-more">
						<a href="<?php echo $tweet->entities->urls[0]->url; ?>">
							<?php echo $tweet->entities->urls[0]->url; ?>
						</a>
					</div>
				<?php } ?>
				<?php if(isset($tweet->created_at) && $tweet->created_at){?>
					<?php
					  $first_date = strtotime($tweet->created_at);
					  $second_date = time();
					  $datediff = abs($first_date - $second_date);
					?>
					<span><?php echo __('Posted ', 'Wpbingo'); echo floor($datediff / (60*60*24)); echo __(' Ago', 'Wpbingo'); ?></span>
				<?php } ?>
			</div>
		<?php }?>
	</div>						
  </div>
 </div>
</div>
<?php endif; ?>

