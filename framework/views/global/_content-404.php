<?php

// =============================================================================
// VIEWS/GLOBAL/_CONTENT-404.PHP
// -----------------------------------------------------------------------------
// Output for the 404 page.
// =============================================================================

?>
<p><?php _e( 'Sorry, the page you are looking for doesn\'t appear to exist (or may have moved). You can search or browse some of the links below:', '__x__' ); ?></p>
<?php get_search_form(); ?>
<ul>
	<li><a href="<?php echo home_url(); ?>">Home</a></li>
	<?php wp_list_categories( array(
        'title_li' => '',
        'orderby'    => 'posts',
        'order'		=> 'DESC',
        'include'    => array( 93, 95, 97, 99, 5, 7 )
    ) ); ?> 
</ul>
<p><?php _e( 'Want to let us know about this error? <a href="mailto:webmaster@eng.ufl.edu?Subject=Page not found">Contact the webmaster</a>', '__x__' ); ?></p>