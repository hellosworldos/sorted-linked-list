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
        $list = new SortedLinkedList();

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
}
