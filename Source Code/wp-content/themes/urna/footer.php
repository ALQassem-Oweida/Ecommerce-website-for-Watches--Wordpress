<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Urna
 * @since Urna 1.0
 */

$active_theme = urna_tbay_get_theme();
get_template_part('footer/'.$active_theme);
