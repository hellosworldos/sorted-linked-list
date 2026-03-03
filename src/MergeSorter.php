<?php

declare(strict_types=1);

namespace Hellosworldos\SortedLinkedList;

class MergeSorter implements Sorter
{
    public function sort(?LinkedListNode $head): ?LinkedListNode
    {
        if ($head === null || $head->next === null) {
            return $head;
        }

        $middle = $this->getMiddle($head);
        $nextToMiddle = $middle->next;
        $middle->unlinkNext();

        $left = $this->sort($head);
        $right = $this->sort($nextToMiddle);

        return $this->sortedMerge($left, $right);
    }

    private function getMiddle(LinkedListNode $head): LinkedListNode
    {
        $slow = $head;
        $fast = $head->next;

        while ($fast !== null && $fast->next !== null) {
            $nextSlow = $slow->next;
            assert($nextSlow !== null);
            $slow = $nextSlow;
            $fast = $fast->next->next;
        }

        return $slow;
    }

    private function sortedMerge(?LinkedListNode $a, ?LinkedListNode $b): ?LinkedListNode
    {
        $head = null;
        $tail = null;

        while ($a !== null && $b !== null) {
            if ($a->value <= $b->value) {
                $node = $a;
                $a = $a->next;
            } else {
                $node = $b;
                $b = $b->next;
            }

            $node->unlinkNext();

            if ($tail === null) {
                $head = $node;
                $tail = $node;
            } else {
                $tail->linkNext($node);
                $tail = $node;
            }
        }

        $remainder = $a ?? $b;

        if ($tail === null) {
            $head = $remainder;
        } elseif ($remainder !== null) {
            $tail->linkNext($remainder);
        }

        return $head;
    }
}
