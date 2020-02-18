<?php
/**
 *
 */

class ClassName
{

	private $post_data = array();
	private $conditions = array();

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load_model('M_Haji');
	}

	public function generate($post_data)
	{
		$this->set_post_data($post_data);

		$field_where = array();

		if ($this->get_conditions()) {

		}


	}

	public function get_conditions()
	{
		return $this->conditions;
	}

	private function get_condition($key)
	{
		if (isset($this->conditions[$key])) {
			return $this->conditions[$key];
		}

		return null;
	}

	private function get_color_hex($weight, $color1 = array(0, 159, 255), $color2 = array(236, 47, 75))
	{
		$w1 = $weight;
		$w2 = 1 - $w1;
		$rgb = [round($color1[0] * $w1 + $color2[0] * $w2),
		round($color1[1] * $w1 + $color2[1] * $w2),
		round($color1[2] * $w1 + $color2[2] * $w2)];

		$rgb = "rgb({$rgb[0]},{$rgb[1]},{$rgb[2]})";
		return $rgb;
	}

	private function is_condition()
	{
		return (bool) count($this->get_conditions());
	}

	private function set_post_data($pd)
	{
		$this->post_data = $pd;
	}

	private function print_table_top()
	{

	}

	private function print_table_left()
	{

	}

}
