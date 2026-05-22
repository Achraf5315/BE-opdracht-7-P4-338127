<?php

namespace Tests\Unit;

use App\Http\Controllers\InstructorController;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use ReflectionProperty;
use Tests\TestCase;

class DashboardPaginationTest extends TestCase
{
    public function test_dashboard_instructors_are_paginated(): void
    {
        $controller = new InstructorController;

        $instructorModelMock = Mockery::mock();
        $instructorModelMock->shouldReceive('InstructorCount')
            ->twice()
            ->andReturn((object) ['InstructorsCount' => 5]);
        $instructorModelMock->shouldReceive('GetAllInstructors')
            ->twice()
            ->andReturn([
                (object) ['Id' => 5, 'FullName' => 'Mohammed El Yassidi', 'Mobile' => '0610000005', 'StartDate' => '2024-01-05', 'NumberOfStars' => 5],
                (object) ['Id' => 4, 'FullName' => 'Bert Van Sali', 'Mobile' => '0610000004', 'StartDate' => '2024-01-04', 'NumberOfStars' => 4],
                (object) ['Id' => 1, 'FullName' => 'Li Zhan', 'Mobile' => '0610000001', 'StartDate' => '2024-01-01', 'NumberOfStars' => 3],
                (object) ['Id' => 3, 'FullName' => 'Yoeri Van Veen', 'Mobile' => '0610000003', 'StartDate' => '2024-01-03', 'NumberOfStars' => 3],
                (object) ['Id' => 2, 'FullName' => 'Leroy Boerhaven', 'Mobile' => '0610000002', 'StartDate' => '2024-01-02', 'NumberOfStars' => 1],
            ]);

        $this->setPrivateProperty($controller, 'InstructorModel', $instructorModelMock);

        $this->app->instance('request', Request::create('/dashboard', 'GET'));

        $firstPage = $controller->index();
        $firstPageData = $firstPage->getData();

        $this->assertInstanceOf(LengthAwarePaginator::class, $firstPageData['instructors']);
        $this->assertCount(4, $firstPageData['instructors']->items());
        $this->assertSame('Mohammed El Yassidi', $firstPageData['instructors']->items()[0]->FullName);
        $this->assertSame('Yoeri Van Veen', $firstPageData['instructors']->items()[3]->FullName);

        $this->app->instance('request', Request::create('/dashboard', 'GET', ['page' => 2]));

        $secondPage = $controller->index();
        $secondPageData = $secondPage->getData();

        $this->assertInstanceOf(LengthAwarePaginator::class, $secondPageData['instructors']);
        $this->assertCount(1, $secondPageData['instructors']->items());
        $this->assertSame('Leroy Boerhaven', $secondPageData['instructors']->items()[0]->FullName);
    }

    private function setPrivateProperty(object $object, string $propertyName, mixed $value): void
    {
        $property = new ReflectionProperty($object, $propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }
}
