<?php
get_header();

// An array to store post IDs
$do_not_repeat = array();

if (!is_paged()) {
  ?>
  <section class="grid-container">
    <div class="container">
      <h2><?php  single_cat_title(); ?></h2>
  <?php

  $index = 0;

  $current_cat = get_query_var('cat');
  // Options for the loop
  // Get PROMOTED posts in THE CURRENT CATEGORY
  $query = new WP_Query( array(
    'cat' => $current_cat,
    'posts_per_page' => 4,
    'meta_key' => 'smoke_promoted',
    'meta_value'	=> 'on'
  ) );
  // Are there posts to loop?
  if ( $query->have_posts() ) {
    // Pre-loop markup here
    // Start the loop
  	while ( $query->have_posts() ) {
  		$query->the_post();
      // If current post ID exists in array, skip post and continue with loop
      if (in_array(get_the_ID(), $do_not_repeat)) { continue; };
      // Save current post ID to array
      array_push($do_not_repeat, get_the_ID());
      // First post like so
      if ($index == 0) {
  ?>
  <ul class="grid">
    <li class="top-story">
      <a href="<?php the_permalink(); ?>">
        <div class="image" style="background-image:url(<?php the_post_thumbnail_url( 'large' )?>">
          <h5><?php smoke_byline(get_the_ID()); ?></h5>
        </div>
        <h3><?php the_title(); ?></h3>
        <p><?php the_excerpt(); ?></p>
      </a>
    </li>
  <?php
      // Second post like so
    } elseif($index == 1){
  ?>
    <ul class="trails">
      <li class="trail">
        <a href="<?php the_permalink(); ?>">
          <div class="image" style="background-image:url(<?php the_post_thumbnail_url( 'medium' )?>"></div>
          <h3><span><?php smoke_byline(get_the_ID()); ?> /</span> <?php the_title(); ?></h3>
        </a>
      </li>
  <?php
      // Third post like so
      } elseif($index == 2){
  ?>
      <li class="trail">
        <a href="<?php the_permalink(); ?>">
          <div class="image" style="background-image:url(<?php the_post_thumbnail_url( 'medium' )?>"></div>
          <h3><span><?php smoke_byline(get_the_ID()); ?> /</span> <?php the_title(); ?></h3>
        </a>
      </li>
  <?php
      // Fourth post like so
    } elseif($index == 3){
  ?>
      <li class="trail">
        <a href="<?php the_permalink(); ?>">
          <div class="image" style="background-image:url(<?php the_post_thumbnail_url( 'medium' )?>"></div>
          <h3><span><?php smoke_byline(get_the_ID()); ?> /</span> <?php the_title(); ?></h3>
        </a>
      </li>
    </ul>
  </ul>
  <?php
    }
    // Iterate the counter
    $index++;
    // End the loop
    }
  // Post-loop markup here
  ?>
  <?php
  // End the if statement
  } else {
    echo "Sorry, no posts found.";
  }
  ?>
  </div>
  </section>
<?php
}
?>
<section class="chronological-list">
  <div class="container">
    <h3>All <?php  single_cat_title(); ?><?php if (is_paged()) {echo '<span> / Page ' . get_query_var('paged') . "</span>"; }?></h3>
    <ul>
<?php

// A new counter
$index = 0;

if(have_posts()): while(have_posts()):
  the_post();
  // If current post ID exists in array, skip post and continue with loop
  if (in_array(get_the_ID(), $do_not_repeat)) { continue; };

  // Iterate counter
  $index++;
  ?>
    <li>
      <a href="<?php the_permalink(); ?>">
        <div class="featured-image" style="background-image:url(<?php the_post_thumbnail_url( 'medium' )?>)"></div>
        <div>
          <h5><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></h5>
          <h4><?php the_title(); ?></h4>
        </div>
      </a>
    </li>
  <?php
  endwhile;
endif;
?>
    </ul>
    <div class="pagination">
      <?php next_posts_link( '<i class="fa fa-arrow-left"></i> Older posts' ); ?>
      <?php previous_posts_link( 'Newer posts <i class="fa fa-arrow-right"></i>' ); ?>
    </div>
  </div>
</section>
<?php
get_footer();
