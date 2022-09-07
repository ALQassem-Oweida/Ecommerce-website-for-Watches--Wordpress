<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Urna
 * @since Urna 1.0
 */
/*

*Template Name: 404 Page
*/
get_header();
$custom_link	= urna_tbay_get_config('contact_select');

$url_link = get_the_permalink($custom_link);
?>

<section id="main-container" class=" container inner">
	<div id="main-content" class="main-page page-404">

		<section class="error-404 text-center">
			<h1><?php esc_html_e('Page not found.', 'urna'); ?></h1>
			<div class="page-content">
				<p class="sub-title"><?php esc_html_e('We’re very sorry but the page you are looking for doesn’t exist or has been moved. Please back to homepage or contact us if It’s mistake.', 'urna'); ?></p>
				<div class="group">
					<a class="backtohome" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('home page', 'urna'); ?></a>
					<a class="contactus" href="<?php echo esc_url($url_link); ?>"><?php esc_html_e('contact us', 'urna'); ?></a>
				</div>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->
	</div>
</section>

<?php get_footer(); ?>