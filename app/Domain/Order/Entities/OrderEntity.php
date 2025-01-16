<?php
namespace App\Domains\Orders\Entities;

use App\Domain\Product\Entities\ProductEntity;

class OrderEntity
{
    private int $id;
    private int $userId;
    private ProductEntity $product;
    private string $notes;
    private string $status;

    public function __construct(
        int $id,
        int $userId,
        ProductEntity $product,
        string $notes,
        string $status
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->product = $product;
        $this->notes = $notes;
        $this->status = $status;
    }

    // Getter per le proprietà
    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProduct(): ProductEntity
    {
        return $this->product;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function getStatus(): string
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
