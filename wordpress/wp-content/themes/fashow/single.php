<?php 
	get_header();
	$post_single_layout = fashow_post_sidebar();
?>

<div class="container">
	<div class="single-post-content <?php echo esc_attr($post_single_layout); ?> row">
			<?php if($post_single_layout == 'left' && is_active_sidebar('sidebar-blog')):?>			
			<div class="bwp-sidebar sidebar-blog <?php echo esc_attr(fashow_get_class()->class_sidebar_left); ?>">
				<?php dynamic_sidebar('sidebar-blog');?>	
			</div>				
			<?php endif; ?>
			<div class="<?php echo esc_attr(fashow_get_class()->class_single_content); ?>">
				<div class="post-single">
					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();
							get_template_part( 'content');
						endwhile;
					?>
				</div>
			</div>
			<?php if($post_single_layout == 'right' && is_active_sidebar('sidebar-blog')):?>			
				<div class="bwp-sidebar sidebar-blog <?php echo esc_attr(fashow_get_class()->class_sidebar_right); ?>">
					<?php dynamic_sidebar('sidebar-blog');?>	
				</div>				
			<?php endif; ?>
            
    </div>
</div>
<?php
get_footer();