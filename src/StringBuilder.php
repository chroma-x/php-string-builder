<?php

namespace Markenwerk\StringBuilder;

use Markenwerk\StringBuilder\Util\ArgumentValidator;

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
	 * @throws \InvalidArgumentException
	 */
	public function __construct($string = null)
	{
		if ($string !== null) {
			ArgumentValidator::validateScalar($string);
			$this->string = (string)$string;
		}
	}

	/**
	 * Appends the given string
	 *
	 * @param string $string
	 * @return $this
	 * @throws \InvalidArgumentException
	 */
	public function append($string)
	{
		ArgumentValidator::validateScalar($string);
		$this->string .= (string)$string;
		return $this;
	}

	/**
	 * Prepends the given string
	 *
	 * @param string $string
	 * @return $this
	 * @throws \InvalidArgumentException
	 */
	public function prepend($string)
	{
		ArgumentValidator::validateScalar($string);
		$this->string = (string)$string . $this->string;
		return $this;
	}

	/**
	 * Inserts the given string at the given position
	 *
	 * @param int $position
	 * @param string $string
	 * @return $this
	 * @throws \InvalidArgumentException
	 */
	public function insert($position, $string)
	{
		ArgumentValidator::validateUnsignedInteger($position);
		ArgumentValidator::validateScalar($string);
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
	 * @throws \InvalidArgumentException
	 */
	public function replace($position, $length, $string)
	{
		ArgumentValidator::validateUnsignedInteger($position);
		ArgumentValidator::validateUnsignedInteger($length);
		ArgumentValidator::validateScalar($string);
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
	 * @throws \InvalidArgumentException
	 */
	public function setCharAt($position, $character)
	{
		ArgumentValidator::validateUnsignedInteger($position);
		ArgumentValidator::validateScalar($character);
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
	 * @throws \InvalidArgumentException
	 */
	public function delete($position, $length = null)
	{
		ArgumentValidator::validateUnsignedInteger($position);
		ArgumentValidator::validateUnsignedIntegerOrNull($length);
		if ($position >= $this->length()) {
			throw new \InvalidArgumentException('Position invalid');
		}
		if ($length === null) {
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
	 * @throws \InvalidArgumentException
	 */
	public function deleteCharAt($position)
	{
		ArgumentValidator::validateUnsignedInteger($position);
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
	 * @throws \InvalidArgumentException
	 */
	public function contains($substring)
	{
		ArgumentValidator::validateScalar($substring);
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
	 * @throws \InvalidArgumentException
	 */
	public function indexOf($string, $offset = 0)
	{
		ArgumentValidator::validateScalar($string);
		ArgumentValidator::validateEmpty($string);
		ArgumentValidator::validateUnsignedInteger($offset);
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
	 * @throws \InvalidArgumentException
	 */
	public function lastIndexOf($string, $offset = 0)
	{
		ArgumentValidator::validateScalar($string);
		ArgumentValidator::validateEmpty($string);
		ArgumentValidator::validateUnsignedInteger($offset);
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
	 * @throws \InvalidArgumentException
	 */
	public function charAt($position)
	{
		ArgumentValidator::validateUnsignedInteger($position);
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
	 * @throws \InvalidArgumentException
	 */
	public function buildSubstring($startPosition, $length = null)
	{
		ArgumentValidator::validateUnsignedInteger($startPosition);
		ArgumentValidator::validateUnsignedIntegerOrNull($length);
		if ($startPosition >= $this->length()) {
			throw new \InvalidArgumentException('Start position ' . (string)$startPosition . ' invalid');
		}
		if ($length === null) {
			return mb_substr($this->string, $startPosition);
		}
		return mb_substr($this->string, $startPosition, $length);
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

}
