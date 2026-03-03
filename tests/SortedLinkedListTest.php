<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;

class SortedLinkedListTest extends TestCase
{
    public function testEmptyListGetsEmptyResultAndHasZeroLength(): void
    {
        // act
        $list = new SortedLinkedList();
    }
}