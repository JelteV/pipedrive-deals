<?php

namespace App\Tests\unit;

use App\Entity\Pipedrive\Field\EntityField;
use App\Entity\Pipedrive\Field\Field;
use App\Entity\Pipedrive\Stage\BinnenKomendeDeals;
use App\Entity\Pipedrive\Stage\LageWaarde;
use App\Service\DealChangeDetector;
use App\Service\DealService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

class DealProcessableChangesTest extends KernelTestCase
{
    private DealService $dealService;
    private DealChangeDetector $dealChangeDetector;

    public function setUp(): void
    {
        $this->dealChangeDetector = new DealChangeDetector();
        $this->dealService = self::getContainer()->get(DealService::class);
    }

    /** @dataProvider hasChangedPaymentDetailsDataProvider */
    public function testHasChangedPaymentDetails(Request $request, bool $expected): void
    {
        $deal = $this->dealService->fromWebhookData($request);

        $this->assertEquals($this->dealChangeDetector->hasChangedPaymentDetails($request, $deal), $expected);
    }

    /** @dataProvider hasChangedDealValueDataProvider */
    public function testHasChangedDealValue(Request $request, bool $expected): void
    {
        $this->assertEquals($this->dealChangeDetector->hasChangedDealValue($request), $expected);
    }

    /** @dataProvider hasDealStatusChangedDataProvider */
    public function testHasDealStatusChanged(Request $request, bool $expected): void
    {
        $this->assertEquals($this->dealChangeDetector->hasChangedDealStatus($request), $expected);
    }

    /**
     * @dataProvider hasChangedDealStageDataProvider
     */
    public function testHasChangedDealStage(Request $request, bool $expected)
    {
        $this->assertEquals($this->dealChangeDetector->hasChangedDealStage($request), $expected);
    }

    public static function hasChangedPaymentDetailsDataProvider(): array
    {
        $prePaymentField = new Field(EntityField::prePaymentField->value, 'abe5e7a3b992b7c3ff539cab747e65e5cd7ea4da', 0.0);
        $postPaymentField = new Field(EntityField::postPaymentField->value, '210171ff329a4d3e90f48653eb7b1f4c813538ca', 0.0);

        return [
            [
                self::createRequest(
                    [
                        "current" => ['id' => 0, 'value' => 5, 'status' => 'open',  $prePaymentField->getKey() => null, $postPaymentField->getKey() => 5],
                        'previous' => ['id' => 0, 'value' => 5, 'status' => 'open',  $prePaymentField->getKey() => 5, $postPaymentField->getKey() => 5,]
                    ]
                ),
                true
            ],
            [
                self::createRequest(
                    [
                        "current" => ['id' => 0, 'value' => 5, 'status' => 'open', $prePaymentField->getKey() => 9, $postPaymentField->getKey() => 5],
                        'previous' => ['id' => 0, 'value' => 5, 'status' => 'open', $prePaymentField->getKey() => 5, $postPaymentField->getKey() => 5]
                    ]
                ),
                true
            ],
            [
                self::createRequest(
                    [
                        "current" => ['id' => 0, 'value' => 5, 'status' => 'open', $prePaymentField->getKey() => 5, $postPaymentField->getKey() => null],
                        'previous' => ['id' => 0, 'value' => 5, 'status' => 'open', $prePaymentField->getKey() => 5, $postPaymentField->getKey() => null],
                    ]
                ),
                false
            ],
            [
                self::createRequest(
                    [
                        "current" => ['id' => 0, 'value' => 5, 'status' => 'open', $prePaymentField->getKey() => null, $postPaymentField->getKey() => 5],
                        'previous' => ['id' => 0, 'value' => 5, 'status' => 'open', $prePaymentField->getKey() => null, $postPaymentField->getKey() => 5]
                    ]
                ),
                false
            ],
        ];
    }

    public static function hasChangedDealValueDataProvider(): array
    {
        return [
            [self::createRequest(["current" => ['value' => null], 'previous' => ['value' => 7]]), true],
            [self::createRequest(["current" => ['value' => 90], 'previous' => ['value' => null]]), true],
            [self::createRequest(["current" => ['value' => null], 'previous' => ['value' => null]]), false],
            [self::createRequest(["current" => ['value' => 7], 'previous' => ['value' => 7]]), false],
        ];
    }

    public static function hasDealStatusChangedDataProvider(): array
    {
        return [
            [self::createRequest(["current" => ['id' => 0, 'status' => 'open'], 'previous' => ['status' => 'lost']]), true],
            [self::createRequest(["current" => ['id' => 0, 'status' => 'won'], 'previous' => ['status' => 'open']]), true],
            [self::createRequest(["current" => ['id' => 0, 'status' => 'won'], 'previous' => ['status' => 'won']]), false],
            [self::createRequest(["current" => ['id' => 0, 'status' => null], 'previous' => ['status' => null]]), false],
        ];
    }

    public static function hasChangedDealStageDataProvider(): array
    {
        return [
            [self::createRequest(["current" => ['id' => 0, 'stage_id' => (new BinnenKomendeDeals())->getStageId()], 'previous' => ['stage_id' => (new LageWaarde())->getStageId()]]), true],
            [self::createRequest(["current" => ['id' => 0, 'stage_id' => (new BinnenKomendeDeals())->getStageId()], 'previous' => ['stage_id' => (new BinnenKomendeDeals())->getStageId()]]), false]
        ];
    }

    private static function createRequest(array $body): Request
    {
        return Request::create('foo.bar', Request::METHOD_POST, [], [], [], [], json_encode($body, false));
    }
}
