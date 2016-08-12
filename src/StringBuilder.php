<?php

namespace Markenwerk\StringBuilder;

/**
 * Class StringBuilder
 *
 * @package Markenwerk\StringBuilder
 */
class StringBuilder
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
			$this->validateScalar($string);
			$this->string = (string)$string;
		}
	}

	/**
	 * @param int $position
	 * @return string
	 */
	public function charAt($position)
	{
		$this->validateInteger($position);
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
		$this->validateScalar($string);
		$this->string .= (string)$string;
		return $this;
	}

	/**
	 * @param string $string
	 * @return $this
	 */
	public function prepend($string)
	{
		$this->validateScalar($string);
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
		$this
			->validateInteger($position)
			->validateScalar($string);
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
		$this
			->validateInteger($position)
			->validateInteger($length)
			->validateScalar($string);
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid.');
		}
		if ($position + $length > $this->length()) {
			throw new \InvalidArgumentException('Length invalid.');
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
		$this
			->validateInteger($position)
			->validateScalar($string);
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid.');
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
		$this
			->validateInteger($position)
			->validateIntegerOrNull($length);
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
		$this->validateInteger($position);
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
		$this->validateScalar($string);
		return strpos($this->string, (string)$string) !== false;
	}

	/**
	 * @param string $string
	 * @param int $offset
	 * @return int
	 */
	public function indexOf($string, $offset = 0)
	{
		$this
			->validateScalar($string)
			->validateEmpty($string)
			->validateInteger($offset);
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
		$this
			->validateScalar($string)
			->validateEmpty($string)
			->validateInteger($offset);
		$index = mb_strrpos($this->string, (string)$string, -1 * $offset);
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
		$this
			->validateInteger($startPosition)
			->validateIntegerOrNull($length);
		if ($startPosition >= $this->length()) {
			throw new \InvalidArgumentException('Start position ' . (string)$startPosition . ' invalid.');
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

	/**
	 * @param mixed $value
	 * @return $this
	 */
	private function validateScalar($value)
	{
		if (!is_scalar($value)) {
			$type = is_object($value) ? get_class($value) : gettype($value);
			throw new \InvalidArgumentException('Expected a scalar value. Got ' . $type . '.');
		}
		return $this;
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	private function validateInteger($value)
	{
		if (!is_int($value)) {
			$type = is_object($value) ? get_class($value) : gettype($value);
			throw new \InvalidArgumentException('Expected integer. Got ' . $type . '.');
		}
		return $this;
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	private function validateIntegerOrNull($value)
	{
		if (is_null($value)) {
			return $this;
		}
		return $this->validateInteger($value);
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	private function validateEmpty($value)
	{
		$value = (string)$value;
		if (empty($value)) {
			throw new \InvalidArgumentException('Empty string is invalid.');
		}
		return $this;
	}

}
