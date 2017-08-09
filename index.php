<?php
get_header();

// An array to store post IDs
$do_not_repeat = array();


?>
<section class="chronological-list">
  <div class="container">
    <h3>Results <?php if (is_paged()) {echo '<span> / Page ' . get_query_var('paged') . "</span>"; }?></h3>
    <ul>
<?php

// A new counter
$index = 0;

if(have_posts()): while(have_posts()):
  the_post();
  // If current post ID exists in array, skip post and continue with loop
  if (in_array(get_the_ID(), $do_not_repeat)) { continue; };

  if ($index > 6) continue;
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
      <?php next_posts_link( '<i class="fa fa-arrow-left"></i> More posts' ); ?>
      <?php previous_posts_link( 'Previous posts <i class="fa fa-arrow-right"></i>' ); ?>
    </div>
  </div>
</section>
<?php
get_footer();
