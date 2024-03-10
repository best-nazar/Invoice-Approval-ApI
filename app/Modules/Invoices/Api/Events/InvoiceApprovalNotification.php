<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Events;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\invoices\Infrastructure\Entities\Invoice;

class InvoiceApprovalNotification
{
    public function handle(EntityApproved|EntityRejected $event): void
    {
        $invoiceModel = new $event->approvalDto->entity();
        $invoice = $invoiceModel->findOrFail($event->approvalDto->id);

        switch (true) {
            case $event instanceof EntityApproved:
                $this->updateInvoice($invoice, StatusEnum::APPROVED);
                break;
            case $event instanceof EntityRejected:
                $this->updateInvoice($invoice, StatusEnum::REJECTED);
                break;
        }
    }

    protected function updateInvoice(Invoice $invoice, $status)
    {
        $invoice->status = $status;
        $invoice->save();
    }
}
