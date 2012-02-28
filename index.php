<?php get_header(); ?>
<section>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <article class="post" id="post-<?php the_ID(); ?>">
    <aside class="post_image">
      <?php
        if ( has_post_thumbnail() ) {
            the_post_thumbnail();
        } else { ?>
      <a class="noimage" href="<?php the_permalink() ?>">&nbsp;</a>
      <div class="bigimage"></div>
	  <?php }?>
    </aside>
    <section class="post_content">
      <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
        <?php the_title(); ?>
        </a></h1>
      <p><?php echo get_the_excerpt(); ?></p>
      <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>" class="read_more">Read More</a> </section>
    <!--<section class="meta">
      <p><time class="updated" datetime="<?php $postDate = get_the_date('c');$postDate2 = get_the_date('d.m.Y');echo $postDate ?>"><?php echo $postDate2; ?></time></p>
    </section>-->
  </article>
  <?php endwhile; else: ?>
  <p>
    <?php _e('Sorry, no posts matched your criteria.'); ?>
  </p>
  <?php endif; ?>
  <?php page_navi(); // use the page navi function ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
