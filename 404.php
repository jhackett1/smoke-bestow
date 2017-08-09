<?php
get_header();

// An array to store post IDs
$do_not_repeat = array();


?>
<section class="not-found container">
  <img src='<?php echo get_template_directory_uri() . "/assets/not-found.svg"; ?>'/>
  <h1>There's nothing to see here</h1>
  <p>We couldn't find what you're looking for. Try <a href="#" onclick="toggleSearchBox()">searching for it</a>, or just <a href="/">head home</a>.</p>
</section>
<?php
get_footer();
