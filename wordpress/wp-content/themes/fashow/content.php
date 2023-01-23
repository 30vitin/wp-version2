<?php $fashow_settings = fashow_global_settings(); ?>
<article id="post-<?php esc_attr(the_ID()); ?>" <?php post_class(); ?>>
	<?php if ( get_the_post_thumbnail() ){ ?>
		<div class="entry-thumb single-thumb">
			<?php the_post_thumbnail( 'full' ); ?>
		</div>
	<?php }; ?>	
	<div class="detail-content">
		<?php	
			$show_post_title = fashow_get_config('post-title',true);
			if ($show_post_title){
				if ( is_single() ){
					the_title( '<h3 class="entry-title">', '</h3>' );
				}else {
					the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
				}
			}
		?>	
		<?php fashow_single_posted_on(); ?>
		<?php if ( is_search() ) : ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="post-content">
			
			<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && fashow_categorized_blog() ) : ?>
			<div class="entry-meta hidden">
				<span class="cat-links"><?php echo get_the_category_list( esc_html__( 'Used between list items, there is a space after the comma.', 'fashow' ) ); ?></span>
			</div>
			<?php endif; ?>
			<div class="post-excerpt clearfix">
				<?php
					/* translators: %s: Name of current post */
					the_content( sprintf(
						the_title( '<span class="screen-reader-text">', '</span>', false )
					) );

					wp_link_pages( array(
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );
				?>
			</div>

			<div class="entry-meta-content">
				<?php if ( shortcode_exists( 'social_share' ) ) : ?> 
					<?php echo esc_html__( 'Share this on: ', 'fashow' ) ?>
					<?php echo do_shortcode( "[social_share]" ); ?>	
				<?php endif; ?>
			</div>	
			
			<div class="clearfix"></div>
			<!-- Tag -->
			<?php 
				fashow_entry_footer();
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				// Previous/next post navigation.
				fashow_post_nav();
			?>					
		</div><!-- .entry-content -->
		<?php endif; ?>
	</div>
	<div class="clearfix"></div>
</article><!-- #post-## -->
