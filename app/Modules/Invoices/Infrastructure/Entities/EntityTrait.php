<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Entities;

use App\Domain\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait EntityTrait
{
    public $timestamps = true;

    public function id(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Uuid::fromString($value),
            set: fn(string|UuidInterface $value) => $value instanceof UuidInterface ? $value : Uuid::fromString($value)
        );
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => StatusEnum::tryFrom($value),
            set: fn(string|StatusEnum $value) => $value instanceof StatusEnum ? $value : StatusEnum::tryFrom($value)
        );
    }
}
