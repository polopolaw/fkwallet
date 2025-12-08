<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

final class OnlineProductResponse
{
    /**
     * @param array<int, array{key: string, placeholder: string, values: array<int, string>, info: array<int, string>}> $fields
     */
    public function __construct(
        private readonly int $id,
        private readonly string $nameRu,
        private readonly string $nameEn,
        private readonly string $descriptionRu,
        private readonly string $descriptionEn,
        private readonly string $helpDescriptionRu,
        private readonly string $helpDescriptionEn,
        private readonly string $slug,
        private readonly float $price,
        private readonly string $currency,
        private readonly int $sort,
        private readonly array $fields
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNameRu(): string
    {
        return $this->nameRu;
    }

    public function getNameEn(): string
    {
        return $this->nameEn;
    }

    public function getDescriptionRu(): string
    {
        return $this->descriptionRu;
    }

    public function getDescriptionEn(): string
    {
        return $this->descriptionEn;
    }

    public function getHelpDescriptionRu(): string
    {
        return $this->helpDescriptionRu;
    }

    public function getHelpDescriptionEn(): string
    {
        return $this->helpDescriptionEn;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @return array<int, array{key: string, placeholder: string, values: array<int, string>, info: array<int, string>}>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            $data['name_ru'],
            $data['name_en'],
            $data['description_ru'],
            $data['description_en'],
            $data['help_description_ru'],
            $data['help_description_en'],
            $data['slug'],
            (float) $data['price'],
            $data['currency'],
            (int) ($data['sort'] ?? 0),
            $data['fields'] ?? []
        );
    }
}

