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

	/**
	 * @var array
	 */
	private $strings = array();

	/**
	 * @param string $string
	 * @return $this
	 */
	public function append($string)
	{
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		$this->strings[] = (string)$string;
		return $this;
	}

	/**
	 * @param string $string
	 * @return $this
	 */
	public function prepend($string)
	{
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		array_unshift($this->strings, (string)$string);
		return $this;
	}

	/**
	 * @param int $position
	 * @param string $string
	 * @return $this
	 */
	public function replace($position, $string)
	{
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		if (!isset($this->strings[$position])) {
			throw new \InvalidArgumentException('Position ' . (string)$position . ' invalid.');
		}
		array_splice($this->strings, $position, 1, (string)$string);
		return $this;
	}

	/**
	 * @param int $position
	 * @return $this
	 */
	public function remove($position)
	{
		if (!isset($this->strings[$position])) {
			throw new \InvalidArgumentException('Position ' . (string)$position . ' invalid.');
		}
		array_splice($this->strings, $position, 1);
		return $this;
	}

	/**
	 * @param string $string
	 * @return bool
	 */
	public function contains($string)
	{
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		for ($i = 0, $n = $this->size(); $i < $n; $i++) {
			if ($this->strings[$i] === (string)$string) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param string $string
	 * @return bool
	 */
	public function stringContains($string)
	{
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		return strpos($this->build(), (string)$string) !== false;
	}

	/**
	 * @return int
	 */
	public function size()
	{
		return count($this->strings);
	}

	/**
	 * @return int
	 */
	public function length()
	{
		return mb_strlen($this->build());
	}

	/**
	 * @param int $startPosition
	 * @param int $size
	 * @return string
	 */
	public function buildSubstring($startPosition, $size = null)
	{
		if (!isset($this->strings[$startPosition])) {
			throw new \InvalidArgumentException('Start position ' . (string)$startPosition . ' invalid.');
		}
		if (!is_int($size) && !is_null($size)) {
			$type = is_object($size) ? get_class($size) : gettype($size);
			throw new \InvalidArgumentException('Length invalid. Expected integer. Got ' . $type . '.');
		}
		return implode('', array_slice($this->strings, $startPosition, $size));
	}

	/**
	 * @return string
	 */
	public function build()
	{
		return implode('', $this->strings);
	}

}
