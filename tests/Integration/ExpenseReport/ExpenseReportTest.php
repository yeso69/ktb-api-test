<?php

declare(strict_types=1);

namespace App\Tests\Integration\ExpenseReport;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

final class ExpenseReportTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetExpenseReportCollection(): void
    {
        // Act
        static::createClient()->request('GET', '/api/expense_reports');

        // Assert
        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            "hydra:totalItems" => 5,
        ]);
    }

    public function testGetAnExpenseReport(): void
    {
        // Act
        $response = static::createClient()->request('GET', '/api/expense_reports/1');

        // Assert
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            "@context" => "/api/contexts/ExpenseReport",
            "@id" => "/api/expense_reports/1",
            "@type" => "ExpenseReport",
            "id" => 1,
            "user" => "/api/users/1",
        ]);
    }

    public function testCreateExpenseReport(): void
    {
        // Act
        $response = static::createClient()->request('POST', '/api/expense_reports', [
            'json' => [
                'date' => '2023-03-20T01:31:25.825Z',
                'amount'=> 25,
                'type'=> 'IT equipment',
                'user'=> '/api/users/1',
            ]
        ]);

        // Assert
        $this->assertResponseStatusCodeSame(201);
        $this->assertNotEmpty($response->toArray()['createdAt']);
    }

    public function testCreateAnExpenseReportWithoutAUserReturnsA400Error(): void
    {
        // Act
        static::createClient()->request('POST', '/api/expense_reports', [
            'json' => [
                'date' => '2023-03-20T01:31:25.825Z',
                'amount'=> 25,
                'type'=> 'IT equipment',
                'user'=> null,
            ]
        ]);

        // Assert
        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreateAnExpenseReportWithANegativeAmountReturnsA422ValidationError(): void
    {
        // Act
        static::createClient()->request('POST', '/api/expense_reports', [
            'json' => [
                'date' => '2023-03-20T01:31:25.825Z',
                'amount'=> -25,
                'type'=> 'IT equipment',
                'user'=> '/api/users/1',
            ]
        ]);

        // Assert
        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonContains([
            "hydra:description" => "amount: This value should be positive.",
        ]);
    }

    public function testCreateAnExpenseReportWithAnInvalidDateReturnsA400Error(): void
    {
        // Act
        static::createClient()->request('POST', '/api/expense_reports', [
            'json' => [
                'date' => '6 janvier 2023',
                'amount'=> 25,
                'type'=> 'IT equipment',
                'user'=> '/api/users/1',
            ]
        ]);

        // Assert
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains([
            "hydra:description" => "DateTime::__construct(): Failed to parse time string (6 janvier 2023) at position 5 (v): The timezone could not be found in the database",
        ]);
    }

    public function testUpdateExpenseReportWithPut(): void
    {
        // Act
        static::createClient()->request('PUT', '/api/expense_reports/1', [
            'json' => [
                'amount'=> 666,
            ]
        ]);

        // Assert
        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            "amount" => 666,
        ]);
    }

    public function testUpdateExpenseReportWithPatch(): void
    {
        // Act
        static::createClient()->request('PATCH', '/api/expense_reports/1', [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ],
            'json' => [
                'amount'=> 777,
            ]
        ]);

        // Assert
        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            "amount" => 777,
        ]);
    }

    public function testDeleteAnExpenseReport(): void
    {
        // Act
        static::createClient()->request('DELETE', '/api/expense_reports/1');

        // Assert
        $this->assertResponseStatusCodeSame(204);
    }

    public function testDeletingAnUnexistingExpenseReportReturnsa404Error(): void
    {
        // Act
        static::createClient()->request('DELETE', '/api/expense_reports/123456789');

        // Assert
        $this->assertResponseStatusCodeSame(404);
    }
}