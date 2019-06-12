<?php

namespace App\Tests\Unit\Controller;

use App\Controller\DefaultController;
use App\Repository\HospitalRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DefaultControllerTest extends TestCase
{
    /** @var DefaultController $controller */
    private $controller;

    protected function setUp(): void
    {
        $this->controller = new DefaultController();
    }


    public function testHospitalListAction()
    {
        $expected = [
            'St. Thomas'
        ];

        $hospitalRepository = $this->createMock(HospitalRepository::class);
        $hospitalRepository
            ->expects($this->once())
            ->method('findBy')
            ->with($this->equalTo([]))
            ->willReturn($expected)
        ;

        $actual = $this->controller->hospitalListAction($hospitalRepository);
        $this->assertEquals(['hospitals' => $expected], $actual);
    }
}
