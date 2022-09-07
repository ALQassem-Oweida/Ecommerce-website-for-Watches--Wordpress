<?php

$columns = isset($columns) ? $columns : 4;

$count = 0;

?>
<?php
     foreach ($all_categories as $cat) {
         $cat_id 	= 	$cat->term_id;
         $cat_name 	= 	$cat->name;
         $cat_slug 	= 	$cat->slug;
         $cat_count 		= 	$cat->count;

         $thumbnail_id = get_term_meta($cat_id, 'thumbnail_id', true);
         $image = wp_get_attachment_url($thumbnail_id); ?> 

			<div class="item">
				<?php wc_get_template('item-categories/cat.php', array('cat'=> $cat)); ?>
			</div>
		<?php
        $count++; ?>
        <?php
     }
?>

<?php wp_reset_postdata(); ?>