<?php declare(strict_types = 1);

namespace PHPStan\Rules\Generics;

use PHPStan\Rules\PhpDoc\UnresolvableTypeHelper;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<InterfaceAncestorsRule>
 */
class InterfaceAncestorsRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new InterfaceAncestorsRule(
			new GenericAncestorsCheck(
				$this->createReflectionProvider(),
				new GenericObjectTypeCheck(),
				new VarianceCheck(),
				new UnresolvableTypeHelper(),
				[],
				true,
			),
			new CrossCheckInterfacesHelper(),
		);
	}

	public function testRuleImplements(): void
	{
		$this->analyse([__DIR__ . '/data/interface-ancestors-implements.php'], [
			[
				'Interface InterfaceAncestorsImplements\FooDoesNotImplementAnything has @implements tag, but can not implement any interface, must extend from it.',
				35,
			],
			[
				'Interface InterfaceAncestorsImplements\FooInvalidImplementsTags has @implements tag, but can not implement any interface, must extend from it.',
				44,
			],
			[
				'Interface InterfaceAncestorsImplements\FooInvalidImplementsTags has @implements tag, but can not implement any interface, must extend from it.',
				44,
			],
			[
				'Interface InterfaceAncestorsImplements\FooWrongClassImplemented has @implements tag, but can not implement any interface, must extend from it.',
				52,
			],
			[
				'Interface InterfaceAncestorsImplements\FooWrongTypeInImplementsTag @implements tag contains incompatible type class-string<InterfaceAncestorsImplements\T>.',
				60,
			],
			[
				'Interface InterfaceAncestorsImplements\FooCorrect has @implements tag, but can not implement any interface, must extend from it.',
				68,
			],
			[
				'Interface InterfaceAncestorsImplements\FooNotEnough has @implements tag, but can not implement any interface, must extend from it.',
				76,
			],
			[
				'Interface InterfaceAncestorsImplements\FooExtraTypes has @implements tag, but can not implement any interface, must extend from it.',
				84,
			],
			[
				'Interface InterfaceAncestorsImplements\FooNotSubtype has @implements tag, but can not implement any interface, must extend from it.',
				92,
			],
			[
				'Interface InterfaceAncestorsImplements\FooAlsoNotSubtype has @implements tag, but can not implement any interface, must extend from it.',
				100,
			],
			[
				'Interface InterfaceAncestorsImplements\FooUnknownClass has @implements tag, but can not implement any interface, must extend from it.',
				108,
			],
			[
				'Interface InterfaceAncestorsImplements\FooGenericGeneric has @implements tag, but can not implement any interface, must extend from it.',
				117,
			],
			[
				'Interface InterfaceAncestorsImplements\FooGenericGeneric2 has @implements tag, but can not implement any interface, must extend from it.',
				126,
			],
			[
				'Interface InterfaceAncestorsImplements\FooGenericGeneric3 has @implements tag, but can not implement any interface, must extend from it.',
				136,
			],
			[
				'Interface InterfaceAncestorsImplements\FooGenericGeneric4 has @implements tag, but can not implement any interface, must extend from it.',
				145,
			],
			[
				'Interface InterfaceAncestorsImplements\FooGenericGeneric5 has @implements tag, but can not implement any interface, must extend from it.',
				154,
			],
			[
				'Interface InterfaceAncestorsImplements\FooGenericGeneric6 has @implements tag, but can not implement any interface, must extend from it.',
				163,
			],
			[
				'Interface InterfaceAncestorsImplements\FooGenericGeneric7 has @implements tag, but can not implement any interface, must extend from it.',
				172,
			],
			[
				'Interface InterfaceAncestorsImplements\FooGenericGeneric8 has @implements tag, but can not implement any interface, must extend from it.',
				182,
			],
			[
				'Interface InterfaceAncestorsImplements\FooGenericGeneric8 has @implements tag, but can not implement any interface, must extend from it.',
				182,
			],
			[
				'Interface InterfaceAncestorsImplements\FooTypeProjection has @implements tag, but can not implement any interface, must extend from it.',
				190,
			],
		]);
	}

	public function testRuleExtends(): void
	{
		$this->analyse([__DIR__ . '/data/interface-ancestors-extends.php'], [
			[
				'Interface InterfaceAncestorsExtends\FooDoesNotImplementAnything has @extends tag, but does not extend any interface.',
				35,
			],
			[
				'The @extends tag of interface InterfaceAncestorsExtends\FooInvalidImplementsTags describes InterfaceAncestorsExtends\FooGeneric2 but the interface extends: InterfaceAncestorsExtends\FooGeneric',
				44,
			],
			[
				'The @extends tag of interface InterfaceAncestorsExtends\FooWrongClassImplemented describes InterfaceAncestorsExtends\FooGeneric2 but the interface extends: InterfaceAncestorsExtends\FooGeneric, InterfaceAncestorsExtends\FooGeneric3',
				52,
			],
			[
				'Interface InterfaceAncestorsExtends\FooWrongClassImplemented extends generic interface InterfaceAncestorsExtends\FooGeneric but does not specify its types: T, U',
				52,
			],
			[
				'Interface InterfaceAncestorsExtends\FooWrongClassImplemented extends generic interface InterfaceAncestorsExtends\FooGeneric3 but does not specify its types: T, W',
				52,
			],
			[
				'Interface InterfaceAncestorsExtends\FooWrongTypeInImplementsTag @extends tag contains incompatible type class-string<InterfaceAncestorsExtends\T>.',
				60,
			],
			[
				'Interface InterfaceAncestorsExtends\FooWrongTypeInImplementsTag extends generic interface InterfaceAncestorsExtends\FooGeneric but does not specify its types: T, U',
				60,
			],
			[
				'Generic type InterfaceAncestorsExtends\FooGeneric<int> in PHPDoc tag @extends does not specify all template types of interface InterfaceAncestorsExtends\FooGeneric: T, U',
				76,
			],
			[
				'Generic type InterfaceAncestorsExtends\FooGeneric<int, InvalidArgumentException, string> in PHPDoc tag @extends specifies 3 template types, but interface InterfaceAncestorsExtends\FooGeneric supports only 2: T, U',
				84,
			],
			[
				'Type Throwable in generic type InterfaceAncestorsExtends\FooGeneric<int, Throwable> in PHPDoc tag @extends is not subtype of template type U of Exception of interface InterfaceAncestorsExtends\FooGeneric.',
				92,
			],
			[
				'Type stdClass in generic type InterfaceAncestorsExtends\FooGeneric<int, stdClass> in PHPDoc tag @extends is not subtype of template type U of Exception of interface InterfaceAncestorsExtends\FooGeneric.',
				100,
			],
			[
				'PHPDoc tag @extends has invalid type InterfaceAncestorsExtends\Zazzuuuu.',
				108,
			],
			[
				'Type mixed in generic type InterfaceAncestorsExtends\FooGeneric<int, mixed> in PHPDoc tag @extends is not subtype of template type U of Exception of interface InterfaceAncestorsExtends\FooGeneric.',
				117,
			],
			[
				'Type Throwable in generic type InterfaceAncestorsExtends\FooGeneric<int, Throwable> in PHPDoc tag @extends is not subtype of template type U of Exception of interface InterfaceAncestorsExtends\FooGeneric.',
				126,
			],
			[
				'Type stdClass in generic type InterfaceAncestorsExtends\FooGeneric<int, stdClass> in PHPDoc tag @extends is not subtype of template type U of Exception of interface InterfaceAncestorsExtends\FooGeneric.',
				172,
			],
			[
				'Type stdClass in generic type InterfaceAncestorsExtends\FooGeneric<int, stdClass> in PHPDoc tag @extends is not subtype of template type U of Exception of interface InterfaceAncestorsExtends\FooGeneric.',
				182,
			],
			[
				'Type stdClass in generic type InterfaceAncestorsExtends\FooGeneric2<int, stdClass> in PHPDoc tag @extends is not subtype of template type V of Exception of interface InterfaceAncestorsExtends\FooGeneric2.',
				182,
			],
			[
				'Interface InterfaceAncestorsExtends\ExtendsGenericInterface extends generic interface InterfaceAncestorsExtends\FooGeneric but does not specify its types: T, U',
				197,
			],
			[
				'Template type T is declared as covariant, but occurs in invariant position in extended type InterfaceAncestorsExtends\FooGeneric9<T, T> of interface InterfaceAncestorsExtends\FooGeneric10.',
				215,
			],
			[
				'Call-site variance annotation of covariant LogicException in generic type InterfaceAncestorsExtends\FooGeneric<int, covariant LogicException> in PHPDoc tag @extends is not allowed.',
				223,
			],
		]);
	}

	public function testCrossCheckInterfaces(): void
	{
		$this->analyse([__DIR__ . '/data/cross-check-interfaces-interfaces.php'], [
			[
				'Interface IteratorAggregate specifies template type TValue of interface Traversable as string but it\'s already specified as CrossCheckInterfacesInInterfaces\Item.',
				19,
			],
		]);
	}

}
