<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Urna
 * @since Urna 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="//gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="tbay-customize-header" class="wrapper-container">
	<?php
        // Start the Loop.
        while (have_posts()) : the_post();
            the_content();
        // End the loop.
        endwhile;
    ?>
	<div id="nav-cover"></div>
	<div class="bg-close-canvas-menu"></div>
</div>
<?php wp_footer(); ?>
</body>
</html>