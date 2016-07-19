<?php

namespace Markenwerk\SimpleStringBuilder;

/**
 * Class SimpleStringBuilder
 *
 * Simple string builder utility
 *
 * @package Markenwerk\SimpleStringBuilder
 */
class SimpleStringBuilder
{

	private $string = '';

	/**
	 * @param string $string
	 * @return $this
	 */
	public function append($string)
	{
		$this->string .= (string)$string;
		return $this;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		return $this->string;
	}

}
