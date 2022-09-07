<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage urna
 * @since urna 2.1.6
 */


$sidebar = tbay_get_sidebar_dokan();

if (!isset($sidebar['id']) || empty($sidebar['id'])) {
    return;
}

?> <div class="tbay-sidebar-vendor sidebar"><?php dynamic_sidebar($sidebar['id']); ?></div>