<?php

//Function to display the byline
function smoke_byline($ID){
	if (get_post_meta( $ID, 'byline')) {
		$byline = get_post_meta( $ID, 'byline')[0];
	} else {
		$byline = 0;
	}
	if($byline){
		echo $byline;
	}else{
		the_author();
	}
}

//Turn off TinyMCE
add_filter('user_can_richedit' , create_function('' , 'return false;') , 50);

//Function to display star ratings on single pages
function smoke_rating($ID){
	// Retrieve metadata and save as var
	$star_rating = get_post_meta( $ID, 'star_rating')[0];
	if ( $star_rating ){
		// Display container element
		echo "<div class='star-rating'>";
		// Display full stars
		for ($i=0; $i < $star_rating; $i++) {
			echo "<i class='fa fa-star'></i>";
		}
		// Get difference between star rating and 5, then echo remaining empty stars
		$white_stars = 5 - $star_rating;
		for ($i=0; $i < $white_stars; $i++) {
			echo "<i class='fa fa-star-o'></i>";
		}
		// Close container element
		echo "</div>";
	}
}


// Register a meta box to contain fields for adding custom post meta
add_action( 'add_meta_boxes', 'smoke_meta_box_setup' );
function smoke_meta_box_setup(){
	add_meta_box( 'smoke_post_options', 'Smoke Post Options', 'smoke_post_options_content', 'post', 'side', 'high');
}

// Callback function to fill the meta box with form input content, passing in the post object
function smoke_post_options_content( $post ){
	// Fetch all post meta data and save as an array var
	$values = get_post_custom( $post->ID );
	// Save current values of particular meta keys as variables for display
	$byline = isset( $values['byline'] ) ? esc_attr( $values['byline'][0] ) : "";
	$feat_image_credit = isset( $values['feat_image_credit'] ) ? esc_attr( $values['feat_image_credit'][0] ) : "";
	$star_rating = isset( $values['star_rating'] ) ? esc_attr( $values['star_rating'][0] ) : "";
	$smoke_promoted = isset( $values['smoke_promoted'] ) ? $values['smoke_promoted'][0] : "";
	//What a nonce
	wp_nonce_field( 'smoke_post_options_nonce', 'meta_box_nonce' );
	// Display input fields, using variables above to show current values
    ?>
		<p class="description">Use these controls to customise your article's appearence.</p>
		<p>
			<label for="smoke_promoted">Promoted</label><br/>
			<input type="checkbox" id="smoke_promoted" name="smoke_promoted" <?php checked( $smoke_promoted, 'on' ); ?> />
			<p class="description">Send this article to the top of the homepage and category pages.</p>
			<hr>
		</p>
		<p>
			<label for="byline">Byline</label><br/>
			<input type="text" name="byline" id="byline" value="<?php echo $byline; ?>"/>
			<p class="description">If this article was written by a contributor, give their name to replace your own.</p>
			<hr>
		</p>
		<p>
	    <label for="feat_image_credit">Featured image credit</label><br/>
	    <input type="text" name="feat_image_credit" id="feat_image_credit" value="<?php echo $feat_image_credit; ?>"/>
		</p>
		<p>
      <label for="star_rating">Star rating</label><br/>
      <select name="star_rating" id="star_rating">
          <option value="" <?php selected( $star_rating, 'none' ); ?>>None</option>
			    <option value="1" <?php selected( $star_rating, '1' ); ?>>1</option>
			    <option value="2" <?php selected( $star_rating, '2' ); ?>>2</option>
			    <option value="3" <?php selected( $star_rating, '3' ); ?>>3</option>
			    <option value="4" <?php selected( $star_rating, '4' ); ?>>4</option>
			    <option value="5" <?php selected( $star_rating, '5' ); ?>>5</option>
      </select>
		<p class="description">All reviews need a rating out of five.</p>
		</p>
    <?php
}
// Having registered the meta box and filled it with content, now we save the form inputs to the post meta table
add_action( 'save_post', 'smoke_post_options_save' );

// A function to save form inputs to the database
function smoke_post_options_save( $post_id ){
	// If this is an autosave, do nothing
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	// Verify the nonce before proceeding
	// if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	// Check user permissions before proceeding
	if( !current_user_can( 'edit_post' ) ) return;
  $allowed = array(
      'a' => array( // on allow a tags
          'href' => array() // and those anchors can only have href attribute
      )
  );
  // Save featured image credit field
  if( isset( $_POST['feat_image_credit'] ) )
      update_post_meta( $post_id, 'feat_image_credit', wp_kses( $_POST['feat_image_credit'], $allowed ) );
	// Save star rating field
  if( isset( $_POST['star_rating'] ) )
      update_post_meta( $post_id, 'star_rating', esc_attr( $_POST['star_rating'] ) );
	// Save byline field
  if( isset( $_POST['byline'] ) )
      update_post_meta( $post_id, 'byline', esc_attr( $_POST['byline'] ) );
	// Save promoted field
	$chk2 = isset( $_POST['smoke_promoted'][0] ) ? 'on' : 'off';
  	update_post_meta( $post_id, 'smoke_promoted', $chk2 );
}
