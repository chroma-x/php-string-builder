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
			->append(false)
			->append(true);
		$this->assertEquals('a121', $builder->toString());
	}

}
