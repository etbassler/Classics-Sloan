<?php
/**
 * The template for displaying the home pages.
 */
use Roots\Sage\Extras;

get_header(); ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

<div class="home-top d-flex">
	<div class="background-gradient d-flex justify-content-center flex-column">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<h2 class="mb-4"><?php echo get_field('header_left');?></h2>
				</div>
				<div class="col-lg-8 offset-lg-1">
					<?php echo get_field('header_right');?>
				</div>
			</div>
		</div>
		<a href="#middle" class="scroll-down"><?php echo Extras\icons('icon-arrow', 30);?></a>
	</div>
</div>

<div class="home-middle" id="middle">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="text-center">A glimpse into our program:</h2>
				<?php echo get_field('home_hero_video');?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<div id="carouselQuotes" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
					<?php // check if the repeater field has rows of data
					$indicatorCount = 0;
					if( have_rows('quotes') ):
						// loop through the rows of data
						while ( have_rows('quotes') ) : the_row();?>
						<li data-target="#carouselQuotes" data-slide-to="<?= $indicatorCount;?>" class="<?= $indicatorCount == 0 ? 'active' : '';?>"></li>
						<?php
						$indicatorCount++;
						endwhile;
					endif;
					?>
					</ol>
					<div class="carousel-inner">
						<div class="quote-background">
							<?php echo Extras\icons('quote', 150);?>
						</div>
						<?php // check if the repeater field has rows of data
						$slideCount = 0;
						if( have_rows('quotes') ):
							// loop through the rows of data
							while ( have_rows('quotes') ) : the_row();?>
							<div class="carousel-item flex-column <?= $slideCount == 0 ? 'active' : '';?>">
								<div class="quote--content mb-2">
									<?php the_sub_field('quote_content');?>
								</div>
								<div class="quote--attribution d-flex flex-column">
									<?php the_sub_field('quote_name');?>
									<span class="quote--affiliation"><?php the_sub_field('quote_affiliation');?></span>
								</div>
							</div>
							<?php
							$slideCount++;
							endwhile;
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="home-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2 d-flex flex-column align-items-center">
				<h2 class="mb-4 text-center"><?php echo get_field('bottom_text');?></h2>
				<?php $link = get_field('bottom_link');?>
				<a href="<?= $link['url'];?>" class="btn btn-primary" target="<?= $link['target']; ?>"><?= $link['title']; ?></a>
			</div>
		</div>
	</div>
</div>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php get_footer(); ?>
