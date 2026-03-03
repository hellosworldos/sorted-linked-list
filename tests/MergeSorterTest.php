<?php

declare(strict_types=1);

namespace Hellosworldos\SortedLinkedList;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MergeSorterTest extends TestCase
{
    private MergeSorter $strategy;

    protected function setUp(): void
    {
        $this->strategy = new MergeSorter();
    }

    public function testReturnsNullForEmptyHead(): void
    {
        $result = $this->strategy->sort(null);

        self::assertNull($result);
    }

    public function testSingleNodeReturnsSameNode(): void
    {
        $node = new LinkedListNode(42);
        self::assertSame($node, $this->strategy->sort($node));
    }

    /**
     * @return iterable<string, array{inputValues: array<int|string>, expectedOrder: array<int|string>}>
     */
    public static function provideDataForSorting(): iterable
    {
        yield 'integers' => [
            'inputValues' => [3, 1, 4, 1, 5, 9, 2, 6],
            'expectedOrder' => [1, 1, 2, 3, 4, 5, 6, 9],
        ];

        yield 'already sorted integers' => [
            'inputValues' => [1, 2, 3, 4, 5],
            'expectedOrder' => [1, 2, 3, 4, 5],
        ];

        yield 'reverse sorted integers' => [
            'inputValues' => [5, 4, 3, 2, 1],
            'expectedOrder' => [1, 2, 3, 4, 5],
        ];

        yield 'strings' => [
            'inputValues' => ['banana', 'apple', 'cherry', 'apricot'],
            'expectedOrder' => ['apple', 'apricot', 'banana', 'cherry'],
        ];

        yield 'already sorted strings' => [
            'inputValues' => ['apple', 'banana', 'cherry'],
            'expectedOrder' => ['apple', 'banana', 'cherry'],
        ];
    }

    /**
     * @param array<int|string> $inputValues
     * @param array<int|string> $expectedOrder
     */
    #[DataProvider('provideDataForSorting')]
    public function testItSortsList(array $inputValues, array $expectedOrder): void
    {
        $head = $this->arrangeLinkedNodesListFromValues($inputValues);

        $sorted = $this->strategy->sort($head);

        self::assertSame($expectedOrder, $this->toArray($sorted));
    }

    /**
     * @param array<int|string> $values
     */
    private function arrangeLinkedNodesListFromValues(array $values): ?LinkedListNode
    {
        $head = null;
        $tail = null;
        foreach ($values as $value) {
            $node = new LinkedListNode($value);
            if ($tail === null) {
                $head = $node;
                $tail = $node;
            } else {
                $tail->linkNext($node);
                $tail = $node;
            }
        }
        return $head;
    }

    /**
     * @return array<int, int|string>
     */
    private function toArray(?LinkedListNode $head): array
    {
        $result = [];
        while ($head !== null) {
            $result[] = $head->value;
            $head = $head->next;
        }
        return $result;
    }
}
