<?php

namespace Test;

use Markenwerk\SimpleStringBuilder\SimpleStringBuilder;

/**
 * Class SimpleStringBuilderTest
 *
 * @package Test
 */
class SimpleStringBuilderTest extends \PHPUnit_Framework_TestCase
{

	public function testBuilder()
	{
		$builder = new SimpleStringBuilder();
		$builder
			->append('a')
			->append(12)
			->append(false)
			->prepend('b')
			->append(true);
		$this->assertEquals('a12b1', $builder->build());
		$this->assertEquals('12b1', $builder->buildSubstring(1));
		$this->assertEquals('a1', $builder->buildSubstring(0, 2));
		$this->assertEquals(5, $builder->size());
		$this->assertEquals(5, $builder->length());
		$this->assertTrue($builder->contains('12b'));
		$this->assertFalse($builder->contains('abc'));
	}

	public function testBuilderAppendFail()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder->append(array());
	}

	public function testBuilderPrependFail()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder->prepend(new \DateTimeZone('Europe/Berlin'));
	}

	public function testBuilderReplaceFail1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder->replace(0, 1, 'a');
	}

	public function testBuilderReplaceFail2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder
			->append('a')
			->replace(0, 2, 'a');
	}

	public function testBuilderReplaceFail3()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder
			->append('a')
			->replace(0, 1, new \DateTimeZone('Europe/Berlin'));
	}

	public function testBuilderContainsFail()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder->contains(array());
	}

	public function testBuilderBuildSubstringFail1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder->buildSubstring(1);
	}

	public function testBuilderBuildSubstringFail2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder
			->append('ab')
			->buildSubstring(0, array());
	}

}
