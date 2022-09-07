<?php
extract($args);
extract($instance);
$title = apply_filters('widget_title', $instance['title']);

if ($title) {
    echo trim($before_title)  . trim($title) . $after_title;
}
$query = new WP_Query(array(
    'post_type'=>'post',
    'post__in' => $ids
));

if (isset($instance['styles'])) {
    $styles = $instance['styles'];
}

if ($query->have_posts()) {
    ?>
	<?php if (isset($styles) && $styles == 'vertical') : ?>

		<div class="post-widget media-post-layout widget-content <?php echo esc_attr($styles); ?>">
			<?php while ($query->have_posts()): $query->the_post(); ?>
				<article class="item-post media">
					<?php
                    if (has_post_thumbnail()) {
                        ?>
					  	<figure class="entry-thumb <?php echo(!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
							<a href="<?php the_permalink(); ?>" aria-hidden="true">
							<?php
                                the_post_thumbnail('full', array( 'alt' => get_the_title() )); ?>
							</a>
					  	</figure>
				  	<?php
                    } ?>
					<div class="entry-header">
						<ul class="entry-meta-list">
							<li class="author"><?php echo get_avatar(urna_tbay_get_id_author_post(), 'urna_avatar_post_carousel'); ?> <?php the_author_posts_link(); ?></li>

							<li class="entry-date"><?php echo urna_time_link(); ?></li>

							<?php if (! post_password_required() && (comments_open() || get_comments_number())) : ?>
								<li class="comments-link"><i class="icons icon-bubbles"></i> <?php comments_popup_link('0', '1', esc_html__('% comments', 'urna')); ?></li>
							<?php endif; ?>

							<li class="entry-category">
					            <i class="icons icon-folder"></i>
					            <?php urna_tbay_get_random_blog_cat(); ?>
					      	</li>
							<li class="post-type"><?php urna_tbay_icon_post_formats(); ?></li>
						</ul>
					</div>
				    <div class="entry-content <?php echo (!has_post_thumbnail()) ? 'no-thumb' : ''; ?>">
				    	<div class="entry-meta">
				            <?php
                                if (get_the_title()) {
                                    ?>
				                    <h3 class="entry-title">
				                       <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				                    </h3>
				                <?php
                                } ?>
				        </div>
				    </div>
				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>

	<?php elseif (isset($styles) && $styles == 'horizontal') : ?>

		<div class="post-widget media-post-layout widget-content <?php echo esc_attr($styles); ?>">
			<?php while ($query->have_posts()): $query->the_post(); ?>
				<article class="item-post media row">
					<?php
                    if (has_post_thumbnail()) {
                        ?>
					<div class="col-sm-6">
					  	<figure class="entry-thumb <?php echo(!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
							<a href="<?php the_permalink(); ?>" aria-hidden="true">
							<?php
                                the_post_thumbnail('full', array( 'alt' => get_the_title() )); ?>
							</a>
					  	</figure>
					</div>  	
				  	<?php
                    } ?>
					<div class="col-sm-6">
						<div class="entry-content">
							<div class="entry-header">
								<?php
                                    if (get_the_title()) {
                                        ?>
					                    <h3 class="entry-title">
					                       <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					                    </h3>
					                <?php
                                    } ?>
								<ul class="entry-meta-list">
									<li class="author"><?php echo get_avatar(urna_tbay_get_id_author_post(), 'urna_avatar_post_carousel'); ?> <?php the_author_posts_link(); ?></li>

									<li class="entry-date"><?php echo urna_time_link(); ?></li>

									<?php if (! post_password_required() && (comments_open() || get_comments_number())) : ?>
										<li class="comments-link"><i class="icons icon-bubbles"></i> <?php comments_popup_link('0', '1', esc_html__('% comments', 'urna')); ?></li>
									<?php endif; ?>

									<li class="entry-category">
							            <i class="icons icon-folder"></i>
							            <?php urna_tbay_get_random_blog_cat(); ?>
							      	</li>
									<li class="post-type"><?php urna_tbay_icon_post_formats(); ?></li>
								</ul>
							</div>
					    	<div class="entry-description"><?php echo urna_tbay_substring(get_the_content(), 40, ''); ?>
					    	</div>
					    </div>	
					</div>    
				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>

	<?php endif; ?>
	
<?php
} ?>
