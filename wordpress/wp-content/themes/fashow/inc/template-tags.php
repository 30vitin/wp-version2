<?php

if (!function_exists('fashow_paging_nav')) :

	function fashow_paging_nav()
	{
		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ($wp_query->max_num_pages < 2) {
			return;
		}

		$paged        = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
		$pagenum_link = html_entity_decode(get_pagenum_link());
		$query_args   = array();
		$url_parts    = explode('?', $pagenum_link);

		if (isset($url_parts[1])) {
			wp_parse_str($url_parts[1], $query_args);
		}

		$pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
		$pagenum_link = trailingslashit($pagenum_link) . '%_%';

		$format  = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

		// Set up paginated links.
		$pagination = paginate_links(array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $wp_query->max_num_pages,
			'current'  => $paged,
			'mid_size' => 1,
			'add_args' => array_map('urlencode', $query_args),
			'prev_text' => esc_html__('Previous', 'fashow'),
			'next_text' => esc_html__('Next', 'fashow'),
			'type'      => 'list'
		));

		if ($pagination) :

?>
			<nav class="navigation paging-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php esc_html_e('Posts navigation', 'fashow'); ?></h1>
				<div class="pagination loop-pagination">
					<?php echo wp_kses($pagination, 'social'); ?>
				</div><!-- .pagination -->
			</nav><!-- .navigation -->
		<?php
		endif;
	}
endif;

if (!function_exists('fashow_post_nav')) :

	function fashow_post_nav()
	{
		// Don't print empty markup if there's nowhere to navigate.
		$previous = (is_attachment()) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
		$next     = get_adjacent_post(false, '', false);

		if (!$next && !$previous) {
			return;
		}

		?>
		<nav class="navigation post-navigation hidden" role="navigation">
			<h1 class="screen-reader-text"><?php esc_html_e('Post navigation', 'fashow'); ?></h1>
			<div class="nav-links">
				<?php
				if (is_attachment()) :
					previous_post_link('%link', esc_html__('<span class="meta-nav">Published In</span>%title', 'fashow'));
				else :
					previous_post_link('%link', esc_html__('<span class="meta-nav">Previous Post</span>%title', 'fashow'));
					next_post_link('%link', esc_html__('<span class="meta-nav">Next Post</span>%title', 'fashow'));
				endif;
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
endif;

function fashow_categorized_blog()
{
	if (false === ($all_the_cool_cats = get_transient('fashow_category_count'))) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories(array(
			'hide_empty' => 1,
		));

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count($all_the_cool_cats);

		set_transient('fashow_category_count', $all_the_cool_cats);
	}

	if (1 !== (int) $all_the_cool_cats) {
		return true;
	} else {
		return false;
	}
}


function fashow_category_transient_flusher()
{
	// Like, beat it. Dig?
	delete_transient('fashow_category_count');
}
add_action('edit_category', 'fashow_category_transient_flusher');
add_action('save_post',     'fashow_category_transient_flusher');

if (!function_exists('fashow_post_thumbnail')) :

	function fashow_post_thumbnail()
	{
		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return;
		}

		if (is_singular()) : ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail('fashow-full-width'); ?>
			</div>
		<?php else : ?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
				<?php the_post_thumbnail('fashow-full-width'); ?>
			</a>
		<?php endif; // End is_singular()
	}

endif;

