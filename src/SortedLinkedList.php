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
    private function __construct(
        private(set) ?LinkedListNode $head = null,
        private(set) int $size = 0,
    ) {
    }

    /**
     * @param array<int|string> $items
     */
    public static function fromArray(array $items, Sorter $sorter = new MergeSorter()): self
    {
        $head = null;
        $tail = null;
        $size = 0;

        if ([] === $items) {
            return new self();
        }

        foreach ($items as $item) {
            $node = new LinkedListNode($item);
            $size += 1;
            if (null === $head) {
                $head = $node;
                $tail = $node;
            } else {
                $tail?->linkNext($node);
                $tail = $node;
            }
        }

        return new self($sorter->sort($head), $size);
    }

    public function addValue(int|string $value): self
    {
        $newNode = new LinkedListNode($value);

        if (null === $this->head) {
            $this->head = $newNode;

            return $this;
        } elseif ($this->head->value >= $value) {
            $newNode->linkNext($this->head);
            $this->head = $newNode;

            return $this;
        }

        $prev = $this->head;
        while ($prev->next !== null && $prev->next->value < $value) {
            $prev = $prev->next;
        }

        if ($prev->next !== null) {
            $newNode->linkNext($prev->next);
        }
        $prev->linkNext($newNode);

        return $this;
    }

    public function shiftHead(int $dropFirstNodesCount = 1): self
    {
        $head = $this->head;
        for ($i = 0; $i < $dropFirstNodesCount; $i++) {
            if ($head === null) {
                break;
            }
            $head = $head->next;
        }

        return new self($head, max(0, $this->size - $dropFirstNodesCount));
    }

    public function setSize(int $newSize): self
    {
        if ($newSize > $this->size) {
            return $this;
        }

        $head = $this->head;
        for ($i = $this->size; $i > $newSize; $i--) {
            if ($head === null) {
                break;
            }
            $head = $head->next;
        }

        return new self($head, max(0, $newSize));
    }

    /**
     * @return array<int, int|string>
     */
    public function sliceValues(int $headNodesCount): array
    {
        $head = $this->head;
        $values = [];
        for ($i = 0; $i < $headNodesCount; $i++) {
            if ($head === null) {
                break;
            }
            $values[] = $head->value;
            $head = $head->next;
        }

        return $values;
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
