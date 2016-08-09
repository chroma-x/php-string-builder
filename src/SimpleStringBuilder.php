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
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid.');
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
		$this->string = (string)$string . $this->string;
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
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid.');
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
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid.');
		}
		if (!is_int($length)) {
			$type = is_object($length) ? get_class($length) : gettype($length);
			throw new \InvalidArgumentException('Length invalid. Expected integer. Got ' . $type . '.');
		}
		if ($position + $length >= $this->length()) {
			throw new \InvalidArgumentException('Length invalid.');
		}
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
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
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid.');
		}
		if (!is_scalar($string)) {
			$type = is_object($string) ? get_class($string) : gettype($string);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		if (mb_strlen((string)$string) !== 1) {
			throw new \InvalidArgumentException('Expected a scalar value of length 1.');
		}
		$this->string = mb_substr($this->string, 0, $position) . (string)$string . mb_substr($this->string, $position + 1);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function reverse()
	{
		$length = $this->length();
		$reversed = '';
		while ($length-- > 0) {
			$reversed .= mb_substr($this->string, $length, 1, mb_detect_encoding($this->string));
		}
		$this->string = $reversed;
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
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid.');
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
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid.');
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
		if (mb_strlen((string)$string) === 0) {
			throw new \InvalidArgumentException('Empty string is invalid.');
		}
		if (!is_int($offset)) {
			$type = is_object($offset) ? get_class($offset) : gettype($offset);
			throw new \InvalidArgumentException('Offset invalid. Expected integer. Got ' . $type . '.');
		}
		$index = mb_strpos($this->string, (string)$string, $offset);
		return $index === false ? null : $index;
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
		$index = mb_strrpos($this->string, (string)$string, $offset);
		return $index === false ? null : $index;
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
		return mb_strlen($this->string, mb_detect_encoding($this->string));
	}

	/**
	 * @param int $startPosition
	 * @param int $length
	 * @return string
	 */
	public function buildSubstring($startPosition, $length = null)
	{
		if ($startPosition > $this->length()) {
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
