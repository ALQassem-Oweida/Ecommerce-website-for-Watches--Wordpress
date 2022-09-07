<?php
/**
 * widget base for Urna Core
 *
 * @package    urna-core
 * @author     Team Thembays <tbaythemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  2015-2016 Urna Core
 */

abstract class Urna_Widget extends WP_Widget {
	
	public $template;
	abstract function getTemplate();

	public function display( $args, $instance ) {
		$this->getTemplate();
		extract($args);
		extract($instance);
		echo $before_widget;
			require urna_core_get_widget_locate( $this->template );
		echo $after_widget;
	}
}