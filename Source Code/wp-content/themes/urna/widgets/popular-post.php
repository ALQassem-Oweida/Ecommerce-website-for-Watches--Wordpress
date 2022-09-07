<?php
extract($args);
extract($instance);
$title = apply_filters('widget_title', $instance['title']);

if ($title) {
    echo trim($before_title)  . trim($title) . $after_title;
}

if (isset($instance['styles'])) {
    $styles = $instance['styles'];
}

$args = array(
    'post_type' => 'post',
    'meta_key' => 'urna_post_views_count',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    'posts_per_page' => $number_post
);
$current_theme = urna_tbay_get_theme();
$query = new WP_Query($args);
if ($query->have_posts()): ?>
	<div class="post-widget media-post-layout widget-content <?php echo esc_attr($styles); ?>">
		<ul class="posts-list">
		<?php
            while ($query->have_posts()):$query->the_post();
        ?>
			<li>
				<article class="post post-list">

				    <div class="entry-content media">

				        <?php
                        if (has_post_thumbnail()) {
                            ?>
				              <div class="media-left">
				                <figure class="entry-thumb">
				                    <a href="<?php the_permalink(); ?>" class="entry-image">
				                        <?php the_post_thumbnail('widget'); ?>
				                    </a>  
				                </figure>
				              </div>
				            <?php
                        }
                        ?>
				        <div class="media-body">
				          	<?php
                              if (get_the_title()) {
                                  ?>
				                  <h4 class="entry-title">
				                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				                  </h4>
				              <?php
                              }
                              ?>

			          		<div class="entry-content-inner clearfix">
			                   	<ul class="entry-meta-list">
			                      	<li class="entry-date"><?php echo urna_time_link(); ?></li>
			                      
									<li class="entry-view"><i class="icon-eye icons"></i> 
			                      		<?php echo urna_get_post_views(get_the_ID()); ?>
			                      	</li>
			                  	</ul>
				          	</div>
				        </div>
				    </div>
				</article>
			</li>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
		</ul>
	</div>

<?php endif; ?>
