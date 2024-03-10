<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\UuidInterface;

class Invoice extends Model
{
    use EntityTrait;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = 'invoices';
    protected $hidden = ['company_id', 'created_at', 'updated_at'];
    protected $fillable = ['id', 'number', 'created_at', 'updated_at', 'date', 'due_date', 'company_id', 'status'];

    /**
     * The "type" of the primary key ID.
     */
    protected $keyType = UuidInterface::class;


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'invoice_product_lines')
            ->using(InvoiceProduct::class)
            ->as('item')
            ->withPivot('quantity');

    }
}
