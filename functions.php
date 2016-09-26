<?php

// =============================================================================
// FUNCTIONS.PHP
// -----------------------------------------------------------------------------
// Overwrite or add your own custom functions to X in this file.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Enqueue Parent Stylesheet
//   02. Entry Meta
//   03. Entry Cover
//   04. Featured Index Content
// =============================================================================

// Enqueue Parent Stylesheet
// =============================================================================

add_filter( 'x_enqueue_parent_stylesheet', '__return_true' );


// Entry Meta
// =============================================================================

if ( ! function_exists( 'x_ethos_entry_meta' ) ) :
	function x_ethos_entry_meta() {

		//
		// Author.
		//
 
		// $author = sprintf( ' %1$s %2$s</span>',
		//   __( 'by', '__x__' ),
		//   get_the_author()

		// );

			 // $author = '</span>';

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


// Entry Cover
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

// Featured Index Content
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
