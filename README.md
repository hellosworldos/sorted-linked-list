# sorted-linked-list

A simple implementation of a sorted linked list.

```php
# initialization
$intList = SortedLinkedList::fromArray([20, 10, 30]);
$stringList = SortedLinkedList::fromArray(['banana', 'apple', 'tomato']);

# get the head value
$intList->head->value;

# get the nodes count
$intList->size

# iterating over sorted elements
foreach ($intList as $value) {
    echo $value . "\n";
}

# shifting the head to the next node
$newList = $intList->shiftHead();

# shifting the head to the 5 nodes
$newList = $intList->shiftHead(5);

# dropping the first nodes according to the new limit
$newList = $intList->setSize(2);

# Get first X node values from the list (minimal ones)
$nodeValues = $intList->sliceValues(2);

```