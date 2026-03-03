<?php
declare(strict_types=1);

namespace Hellosworldos\SortedLinkedList;

class MergeSortingStrategy implements SortingStrategy
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
            $slow = $slow->next;
            $fast = $fast->next->next;
        }

        return $slow;
    }

    private function sortedMerge(?LinkedListNode $a, ?LinkedListNode $b): ?LinkedListNode
    {
        $dummy = new LinkedListNode(0);
        $tail = $dummy;

        while ($a !== null && $b !== null) {
            if ($a->value <= $b->value) {
                $tail->linkNext($a);
                $a = $a->next;
            } else {
                $tail->linkNext($b);
                $b = $b->next;
            }
            $tail = $tail->next;
            $tail->unlinkNext();
        }

        $tail->linkNext($a ?? $b);

        return $dummy->next;
    }
}