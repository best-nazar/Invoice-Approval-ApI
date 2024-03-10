<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Controllers;

use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use LogicException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class InvoicesController extends Controller
{
    public function __construct(
        protected InvoiceFacadeInterface $invoiceFacade
    ){}

    public function show(string $id): JsonResponse
    {
        $invoice =  $this->invoiceFacade->show($id);

        return response()->json([
            'data' => $invoice
        ]);
    }

    public function approve(string $id): JsonResponse
    {
        try {
            $invoice = $this->invoiceFacade->approve($id);

            return response()->json([
                'data' => $invoice,
            ]);
        } catch (LogicException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], ResponseAlias::HTTP_CONFLICT);
        }
    }

    public function reject(string $id): JsonResponse
    {
        try {
            $invoice = $this->invoiceFacade->reject($id);

            return response()->json([
                'data' => $invoice,
            ]);
        } catch (LogicException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], ResponseAlias::HTTP_CONFLICT);
        }
    }
}
