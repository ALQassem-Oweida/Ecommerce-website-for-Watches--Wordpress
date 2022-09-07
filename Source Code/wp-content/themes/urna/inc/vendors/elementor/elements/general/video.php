<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_video')) {
    exit; // Exit if accessed directly.
}
use Elementor\Controls_Manager;

class Urna_Elementor_video extends Urna_Elementor_Widget_Base
{
    public function get_name()
    {
        return 'tbay-video';
    }

    public function get_title()
    {
        return esc_html__('Urna Video', 'urna');
    }

    public function get_script_depends()
    {
        return [ 'slick', 'urna-slick' ];
    }

    public function get_icon()
    {
        return 'eicon-youtube';
    }

    protected function register_controls()
    {
        $this->register_controls_heading();
        $this->register_remove_heading_element();

        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('General', 'urna'),
            ]
        );

        $this->add_control(
            'video_image',
            [
                'label'     => esc_html__('Choose Image', 'urna'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url'   => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'video_url',
            [
                'label' => esc_html__('Video URL', 'urna'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter the video url at https://vimeo.com/ or https://www.youtube.com/', 'urna'),
                'default' => 'https://youtu.be/Im2q_ri-7AM',
                'label_block' => true,
            ]
        );

        
        $this->end_controls_section();
    }

    public function the_video_content()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $video = urna_tbay_VideoUrlType($video_url);

        if ($video['video_type'] == 'youtube') {
            $url  = 'https://www.youtube.com/embed/'.$video['video_id'].'?autoplay=1';
        } elseif (($video['video_type'] == 'vimeo')) {
            $url = 'https://player.vimeo.com/video/'.$video['video_id'].'?autoplay=1';
        }

        $_id = urna_tbay_random_key();
        $image_id       = $video_image['id'];
        $img            = wp_get_attachment_image_src($image_id, 'full');

        $icon = '<i class="zmdi zmdi-play"></i>';
        
        if (!empty($video_url) && (!empty($img) && isset($img[0]))) : ?>

        <div class="tbay-addon-content">

            <?php if (!empty($img) && isset($img[0])): ?>
                <div class="video-image">
                   <?php echo wp_get_attachment_image($image_id, 'full', false); ?>
                </div>
            <?php endif; ?>

          <div class="modal fade tbay-video-modal" data-id="<?php echo esc_attr($_id); ?>" id="video-modal-<?php echo esc_attr($_id); ?>">
            <div class="modal-dialog">
                <div class="modal-content tbay-modalContent">

                <div class="modal-body">
                    
                    <div class="close-button">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"></iframe>
                    </div>
                </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div class="main-content">
                
                <?php if (!empty($heading_title)) : ?>
                    <<?php echo trim($heading_title_tag); ?> class="tbay-addon-title">
                        <span class="title"><?php echo esc_html($heading_title); ?></span>

                        <?php if (!empty($heading_subtitle)) : ?>
                            <span class="subtitle"><?php echo trim($heading_subtitle); ?></span>
                        <?php endif; ?>
                    </<?php echo trim($heading_title_tag); ?>>
                <?php endif; ?>

                <button type="button" class="tbay-modalButton" data-toggle="modal" data-tbaySrc="<?php echo esc_attr($url); ?>" data-tbayWidth="640" data-tbayHeight="480" data-target="#video-modal-<?php echo esc_attr($_id); ?>"  data-tbayVideoFullscreen="true"><?php echo trim($icon); ?></button>
            </div>

        </div>

        <?php endif;
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_video());
