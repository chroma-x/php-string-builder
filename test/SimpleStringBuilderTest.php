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
			->remove(1)
			->replace(0, 'ab')
			->append(true);
		$this->assertEquals('ab121', $builder->build());
		$this->assertEquals('121', $builder->buildSubstring(1));
		$this->assertEquals('ab12', $builder->buildSubstring(0, 2));
		$this->assertEquals(4, $builder->size());
		$this->assertEquals(5, $builder->length());
		$this->assertTrue($builder->contains('ab'));
		$this->assertFalse($builder->contains('abc'));
		$this->assertTrue($builder->stringContains('ab1'));
		$this->assertFalse($builder->stringContains('abc'));
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
		$builder->prepend(new \DateTime());
	}

	public function testBuilderReplaceFail1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder->replace(0, 'a');
	}

	public function testBuilderReplaceFail2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder
			->append('a')
			->replace(0, new \DateTime());
	}

	public function testBuilderRemoveFail()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder->remove(0);
	}

	public function testBuilderContainsFail()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new SimpleStringBuilder();
		$builder->contains(array());
	}

	public function testBuilderStringContainsFail()
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
