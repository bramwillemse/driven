<?php get_header() ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="cars table">
		<div class="table-head">
			<div class="photo table-label table-column" data-label="Photo"></div>
			<div class="model table-label table-column" data-label="Model">Model</div>
			<div class="date table-label table-column" data-label="Date">Date</div>
			<div class="engine table-label table-column" data-label="Engine">Engine</div>
			<div class="cylinder table-label table-column" data-label="Cylinders">Cylinders</div>
			<div class="displacement table-label table-column" data-label="Displacement">Displacement</div>
			<div class="bhp table-label table-column" data-label="Horsepower">Horsepower</div>
			<div class="color table-label table-column" data-label="Color">Color</div>
			<div class="price table-label table-column" data-label="Price">Price</div>
			<div class="year table-label table-column" data-label="Year">Year</div>
		</div>

		<div class="car table-row"><!-- !!! keep in sync with table-head !! -->
			<div class="photo table-column" data-label="Photo">	<?php the_post_thumbnail('tiny-wide'); ?></div>
			<div class="model table-column" data-label="Model"><?php the_title(); ?></div>
			<div class="date table-column" data-label="Date"><?php the_time('j F Y'); ?></div>
			<div class="engine table-column" data-label="Engine"><?php the_field('engine'); ?></div>
			<div class="cylinder table-column" data-label="Cylinders"><?php the_field('cylinders'); ?></div>
			<div class="displacement table-column" data-label="Displacement"><?php the_field('displacement'); ?>cc</div>
			<div class="bhp table-column" data-label="Horsepower"><?php the_field('bhp'); ?>bhp</div>
			<div class="color table-column" data-label="Color"><?php the_field('color'); ?></div>
			<div class="price table-column" data-label="Price">€<?php the_field('price'); ?></div>
			<div class="year table-column" data-label="Year"><?php the_field('year'); ?></div>
		</div><!-- /car -->
	</div><!-- /cars -->
<?php endwhile; else : ?>
    //Something that happens when a post isn’t found.
<?php endif; ?>

<?php get_footer() ?>