function fashow_page_title()
{
	global $post, $fashow_settings, $wp_query;
	$enable_page_title = isset($fashow_settings['page_title']) ? $fashow_settings['page_title'] : true;
	if ($enable_page_title && 1 == 2) {
		$bg = isset($fashow_settings['page_title_bg']['url']) ? $fashow_settings['page_title_bg']['url'] : "";
		$class_empty = (empty($bg)) ? " empty-image" : "";
		?>
		<div class="container-full">
			<div class="page-title bwp-title<?php echo esc_attr($class_empty); ?>" <?php echo (!empty($bg) ? ' style="background-image:url(' . esc_url($bg) . ');"' : ''); ?>>
				<?php if (!is_single()) :  ?>
					<h1>
						<?php
						if (is_category()) :
							single_cat_title();

						elseif (is_tax()) :
							single_tag_title();

						elseif (is_tax('post_format', 'post-format-gallery')) :
							esc_html_e('Galleries', 'fashow');

						elseif (is_tax('post_format', 'post-format-image')) :
							esc_html_e('Images', 'fashow');

						elseif (is_tax('post_format', 'post-format-video')) :
							esc_html_e('Videos', 'fashow');

						elseif (is_tax('post_format', 'post-format-quote')) :
							esc_html_e('Quotes', 'fashow');

						elseif (is_tax('post_format', 'post-format-audio')) :
							esc_html_e('Audios', 'fashow');

						elseif (is_archive() && is_author()) :
							esc_html_e('Posts by " ', 'fashow') . the_author() . esc_html_e(' " ', 'fashow');

						elseif (function_exists('is_shop') && is_shop()) :
							esc_html_e('Shop', 'fashow');

						elseif (is_archive() && !is_search()) :
							the_archive_title();

						elseif (is_search()) :
							printf(esc_html__('Search for: %s', 'fashow'), get_search_query());

						elseif (is_404()) :
							esc_html_e('404 Error', 'fashow');

						elseif (is_singular('knowledge')) :
							esc_html_e('Knowledge Base', 'fashow');

						elseif (is_home()) :
							esc_html_e('Posts', 'fashow');

						else :
							echo get_the_title();
						endif;
						?>
					</h1>
				<?php endif; ?>
				<?php $enable_breadcrumb = isset($fashow_settings['breadcrumb']) ? $fashow_settings['breadcrumb'] : true; ?>
				<?php if ($enable_breadcrumb) : ?>
					<?php
					if (function_exists('is_woocommerce') && is_woocommerce())
						fashow_woocommerce_breadcrumb();
					else
						get_template_part('breadcrumb');
					?>
				<?php endif; ?>

			</div><!-- .container -->
		</div><!-- .page-title -->
	<?php } ?>
	<?php
	//if ($enable_page_title) {
		//LO NUEVO
	//	get_template_part('breadcrumb');
	//}
	?>

	<?php }

if (!function_exists('fashow_single_posted_on')) :

	function fashow_single_posted_on()
	{
		global $fashow_settings, $post; ?>
		
		<div class="entry-meta">
			<?php if (is_sticky() && is_home() && !is_paged()) { ?>
				<span class="sticky-post"><?php echo esc_html__('Featured', 'fashow') ?></span>
			<?php } ?>
			<span class="post-date">
				<i class="fa fa-calendar"></i><?php echo fashow_time_link(); ?>
			</span>
			<?php if (fashow_get_config('archives-author')) { ?>
				<span class="entry-meta-link"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span>
			<?php } ?>
			<a href="<?php echo esc_attr('#respond'); ?>" class="comments-link">
				<i class="fa fa-comment"></i><?php echo esc_attr($post->comment_count); ?>
			</a>
		</div>
	<?php }

endif;

if (!function_exists('fashow_posted_on')) :

	function fashow_posted_on()
	{
		global $fashow_settings, $post; ?>
		<div class="entry-meta">
			<?php if (is_sticky() && is_home() && !is_paged()) { ?>
				<span class="sticky-post"><?php echo esc_html__('Featured', 'fashow') ?></span>
			<?php } ?>
			<span class="post-date">
				<i class="fa fa-calendar"></i><?php echo fashow_time_link(); ?>
			</span>
			<?php if (fashow_get_config('archives-author')) { ?>
				<span class="entry-meta-link"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span>
			<?php } ?>
			<span class="comments-link">
				<i class="fa fa-comment"></i><?php echo esc_attr($post->comment_count); ?>
			</span>
		</div>
<?php }

endif;

if (!function_exists('fashow_entry_footer')) :
	function fashow_entry_footer()
	{
		if ('post' === get_post_type()) {
			$categories_list = get_the_category_list(esc_html__(', ', 'fashow'));
			if ($categories_list) {
				/* translators: 1: list of categories. */
				printf('<span class="cat-links">' . esc_html__('Posted in: %1$s', 'fashow') . '</span>', $categories_list); // WPCS: XSS OK.
			}
			$tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'fashow'));
			if ($tags_list) {
				printf('<span class="tags-links">' . esc_html__('Tagged: %1$s', 'fashow') . '</span>', $tags_list); // WPCS: XSS OK.
			}
		}

		edit_post_link(
			sprintf(
				wp_kses(
					__('Edit <span class="screen-reader-text">%s</span>', 'fashow'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if (!function_exists('fashow_time_link')) :
	function fashow_time_link()
	{
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf(
			$time_string,
			get_the_date(DATE_W3C),
			get_the_date(),
			get_the_modified_date(DATE_W3C),
			get_the_modified_date()
		);
		return sprintf(
			__('<span class="screen-reader-text">' . esc_html__('Posted on', 'fashow') . '</span> %s', 'fashow'),
			'<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
		);
	}
endif;
