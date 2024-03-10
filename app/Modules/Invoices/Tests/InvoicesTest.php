<?php

namespace App\Modules\Invoices\Tests;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Infrastructure\Entities\Company;
use App\Modules\Invoices\Infrastructure\Entities\Invoice;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InvoicesTest extends TestCase
{
    protected const API_URL = '/api/invoice/';
    private Invoice $testInvoice;

    public function setUp(): void
    {
        parent::setUp();

        $company = Company::take(1)->get()->first();
        $invoice = Invoice::create([
            'id' => Uuid::uuid4()->toString(),
            'number' => Uuid::uuid4()->toString(),
            'date' => now(),
            'due_date' => now(),
            'company_id' => $company->id,
            'status' => StatusEnum::DRAFT->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->testInvoice = $invoice;
    }

    public function testShowInvoice()
    {
        $response = $this->json('GET',  self::API_URL . $this->testInvoice->id);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'number',
                'date',
                'due_date',
                'company' => ['name', 'street', 'city', 'zip', 'phone', 'email'] ,
                'products' => ['*' => ['name', 'price', 'currency', 'item' => [
                    'quantity'
                ]]]
            ]
        ], $response->json());

        $response->assertStatus(200);
    }

    public function testApproveInvoice()
    {
        $response = $this->json('POST',  self::API_URL . $this->testInvoice->id . '/approve');
        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(StatusEnum::APPROVED->value, $data['status']);
    }

    public function testCantApproveInvoice()
    {
        $this->testInvoice->status = StatusEnum::APPROVED->value;
        $this->testInvoice->save();

        $response = $this->json('POST',  self::API_URL . $this->testInvoice->id . '/approve');
        $response->assertStatus(409);
    }

    public function tearDown(): void
    {
        $this->testInvoice->delete();
    }
}
