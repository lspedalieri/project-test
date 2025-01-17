<?php
namespace App\Domain\Order\Entities;

use App\Domain\Product\Entities\ProductEntity;
use App\Domain\Order\Enums\OrderStatus;
use App\Models\User;

class OrderEntity
{
    public function __construct(
        public int $id,
        public User $user,
        public ProductEntity $product,
        public string $notes,
        public OrderStatus $status
    ) {}

    // Getter per le proprietà
    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user->id;
    }

    public function getProduct(): ProductEntity
    {
        return $this->product;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    // Logica di dominio (esempio)
    public function canBeCanceled(): bool
    {
        return $this->status !== 'cancellato';
    }

    public function markAsSent(): void
    {
        if ($this->status === 'ordinato') {
            $this->status = 'inviato';
        }
    }
}
