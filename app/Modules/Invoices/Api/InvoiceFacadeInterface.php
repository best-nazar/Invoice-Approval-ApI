<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api;

use App\Modules\invoices\Infrastructure\Entities\Invoice;
use Illuminate\Database\Eloquent\Model;

interface InvoiceFacadeInterface
{
    /**
     * @param string $id Invoice Identifier.
     */
    public function show(string $id): Model;
    public function approve(string $id): Invoice;
    public function reject(string $id): Invoice;
}
