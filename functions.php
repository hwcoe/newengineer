<?php

// =============================================================================
// FUNCTIONS.PHP
// -----------------------------------------------------------------------------
// Overwrite or add your own custom functions to X in this file.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//		01. Enqueue Parent Stylesheet
//		02. Entry Meta - Override
//		03. Entry Cover - Override
//		04. Featured Index Content - Override
//		05. Admin Post Meta Boxes - Override
//		06. Navbar Searchform Popup - Override
//		07. Social Output - Override
// =============================================================================

// 01. Enqueue Parent Stylesheet
// =============================================================================

add_filter( 'x_enqueue_parent_stylesheet', '__return_true' );


// 02. Entry Meta - Override
// =============================================================================

if ( ! function_exists( 'x_ethos_entry_meta' ) ) :
	function x_ethos_entry_meta() {

		$byline = get_post_meta(get_the_ID(), 'byline', true);
		
		if ($byline) {
			$author = sprintf( ' %1$s %2$s</span>',
				__( 'by', '__x__' ),
				$byline

			);
	} else {
		$author = '</span>';
	};


		//
		// Date.
		//

		$date = sprintf( '<span><time class="entry-date" datetime="%1$s">%2$s</time></span>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);


		//
		// Categories.
		//

		if ( get_post_type() == 'x-portfolio' ) {
			if ( has_term( '', 'portfolio-category', NULL ) ) {
				$categories        = get_the_terms( get_the_ID(), 'portfolio-category' );
				$separator         = ', ';
				$categories_output = '';
				foreach ( $categories as $category ) {
					$categories_output .= '<a href="'
															. get_term_link( $category->slug, 'portfolio-category' )
															. '" title="'
															. esc_attr( sprintf( __( "View all posts in: &ldquo;%s&rdquo;", '__x__' ), $category->name ) )
															. '"> '
															. $category->name
															. '</a>'
															. $separator;
				}

				$categories_list = sprintf( '<span>%1$s %2$s',
					__( 'In', '__x__' ),
					trim( $categories_output, $separator )
				);
			} else {
				$categories_list = '';
			}
		} else {
			$categories        = get_the_category();
			$separator         = ', ';
			$categories_output = '';
			foreach ( $categories as $category ) {
				$categories_output .= '<a href="'
														. get_category_link( $category->term_id )
														. '" title="'
														. esc_attr( sprintf( __( "View all posts in: &ldquo;%s&rdquo;", '__x__' ), $category->name ) )
														. '"> '
														. $category->name
														. '</a>'
														. $separator;
			}

			$categories_list = sprintf( '<span>%1$s %2$s',
				__( 'In', '__x__' ),
				trim( $categories_output, $separator )
			);
		}


		//
		// Comments link.
		//

		if ( comments_open() ) {

			$title  = apply_filters( 'x_entry_meta_comments_title', get_the_title() );
			$link   = apply_filters( 'x_entry_meta_comments_link', get_comments_link() );
			$number = apply_filters( 'x_entry_meta_comments_number', get_comments_number() );
			
			$text = ( 0 === $number ) ? 'Leave a Comment' : sprintf( _n( '%s Comment', '%s Comments', $number, '__x__' ), $number );

			$comments = sprintf( '<span><a href="%1$s" title="%2$s" class="meta-comments">%3$s</a></span>',
				esc_url( $link ),
				esc_attr( sprintf( __( 'Leave a comment on: &ldquo;%s&rdquo;', '__x__' ), $title ) ),
				$text
			);

		} else {

			$comments = '';

		}


		//
		// Output.
		//

		if ( x_does_not_need_entry_meta() ) {
			return;
		} else {
			printf( '<p class="p-meta">%1$s%2$s%3$s%4$s</p>',
				$categories_list,
				$author,
				$date,
				$comments
			);
		}

	}
endif;


// 03. Entry Cover - Override
// =============================================================================

if ( ! function_exists( 'x_ethos_entry_cover' ) ) :
	function x_ethos_entry_cover( $location ) {

		if ( $location == 'main-content' ) { ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<a class="entry-cover" href="<?php the_permalink(); ?>" style="<?php echo x_ethos_entry_cover_background_image_style(); ?>">
					<h2 class="h-entry-cover"><span><?php x_the_alternate_title(); ?></span></h2>
				</a>
			</article>

		<?php } elseif ( $location == 'post-carousel' ) { ?>

			<?php GLOBAL $post_carousel_entry_id; ?>

			<article <?php post_class(); ?>>
				<a class="entry-cover" href="<?php the_permalink(); ?>" style="<?php echo x_ethos_entry_cover_background_image_style(); ?>">
					<h2 class="h-entry-cover">
						<span><?php ( $post_carousel_entry_id == get_the_ID() ) ? the_title() : x_the_alternate_title(); ?></span>
						<span class="date"><?php echo get_the_date( 'F j, Y' ); ?></span>
					</h2>
					<div class="x-post-carousel-meta">
						<!-- <span class="entry-cover-date"><?php echo get_the_date( 'F j, Y' ); ?></span> -->
						<span class="view"><?php _e( 'Read Story &raquo;', '__x__' ); ?></span>
					</div>
				</a>
			</article>

		<?php }

	}
endif;

// 04. Featured Index Content - Override
// =============================================================================

if ( ! function_exists( 'x_ethos_featured_index' ) ) :
  function x_ethos_featured_index() {

	$entry_id                    = get_the_ID();
	$index_featured_layout       = get_post_meta( $entry_id, '_x_ethos_index_featured_post_layout', true );
	$index_featured_size         = get_post_meta( $entry_id, '_x_ethos_index_featured_post_size', true );
	$index_featured_layout_class = ( $index_featured_layout == 'on' ) ? ' featured' : '';
	$index_featured_size_class   = ( $index_featured_layout == 'on' ) ? ' ' . strtolower( $index_featured_size ) : '';
	$is_index_featured_layout    = $index_featured_layout == 'on' && ! is_single();

	?>

	  <a href="<?php the_permalink(); ?>" class="entry-thumb<?php echo $index_featured_layout_class; echo $index_featured_size_class; ?>" style="<?php echo x_ethos_entry_cover_background_image_style(); ?>">
		<?php if ( $is_index_featured_layout ) : ?>
		  <span class="featured-meta"><?php echo x_ethos_post_categories(); ?> / <?php echo get_the_date( 'F j, Y' ); ?></span>
		  <h2 class="h-featured"><span><?php x_the_alternate_title(); ?></span></h2>
		  <span class="featured-view"><?php _e( 'Read Story', '__x__' ); ?></span>
		<?php else : ?>
		  <span class="view"><?php _e( 'Read Story', '__x__' ); ?></span>
		<?php endif; ?>
	  </a>

	<?php

  }
endif;

// 05. Admin Post Meta Boxes - Override
// =============================================================================

function newengineer_add_post_meta_boxes() {
	remove_action ( 'add_meta_boxes', 'x_add_post_meta_boxes' );
}

// add_action( 'add_meta_boxes', 'newengineer_add_post_meta_boxes', 8 );

// 06. Navbar Searchform Popup - Override
// =============================================================================

if ( ! function_exists( 'x_navbar_searchform_overlay' ) ) :
  function x_navbar_searchform_overlay() {

	if ( x_get_option( 'x_header_search_enable' ) == '1' ) :

	  ?>

		<div class="x-searchform-overlay">
			<div class="x-searchform-overlay-inner">
				<div class="x-container max width">
					<form method="get" id="searchform" class="form-search center-text" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label for="s" class="visually-hidden"><?php esc_html_e( 'Search', '__x__' ); ?></label>
						<input type="text" id="s" class="search-query cfc-h-tx center-text tt-upper" name="s" placeholder="<?php esc_attr_e( 'Search', '__x__' ); ?>">
						<button type="submit" class="btn-search">
							<span class="visually-hidden"><?php esc_html_e('Search', '__x__'); ?></span>
							<span><span class="x-icon-search" data-x-icon-s="&#xf002;" aria-hidden="true"></span><span class="x-hidden-desktop"> Search</span></span>
						</button>
					</form>
				</div>
			</div>
	  </div>

	  <?php

	endif;

  }
  add_action( 'x_before_site_end', 'x_navbar_searchform_overlay' );
endif;

// 07. Social Output - Override
// =============================================================================

if ( ! function_exists( 'x_social_global' ) ) :
	function x_social_global() {

		$facebook    = x_get_option( 'x_social_facebook' );
		$twitter     = x_get_option( 'x_social_twitter' );
		$google_plus = x_get_option( 'x_social_googleplus' );
		$linkedin    = x_get_option( 'x_social_linkedin' );
		$xing        = x_get_option( 'x_social_xing' );
		$foursquare  = x_get_option( 'x_social_foursquare' );
		$youtube     = x_get_option( 'x_social_youtube' );
		$vimeo       = x_get_option( 'x_social_vimeo' );
		$instagram   = x_get_option( 'x_social_instagram' );
		$pinterest   = x_get_option( 'x_social_pinterest' );
		$dribbble    = x_get_option( 'x_social_dribbble' );
		$flickr      = x_get_option( 'x_social_flickr' );
		$github      = x_get_option( 'x_social_github' );
		$behance     = x_get_option( 'x_social_behance' );
		$tumblr      = x_get_option( 'x_social_tumblr' );
		$whatsapp    = x_get_option( 'x_social_whatsapp' );
		$soundcloud  = x_get_option( 'x_social_soundcloud' );
		$rss         = x_get_option( 'x_social_rss' );

		$output = '<div class="x-social-global">';

		if ( $facebook )    : $output .= '<a href="' . $facebook    . '" class="facebook" title="Facebook" target="_blank"><span class="x-icon-facebook-square" data-x-icon-b="&#xf082;" aria-hidden="true"></span><span class="sr-only"> Facebook</span></a>'; endif;
		if ( $twitter )     : $output .= '<a href="' . $twitter     . '" class="twitter" title="Twitter" target="_blank"><span class="x-icon-twitter-square" data-x-icon-b="&#xf081;" aria-hidden="true"></span><span class="sr-only"> Twitter</span></a>'; endif;
		if ( $google_plus ) : $output .= '<a href="' . $google_plus . '" class="google-plus" title="Google+" target="_blank"><span class="x-icon-google-plus-square" data-x-icon-b="&#xf0d4;" aria-hidden="true"></span><span class="sr-only"> Google+</span></a>'; endif;
		if ( $linkedin )    : $output .= '<a href="' . $linkedin    . '" class="linkedin" title="LinkedIn" target="_blank"><span class="x-icon-linkedin-square" data-x-icon-b="&#xf08c;" aria-hidden="true" role="img"></span><span class="sr-only"> LinkedIn</span></a>'; endif;
		if ( $xing )        : $output .= '<a href="' . $xing        . '" class="xing" title="XING" target="_blank"><span class="x-icon-xing-square" data-x-icon-b="&#xf169;" aria-hidden="true"></span><span class="sr-only"> XING</span></a>'; endif;
		if ( $foursquare )  : $output .= '<a href="' . $foursquare  . '" class="foursquare" title="Foursquare" target="_blank"><span class="x-icon-foursquare" data-x-icon-b="&#xf180;" aria-hidden="true"></span><span class="sr-only"> Foursquare</span></a>'; endif;
		if ( $youtube )     : $output .= '<a href="' . $youtube     . '" class="youtube" title="YouTube" target="_blank"><span class="x-icon-youtube-square" data-x-icon-b="&#xf431;" aria-hidden="true"></span><span class="sr-only"> YouTube</span></a>'; endif;
		if ( $vimeo )       : $output .= '<a href="' . $vimeo       . '" class="vimeo" title="Vimeo" target="_blank"><span class="x-icon-vimeo-square" data-x-icon-b="&#xf194;" aria-hidden="true"></span><span class="sr-only"> Vimeo</span></a>'; endif;
		if ( $instagram )   : $output .= '<a href="' . $instagram   . '" class="instagram" title="Instagram" target="_blank"><span class="x-icon-instagram" data-x-icon-b="&#xf16d;" aria-hidden="true"></span><span class="sr-only"> Instagram</span></a>'; endif;
		if ( $pinterest )   : $output .= '<a href="' . $pinterest   . '" class="pinterest" title="Pinterest" target="_blank"><span class="x-icon-pinterest-square" data-x-icon-b="&#xf0d3;" aria-hidden="true"></span><span class="sr-only"> Pinterest</span></a>'; endif;
		if ( $dribbble )    : $output .= '<a href="' . $dribbble    . '" class="dribbble" title="Dribbble" target="_blank"><span class="x-icon-dribbble" data-x-icon-b="&#xf17d;" aria-hidden="true"></span><span class="sr-only"> Dribbble</span></a>'; endif;
		if ( $flickr )      : $output .= '<a href="' . $flickr      . '" class="flickr" title="Flickr" target="_blank"><span class="x-icon-flickr" data-x-icon-b="&#xf16e;" aria-hidden="true"></span><span class="sr-only"> Flickr</span></a>'; endif;
		if ( $github )      : $output .= '<a href="' . $github      . '" class="github" title="GitHub" target="_blank"><span class="x-icon-github-square" data-x-icon-b="&#xf092;" aria-hidden="true"></span><span class="sr-only"> GitHub</span></a>'; endif;
		if ( $behance )     : $output .= '<a href="' . $behance     . '" class="behance" title="Behance" target="_blank"><span class="x-icon-behance-square" data-x-icon-b="&#xf1b5;" aria-hidden="true"></span><span class="sr-only"> Behance</span></a>'; endif;
		if ( $tumblr )      : $output .= '<a href="' . $tumblr      . '" class="tumblr" title="Tumblr" target="_blank"><span class="x-icon-tumblr-square" data-x-icon-b="&#xf174;" aria-hidden="true"></span><span class="sr-only"> Tumblr</span></a>'; endif;
		if ( $whatsapp )    : $output .= '<a href="' . $whatsapp    . '" class="whatsapp" title="Whatsapp" target="_blank"><span class="x-icon-whatsapp" data-x-icon-b="&#xf232;" aria-hidden="true"></span><span class="sr-only"> Whatsapp</span></a>'; endif;
		if ( $soundcloud )  : $output .= '<a href="' . $soundcloud  . '" class="soundcloud" title="SoundCloud" target="_blank"><span class="x-icon-soundcloud" data-x-icon-b="&#xf1be;" aria-hidden="true"></span><span class="sr-only"> SoundCloud</span></a>'; endif;
		if ( $rss )         : $output .= '<a href="' . $rss         . '" class="rss" title="RSS" target="_blank"><span class="x-icon-rss-square" data-x-icon-s="&#xf143;" aria-hidden="true"></span><span class="sr-only"> RSS</span></a>'; endif;

		$output .= '</div>';

		echo $output;

		}
	endif;