<?php
/* Template Name: Full Width */
get_header(); ?>

<?php
// Start the loop
if (have_posts()) : while ( have_posts()) : the_post();
?>
<section class="desktop-article-masthead container">
  <h1 class="page-title full-width"><?php the_title(); ?></h1>
</section>
<main class="container">
  <article class="single page full-width">
    <?php if (the_post_thumbnail()) { ?>
    <div class="featured-image" style="background-image:url(<?php the_post_thumbnail_url( 'large' )?>)"></div>
    <?php } ?>
    <h1><?php the_title(); ?></h1>
    <section class="content">
      <?php the_content(); ?>
    </section>
  </article>
<?php
// What if there are no posts?
endwhile; else :
// End the loop
endif; ?>
</main>
<?php

get_footer();
