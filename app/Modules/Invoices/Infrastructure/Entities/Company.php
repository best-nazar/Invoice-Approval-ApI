<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use EntityTrait;

    protected $table = 'companies';
    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'invoices_company_id_foreign');
    }
}
