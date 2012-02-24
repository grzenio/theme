<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<section class="content">
<div class="breadcrumbs"><?php //the_breadcrumb(''); ?></div>
    <article class="box">
        <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>

        <section id="entry-content-single">
          <?php the_content('<p>Read More</p>'); ?>
        </section>
        <section class="meta"> Posted by:
          <?php the_author() ?>
          <?php edit_post_link(__('Edit This')); ?> 

          <p><?php the_tags(""); ?></p>
        </section>
        <div class="clearfix"></div>
    </article>
  <!-- end post -->
</section></div>
<?php endwhile; else: ?>  
<?php endif; ?> 
<?php get_footer(); ?>