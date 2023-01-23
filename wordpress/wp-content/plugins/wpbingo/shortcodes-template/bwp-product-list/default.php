
<?php
$widget_id = isset( $widget_id ) ? $widget_id : 'bwp_woo_slider_'.rand().time();
$class_col_lg = ($columns == 5) ? '2-4'  : (12/$columns);
$class_col_md = ($columns1 == 5) ? '2-4'  : (12/$columns1);
$class_col_sm = ($columns2 == 5) ? '2-4'  : (12/$columns2);
$class_col_xs = ($columns3 == 5) ? '2-4'  : (12/$columns3);
$attributes = 'col-lg-'.$class_col_lg .' col-md-'.$class_col_md .' col-sm-'.$class_col_sm .' col-xs-'.$class_col_xs; 
do_action( 'before' ); 
if ( $list -> have_posts() ){ ?>
	<div id="<?php echo $widget_id; ?>" class="<?php echo $widget_class; ?> <?php echo esc_attr($class); ?> <?php if(empty($title1)) echo 'no-title'; ?>">
		<?php if($title1) { ?>
		<div class="title-block text-center">
			<?php if($description) { ?>
			<div class="page-description"><?php echo $description; ?></div>
			<?php } ?>  
			<h2><?php echo $title1; ?></h2>  
		</div> 
		<?php } ?>         
		<div class="content products-list grid row">	
		<?php while($list->have_posts()): $list->the_post();
		global $product, $post, $wpdb, $average; ?>
			<div class="item-product <?php echo $attributes; ?>">
				<?php include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'content-product.php'); ?>
			</div>
		<?php endwhile; wp_reset_postdata();?>
		</div>
	</div>
	<?php
	}
?>