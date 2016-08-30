<?php

namespace Test;

use Markenwerk\StringBuilder\StringBuilder;

/**
 * Class StringBuilderTest
 *
 * @package Test
 */
class StringBuilderTest extends \PHPUnit_Framework_TestCase
{

	public function testBuilder()
	{
		$builder = new StringBuilder('Test');
		$this->assertEquals(4, $builder->size());
		$builder = new StringBuilder();
		$builder
			->append('a')
			->append(12)
			->append(false)
			->prepend('b')
			->append(true)
			->insert(1, 'qas')
			->replace(2, 2, 'we')
			->setCharAt(4, '2')
			->append('beö');
		$this->assertEquals('bqwe2121beö', $builder->build());
		$this->assertEquals('we2121beö', $builder->buildSubstring(2));
		$this->assertEquals('bq', $builder->buildSubstring(0, 2));
		$this->assertEquals('w', $builder->charAt(2));
		$this->assertEquals(12, $builder->size());
		$this->assertEquals(11, $builder->length());
		$this->assertEquals(3, $builder->indexOf('e'));
		$this->assertEquals(9, $builder->indexOf('e', 4));
		$this->assertNull($builder->indexOf('e', 10));
		$this->assertEquals(9, $builder->lastIndexOf('e'));
		$this->assertNull($builder->lastIndexOf('e',10));
		$this->assertTrue($builder->contains('21b'));
		$this->assertEquals('b', $builder->firstChar());
		$this->assertEquals('ö', $builder->lastChar());
		$this->assertFalse($builder->contains('abc'));
		$this->assertEquals('öeb1212ewqb', $builder->reverse()->build());
		$builder = new StringBuilder('0123456');
		$builder->delete(4);
		$this->assertEquals('0123', $builder->build());
		$builder = new StringBuilder('0123456');
		$builder
			->delete(4, 1)
			->deleteCharAt(1);
		$this->assertEquals('02356', $builder->build());
	}

	public function testBuilderConstructFail()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		new StringBuilder(array());
	}

	public function testBuilderAppendFail()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->append(array());
	}

	public function testBuilderPrependFail()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->prepend(new \DateTimeZone('Europe/Berlin'));
	}

	public function testBuilderInsertFail1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->insert('a', 'a');
	}

	public function testBuilderInsertFail2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->insert(0, array());
	}

	public function testBuilderInsertFail3()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->insert(0, 'a');
	}

	public function testBuilderInsertFail4()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->insert(-1, 'a');
	}

	public function testBuilderReplaceFail1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->replace('a', 1, 'a');
	}

	public function testBuilderReplaceFail2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->replace(0, 1, 'a');
	}

	public function testBuilderReplaceFail3()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder
			->append('a')
			->replace(0, 'a', 'a');
	}

	public function testBuilderReplaceFail4()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder
			->append('a')
			->replace(0, 2, 'a');
	}

	public function testBuilderReplaceFail5()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder
			->append('a')
			->replace(0, 1, new \DateTimeZone('Europe/Berlin'));
	}

	public function testBuilderSetCharAtFail1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->setCharAt('a', 'a');
	}

	public function testBuilderSetCharAtFail2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder
			->append('a')
			->setCharAt(0, array());
	}

	public function testBuilderSetCharAtFail3()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder
			->append('a')
			->setCharAt(1, 'a');
	}

	public function testBuilderSetCharAtFail4()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder
			->append('a')
			->setCharAt(0, 'ab');
	}

	public function testBuilderDeleteFail1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder('012345');
		$builder->delete('a');
	}

	public function testBuilderDeleteFail2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder('012345');
		$builder->delete(0, 'a');
	}

	public function testBuilderDeleteFail3()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder('012345');
		$builder->delete(10);
	}

	public function testBuilderDeleteCharAtFail1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder('012345');
		$builder->deleteCharAt('a');
	}

	public function testBuilderDeleteCharAtFail2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder('012345');
		$builder->deleteCharAt(6);
	}

	public function testBuilderCharAtFail1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->charAt('a');
	}

	public function testBuilderCharAtFail2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->charAt(0);
	}

	public function testBuilderContainsFail()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->contains(array());
	}

	public function testBuilderBuildSubstringFail1()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder->buildSubstring(1);
	}

	public function testBuilderBuildSubstringFail2()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder
			->append('ab')
			->buildSubstring(0, array());
	}

	public function testBuilderBuildIndexOfFail()
	{
		$this->setExpectedException(get_class(new \InvalidArgumentException()));
		$builder = new StringBuilder();
		$builder
			->append('ab')
			->indexOf('');
	}

}
