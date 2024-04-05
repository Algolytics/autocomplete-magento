<?php
declare(strict_types=1);

/**
 * File: UserOperationsTest.php
 *
 * @copyright Copyright (C) 2022 Algomaps (https://algomaps.com)
 */

namespace Algolytics\AlgoIntegration\Test\Unit\Model\Api;

use Algolytics\AlgoIntegration\Api\Config\ConfigProviderInterface;
use Algolytics\AlgoIntegration\Api\HintsInterface;
use Algolytics\AlgoIntegration\Model\Api\Hints;
use Algolytics\AlgoIntegration\Model\Api\HintsFactory;
use Algolytics\AlgoIntegration\Model\Api\UserOperations;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Psr7\Response;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

/**
 * Class UserOperationsTest
 * @package Algolytics\AlgoIntegration\Test\Unit\Model\Api
 */
class UserOperationsTest extends TestCase
{
    /**
     * @var object
     */
    private object $userOperations;

    /**
     * @var ConfigProviderInterface|ConfigProviderInterface&MockObject|MockObject
     */
    private $configProviderMock;

    /**
     * @var ClientFactory|ClientFactory&MockObject|MockObject
     */
    private $clientFactoryMock;

    /**
     * @var Client&MockObject|MockObject
     */
    private $clientMock;

    /**
     * @var Response|Response&MockObject|MockObject
     */
    private $responseMock;

    /**
     * @var MockObject|StreamInterface|StreamInterface&MockObject
     */
    private $streamInterfaceMock;

    /**
     * @var HintsFactory|HintsFactory&MockObject|MockObject
     */
    private $hintsFactoryMock;

    /**
     * @var Hints|Hints&MockObject|MockObject
     */
    private $hintsMock;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->addMethods(['get', 'post'])
            ->getMock();

        $this->hintsMock = $this->createMock(Hints::class);
        $this->hintsFactoryMock = $this->createMock(HintsFactory::class);
        $this->hintsFactoryMock->method('create')->willReturn($this->hintsMock);
        $this->streamInterfaceMock = $this->createMock(StreamInterface::class);
        $this->responseMock = $this->createMock(Response::class);
        $this->responseMock->method('getBody')->willReturn($this->streamInterfaceMock);
        $this->configProviderMock = $this->createMock(ConfigProviderInterface::class);
        $this->configProviderMock->method('getAuthorizationHeaderName')->willReturn('');
        $this->configProviderMock->method('isActive')->willReturn(true);
        $this->clientMock->method('post')->willReturn($this->responseMock);
        $this->clientFactoryMock = $this->createMock(ClientFactory::class);
        $this->clientFactoryMock->method('create')->willReturn($this->clientMock);

        $objectManager = new ObjectManagerHelper($this);

        $this->userOperations = $objectManager->getObject(UserOperations::class, [
            'configProvider' => $this->configProviderMock,
            'clientFactory' => $this->clientFactoryMock,
            'hintsFactory' => $this->hintsFactoryMock
        ]);
    }

    /**
     * @return void
     */
    public function testCheckPostalCode(): void
    {
        $this->clientMock->method('get')->willReturn($this->responseMock);
        $this->responseMock->method('getStatusCode')->willReturn(200);

        $result = $this->userOperations->checkPostalCode('44100');

        $this->assertEquals(200, $result);
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testAutoCompleteCity(): void
    {
        $json = '{"hints":[{"lookedUpName":null,"actualName":"Tarnawa","hasStreets":true},{"lookedUpName":null,"actualName":"Tarnawa Dolna","hasStreets":false},{"lookedUpName":null,"actualName":"Tarnawa Duża","hasStreets":false},{"lookedUpName":null,"actualName":"Tarnawa Górna","hasStreets":false},{"lookedUpName":null,"actualName":"Tarnawa Krośnieńska","hasStreets":false},{"lookedUpName":null,"actualName":"Tarnawa Mała","hasStreets":false},{"lookedUpName":null,"actualName":"Tarnawa Niżna","hasStreets":false},{"lookedUpName":null,"actualName":"Tarnawa Rzepińska","hasStreets":false},{"lookedUpName":null,"actualName":"Tarnawa Wyżna","hasStreets":false},{"lookedUpName":null,"actualName":"Tarnawa-Góra","hasStreets":false}]}';
        $this->streamInterfaceMock->method('getContents')->willReturn($json);

        $result = $this->userOperations->autoCompleteCity('Ka');

        $dataToTest = $this->getJsonDecode($json);

        $this->assertCount(10, $dataToTest['hints']);
        $this->assertEquals('Tarnawa', $dataToTest['hints'][0]['actualName']);
        $this->assertInstanceOf(HintsInterface::class, $result);
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testAutoCompleteStreet(): void
    {
        $json = '{"hints":[{"lookedUpName":null,"actualName":"Szabelniana"},{"lookedUpName":null,"actualName":"Szadoka"},{"lookedUpName":null,"actualName":"Szafirowa"},{"lookedUpName":null,"actualName":"Szałwiowa"},{"lookedUpName":null,"actualName":"Szarotek"},{"lookedUpName":null,"actualName":"Szarych Szeregów"},{"lookedUpName":null,"actualName":"Szczecińska"},{"lookedUpName":null,"actualName":"Szczupaków"},{"lookedUpName":null,"actualName":"Szczygłów"},{"lookedUpName":null,"actualName":"Szeroka"}]}';
        $this->streamInterfaceMock->method('getContents')->willReturn($json);

        $result = $this->userOperations->autoCompleteStreet('Katowice', 'Sz');

        $dataToTest = $this->getJsonDecode($json);

        $this->assertCount(10, $dataToTest['hints']);
        $this->assertEquals('Szabelniana', $dataToTest['hints'][0]['actualName']);
        $this->assertInstanceOf(HintsInterface::class, $result);
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testAutoCompleteBuildingNumber(): void
    {
        $json = '{"hints":[{"postalCode":"40-370","buildingNumber":"1A"},{"postalCode":"40-370","buildingNumber":"1B"},{"postalCode":"40-370","buildingNumber":"12"},{"postalCode":"40-370","buildingNumber":"14"},{"postalCode":"40-370","buildingNumber":"16"}]}';
        $this->streamInterfaceMock->method('getContents')->willReturn($json);

        $result = $this->userOperations->autoCompleteStreet('Katowice', 'Szabelniana', '1');

        $dataToTest = $this->getJsonDecode($json);

        $this->assertCount(5, $dataToTest['hints']);
        $this->assertEquals('40-370', $dataToTest['hints'][0]['postalCode']);
        $this->assertInstanceOf(HintsInterface::class, $result);
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testAutoCompletePostalCode()
    {
        $json = '{"hints":[{"postalCode":"40-370"}]}';
        $this->streamInterfaceMock->method('getContents')->willReturn($json);

        $result = $this->userOperations->autoCompletePostalCode('Katowice', 'Szabelniana', '1A');

        $dataToTest = $this->getJsonDecode($json);

        $this->assertCount(1, $dataToTest['hints']);
        $this->assertEquals('40-370', $dataToTest['hints'][0]['postalCode']);
        $this->assertInstanceOf(HintsInterface::class, $result);
    }

    /**
     * @param string $json
     * @return array
     * @throws \JsonException
     */
    private function getJsonDecode(string $json): array
    {
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }
}
