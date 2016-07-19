<?php

namespace Test;

use Markenwerk\SimpleStringBuilder\SimpleStringBuilder;

/**
 * Class SimpleStringBuilderTest
 *
 * @package Test
 */
class SimpleStringBuilderTest extends \PHPUnit_Framework_TestCase{

	public function testBuilder()
	{
		$builder = new SimpleStringBuilder();
		$builder
			->append('a')
			->append(12)
			->append(array('a'))
			->append(false)
			->append(true);
		$this->assertEquals('a12Array1', $builder->toString());
	}

}
