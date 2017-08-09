<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php if (wp_title('', false)) {
    echo wp_title('', false) . ' | Smoke Radio';
  } else {
    echo "Smoke Radio | London's student sound";
  }
  ?></title>
  <meta property="fb:app_id" content="1134129026651501" />
  <!-- if page is content page -->
  <?php if (is_single()){
  $feat = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'ogimg' );
  $feat = $feat[0];
  $description = get_post_field( 'post_content', $post->ID );
  $description = trim( wp_strip_all_tags( $description, true ) );
  $description = wp_trim_words( $description, 15 );
  ?>
    <meta property="og:url" content="<?php the_permalink() ?>"/>
    <meta property="og:title" content="<?php single_post_title(''); ?>" />
    <meta property="og:description" content="<?php echo $description; ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="<?php echo $feat; ?>" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Smoke_Radio">
    <meta name="twitter:creator" content="@Smoke_Radio">
    <meta name="twitter:title" content="<?php the_title(); ?>">
    <meta name="twitter:description" content="<?php echo $description; ?>">
    <meta name="twitter:image" content="<?php echo $feat; ?>">
  <?php } else { ?>
    <meta property="og:url" content="http://smokeradio.co.uk"/>
    <meta property="og:title" content="Smoke Radio" />
    <meta property="og:site_name" content="Smoke Radio" />
    <meta property="og:description" content="London's student sound." />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?php echo get_template_directory_uri() ?>/assets/poster-radio.jpg" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Smoke_Radio">
    <meta name="twitter:creator" content="@Smoke_Radio">
    <meta name="twitter:title" content="Smoke Radio">
    <meta name="twitter:description" content="By the students, for the students.">
    <meta name="twitter:image" content="<?php echo get_template_directory_uri() ?>/assets/poster-radio.jpg" >
  <?php
  }
  ?>
  <?php wp_head(); ?>
</head>
<body <?php body_class('wp-frontend'); ?>>

<header id="site-header" class="radio" style="background-image: url(<?php echo get_template_directory_uri() . "/assets/radio-pattern.png"?>);">
  <div class="container">
    <nav id="top-navigation">
      <?php wp_nav_menu(array( 'theme_location' => 'top' )); ?>
    </nav>
    <a class="custom-logo-link" href="/radio">
      <img src="<?php echo get_template_directory_uri() . "/assets/radio-logo.png"; ?>"/>
    </a>
    <span id="more" onclick="toggleMoreMenu()"><i class="fa fa-caret-down"></i> More</span>
  </div>
  <nav id="main-navigation">
    <i class="fa fa-close big" onclick="toggleMainMenu()"></i>
    <div class="container">
      <?php wp_nav_menu(array( 'theme_location' => 'main_radio')); ?>
      <i class="fa fa-search" onclick="toggleSearchBox()"></i>
      <?php get_search_form(); ?>
    </div>
  </nav>
  <i class="fa fa-bars big" onclick="toggleMainMenu()"></i>
</header>
