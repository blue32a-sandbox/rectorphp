<?php

declare(strict_types=1);

/**
 * 組み込みインターフェースの実装
 */
// PHP 8.1 で非推奨: 組み込みインターフェースのメソッドに戻り値の型がない
// PHP 8.1 で非推奨: Serializable インターフェース → __serialize() / __unserialize()
final class Tags implements ArrayAccess, Countable, IteratorAggregate, Serializable
{
    private array $items = [];

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function count()
    {
        return count($this->items);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function serialize()
    {
        return json_encode($this->items);
    }

    public function unserialize($data)
    {
        $this->items = json_decode($data, true);
    }
}

function demo_collection(): array
{
    $tags = new Tags();
    $tags['lang'] = 'php';
    $tags['tool'] = 'rector';

    $restored = unserialize(serialize($tags));

    return [
        'count'    => count($tags),
        'items'    => iterator_to_array($tags),
        'restored' => $restored['tool'],
    ];
}
