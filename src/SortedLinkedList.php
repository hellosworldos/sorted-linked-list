<?php

declare(strict_types=1);

namespace Hellosworldos\SortedLinkedList;

use Generator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, int|string>
 */
class SortedLinkedList implements IteratorAggregate
{
    public function __construct(
        private(set) ?LinkedListNode $head = null,
    ) {
    }

    /**
     * @param array<int|string> $items
     */
    public static function fromArray(array $items, Sorter $sortingStrategy = new MergeSorter()): self
    {
        $head = null;
        $tail = null;

        if ([] === $items) {
            return new self();
        }

        foreach ($items as $item) {
            $node = new LinkedListNode($item);
            if (null === $head) {
                $head = $node;
                $tail = $node;
            } else {
                $tail->linkNext($node);
                $tail = $node;
            }
        }

        return new self($sortingStrategy->sort($head));
    }

    /**
     * @return Generator<int, int|string, mixed, void>
     */
    public function getIterator(): Generator
    {
        $node = $this->head;
        while ($node !== null) {
            yield $node->value;
            $node = $node->next;
        }
    }

    /**
     * @return array<int, int|string>
     */
    public function toArray(): array
    {
        return iterator_to_array($this->getIterator());
    }
}
