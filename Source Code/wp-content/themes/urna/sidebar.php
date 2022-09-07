<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Urna
 * @since Urna 1.0
 */

if (class_exists('WeDevs_Dokan') && !urna_dokan_theme_store_sidebar()) {
    return;
}

if (has_nav_menu('primary')) : ?>
	<div id="secondary" class="secondary">

		<?php if (has_nav_menu('primary')) : ?>
			<nav id="site-navigation" class="main-navigation">
				<?php
                    // Primary navigation menu.
                    wp_nav_menu(array(
                        'menu_class'     => 'nav-menu',
                        'theme_location' => 'primary',
                    ));
                ?>
			</nav><!-- .main-navigation -->
		<?php endif; ?>

	</div><!-- .secondary -->

<?php endif; ?>
