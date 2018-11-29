<?php

// =============================================================================
// VIEWS/ETHOS/_LANDMARK-HEADER.PHP
// -----------------------------------------------------------------------------
// Handles content output of large headers for key pages such as the blog or
// search results.
// =============================================================================

$disable_page_title = get_post_meta( get_the_ID(), '_x_entry_disable_page_title', true );

?>

<?php if ( ! x_is_blank( 1 ) && ! x_is_blank( 2 ) && ! x_is_blank( 4 ) && ! x_is_blank( 5 ) ) : ?>
  <?php if ( is_page() && $disable_page_title == 'on' ) : ?>
  <?php else : ?>

    <?php if ( x_is_shop() || x_is_product() ) : ?>

      <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
        <h1 class="h-landmark" id="header-landmark"><?php echo x_get_option( 'x_ethos_shop_title' ); ?></h1>
      </header>

    <?php elseif ( x_is_bbpress() ) : ?>

      <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
        <h1 class="h-landmark" id="header-landmark"><?php echo get_the_title(); ?></h1>
      </header>

    <?php elseif ( x_is_buddypress() ) : ?>
      <?php if ( x_buddypress_is_component_with_landmark_header() ) : ?>

        <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
          <h1 class="h-landmark" id="header-landmark"><?php echo x_buddypress_get_the_title(); ?></h1>
        </header>

      <?php endif; ?>
    <?php elseif ( is_page() ) : ?>

      <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
        <h1 class="h-landmark entry-title"><?php the_title(); ?></h1>
      </header>

    <?php elseif ( x_is_portfolio_item() ) : ?>

      <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
        <h1 class="h-landmark" id="header-landmark"><?php the_title(); ?></h1>
      </header>

    <?php elseif ( is_search() ) : ?>

       <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
       <h1 class="h-landmark" id="header-landmark"><?php _e( 'Search Results for &ldquo;', '__x__' ); echo the_search_query(); echo '&rdquo;' ?></h1>
      </header>


    <?php elseif ( is_category() || x_is_portfolio_category() || x_is_product_category() ) : ?>

      <?php

      $meta  = x_get_taxonomy_meta();
      $title = ( $meta['archive-title'] != "" ) ? $meta['archive-title'] : __( single_cat_title("", false ), '__x__' );

      ?>

      <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
        <h1 class="h-landmark" id="header-landmark"><?php echo $title; ?></h1>
      </header>

    <?php elseif ( is_tag() || x_is_portfolio_tag() || x_is_product_tag() ) : ?>

      <?php

      $meta  = x_get_taxonomy_meta();
      $title = ( $meta['archive-title'] != '' ) ? $meta['archive-title'] : __( 'Tag Archive', '__x__' );

      ?>

      <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
        <h1 class="h-landmark" id="header-landmark"><?php echo $title ?></h1>
      </header>

    <?php elseif ( is_404() ) : ?>

      <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
        <h1 class="h-landmark" id="header-landmark"><?php _e( 'Page Not Found', '__x__' ); ?></h1>
      </header>

    <?php elseif ( is_year() ) : ?>

      <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
        <h1 class="h-landmark" id="header-landmark"><?php _e( 'Post Archive by Year', '__x__' ); ?></h1>
      </header>

    <?php elseif ( is_month() ) : ?>

      <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
        <h1 class="h-landmark" id="header-landmark"><?php _e( 'Post Archive by Month', '__x__' ); ?></h1>
      </header>

    <?php elseif ( is_day() ) : ?>

      <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
        <h1 class="h-landmark" id="header-landmark"><?php _e( 'Post Archive by Day', '__x__' ); ?></h1>
      </header>

    <?php elseif ( x_is_portfolio() ) : ?>

      <header class="x-header-landmark x-container max width" aria-labelledby="header-landmark">
        <h1 class="h-landmark" id="header-landmark"><?php echo x_get_option( 'x_portfolio_title' ); ?></h1>
      </header>

    <?php endif; ?>

  <?php endif; ?>
<?php endif; ?>