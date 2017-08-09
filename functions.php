<?php
require_once( __DIR__ . '/helpers.php');

function scripts_n_styles(){
  // Get fonts and styles
  wp_enqueue_style('open-sans-condensed', "https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300i,700");
  wp_enqueue_style('font-awesome', get_template_directory_uri() . '/fonts/font-awesome-4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('styles', get_template_directory_uri() . '/style.css');
  // Get scripts
  wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js');
}
add_filter('wp_enqueue_scripts', 'scripts_n_styles');



// Add support for a site logo and turn featured images on
add_theme_support('custom-logo');
add_theme_support('post-thumbnails');

// Register three navigation menus
register_nav_menus( array(
  'main' => 'Main header menu',
  'top' => 'Top header menu',
  'footer' => 'Footer menu',
  'main_radio' => 'Main header menu (Radio)'
));

// Register three footer widget areas and a sidebar
function smoke_widgets_init() {
	register_sidebar( array(
		'name'          => 'Left footer',
		'id'            => 'left_footer',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );
  register_sidebar( array(
		'name'          => 'Centre footer',
		'id'            => 'centre_footer',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget">',
		'after_title'   => '</h2>',
	) );
  register_sidebar( array(
		'name'          => 'Right footer',
		'id'            => 'right_footer',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );
  register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );
  register_sidebar( array(
		'name'          => 'Radio sidebar',
		'id'            => 'radio_sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'smoke_widgets_init' );

// Stop auto-p ing images
function unp_images($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'unp_images');

// Prettify excerpts
function smoke_excerpt_length( $length ) {
	return 20;
}
function smoke_excerpt_more($more) {
  global $post;
	return '...';
}
add_filter( 'excerpt_length', 'smoke_excerpt_length', 999 );
add_filter('excerpt_more', 'smoke_excerpt_more');

// Add login/out link to the top menu location
add_filter('wp_nav_menu_items', 'smoke_loginout_menu_link', 10, 2);
function smoke_loginout_menu_link( $items, $args ) {
   if ($args->theme_location == 'top') {
      if (is_user_logged_in()) {
         $items .= '<li class="right"><a href="'. wp_logout_url() .'">'. __("Log Out") .'</a></li>';
      } else {
         $items .= '<li class="right"><a href="'. wp_login_url(get_permalink()) .'">'. __("Log In") .'</a></li>';
      }
   }
   return $items;
}

// Track post popularity with meta key
function smoke_popular_posts($post_id) {
	$count_key = 'popular_posts';
	$count = get_post_meta($post_id, $count_key, true);
	if ($count == '') {
		$count = 0;
		delete_post_meta($post_id, $count_key);
		add_post_meta($post_id, $count_key, '0');
	} else {
		$count++;
		update_post_meta($post_id, $count_key, $count);
	}
}
function smoke_track_posts($post_id) {
	if (!is_single()) return;
	if (empty($post_id)) {
		global $post;
		$post_id = $post->ID;
	}
	smoke_popular_posts($post_id);
}
add_action('wp_head', 'smoke_track_posts');






// Register and load a custom widget
function smoke_load_widget() {
	register_widget( 'smoke_popular_widget' );
}
add_action( 'widgets_init', 'smoke_load_widget' );
// Creating the widget
class smoke_popular_widget extends WP_Widget {
  function __construct() {
    parent::__construct(
    // Base ID of your widget
    'smoke_popular_widget',
    // Widget name will appear in UI
    'Smoke Popular Posts',
    // Widget description
    array(
      'description' => 'Track popular posts'
      )
    );
  }
  // Creating widget front-end
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
    // Output code
    ?>
    <ul class="popular-posts">
    	<?php
      // Save the ID of the big post
      $queried_object = get_queried_object();
      $post_id = $queried_object->ID;
      $counter = 0;
      $popular = new WP_Query(array(
        'meta_key'=>'popular_posts',
        'orderby'=>'meta_value_num',
        'order'=>'DESC'
      ));
    	while ($popular->have_posts()) : $popular->the_post();
      // Skip over the big post, if it appears
      $ID = get_the_ID();
      if ($ID === $post_id) { continue; };
      // Stop looping after fourth post
      if ($counter>2) { break; };
      ?>
    	<li>
        <a href="<?php the_permalink(); ?>">
          <div class="featured-image" style="background-image:url(<?php the_post_thumbnail_url( 'thumbnail' )?>)"></div>
          <h4><?php the_title(); ?></h4>
        </a>
      </li>
    	<?php
      $counter++;
      endwhile; wp_reset_postdata(); ?>
    </ul>
    <?php
    echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'New title', 'wpb_widget_domain' );
    }
  // Widget admin form
  ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
  <?php
  }
  //Make customiser work
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
} // Widget done


// Create a function to display Facebook and Twitter share buttons

// Function to set up share buttons that work on any page
  function smoke_share_buttons($ID){
    // Echo out empty container for scirpt to work on
    echo '<ul id="smoke-share-buttons" class="share-buttons"></ul>';
    ?>
    <script>
    // Save the permalink as a var
    var post_url = window.location.href;
    // Save the post title (or whatever is in the H2 tag) as a var
    var post_title = document.getElementsByTagName("h1")[0].textContent;
    // Process vars into uniform sharing urls
    var facebookURL = "http://www.facebook.com/sharer/sharer.php?u=" + post_url;
    var twitterURL = "https://twitter.com/intent/tweet?text=" + post_title + "&amp;url=" + post_url + "&amp;via=Media_Smoke";
    // Put it into practice, giving Pinterest special treatment
    document.getElementById("smoke-share-buttons").innerHTML = `
      <li><a href='${facebookURL}' target="blank"><i class="fa fa-facebook"></i></a></li>
      <li><a href="${twitterURL}" target="blank"><i class="fa fa-twitter"></i></a></li>
    `;
    </script>
    <?php
  }

  // Responsive Youtube embeds
  function yt_embed_html( $html ) {
      return '<div class="video-wrapper">' . $html . '</div>';
  }
  add_filter( 'embed_oembed_html', 'yt_embed_html', 10, 3 );
  add_filter( 'video_embed_html', 'yt_embed_html' );


// //Create virtual blended/joint category pages for Radio
// function blend_radio_categories($query) {
//   $catnames = $query->get('category_name');
//   if ($catnames == 'radio-news') {
//       $query->set('category__and', array( 5,308 ));
//   }
//   if ($catnames == 'radio-music') {
//       $query->set('category__and', array( 320,308 ));
//   }
//   if ($catnames == 'radio-sport') {
//       $query->set('category__and', array( 9,308 ));
//   }
// }
// add_action('pre_get_posts', 'blend_radio_categories');
