<?php

namespace Markenwerk\StringBuilder\Util;

/**
 * Class ArgumentValidator
 *
 * @package Markenwerk\StringBuilder\Util
 */
class ArgumentValidator{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public static function validateScalar($value)
	{
		if (!is_scalar($value)) {
			$type = is_object($value) ? get_class($value) : gettype($value);
			throw new \InvalidArgumentException('Expected a scalar value; got ' . $type);
		}
	}

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public static function validateUnsignedInteger($value)
	{
		if (!is_int($value)) {
			$type = is_object($value) ? get_class($value) : gettype($value);
			throw new \InvalidArgumentException('Expected an unsigned integer; got ' . $type);
		}
		if ($value < 0) {
			throw new \InvalidArgumentException('Expected an unsigned integer; got ' . $value);
		}
	}

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public static function validateUnsignedIntegerOrNull($value)
	{
		if ($value === null) {
			return;
		}
		self::validateUnsignedInteger($value);
	}

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public static function validateEmpty($value)
	{
		$value = (string)$value;
		if (empty($value)) {
			throw new \InvalidArgumentException('Empty string is invalid');
		}
	}

}