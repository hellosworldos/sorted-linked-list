<?php
declare(strict_types=1);

namespace Hellosworldos\SortedLinkedList\Tests;

use Hellosworldos\SortedLinkedList\ListNode;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class ListNodeTest extends TestCase
{
    public function testItLinksNodeOfTheSameTypeInt(): void
    {
        // arrange
        $node1 = new ListNode(1);
        $node2 = new ListNode(2);

        // act
        $node1->linkNext($node2);

        // assert
        self::assertSame($node2, $node1->next);
    }

    public function testItLinksNodeOfTheSameTypeString(): void
    {
        // arrange
        $node1 = new ListNode('first');
        $node2 = new ListNode('second');

        // act
        $node1->linkNext($node2);

        // assert
        self::assertSame($node2, $node1->next);
    }

    public function testItThrowsExceptionWhenNodesAreNotTheSameType(): void
    {
        // arrange
        $node1 = new ListNode(1);
        $node2 = new ListNode('second');

        // assert
        $this->expectException(UnexpectedValueException::class);

        // act
        $node1->linkNext($node2);
    }

    public function testAfterUnlinkingTheNextIsNull(): void
    {
        // arrange
        $node = new ListNode(1)
            ->linkNext(new ListNode(2));

        // act
        $node->unlinkNext();

        // assert
        self::assertNull($node->next);
    }
}
