<?php
/**
 * The template for displaying the home pages.
 */
use Roots\Sage\Extras;

get_header(); ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

		<?php the_content();?>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php get_footer(); ?>
