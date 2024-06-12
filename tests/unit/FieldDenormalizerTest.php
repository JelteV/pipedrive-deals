<?php

namespace App\Tests\unit;

use App\Entity\Pipedrive\Field\Field;
use App\Serializer\FieldDenormalizer;
use PHPUnit\Framework\TestCase;

class FieldDenormalizerTest extends TestCase
{
    private FieldDenormalizer $fieldDenormalizer;

    public function setUp(): void
    {
        $this->fieldDenormalizer = new FieldDenormalizer();
    }

    /**
     * @dataProvider requestDataProvider
     */
    public function testDenormalizeField($fieldData, Field $expectedField): void
    {
        $field = $this->fieldDenormalizer->denormalize($fieldData, Field::class);

        $this->assertEquals($field, $expectedField);
    }

    public static function requestDataProvider(): array
    {
        return [
            [
                '{	"success": true,	"data": {		"id": 39,		"key": "210171ff329a4d3e90f48653eb7b1f4c813538ca",		"name": "Betaling achteraf",		"group_id": null,		"order_nr": 2,		"field_type": "monetary",		"json_column_flag": true,		"add_time": "2024-06-11 14:43:43",		"update_time": "2024-06-11 14:43:43",		"last_updated_by_user_id": 21369366,		"edit_flag": true,		"details_visible_flag": true,		"add_visible_flag": false,		"important_flag": false,		"bulk_edit_allowed": true,		"filtering_allowed": true,		"sortable_flag": true,		"searchable_flag": true,		"description": null,		"created_by_user_id": 21369366,		"projects_detail_visible_flag": false,		"show_in_pipelines": {			"show_in_all": true,			"pipeline_ids": []		},		"mandatory_flag": false,		"subfields": [			{				"id": null,				"key": "210171ff329a4d3e90f48653eb7b1f4c813538ca_currency",				"field_type": "varchar",				"label": "Currency of Betaling achteraf",				"edit_flag": true,				"mandatory_flag": false			}		]	},	"additional_data": null}',
                new Field(39, "210171ff329a4d3e90f48653eb7b1f4c813538ca", null)
            ],
            [
                '{	"success": true,	"data": {		"id": 38,		"key": "abe5e7a3b992b7c3ff539cab747e65e5cd7ea4da",		"name": "Betaling vooraf",		"group_id": null,		"order_nr": 1,		"field_type": "monetary",		"json_column_flag": true,		"add_time": "2024-06-11 14:43:30",		"update_time": "2024-06-11 14:43:30",		"last_updated_by_user_id": 21369366,		"edit_flag": true,		"details_visible_flag": true,		"add_visible_flag": false,		"important_flag": false,		"bulk_edit_allowed": true,		"filtering_allowed": true,		"sortable_flag": true,		"searchable_flag": true,		"description": null,		"created_by_user_id": 21369366,		"projects_detail_visible_flag": false,		"show_in_pipelines": {			"show_in_all": true,			"pipeline_ids": []		},		"mandatory_flag": false,		"subfields": [			{				"id": null,				"key": "abe5e7a3b992b7c3ff539cab747e65e5cd7ea4da_currency",				"field_type": "varchar",				"label": "Currency of Betaling vooraf",				"edit_flag": true,				"mandatory_flag": false			}		]	},	"additional_data": null}',
                new Field(38, "abe5e7a3b992b7c3ff539cab747e65e5cd7ea4da", null)
            ]
        ];
    }


}
