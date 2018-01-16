<?php

namespace ExtendedArrays\Tests;

use ExtendedArrays\Traits\ReadOnly;
use ExtendedArrays\ReadOnlyAssociativeArray;

use PHPUnit\Framework\TestCase;

/**
 * @covers \ExtendedArrays\Traits\ReadOnly
 */
final class ReadOnlyTraitTest extends TestCase {
	public function testReadOnlyThrowsExceptionOnConstructedWithNonAssociaitiveArray()
	{
		$this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot apply \'ReadOnly\' trait to a class that does not inherit \\ExtendedArrays\\AssociativeArray');

		$readOnly = new class {
			use ReadOnly;
		};
	}

	public function testReadOnlyThrowsExceptionOnSet()
	{
		$readOnly = new ReadOnlyAssociativeArray([
			'name' => 'nathan',
			'age' => 22,
		]);

		$this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot modify a read only array.');

		$readOnly->name = 'test';
	}

	public function testReadOnlyThrowsExceptionOnFunctionSet()
	{
		$readOnly = new ReadOnlyAssociativeArray([
			'name' => 'nathan',
			'age' => 22,
		]);

		$this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot modify a read only array.');

		$readOnly->name('test');	
	}

	public function testReadOnlyThrowsExceptionOnArraySet()
	{
		$readOnly = new ReadOnlyAssociativeArray([
			'name' => 'nathan',
			'age' => 22,
		]);

		$this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot modify a read only array.');

		$readOnly['name'] = 'test';	
	}

	public function testReadOnlyUnsetThrowsException()
	{
		$readOnly = new ReadOnlyAssociativeArray([
			'name' => 'nathan',
			'age' => 22,
		]);

		$this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot modify a read only array.');
		
		unset($readOnly['name']);	
	}

	public function testReadOnlyThrowsExceptionOnUndefinedFunctionCall()
	{
		$readOnly = new ReadOnlyAssociativeArray([
			'name' => 'nathan',
			'age' => 22,
		]);

		$this->expectException(\Exception::class);
        $this->expectExceptionMessage('Call to undefined function \'doesntExist\'.');

		$readOnly->doesntExist();
	}

	public function testReadOnlyReturnsValueOnValidFunctionCall()
	{
		$readOnly = new ReadOnlyAssociativeArray([
			'name' => 'nathan',
			'age' => 22,
		]);

		$this->assertEquals(
			$readOnly->name(),
			'nathan'
		);
	}
}