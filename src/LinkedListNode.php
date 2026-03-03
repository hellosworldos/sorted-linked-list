<?php

declare(strict_types=1);

namespace Hellosworldos\SortedLinkedList;

use UnexpectedValueException;

class LinkedListNode
{
    public private(set) ?self $next = null;

    public function __construct(
        public readonly int|string $value,
    ) {
    }

    public function linkNext(self $nextNode): self
    {
        $this->validateTypes($nextNode);

        $this->next = $nextNode;
        return $this;
    }

    public function unlinkNext(): self
    {
        $this->next = null;

        return $this;
    }

    private function validateTypes(LinkedListNode $nextNode): void
    {
        $thisType = gettype($this->value);
        $nextType = gettype($nextNode->value);

        if ($thisType !== $nextType) {
            throw new UnexpectedValueException(
                "Cannot link nodes with different value types: $thisType vs $nextType"
            );
        }
    }
}
