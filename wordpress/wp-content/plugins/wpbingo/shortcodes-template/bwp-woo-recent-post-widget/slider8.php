<?php
	$tag_id = 'recent_post_' .rand().time(); 
	$args = array(
	'post_type' => 'post',
	'cat' => $category, 
	'posts_per_page' => $limit
	);

	$query = new WP_Query($args);
	$post_count = $query->post_count;
	$j = 0;
?>
<?php if($query->have_posts()):?>
<div class="bwp-recent-post slider layout8">
 <div class="block">
 	<?php if(isset($title1) && $title1) { ?>
	<div class="title-block">
		<h2><?php echo esc_html($title1); ?></h2>
	</div>
	<?php } ?>
  <div class="block_content">
   <div id="<?php echo esc_attr($tag_id); ?>" class="slick-carousel" data-columns4="<?php echo $columns4; ?>" data-columns3="<?php echo $columns3; ?>" data-columns2="<?php echo $columns2; ?>" data-columns1="<?php echo $columns1; ?>" data-columns="<?php echo $columns; ?>">
		<?php while($query->have_posts()):$query->the_post(); ?>
		<!-- Wrapper for slides -->
		<?php	if( ( $j % $item_row ) == 0 && $item_row !=1) { ?>
			<div class="item">
			<?php } ?>
				<div  <?php post_class( 'post-grid' ); ?>>	
				<div class="post-inner"> 
					<?php wpbingo_posted_on3(); ?>
					<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
					<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
					<?php
						if( has_post_thumbnail() ) :
							the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
						else :
							echo '<img src="' . esc_url( get_template_directory_uri() . '/images/placeholder.jpg' ) . '" alt="' . get_the_title() . '">';
						endif;
					?>
					</a>
					<div class="post-content">
						<?php echo wpbingo_get_excerpt( $length, true ); ?>
						<a class="post-btn-more" href="<?php echo esc_url(the_permalink()) ?>"><i class="fa fa-file-text"></i><?php echo  esc_html_e( 'Read More', 'wpbingo' ) ?></a>
					</div>
				</div>
				</div><!-- #post-## -->
			<?php if( ($j % $item_row == 1 || $j == $post_count) && $item_row !=1  ){?> 
			</div>
			<?php  } $j++;?>
		<?php endwhile; wp_reset_postdata(); ?>
   </div>
  </div>
 </div>
</div>
<?php endif;?>