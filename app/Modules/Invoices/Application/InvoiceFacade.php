<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\invoices\Infrastructure\Entities\Invoice;
use Illuminate\Database\Eloquent\Model;
use LogicException;

class InvoiceFacade implements InvoiceFacadeInterface
{
    public function __construct(protected Invoice $model, protected ApprovalFacadeInterface $approval)
    {
    }

    /**
     * @param string $id Invoice Identifier
     */
    public function show(string $id): Model
    {
        return $this->model->with(['company', 'products'])->findOrFail($id);
    }

    /**
     * @param string $id Invoice Identifier
     * @throws LogicException
     */
    public function approve(string $id): Invoice
    {
        return $this->updateInvoiceStatus($id, StatusEnum::APPROVED);
    }

    /**
     * @param string $id Invoice Identifier
     * @throws LogicException
     */
    public function reject(string $id): Invoice
    {
        return $this->updateInvoiceStatus($id, StatusEnum::REJECTED);
    }

    /**
     * @param string $id    Invoice identifier
     * @throws LogicException
     */
    protected function updateInvoiceStatus(string $id, StatusEnum $status): Invoice
    {
        $invoice = $this->model->findOrFail($id);
        $approvalDTO = new ApprovalDto($invoice->id, $invoice->status, get_class($invoice));

        switch ($status) {
            case StatusEnum::APPROVED:
                $this->approval->approve($approvalDTO);
                break;
            case StatusEnum::REJECTED:
                $this->approval->reject($approvalDTO);
                break;
            default:
                throw new LogicException(sprintf('Status %s not supported', $status->value));
        }

        return $invoice->fresh();
    }
}
