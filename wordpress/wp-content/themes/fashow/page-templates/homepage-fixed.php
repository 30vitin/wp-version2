<?php
/**
 * Template Name: Home Page Fixed
 *
 * @package Wpbingo
 * @subpackage Fashow
 * @since Wpbingo Fashow 1.0
 */
get_header(); ?>

<div id="container" class="container homepage-fixed">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'templates/content/content', 'page');

				endwhile;
			?>

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();
