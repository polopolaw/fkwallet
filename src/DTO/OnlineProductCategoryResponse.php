<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

final class OnlineProductCategoryResponse
{
    public function __construct(
        private readonly int $id,
        private readonly string $name_ru,
        private readonly string $name_en,
        private readonly string $description_ru,
        private readonly string $description_en,
        private readonly string $slug,
        private readonly int $sort,
        private readonly ?int $parent_id = null
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            $data['name_ru'],
            $data['name_en'],
            $data['description_ru'],
            $data['description_en'],
            $data['slug'],
            (int) $data['sort'],
            (int) $data['parent_id'] ?? null,
        );
    }
}

