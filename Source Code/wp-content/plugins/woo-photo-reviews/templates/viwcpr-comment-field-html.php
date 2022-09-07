<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( empty($comment_form)  || empty( $settings ) ) {
	return;
}
global $product;
$max                       = $settings->get_params( 'photo', 'maxsize' );
$max_files                 = 2;
if ('on' == $settings->get_params( 'photo', 'enable' )){
	?>
	<div class="wcpr-comment-form-images">
		<label for="wcpr_image_upload">
			<?php
			esc_html_e( 'Choose pictures', 'woo-photo-reviews' );
			if ( $settings->get_params( 'photo', 'required' ) == 'on' ) {
				?>
				<span class="required">*</span>
				<?php
			}
			printf(esc_html__(' (maxsize: %skB, max files: 2)', 'woo-photo-reviews'), esc_attr($max));
			?>
		</label>
		<div class="wcpr-input-file-container">
			<div class="wcpr-input-file-wrap">
				<input type="file" name="wcpr_image_upload[]" id="wcpr_image_upload" class="wcpr_image_upload" multiple accept=".jpg, .jpeg, .png, .bmp, .webp, .gif"/>
				<div class="wcpr-selected-image-container"></div>
			</div>
		</div>
	</div>
	<?php
}
if ( $settings->get_params( 'photo', 'gdpr' ) === 'on' ) {
	printf('<p class="wcpr-gdpr-policy"><input type="checkbox" name="wcpr_gdpr_checkbox" id="wcpr_gdpr_checkbox"><label for="wcpr_gdpr_checkbox">%s</label></p>',
		wp_kses_post($settings->get_params( 'photo', 'gdpr_message' )) ?: esc_html__( 'I agree with the term and condition.', 'woo-photo-reviews' ) );
}
?>