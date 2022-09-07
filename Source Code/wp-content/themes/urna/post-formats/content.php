<?php
/**
 *
 * The default template for displaying content
 * @since 1.0
 * @version 1.2.0
 *
 */

$columns					= urna_tbay_blog_loop_columns('');
$date 						= urna_tbay_get_boolean_query_var('enable_date');
$author 					= urna_tbay_get_boolean_query_var('enable_author');
$categories 				= urna_tbay_get_boolean_query_var('enable_categories');
$cat_type 					= urna_tbay_categories_blog_type();
$comment 					= urna_tbay_get_boolean_query_var('enable_comment');
$short_descriptions 		= urna_tbay_get_boolean_query_var('enable_short_descriptions');
$read_more 					= urna_tbay_get_boolean_query_var('enable_readmore');

$image_position   			= apply_filters('urna_archive_image_position', 10, 2);

$class_main = $class_left = '';
if ($image_position == 'left') {
    $class_main = 'row';
    $class_left = ' col-md-6';
}

$class_blog = ($columns > 1) ? 'post-grid' : 'post-list';
?>
<!-- /post-standard -->
<?php if (! is_single()) : ?>
<div  class="<?php echo esc_attr($class_blog); ?> clearfix position-image-<?php echo esc_attr($class_main); ?>">
<?php endif; ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class($class_main); ?>>
<?php if (is_single()) : ?>
	<div class="entry-single">
<?php endif; ?>
		
        <?php
            if (is_single()) : ?>
				
	        	<div class="entry-header">
	        		<?php
                        if (get_the_title()) {
                            ?>
		                    <h1 class="entry-title">
		                       <?php the_title(); ?>
		                    </h1>
		                <?php
                        }
                    ?>

				    <?php urna_post_meta(array(
                        'date'     => 1,
                        'author'   => 1,
                        'comments' => 1,
                        'tags'     => 0,
                        'cats'     => 1,
                        'edit'     => 0,
                    )); ?>
		            
		            <?php
                        urna_tbay_post_share_box();
                    ?>
				</div>
				<?php
                if (has_post_thumbnail()) {
                    ?>
					<figure class="entry-thumb <?php echo(!has_post_thumbnail() ? 'no-thumb' : ''); ?>">

						<?php urna_tbay_post_thumbnail(); ?>
					</figure>
					<?php
                }
                ?>
				<div class="post-excerpt entry-content">
					 

					<?php the_content(esc_html__('Continue reading', 'urna')); ?>

					<?php do_action('urna_tbay_post_bottom') ?>
					
				</div><!-- /entry-content -->

				<?php
                    wp_link_pages(array(
                        'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'urna') . '</span>',
                        'after'       => '</div>',
                        'link_before' => '<span>',
                        'link_after'  => '</span>',
                        'pagelink'    => '<span class="screen-reader-text">' . esc_html__('Page', 'urna') . ' </span>%',
                        'separator'   => '<span class="screen-reader-text">, </span>',
                    ));
                ?>
		<?php endif; ?>
		
		
    	<?php if (! is_single()) : ?>

			<?php
                if (has_post_thumbnail()) {
                    ?>
			  	<figure class="entry-thumb <?php echo esc_attr($class_left); ?> <?php echo(!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
			   		<?php urna_tbay_post_thumbnail(); ?>
			  	</figure>
			  	<?php
                }
            ?>
			<div class="entry-content <?php echo esc_attr($class_left); ?> <?php echo (!has_post_thumbnail()) ? 'no-thumb' : ''; ?>">

				<div class="entry-header">
					
					<?php if ($categories) { ?>
						<span class="entry-category <?php echo esc_attr($cat_type) ?>">
						<?php if ($cat_type == 'type-1') {
                urna_the_post_category_full(false);
            } else { ?>
							<i class="linear-icon-tag"></i><?php esc_html_e('Categories: ', 'urna') . urna_the_post_category_full();
                        } ?>
						</span>
					<?php } ?>

					<?php urna_post_archive_the_title(); ?>

				    <?php urna_post_meta(array(
                        'date'     => $date,
                        'author'     => $author,
                        'comments' => $comment,
                        'tags'     => 0,
                        'cats'     => 0,
                        'edit'     => 0,
                    )); ?>

					<?php if ($short_descriptions) : ?>
						<?php urna_post_archive_the_short_description(); ?>
					<?php endif; ?>

					<?php if ($read_more) : ?>
						<?php urna_post_archive_the_read_more(); ?>
					<?php endif; ?>

			    </div>

			</div>

    	<?php endif; ?>
    <?php if (is_single()) : ?>
</div>
<?php endif; ?>
</article>

<?php if (! is_single()) : ?>
</div>
<?php endif; ?>