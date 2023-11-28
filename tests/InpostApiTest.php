<?php

use PHPUnit\Framework\TestCase;

use App\Command\InpostApiCommand;
use Symfony\Component\Console\Tester\CommandTester;

class InpostTest extends TestCase
{
    public function testGetDataIsCalled(): void
    {
        $serializerMock = $this->createMock(\Symfony\Component\Serializer\SerializerInterface::class);

        $inpostMock = $this->getMockBuilder(\App\Service\Inpost::class)
            ->setConstructorArgs([$serializerMock])
            ->onlyMethods(['getData'])
            ->getMock();

        $inpostMock->expects($this->once())
            ->method('getData')
            ->willReturn([
                'resources' => (object) ['count' => 0, 'page' => 1, 'totalPages' => 1],
                'items' => []
            ]);

        $command = new InpostApiCommand($inpostMock);

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'resource' => 'points',
            'city' => 'Podlipie',
        ]);

        $this->assertEquals('[OK] No results found for the provided query.', trim($commandTester->getDisplay()));
    }

    public function testGetDataWithItems(): void
    {
        $serializerMock = $this->createMock(\Symfony\Component\Serializer\SerializerInterface::class);

        $item = new \App\Entity\Inpost\Items();
        $item->setName("PLP01M");
        $item->setAddress('{"city":"Podlipie","province":"małopolskie","post_code":"32-329","street":"Podlipie","building_number":"1","flat_number":null}');

        $inpostMock = $this->getMockBuilder(\App\Service\Inpost::class)
            ->setConstructorArgs([$serializerMock])
            ->onlyMethods(['getData'])
            ->getMock();

        $inpostMock->expects($this->once())
            ->method('getData')
            ->willReturn([
                'resources' => (object) ['count' => 0, 'page' => 1, 'totalPages' => 1],
                'items' => [$item]
            ]);

        $command = new InpostApiCommand($inpostMock);

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'resource' => 'points',
            'city' => 'Podlipie',
        ]);

        $this->assertEquals('[OK] Data fetched and deserialized successfully.', trim($commandTester->getDisplay()));
    }
}
