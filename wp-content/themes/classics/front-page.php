<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

get_header(); ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

<div class="home-top">
	<div class="background-gradient">
		<div class="container">
			<div class="row">
				<div class="col-md-5 offset-md-1">
					<h2>What can classics do for you?</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quis quam nec nulla cursus venenatis sed id lacus. Cras finibus, turpis quis eleifend dictum, eros justo malesuada arcu, congue rutrum augue massa id mauris. Donec eu vestibulum turpis. Vivamus sem sapien, iaculis ut leo ut, sagittis rhoncus mauris. In eu nulla vitae magna fringilla tristique. </p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="home-middle">
	<div class="container">
		<?php echo get_field('home_hero_video');?>
	</div>
</div>
<div class="home-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2 d-flex flex-column align-items-center">
				<h2 class="mb-4">Ready to jump start your education?</h2>
				<a class="btn btn-primary">View Courses</a>
			</div>
		</div>
	</div>
</div>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php get_footer(); ?>
