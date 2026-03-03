<?php

declare(strict_types=1);

namespace Hellosworldos\SortedLinkedList\Tests;

use Hellosworldos\SortedLinkedList\LinkedListNode;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class LinkedListNodeTest extends TestCase
{
    public function testItLinksNodeOfTheSameTypeInt(): void
    {
        // arrange
        $node1 = new LinkedListNode(1);
        $node2 = new LinkedListNode(2);

        // act
        $node1->linkNext($node2);

        // assert
        self::assertSame($node2, $node1->next);
    }

    public function testItLinksNodeOfTheSameTypeString(): void
    {
        // arrange
        $node1 = new LinkedListNode('first');
        $node2 = new LinkedListNode('second');

        // act
        $node1->linkNext($node2);

        // assert
        self::assertSame($node2, $node1->next);
    }

    public function testItThrowsExceptionWhenNodesAreNotTheSameType(): void
    {
        // arrange
        $node1 = new LinkedListNode(1);
        $node2 = new LinkedListNode('second');

        // assert
        $this->expectException(UnexpectedValueException::class);

        // act
        $node1->linkNext($node2);
    }

    public function testAfterUnlinkingTheNextIsNull(): void
    {
        // arrange
        $node = new LinkedListNode(1)
            ->linkNext(new LinkedListNode(2));

        // act
        $node->unlinkNext();

        // assert
        self::assertNull($node->next);
    }
}
