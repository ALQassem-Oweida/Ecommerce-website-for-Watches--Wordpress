<div class="popupnewsletter">
    <!-- Modal -->
    <div class="modal fade" id="popupNewsletterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup-newsletter-widget widget-newletter">
                        <?php
                            $bg = !empty($image) ? 'style="background-image: url( '. $image .')"' : '';
                        ?>
                        <div class="popup-content" <?php echo trim($bg); ?>>
                            <a href="javascript:void(0);" data-dismiss="modal"><i class="linear-icon-cross"></i></a>
                            <?php if (!empty($description)) { ?>
                                <p class="description">
                                    <?php echo trim($description); ?>
                                </p>
                            <?php } ?> 
                            <?php if (!empty($title)) { ?>
                                <h3>
                                    <span><?php echo trim($title); ?></span>
                                </h3>
                            <?php } ?>   
                            <?php
                                if (function_exists('mc4wp_show_form')) {
                                    try {
                                        $form = mc4wp_get_form();
                                        echo do_shortcode('[mc4wp_form id="'. $form->ID .'"]');
                                    } catch (Exception $e) {
                                        esc_html_e('Please create a newsletter form from Mailchip plugins', 'urna');
                                    }
                                }
                            ?>
                            <?php if (isset($socials) && is_array($socials)) { ?>
                            <ul class="social list-inline style2">
                                <?php foreach ($socials as $key=>$social):
                                        if (isset($social['status']) && !empty($social['page_url'])): ?>
                                            <li>
                                                <a href="<?php echo esc_url($social['page_url']);?>" class="<?php echo esc_attr($key); ?>">
                                                    <i class="zmdi zmdi-<?php echo esc_attr($key); ?>"></i><span class="hidden"><?php echo esc_html($social['name']); ?></span>
                                                </a>
                                            </li>
                                <?php
                                        endif;
                                    endforeach;
                                ?>
                            </ul>
                            <?php } ?>
                            <span data-dismiss="modal"><?php esc_html_e('No, I’m not interested.', 'urna'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>