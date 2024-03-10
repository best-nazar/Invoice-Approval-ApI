<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class InvoiceProduct extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = 'invoice_product_lines';

    protected $hidden = ['product_id', 'invoice_id'];
}
