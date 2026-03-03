<?php

declare(strict_types=1);

namespace Hellosworldos\SortedLinkedList;

class SortedLinkedList
{
    public ?LinkedListNode $head;

    public function __construct(?LinkedListNode $head = null, private readonly SortingStrategy $sortingStrategy = new MergeSortingStrategy())
    {
        $this->head = $head;
    }

    /**
     * Build a sorted linked list from an array of values using merge sort on the list.
     * This is O(n log n) time and uses O(log n) stack for recursion (top-down).
     * Values are cast to int to match LinkedListNode signature.
     * @param array<int|string> $items
     */
    public static function fromArray(array $items, SortingStrategy $sortingStrategy = new MergeSortingStrategy()): self
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

        return new self($sortingStrategy->sort($head), $sortingStrategy);
    }

    public function toArray(): array
    {
        $out = [];
        $node = $this->head;
        while ($node !== null) {
            $out[] = $node->value;
            $node = $node->next;
        }
        return $out;
    }
}

