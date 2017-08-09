<?php get_header(); ?>

<?php
// Make an empty array to store post IDs, avoiding replicate post display
$do_not_repeat = array();

// A function to display posts
// ARGUMENTS
// Category to display, else PROMOTED meta key
// Ad to include, else an extra post
// Meta should be author name or category
function postgrid($category_slug, $ad = null, $promoted = 0){

  // Grab the global var
  global $do_not_repeat;

  // Options for the loop
  if ($promoted == 0) {
    // A query for a category of posts
    $query = new WP_Query( array(
      'category_name' => $category_slug,
    ) );
  } else {
    // A query for promoted posts
    $query = new WP_Query( array(
      'meta_key' => 'smoke_promoted',
      'meta_value'	=> 'on'
    ) );
  }
  // Are there posts to loop?
  if ( $query->have_posts() ) {
    // Pre-loop markup here
  ?>
  <section class="grid-container <?php if($promoted !== 0) echo 'promoted'; ?>">
    <div class="container">
      <?php if ($promoted == 0) { ?>
        <h2><?php echo $category_slug; ?></h2>
      <?php }
    // Create a counter
    $index = 0;
    // Start the loop
  	while ( $query->have_posts() ) {
  		$query->the_post();
      // If this post has already appeared on the page, skip over it
      if (in_array(get_the_ID(), $do_not_repeat)) { continue; };
      // Stop showing posts after the fourth one
      if ($index > 3) { break; };
      // Still here? Push the post into the array
      array_push($do_not_repeat, get_the_ID());


      // First post like so
      if ($index == 0) {
  ?>
  <ul class="grid">
    <li class="top-story">
      <a href="<?php the_permalink(); ?>">
        <div class="image" style="background-image:url(<?php the_post_thumbnail_url( 'large' )?>">
          <h5><?php if($promoted !== 0){ echo get_the_category()[0]->name; }else{smoke_byline(get_the_ID());} ?></h5>
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
          <h3><span><?php if($promoted !== 0){ echo get_the_category()[0]->name; }else{smoke_byline(get_the_ID());} ?> /</span> <?php the_title(); ?></h3>
        </a>
      </li>
  <?php
      // Third post like so
      } elseif($index == 2){
  ?>
      <li class="trail">
        <a href="<?php the_permalink(); ?>">
          <div class="image" style="background-image:url(<?php the_post_thumbnail_url( 'medium' )?>"></div>
          <h3><span><?php if($promoted !== 0){  echo get_the_category()[0]->name; }else{smoke_byline(get_the_ID());} ?> /</span> <?php the_title(); ?></h3>
        </a>
      </li>
  <?php
      // Fourth post like so
    } elseif($index == 3 && $ad == null){
  ?>
      <li class="trail">
        <a href="<?php the_permalink(); ?>">
          <div class="image" style="background-image:url(<?php the_post_thumbnail_url( 'medium' )?>"></div>
          <h3><span><?php if($promoted !== 0){ echo get_the_category()[0]->name; }else{smoke_byline(get_the_ID());} ?> /</span> <?php the_title(); ?></h3>
        </a>
      </li>
    </ul>
  </ul>
  <?php
      // First ad option
    } elseif($index == 3 && $ad == 'subscribe'){
  ?>
    <li class="trail ad">
      <img src='<?php echo get_template_directory_uri() . "/assets/print.png"; ?>' />
      <h3>Read full issues online</h3>
      <a href="https://issuu.com/westminstersu" target="blank">Explore <i class="fa fa-arrow-right"></i></a>
    </li>
  <?php
    // Second ad option
    } elseif($index == 3 && $ad == 'app'){
    ?>
      <li class="trail ad">
        <img src='<?php echo get_template_directory_uri() . "/assets/mobile.png"; ?>' />
        <h3>Get the app today</h3>
        <a href="http://smoke.media/app">Learn more <i class="fa fa-arrow-right"></i></a>
      </li>
    <?php
  }
    // Iterate the counter
    $index++;
    // End the loop
    }
  // Post-loop markup here
  ?>
    </div>
  </section>
  <?php
  // End the if statement
  } else {
    echo "Sorry, no posts found.";
  }
// End function
}

postgrid('Promoted', null, 1);
postgrid('News');
postgrid('Comment', 'subscribe');
postgrid('Features');
postgrid('Arts', 'app');
postgrid('Music');
postgrid('Fashion');
postgrid('Lifestyle');
postgrid('Sport');


get_footer(); ?>
