<?php

declare(strict_types=1);

namespace Hellosworldos\SortedLinkedList;

interface Sorter
{
    public function sort(?LinkedListNode $head): ?LinkedListNode;
}
