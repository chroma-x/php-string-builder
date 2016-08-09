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
	 * @var string
	 */
	private $string;

	/**
	 * SimpleStringBuilder constructor.
	 *
	 * @param null $string
	 */
	public function __construct($string = null)
	{
		if (!is_null($string)) {
			if (!is_scalar($string)) {
				$type = is_object($string) ? get_class($string) : gettype($string);
				throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
			}
			$this->string = (string)$string;
		}
	}

	/**
	 * @param int $position
	 * @return string
	 */
	public function charAt($position)
	{
		if (!is_int($position)) {
			$type = is_object($position) ? get_class($position) : gettype($position);
			throw new \InvalidArgumentException('Position invalid. Expected integer. Got ' . $type . '.');
		}
		if ($position > $this->length()) {
			return null;
		}
		return mb_substr($this->string, $position, 1);
	}

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
		$this->string .= (string)$string;
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
		$this->string = $this->string . (string)$string;
		return $this;
	}

	/**
	 * @param int $position
	 * @param string $string
	 * @return $this
	 */
	public function insert($position, $string)
	{
		if (!is_int($position)) {
			$type = is_object($position) ? get_class($position) : gettype($position);
			throw new \InvalidArgumentException('Position invalid. Expected integer. Got ' . $type . '.');
		}
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		if ($position > $this->length()) {
			$position = $this->length();
		}
		$this->string = mb_substr($this->string, 0, $position) . (string)$string . mb_substr($this->string, $position);
		return $this;
	}

	/**
	 * @param int $position
	 * @param int $length
	 * @param string $string
	 * @return $this
	 */
	public function replace($position, $length, $string)
	{
		if (!is_int($position)) {
			$type = is_object($position) ? get_class($position) : gettype($position);
			throw new \InvalidArgumentException('Position invalid. Expected integer. Got ' . $type . '.');
		}
		if (!is_int($length)) {
			$type = is_object($length) ? get_class($length) : gettype($length);
			throw new \InvalidArgumentException('Length invalid. Expected integer. Got ' . $type . '.');
		}
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		if ($position > $this->length()) {
			$position = $this->length();
		}
		$this->string = mb_substr($this->string, 0, $position) . (string)$string . mb_substr($this->string, $position + $length);
		return $this;
	}

	/**
	 * @param int $position
	 * @param string $string
	 * @return $this
	 */
	public function setCharAt($position, $string)
	{
		if (!is_int($position)) {
			$type = is_object($position) ? get_class($position) : gettype($position);
			throw new \InvalidArgumentException('Position invalid. Expected integer. Got ' . $type . '.');
		}
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		$this->string = mb_substr($this->string, 0, $position) . (string)$string . mb_substr($this->string, $position + 1);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function reverse()
	{
		$this->string = strrev($this->string);
		return $this;
	}

	/**
	 * @param int $position
	 * @param int $length
	 * @return $this
	 */
	public function delete($position, $length = null)
	{
		if (!is_int($position)) {
			$type = is_object($position) ? get_class($position) : gettype($position);
			throw new \InvalidArgumentException('Position invalid. Expected integer. Got ' . $type . '.');
		}
		if (!is_int($length) && !is_null($length)) {
			$type = is_object($length) ? get_class($length) : gettype($length);
			throw new \InvalidArgumentException('Length invalid. Expected integer. Got ' . $type . '.');
		}
		if ($position > $this->length()) {
			return $this;
		}
		if (is_null($length)) {
			$this->string = mb_substr($this->string, 0, $position);
		} else {
			$this->string = mb_substr($this->string, 0, $position) . mb_substr($this->string, $position + $length);
		}
		return $this;
	}

	/**
	 * @param int $position
	 * @return $this
	 */
	public function deleteCharAt($position)
	{
		if (!is_int($position)) {
			$type = is_object($position) ? get_class($position) : gettype($position);
			throw new \InvalidArgumentException('Position invalid. Expected integer. Got ' . $type . '.');
		}
		if ($position > $this->length()) {
			return $this;
		}
		$this->string = mb_substr($this->string, 0, $position) . mb_substr($this->string, $position + 1);
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
		return strpos($this->string, (string)$string) !== false;
	}

	/**
	 * @param string $string
	 * @param int $offset
	 * @return int
	 */
	public function indexOf($string, $offset = 0)
	{
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		if (!is_int($offset)) {
			$type = is_object($offset) ? get_class($offset) : gettype($offset);
			throw new \InvalidArgumentException('Offset invalid. Expected integer. Got ' . $type . '.');
		}
		return strpos($this->string, (string)$string, $offset);
	}

	/**
	 * @param string $string
	 * @param int $offset
	 * @return int
	 */
	public function lastIndexOf($string, $offset = 0)
	{
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		if (!is_int($offset)) {
			$type = is_object($offset) ? get_class($offset) : gettype($offset);
			throw new \InvalidArgumentException('Offset invalid. Expected integer. Got ' . $type . '.');
		}
		return strrpos($this->string, (string)$string, $offset);
	}

	/**
	 * @return int
	 */
	public function size()
	{
		return strlen($this->string);
	}

	/**
	 * @return int
	 */
	public function length()
	{
		return mb_strlen($this->string);
	}

	/**
	 * @param int $startPosition
	 * @param int $length
	 * @return string
	 */
	public function buildSubstring($startPosition, $length = null)
	{
		if ($this->length() > $startPosition) {
			throw new \InvalidArgumentException('Start position ' . (string)$startPosition . ' invalid.');
		}
		if (!is_int($length) && !is_null($length)) {
			$type = is_object($length) ? get_class($length) : gettype($length);
			throw new \InvalidArgumentException('Length invalid. Expected integer. Got ' . $type . '.');
		}
		if (is_null($length)) {
			return mb_substr($this->string, $startPosition);
		} else {
			return mb_substr($this->string, $startPosition, $length);
		}
	}

	/**
	 * @return string
	 */
	public function build()
	{
		return $this->string;
	}

}
