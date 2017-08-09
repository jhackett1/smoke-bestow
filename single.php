<?php
if (in_category('radio')) {
  get_header('radio');
} else {
  get_header();
}
 ?>



<?php
// Start the loop
if (have_posts()) : while ( have_posts()) : the_post();
?>
<section class="desktop-article-masthead container">
  <h5><?php the_category(', '); ?></h5>
  <h1><?php the_title(); ?></h1>
  <?php smoke_rating(get_the_ID()); ?>
</section>
<main class="container">
  <article class="single">
    <div class="featured-image" style="background-image:url(<?php the_post_thumbnail_url( 'large' )?>)">
      <?php if( get_post_meta( $post->ID, 'feat_image_credit', true ) ){ ?>
        <div class="credit">Image: <?php echo get_post_meta( $post->ID, 'feat_image_credit', true )?></div>
      <?php } ?>
    </div>
    <h5><?php the_category(', '); ?></h5>
    <h1><?php the_title(); ?></h1>
    <?php smoke_rating(get_the_ID()); ?>
    <section class="meta-bar">
      <div>
        <span class="time"><i class="fa fa-clock-o"></i><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span>
        <?php smoke_share_buttons(get_the_ID()); ?>
      </div>
      <span class="author">By <?php smoke_byline(get_the_ID()); ?> <?php if (!get_post_meta( get_the_ID(), 'byline')[0]){ echo get_avatar(get_the_author_meta( 'ID' )); } ?></span>
    </section>
    <section class="content">
      <?php the_content(); ?>
    </section>


    <section class="recommended">
      <h2>Recommended</h2>
      <ul class="recommendations">
        <?php
        $cat = get_the_category()[0]->slug;
        $counter = 0;
        $recommended = new WP_Query(array(
          'category_name' => $cat,
        ));

        $big_post_id = get_the_ID();

        while ($recommended->have_posts()) : $recommended->the_post();
        // Skip over the big post, if it appears
        if ($big_post_id === get_the_ID()) { continue; };
        // Stop looping after third post
        if ($counter>2) { break; };
        ?>
        <li>
          <a href="<?php the_permalink(); ?>">
            <div class="featured-image" style="background-image:url(<?php the_post_thumbnail_url( 'large' )?>)"></div>
            <h4><?php the_title(); ?></h4>
          </a>
        </li>
        <?php
        $counter++;
        endwhile; wp_reset_postdata(); ?>
      </ul>
    </section>

  </article>

  <aside class="sidebar">
    <?php get_sidebar(); ?>
  </aside>
<?php
// What if there are no posts?
endwhile; else :
// End the loop
endif; ?>




</main>
<?php

get_footer();
