<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php if (wp_title('', false)) {
    echo wp_title('', false) . ' | Smoke Media';
  } else {
    echo 'Smoke Media';
  }
  ?></title>

  <meta property="fb:app_id" content="1134129026651501" />
  <!-- if page is content page -->
  <?php
  if (is_single()){
  $feat = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'ogimg' );
  $feat = $feat[0];
  $description = get_post_field( 'post_content', $post->ID );
  $description = trim( wp_strip_all_tags( $description, true ) );
  $description = wp_trim_words( $description, 15 );
  ?>
    <!-- post -->
    <meta property="og:url" content="<?php the_permalink() ?>"/>
    <meta property="og:title" content="<?php single_post_title(''); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="<?php echo $feat; ?>" />
    <meta property="og:description" content="<?php echo $description; ?>" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Media_Smoke">
    <meta name="twitter:creator" content="@Media_Smoke">
    <meta name="twitter:title" content="<?php the_title(); ?>">
    <meta name="twitter:description" content="<?php echo $description; ?>">
    <meta name="twitter:image" content="<?php echo $feat; ?>">
  <?php } else { ?>
    <!-- not a post -->
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
    <meta property="og:description" content="<?php bloginfo('description'); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?php echo get_template_directory_uri() ?>/assets/poster.jpg" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Media_Smoke">
    <meta name="twitter:creator" content="@Media_Smoke">
    <meta name="twitter:title" content="<?php bloginfo('name'); ?>">
    <meta name="twitter:description" content="<?php bloginfo('description'); ?>">
    <meta name="twitter:image" content="<?php echo get_template_directory_uri() ?>/assets/poster.jpg" >
  <?php
  }
  ?>
  <?php wp_head(); ?>
</head>
<body <?php body_class('wp-frontend'); ?>>

<header id="site-header">
  <div class="container">
    <nav id="top-navigation">
      <?php wp_nav_menu(array( 'theme_location' => 'top' )); ?>
    </nav>
    <?php the_custom_logo(); ?>
    <span id="more" onclick="toggleMoreMenu()"><i class="big fa fa-caret-down"></i> More</span>
  </div>
  <nav id="main-navigation">
    <i class="big fa fa-close" onclick="toggleMainMenu()"></i>
    <div class="container">
      <?php wp_nav_menu(array( 'theme_location' => 'main')); ?>
      <i class="big fa fa-search" onclick="toggleSearchBox()"></i>
      <?php get_search_form(); ?>
    </div>
  </nav>
  <i class="fa big fa-bars" onclick="toggleMainMenu()"></i>
</header>
