<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

use Jhernandes\AciRedShield\Domain\Item;

class Cart implements \JsonSerializable, \Countable
{
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public static function fromItems(Item ...$items): self
    {
        $cart = new self();
        foreach ($items as $item) {
            $cart->addItem($item);
        }

        return $cart;
    }

    public function addItem(
        Item $item
    ): void {
        $this->items[] = $item;
    }

    public function addItemFromValues(
        string $name,
        float $originalPrice,
        int $quantity,
        string $sku
    ): void {
        $this->items[] = Item::fromValues($name, $originalPrice, $quantity, $sku);
    }

    public function jsonSerialize(): array
    {
        return [
            'items' => array_map(fn ($item) => $item->jsonSerialize(), $this->items)
        ];
    }

    public function count(): int
    {
        return count($this->items);
    }
}
