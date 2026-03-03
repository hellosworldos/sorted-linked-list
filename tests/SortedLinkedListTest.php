<?php

declare(strict_types=1);

namespace Hellosworldos\SortedLinkedList\Tests;

use Hellosworldos\SortedLinkedList\SortedLinkedList;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SortedLinkedListTest extends TestCase
{
    public function testEmptyListGetsEmptyHead(): void
    {
        $list = SortedLinkedList::fromArray([]);

        self::assertNull($list->head);
    }

    /**
     * @return iterable<string, array{inputValues: array<int|string>, expectedOrder: array<int|string>}>
     */
    public static function provideDataForFromArray(): iterable
    {
        yield 'integers unsorted' => [
            'inputValues' => [3, 1, 4, 1, 5, 9, 2, 6],
            'expectedOrder' => [1, 1, 2, 3, 4, 5, 6, 9],
        ];

        yield 'integers already sorted' => [
            'inputValues' => [1, 2, 3, 4, 5],
            'expectedOrder' => [1, 2, 3, 4, 5],
        ];

        yield 'integers reverse sorted' => [
            'inputValues' => [5, 4, 3, 2, 1],
            'expectedOrder' => [1, 2, 3, 4, 5],
        ];

        yield 'strings unsorted' => [
            'inputValues' => ['banana', 'apple', 'cherry', 'apricot'],
            'expectedOrder' => ['apple', 'apricot', 'banana', 'cherry'],
        ];

        yield 'strings already sorted' => [
            'inputValues' => ['apple', 'banana', 'cherry'],
            'expectedOrder' => ['apple', 'banana', 'cherry'],
        ];

        yield 'empty array' => [
            'inputValues' => [],
            'expectedOrder' => [],
        ];
    }

    /**
     * @param array<int|string> $inputValues
     * @param array<int|string> $expectedOrder
     */
    #[DataProvider('provideDataForFromArray')]
    public function testFromArraySortsValues(array $inputValues, array $expectedOrder): void
    {
        $list = SortedLinkedList::fromArray($inputValues);

        self::assertSame($expectedOrder, $list->toArray());
    }

    /**
     * @return iterable<string, array{initial: array<int|string>, add: int|string, expected: array<int|string>}>
     */
    public static function provideDataForAddValue(): iterable
    {
        yield 'add to empty list' => [
            'initial' => [],
            'add' => 5,
            'expected' => [5],
        ];

        yield 'add integer becomes new head' => [
            'initial' => [3, 5, 7],
            'add' => 1,
            'expected' => [1, 3, 5, 7],
        ];

        yield 'add integer at end' => [
            'initial' => [1, 3, 5],
            'add' => 7,
            'expected' => [1, 3, 5, 7],
        ];

        yield 'add integer in middle' => [
            'initial' => [1, 3, 7],
            'add' => 5,
            'expected' => [1, 3, 5, 7],
        ];

        yield 'add duplicate integer' => [
            'initial' => [1, 3, 5],
            'add' => 3,
            'expected' => [1, 3, 3, 5],
        ];

        yield 'add string becomes new head' => [
            'initial' => ['banana', 'cherry'],
            'add' => 'apple',
            'expected' => ['apple', 'banana', 'cherry'],
        ];

        yield 'add string at end' => [
            'initial' => ['apple', 'banana'],
            'add' => 'cherry',
            'expected' => ['apple', 'banana', 'cherry'],
        ];

        yield 'add string in middle' => [
            'initial' => ['apple', 'cherry'],
            'add' => 'banana',
            'expected' => ['apple', 'banana', 'cherry'],
        ];
    }

    /**
     * @param array<int|string> $initial
     * @param array<int|string> $expected
     */
    #[DataProvider('provideDataForAddValue')]
    public function testAddValue(array $initial, int|string $add, array $expected): void
    {
        $list = SortedLinkedList::fromArray($initial);

        $list->addValue($add);

        self::assertSame($expected, $list->toArray());
    }

    /**
     * @param array<int|string> $inputValues
     * @param array<int|string> $expectedOrder
     */
    #[DataProvider('provideDataForFromArray')]
    public function testFromArrayIsIterable(array $inputValues, array $expectedOrder): void
    {
        $list = SortedLinkedList::fromArray($inputValues);

        $result = [];
        foreach ($list as $value) {
            $result[] = $value;
        }

        self::assertSame($expectedOrder, $result);
    }

    /**
     * @return iterable<string, array{initial: array<int|string>, drop: int, expected: array<int|string>}>
     */
    public static function provideDataForShiftHead(): iterable
    {
        yield 'drop default one node' => [
            'initial' => [1, 2, 3],
            'drop' => 1,
            'expected' => [2, 3],
        ];

        yield 'drop zero nodes' => [
            'initial' => [1, 2, 3],
            'drop' => 0,
            'expected' => [1, 2, 3],
        ];

        yield 'drop multiple nodes' => [
            'initial' => [1, 2, 3, 4, 5],
            'drop' => 3,
            'expected' => [4, 5],
        ];

        yield 'drop all nodes' => [
            'initial' => [1, 2, 3],
            'drop' => 3,
            'expected' => [],
        ];

        yield 'drop more than size returns empty' => [
            'initial' => [1, 2, 3],
            'drop' => 10,
            'expected' => [],
        ];

        yield 'drop from empty list returns empty' => [
            'initial' => [],
            'drop' => 1,
            'expected' => [],
        ];
    }

    /**
     * @param array<int|string> $initial
     * @param array<int|string> $expected
     */
    #[DataProvider('provideDataForShiftHead')]
    public function testShiftHead(array $initial, int $drop, array $expected): void
    {
        $list = SortedLinkedList::fromArray($initial);

        $result = $list->shiftHead($drop);

        self::assertSame($expected, $result->toArray());
    }

    /**
     * @return iterable<string, array{initial: array<int|string>, newSize: int, expected: array<int|string>}>
     */
    public static function provideDataForSetSize(): iterable
    {
        yield 'new size larger than size returns same content' => [
            'initial' => [1, 2, 3],
            'newSize' => 10,
            'expected' => [1, 2, 3],
        ];

        yield 'new size equal to size returns same content' => [
            'initial' => [1, 2, 3],
            'newSize' => 3,
            'expected' => [1, 2, 3],
        ];

        yield 'new size smaller returns last n elements' => [
            'initial' => [1, 2, 3, 4, 5],
            'newSize' => 3,
            'expected' => [3, 4, 5],
        ];

        yield 'new size one returns last element' => [
            'initial' => [1, 2, 3, 4, 5],
            'newSize' => 1,
            'expected' => [5],
        ];

        yield 'new size zero returns empty' => [
            'initial' => [1, 2, 3],
            'newSize' => 0,
            'expected' => [],
        ];
    }

    /**
     * @param array<int|string> $initial
     * @param array<int|string> $expected
     */
    #[DataProvider('provideDataForSetSize')]
    public function testSetSize(array $initial, int $newSize, array $expected): void
    {
        $list = SortedLinkedList::fromArray($initial);

        $result = $list->setSize($newSize);

        self::assertSame($expected, $result->toArray());
    }

    public function testSetSizeWithLargerSizeReturnsSelf(): void
    {
        $list = SortedLinkedList::fromArray([1, 2, 3]);

        $result = $list->setSize(10);

        self::assertSame($list, $result);
    }

    /**
     * @return iterable<string, array{initial: array<int|string>, count: int, expected: array<int|string>}>
     */
    public static function provideDataForSliceValues(): iterable
    {
        yield 'slice zero returns empty' => [
            'initial' => [1, 2, 3],
            'count' => 0,
            'expected' => [],
        ];

        yield 'slice one returns first element' => [
            'initial' => [1, 2, 3, 4, 5],
            'count' => 1,
            'expected' => [1],
        ];

        yield 'slice some returns first n elements' => [
            'initial' => [1, 2, 3, 4, 5],
            'count' => 3,
            'expected' => [1, 2, 3],
        ];

        yield 'slice all returns all elements' => [
            'initial' => [1, 2, 3],
            'count' => 3,
            'expected' => [1, 2, 3],
        ];

        yield 'slice more than size returns all elements' => [
            'initial' => [1, 2, 3],
            'count' => 10,
            'expected' => [1, 2, 3],
        ];

        yield 'slice from empty list returns empty' => [
            'initial' => [],
            'count' => 5,
            'expected' => [],
        ];
    }

    /**
     * @param array<int|string> $initial
     * @param array<int|string> $expected
     */
    #[DataProvider('provideDataForSliceValues')]
    public function testSliceValues(array $initial, int $count, array $expected): void
    {
        $list = SortedLinkedList::fromArray($initial);

        $result = $list->sliceValues($count);

        self::assertSame($expected, $result);
    }
}
