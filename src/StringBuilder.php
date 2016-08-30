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
	 * SimpleStringBuilder constructor
	 *
	 * Takes an initial string as argument
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
	 * Appends the given string
	 *
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
	 * Prepends the given string
	 *
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
	 * Inserts the given string at the given position
	 *
	 * @param int $position
	 * @param string $string
	 * @return $this
	 */
	public function insert($position, $string)
	{
		$this
			->validateUnsignedInteger($position)
			->validateScalar($string);
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid');
		}
		$this->string = mb_substr($this->string, 0, $position) . (string)$string . mb_substr($this->string, $position);
		return $this;
	}

	/**
	 * Replaces the characters defined by the given position and length with the given string
	 *
	 * @param int $position
	 * @param int $length
	 * @param string $string
	 * @return $this
	 */
	public function replace($position, $length, $string)
	{
		$this
			->validateUnsignedInteger($position)
			->validateUnsignedInteger($length)
			->validateScalar($string);
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid');
		}
		if ($position + $length > $this->length()) {
			throw new \InvalidArgumentException('Length invalid');
		}
		$this->string = mb_substr($this->string, 0, $position) . (string)$string . mb_substr($this->string, $position + $length);
		return $this;
	}

	/**
	 * Sets the character at the given position
	 *
	 * @param int $position
	 * @param string $character
	 * @return $this
	 */
	public function setCharAt($position, $character)
	{
		$this
			->validateUnsignedInteger($position)
			->validateScalar($character);
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid');
		}
		if (mb_strlen((string)$character) !== 1) {
			throw new \InvalidArgumentException('Expected a scalar value of length 1');
		}
		$this->string = mb_substr($this->string, 0, $position) . (string)$character . mb_substr($this->string, $position + 1);
		return $this;
	}

	/**
	 * Reverts the string to build
	 *
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
	 * Removes the portion defined by the given position and length
	 *
	 * @param int $position
	 * @param int $length
	 * @return $this
	 */
	public function delete($position, $length = null)
	{
		$this
			->validateUnsignedInteger($position)
			->validateUnsignedIntegerOrNull($length);
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid');
		}
		if (is_null($length)) {
			$this->string = mb_substr($this->string, 0, $position);
		} else {
			$this->string = mb_substr($this->string, 0, $position) . mb_substr($this->string, $position + $length);
		}
		return $this;
	}

	/**
	 * Removes the character at the given position
	 *
	 * @param int $position
	 * @return $this
	 */
	public function deleteCharAt($position)
	{
		$this->validateUnsignedInteger($position);
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid');
		}
		$this->string = mb_substr($this->string, 0, $position) . mb_substr($this->string, $position + 1);
		return $this;
	}

	/**
	 * Whether the string to build contains the given substring
	 *
	 * @param string $substring
	 * @return bool
	 */
	public function contains($substring)
	{
		$this->validateScalar($substring);
		return strpos($this->string, (string)$substring) !== false;
	}

	/**
	 * Returns the index of the first occurence of the given substring or null
	 *
	 * Takes an optional parameter to begin searching after the given offset
	 *
	 * @param string $string
	 * @param int $offset
	 * @return int
	 */
	public function indexOf($string, $offset = 0)
	{
		$this
			->validateScalar($string)
			->validateEmpty($string)
			->validateUnsignedInteger($offset);
		$index = mb_strpos($this->string, (string)$string, $offset);
		return $index === false ? null : $index;
	}

	/**
	 * Returns the index of the last occurence of the given substring or null
	 *
	 * Takes an optional parameter to end searching before the given offset
	 *
	 * @param string $string
	 * @param int $offset
	 * @return int
	 */
	public function lastIndexOf($string, $offset = 0)
	{
		$this
			->validateScalar($string)
			->validateEmpty($string)
			->validateUnsignedInteger($offset);
		$index = mb_strrpos($this->string, (string)$string, -1 * $offset);
		return $index === false ? null : $index;
	}

	/**
	 * Returns the number of bytes of the string to build
	 *
	 * @return int
	 */
	public function size()
	{
		return strlen($this->string);
	}

	/**
	 * Returns the number of characters of the string to build
	 *
	 * @return int
	 */
	public function length()
	{
		return mb_strlen($this->string, mb_detect_encoding($this->string));
	}

	/**
	 * Returns the character at the given position
	 *
	 * @param int $position
	 * @return string
	 */
	public function charAt($position)
	{
		$this->validateUnsignedInteger($position);
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid');
		}
		return mb_substr($this->string, $position, 1);
	}

	/**
	 * Returns first character
	 *
	 * @return string
	 */
	public function firstChar()
	{
		return mb_substr($this->string, 0, 1, mb_detect_encoding($this->string));
	}

	/**
	 * Returns last character
	 *
	 * @return string
	 */
	public function lastChar()
	{
		return mb_substr($this->string, -1, null, mb_detect_encoding($this->string));
	}

	/**
	 * Returns an substring defined by startPosition and length
	 *
	 * @param int $startPosition
	 * @param int $length
	 * @return string
	 */
	public function buildSubstring($startPosition, $length = null)
	{
		$this
			->validateUnsignedInteger($startPosition)
			->validateUnsignedIntegerOrNull($length);
		if ($startPosition >= $this->length()) {
			throw new \InvalidArgumentException('Start position ' . (string)$startPosition . ' invalid');
		}
		if (is_null($length)) {
			return mb_substr($this->string, $startPosition);
		} else {
			return mb_substr($this->string, $startPosition, $length);
		}
	}

	/**
	 * Returns the whole resulting string
	 *
	 * @return string
	 */
	public function build()
	{
		return $this->string;
	}

	/**
	 * Returns the whole resulting string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->build();
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	private function validateScalar($value)
	{
		if (!is_scalar($value)) {
			$type = is_object($value) ? get_class($value) : gettype($value);
			throw new \InvalidArgumentException('Expected a scalar value; got ' . $type);
		}
		return $this;
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	private function validateUnsignedInteger($value)
	{
		if (!is_int($value)) {
			$type = is_object($value) ? get_class($value) : gettype($value);
			throw new \InvalidArgumentException('Expected an unsigned integer; got ' . $type);
		}
		if ($value < 0) {
			throw new \InvalidArgumentException('Expected an unsigned integer; got ' . $value);
		}
		return $this;
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	private function validateUnsignedIntegerOrNull($value)
	{
		if (is_null($value)) {
			return $this;
		}
		return $this->validateUnsignedInteger($value);
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	private function validateEmpty($value)
	{
		$value = (string)$value;
		if (empty($value)) {
			throw new \InvalidArgumentException('Empty string is invalid');
		}
		return $this;
	}

}
