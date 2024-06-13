<?php

namespace App\Tests\unit;

use App\Entity\Pipedrive\Deal;
use App\Entity\Pipedrive\Status\Status;
use App\Serializer\DealDenormalizer;
use PHPUnit\Framework\TestCase;

class DealDenormalizerTest extends TestCase
{
    private DealDenormalizer $dealDenormalizer;


    public function setUp(): void
    {
        $this->dealDenormalizer = new DealDenormalizer();
    }

    /**
     * @dataProvider requestDataProvider
     */
    public function testDenormalizeDeal(string $dealData, Deal $expectedDeal)
    {
        $deal = $this->dealDenormalizer->denormalize($dealData, Deal::class);

        $this->assertEquals($deal, $expectedDeal);
    }

    public static function requestDataProvider(): array
    {
        return [
            [
                '{"v":1,"matches_filters":{"current":[]},"meta":{"action":"updated","change_source":"app","company_id":13525602,"host":"regeljelease-sandbox3.pipedrive.com","id":1,"is_bulk_update":false,"matches_filters":{"current":[]},"object":"deal","permitted_user_ids":[21369366,21369377],"pipedrive_service_name":false,"timestamp":1718178691,"timestamp_micro":1718178691962867,"prepublish_timestamp":1718178691995,"trans_pending":false,"user_id":21369377,"v":1,"webhook_id":"404975"},"current":{"email_messages_count":0,"cc_email":"regeljelease-sandbox3+deal1@pipedrivemail.com","channel":null,"products_count":1,"next_activity_date":null,"next_activity_type":null,"local_close_date":null,"next_activity_duration":null,"id":1,"person_id":1,"creator_user_id":21369377,"abe5e7a3b992b7c3ff539cab747e65e5cd7ea4da_currency":"EUR","expected_close_date":null,"owner_name":"Joram","participants_count":1,"stage_id":1,"probability":null,"undone_activities_count":0,"active":true,"local_lost_date":null,"person_name":"Testpersoon","last_activity_date":null,"close_time":null,"org_hidden":false,"next_activity_id":null,"weighted_value_currency":"EUR","local_won_date":null,"stage_order_nr":0,"next_activity_subject":null,"rotten_time":null,"user_id":21369377,"visible_to":"3","org_id":1,"notes_count":0,"next_activity_time":null,"210171ff329a4d3e90f48653eb7b1f4c813538ca":null,"channel_id":null,"formatted_value":"€10","status":"open","formatted_weighted_value":"€10","first_won_time":null,"origin":"ManuallyCreated","last_outgoing_mail_time":null,"origin_id":null,"title":"Testdeal","last_activity_id":null,"update_time":"2024-06-12 07:51:31","activities_count":0,"pipeline_id":1,"lost_time":null,"currency":"EUR","weighted_value":10,"org_name":"Testorganisatie","value":10,"person_hidden":false,"next_activity_note":null,"files_count":0,"last_incoming_mail_time":null,"label":null,"lost_reason":null,"abe5e7a3b992b7c3ff539cab747e65e5cd7ea4da":6,"deleted":false,"won_time":null,"followers_count":1,"stage_change_time":"2024-06-11 22:02:39","210171ff329a4d3e90f48653eb7b1f4c813538ca_currency":null,"add_time":"2024-06-11 14:47:20","done_activities_count":0},"previous":{"email_messages_count":0,"cc_email":"regeljelease-sandbox3+deal1@pipedrivemail.com","channel":null,"products_count":1,"next_activity_date":null,"next_activity_type":null,"local_close_date":null,"next_activity_duration":null,"id":1,"person_id":1,"creator_user_id":21369377,"abe5e7a3b992b7c3ff539cab747e65e5cd7ea4da_currency":"EUR","expected_close_date":null,"owner_name":"Joram","participants_count":1,"stage_id":1,"probability":null,"undone_activities_count":0,"active":true,"local_lost_date":null,"person_name":"Testpersoon","last_activity_date":null,"close_time":null,"org_hidden":false,"next_activity_id":null,"weighted_value_currency":"EUR","local_won_date":null,"stage_order_nr":0,"next_activity_subject":null,"rotten_time":null,"user_id":21369377,"visible_to":"3","org_id":1,"notes_count":0,"next_activity_time":null,"210171ff329a4d3e90f48653eb7b1f4c813538ca":null,"channel_id":null,"formatted_value":"€10","status":"open","formatted_weighted_value":"€10","first_won_time":null,"origin":"ManuallyCreated","last_outgoing_mail_time":null,"origin_id":null,"title":"Testdeal","last_activity_id":null,"update_time":"2024-06-12 07:51:04","activities_count":0,"pipeline_id":1,"lost_time":null,"currency":"EUR","weighted_value":10,"org_name":"Testorganisatie","value":10,"person_hidden":false,"next_activity_note":null,"files_count":0,"last_incoming_mail_time":null,"label":null,"lost_reason":null,"abe5e7a3b992b7c3ff539cab747e65e5cd7ea4da":7,"deleted":false,"won_time":null,"followers_count":1,"stage_change_time":"2024-06-11 22:02:39","210171ff329a4d3e90f48653eb7b1f4c813538ca_currency":null,"add_time":"2024-06-11 14:47:20","done_activities_count":0},"retry":0,"event":"updated.deal"}',
                new Deal(1, 10, Status::open->value)
            ]
        ];
    }
}
