<?php get_header(); ?>

	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

				<?php 
					if (get_post_meta(get_the_ID(), '_disable_page_title', true) != '1') { ?>
					<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				<?php		
					}
				?>

				<div class="post-entry">
					<?php the_content(); ?>
				</div>

				<div class="postmetadata">
					<?php the_tags('Tags: ', ', ', '<br />'); ?>
					Posted in <?php the_category(', ') ?> | 
					<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
				</div>

			</div>

		<?php endwhile; ?>

		<?php else : ?>

			<h2>Not Found</h2>

		<?php endif; ?>

		<?php get_footer(); ?>
