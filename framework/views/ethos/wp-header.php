<?php

// =============================================================================
// VIEWS/ETHOS/WP-HEADER.PHP
// -----------------------------------------------------------------------------
// Header output for Ethos.
// =============================================================================

?>

<?php x_get_view( 'global', '_header' ); ?>

  <?php x_get_view( 'global', '_slider-above' ); ?>

  <header class="<?php x_masthead_class(); ?>" role="banner">
    <?php x_get_view( 'global', '_topbar' ); ?>
    <?php x_get_view( 'global', '_navbar' ); ?>
    <?php x_get_view( 'ethos', '_breadcrumbs' ); ?>
  </header>

  <?php x_get_view( 'global', '_slider-below' ); ?>
  <?php x_get_view( 'ethos', '_landmark-header' ); ?>

 <?php if (is_front_page()): ?>
  <?php x_get_view( 'ethos', '_post', 'slider' );   // show post slider on home page ?>
  <?php x_get_view( 'ethos', '_post', 'carousel' ); // show post carousel on home page ?>
<?php endif; ?>