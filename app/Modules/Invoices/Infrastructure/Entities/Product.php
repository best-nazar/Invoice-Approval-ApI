<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use EntityTrait;

    protected $table = 'products';
    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class);
    }
}
