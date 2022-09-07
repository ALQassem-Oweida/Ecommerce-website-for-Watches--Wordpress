<?php
if (!defined('URNA_CORE_ACTIVED')) {
    return;
}

class Urna_Widget_Yith_Brand_Images extends Urna_Widget
{
    public function __construct()
    {
        parent::__construct(
            'urna_product_brand',
            esc_html__('Urna Product Brand Images', 'urna'),
            array( 'description' => esc_html__('Show YITH product brand images(Only applicable to product single pages)', 'urna'), )
        );
        $this->widgetName = 'urna_product_brand';
    }
 
    public function getTemplate()
    {
        $this->template = 'product-brand-image.php';
    }

    public function widget($args, $instance)
    {
        $this->display($args, $instance);
    }
    
    public function form($instance)
    {
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();

        return $instance;
    }
}
