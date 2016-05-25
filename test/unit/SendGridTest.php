<?php
class SendGridTest_SendGrid extends \PHPUnit_Framework_TestCase
{
    public $apiKey;
    public $sg;

    public function setUp()
    {
        $this->apiKey = "SENDGRID_API_KEY";
        if(getenv('TRAVIS')) {
            $host = array('host' => getenv('MOCK_HOST'));
        } else {
            $host = array('host' => 'http://localhost:4010');
        }
        $this->sg = new SendGrid($this->apiKey, $host);
    }

    public function testVersion()
    {
        $this->assertEquals(SendGrid::VERSION, '5.0.0');
        $this->assertEquals(json_decode(file_get_contents(__DIR__ . '/../../composer.json'))->version, SendGrid::VERSION);
    }

    public function testSendGrid()
    {
        $apiKey = "SENDGRID_API_KEY";
        $sg = new SendGrid($apiKey);
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$apiKey,
            'User-Agent: sendgrid/' . $sg->version . ';php'
            );
        $this->assertEquals($sg->client->host, "https://api.sendgrid.com");
        $this->assertEquals($sg->client->request_headers, $headers);
        $this->assertEquals($sg->client->version, "/v3");

        $apiKey = "SENDGRID_API_KEY";
        $sg2 = new SendGrid($apiKey, array('host' => 'https://api.test.com'));
        $this->assertEquals($sg2->client->host, "https://api.test.com");
    }

    public function test_access_settings_activity_get()
    {
        $query_params = json_decode('{"limit": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->access_settings()->activity()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_access_settings_whitelist_post()
    {
        $request_body = json_decode('{
  "ips": [
    {
      "ip": "192.168.1.1"
    },
    {
      "ip": "192.*.*.*"
    },
    {
      "ip": "192.168.1.3/32"
    }
  ]
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->access_settings()->whitelist()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_access_settings_whitelist_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->access_settings()->whitelist()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_access_settings_whitelist_delete()
    {
        $request_body = json_decode('{
  "ids": [
    1,
    2,
    3
  ]
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->access_settings()->whitelist()->delete($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_access_settings_whitelist__rule_id__get()
    {
        $query_params = json_decode('null');
        $rule_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->access_settings()->whitelist()->_($rule_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_access_settings_whitelist__rule_id__delete()
    {
        $query_params = json_decode('null');
        $rule_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->access_settings()->whitelist()->_($rule_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_api_keys_post()
    {
        $request_body = json_decode('{
  "name": "My API Key",
  "scopes": [
    "mail.send",
    "alerts.create",
    "alerts.read"
  ]
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->api_keys()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_api_keys_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->api_keys()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_api_keys__api_key_id__put()
    {
        $request_body = json_decode('{
  "name": "A New Hope",
  "scopes": [
    "user.profile.read",
    "user.profile.update"
  ]
}');
        $query_params = json_decode('null');
        $api_key_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->api_keys()->_($api_key_id)->put($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_api_keys__api_key_id__patch()
    {
        $request_body = json_decode('{
  "name": "A New Hope"
}');
        $query_params = json_decode('null');
        $api_key_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->api_keys()->_($api_key_id)->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_api_keys__api_key_id__get()
    {
        $query_params = json_decode('null');
        $api_key_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->api_keys()->_($api_key_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_api_keys__api_key_id__delete()
    {
        $query_params = json_decode('null');
        $api_key_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->api_keys()->_($api_key_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_asm_groups_post()
    {
        $request_body = json_decode('{
  "description": "A group description",
  "is_default": False,
  "name": "A group name"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->asm()->groups()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_asm_groups_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->asm()->groups()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_asm_groups__group_id__patch()
    {
        $request_body = json_decode('{
  "description": "Suggestions for items our users might like.",
  "id": 103,
  "name": "Item Suggestions"
}');
        $query_params = json_decode('null');
        $group_id = "test_url_param";
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->asm()->groups()->_($group_id)->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_asm_groups__group_id__get()
    {
        $query_params = json_decode('null');
        $group_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->asm()->groups()->_($group_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_asm_groups__group_id__delete()
    {
        $query_params = json_decode('null');
        $group_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->asm()->groups()->_($group_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_asm_groups__group_id__suppressions_post()
    {
        $request_body = json_decode('{
  "recipient_emails": [
    "test1@example.com",
    "test2@example.com"
  ]
}');
        $query_params = json_decode('null');
        $group_id = "test_url_param";
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->asm()->groups()->_($group_id)->suppressions()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_asm_groups__group_id__suppressions_get()
    {
        $query_params = json_decode('null');
        $group_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->asm()->groups()->_($group_id)->suppressions()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_asm_groups__group_id__suppressions__email__delete()
    {
        $query_params = json_decode('null');
        $group_id = "test_url_param";
        $email = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->asm()->groups()->_($group_id)->suppressions()->_($email)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_asm_suppressions_global_post()
    {
        $request_body = json_decode('{
  "recipient_emails": [
    "test1@example.com",
    "test2@example.com"
  ]
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->asm()->suppressions()->global()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_asm_suppressions_global__email__get()
    {
        $query_params = json_decode('null');
        $email = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->asm()->suppressions()->global()->_($email)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_asm_suppressions_global__email__delete()
    {
        $query_params = json_decode('null');
        $email = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->asm()->suppressions()->global()->_($email)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_browsers_stats_get()
    {
        $query_params = json_decode('{"end_date": "2016-04-01", "aggregated_by": "day", "browsers": "test_string", "limit": "test_string", "offset": "test_string", "start_date": "2016-01-01"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->browsers()->stats()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_campaigns_post()
    {
        $request_body = json_decode('{
  "categories": [
    "spring line"
  ],
  "custom_unsubscribe_url": "",
  "html_content": "<html><head><title></title></head><body><p>Check out our spring line!</p></body></html>",
  "ip_pool": "marketing",
  "list_ids": [
    110,
    124
  ],
  "plain_content": "Check out our spring line!",
  "segment_ids": [
    110
  ],
  "sender_id": 124451,
  "subject": "New Products for Spring!",
  "suppression_group_id": 42,
  "title": "March Newsletter"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->campaigns()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_campaigns_get()
    {
        $query_params = json_decode('{"limit": 0, "offset": 0}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->campaigns()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_campaigns__campaign_id__patch()
    {
        $request_body = json_decode('{
  "categories": [
    "summer line"
  ],
  "html_content": "<html><head><title></title></head><body><p>Check out our summer line!</p></body></html>",
  "plain_content": "Check out our summer line!",
  "subject": "New Products for Summer!",
  "title": "May Newsletter"
}');
        $query_params = json_decode('null');
        $campaign_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->campaigns()->_($campaign_id)->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_campaigns__campaign_id__get()
    {
        $query_params = json_decode('null');
        $campaign_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->campaigns()->_($campaign_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_campaigns__campaign_id__delete()
    {
        $query_params = json_decode('null');
        $campaign_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->campaigns()->_($campaign_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_campaigns__campaign_id__schedules_patch()
    {
        $request_body = json_decode('{
  "send_at": 1489451436
}');
        $query_params = json_decode('null');
        $campaign_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->campaigns()->_($campaign_id)->schedules()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_campaigns__campaign_id__schedules_post()
    {
        $request_body = json_decode('{
  "send_at": 1489771528
}');
        $query_params = json_decode('null');
        $campaign_id = "test_url_param";
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->campaigns()->_($campaign_id)->schedules()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_campaigns__campaign_id__schedules_get()
    {
        $query_params = json_decode('null');
        $campaign_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->campaigns()->_($campaign_id)->schedules()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_campaigns__campaign_id__schedules_delete()
    {
        $query_params = json_decode('null');
        $campaign_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->campaigns()->_($campaign_id)->schedules()->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_campaigns__campaign_id__schedules_now_post()
    {
        $query_params = json_decode('null');
        $campaign_id = "test_url_param";
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->campaigns()->_($campaign_id)->schedules()->now()->post(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_campaigns__campaign_id__schedules_test_post()
    {
        $request_body = json_decode('{
  "to": "your.email@example.com"
}');
        $query_params = json_decode('null');
        $campaign_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->campaigns()->_($campaign_id)->schedules()->test()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_categories_get()
    {
        $query_params = json_decode('{"category": "test_string", "limit": 1, "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->categories()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_categories_stats_get()
    {
        $query_params = json_decode('{"end_date": "2016-04-01", "aggregated_by": "day", "limit": 1, "offset": 1, "start_date": "2016-01-01", "categories": "test_string"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->categories()->stats()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_categories_stats_sums_get()
    {
        $query_params = json_decode('{"end_date": "2016-04-01", "aggregated_by": "day", "limit": 1, "sort_by_metric": "test_string", "offset": 1, "start_date": "2016-01-01", "sort_by_direction": "asc"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->categories()->stats()->sums()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_clients_stats_get()
    {
        $query_params = json_decode('{"aggregated_by": "day", "start_date": "2016-01-01", "end_date": "2016-04-01"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->clients()->stats()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_clients__client_type__stats_get()
    {
        $query_params = json_decode('{"aggregated_by": "day", "start_date": "2016-01-01", "end_date": "2016-04-01"}');
        $client_type = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->clients()->_($client_type)->stats()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_custom_fields_post()
    {
        $request_body = json_decode('{
  "name": "pet",
  "type": "text"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->contactdb()->custom_fields()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_contactdb_custom_fields_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->custom_fields()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_custom_fields__custom_field_id__get()
    {
        $query_params = json_decode('null');
        $custom_field_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->custom_fields()->_($custom_field_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_custom_fields__custom_field_id__delete()
    {
        $query_params = json_decode('null');
        $custom_field_id = "test_url_param";
        $request_headers = array("X-Mock: 202");
        $response = $this->sg->client->contactdb()->custom_fields()->_($custom_field_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 202);
    }
    public function test_contactdb_lists_post()
    {
        $request_body = json_decode('{
  "name": "your list name"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->contactdb()->lists()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_contactdb_lists_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->lists()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_lists_delete()
    {
        $request_body = json_decode('[
  1,
  2,
  3,
  4
]');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->contactdb()->lists()->delete($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_contactdb_lists__list_id__patch()
    {
        $request_body = json_decode('{
  "name": "newlistname"
}');
        $query_params = json_decode('{"list_id": 0}');
        $list_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->lists()->_($list_id)->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_lists__list_id__get()
    {
        $query_params = json_decode('{"list_id": 0}');
        $list_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->lists()->_($list_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_lists__list_id__delete()
    {
        $query_params = json_decode('{"delete_contacts": "true"}');
        $list_id = "test_url_param";
        $request_headers = array("X-Mock: 202");
        $response = $this->sg->client->contactdb()->lists()->_($list_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 202);
    }
    public function test_contactdb_lists__list_id__recipients_post()
    {
        $request_body = json_decode('[
  "recipient_id1",
  "recipient_id2"
]');
        $query_params = json_decode('null');
        $list_id = "test_url_param";
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->contactdb()->lists()->_($list_id)->recipients()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_contactdb_lists__list_id__recipients_get()
    {
        $query_params = json_decode('{"page": 1, "page_size": 1, "list_id": 0}');
        $list_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->lists()->_($list_id)->recipients()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_lists__list_id__recipients__recipient_id__post()
    {
        $query_params = json_decode('null');
        $list_id = "test_url_param";
        $recipient_id = "test_url_param";
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->contactdb()->lists()->_($list_id)->recipients()->_($recipient_id)->post(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_contactdb_lists__list_id__recipients__recipient_id__delete()
    {
        $query_params = json_decode('{"recipient_id": 0, "list_id": 0}');
        $list_id = "test_url_param";
        $recipient_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->contactdb()->lists()->_($list_id)->recipients()->_($recipient_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_contactdb_recipients_patch()
    {
        $request_body = json_decode('[
  {
    "email": "jones@example.com",
    "first_name": "Guy",
    "last_name": "Jones"
  }
]');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->contactdb()->recipients()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_contactdb_recipients_post()
    {
        $request_body = json_decode('[
  {
    "age": 25,
    "email": "example@example.com",
    "first_name": "",
    "last_name": "User"
  },
  {
    "age": 25,
    "email": "example2@example.com",
    "first_name": "Example",
    "last_name": "User"
  }
]');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->contactdb()->recipients()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_contactdb_recipients_get()
    {
        $query_params = json_decode('{"page": 1, "page_size": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->recipients()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_recipients_delete()
    {
        $request_body = json_decode('[
  "recipient_id1",
  "recipient_id2"
]');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->recipients()->delete($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_recipients_billable_count_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->recipients()->billable_count()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_recipients_count_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->recipients()->count()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_recipients_search_get()
    {
        $query_params = json_decode('{"{field_name}": "test_string"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->recipients()->search()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_recipients__recipient_id__get()
    {
        $query_params = json_decode('null');
        $recipient_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->recipients()->_($recipient_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_recipients__recipient_id__delete()
    {
        $query_params = json_decode('null');
        $recipient_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->contactdb()->recipients()->_($recipient_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_contactdb_recipients__recipient_id__lists_get()
    {
        $query_params = json_decode('null');
        $recipient_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->recipients()->_($recipient_id)->lists()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_reserved_fields_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->reserved_fields()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_segments_post()
    {
        $request_body = json_decode('{
  "conditions": [
    {
      "and_or": "",
      "field": "last_name",
      "operator": "eq",
      "value": "Miller"
    },
    {
      "and_or": "and",
      "field": "last_clicked",
      "operator": "gt",
      "value": "01/02/2015"
    },
    {
      "and_or": "or",
      "field": "clicks.campaign_identifier",
      "operator": "eq",
      "value": "513"
    }
  ],
  "list_id": 4,
  "name": "Last Name Miller"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->segments()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_segments_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->segments()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_segments__segment_id__patch()
    {
        $request_body = json_decode('{
  "conditions": [
    {
      "and_or": "",
      "field": "last_name",
      "operator": "eq",
      "value": "Miller"
    }
  ],
  "list_id": 5,
  "name": "The Millers"
}');
        $query_params = json_decode('{"segment_id": "test_string"}');
        $segment_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->segments()->_($segment_id)->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_segments__segment_id__get()
    {
        $query_params = json_decode('{"segment_id": 0}');
        $segment_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->segments()->_($segment_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_contactdb_segments__segment_id__delete()
    {
        $query_params = json_decode('{"delete_contacts": "true"}');
        $segment_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->contactdb()->segments()->_($segment_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_contactdb_segments__segment_id__recipients_get()
    {
        $query_params = json_decode('{"page": 1, "page_size": 1}');
        $segment_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->contactdb()->segments()->_($segment_id)->recipients()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_devices_stats_get()
    {
        $query_params = json_decode('{"aggregated_by": "day", "limit": 1, "start_date": "2016-01-01", "end_date": "2016-04-01", "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->devices()->stats()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_geo_stats_get()
    {
        $query_params = json_decode('{"end_date": "2016-04-01", "country": "US", "aggregated_by": "day", "limit": 1, "offset": 1, "start_date": "2016-01-01"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->geo()->stats()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_ips_get()
    {
        $query_params = json_decode('{"subuser": "test_string", "ip": "test_string", "limit": 1, "exclude_whitelabels": "true", "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->ips()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_ips_assigned_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->ips()->assigned()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_ips_pools_post()
    {
        $request_body = json_decode('{
  "name": "marketing"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->ips()->pools()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_ips_pools_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->ips()->pools()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_ips_pools__pool_name__put()
    {
        $request_body = json_decode('{
  "name": "new_pool_name"
}');
        $query_params = json_decode('null');
        $pool_name = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->ips()->pools()->_($pool_name)->put($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_ips_pools__pool_name__get()
    {
        $query_params = json_decode('null');
        $pool_name = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->ips()->pools()->_($pool_name)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_ips_pools__pool_name__delete()
    {
        $query_params = json_decode('null');
        $pool_name = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->ips()->pools()->_($pool_name)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_ips_pools__pool_name__ips_post()
    {
        $request_body = json_decode('{
  "ip": "0.0.0.0"
}');
        $query_params = json_decode('null');
        $pool_name = "test_url_param";
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->ips()->pools()->_($pool_name)->ips()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_ips_pools__pool_name__ips__ip__delete()
    {
        $query_params = json_decode('null');
        $pool_name = "test_url_param";
        $ip = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->ips()->pools()->_($pool_name)->ips()->_($ip)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_ips_warmup_post()
    {
        $request_body = json_decode('{
  "ip": "0.0.0.0"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->ips()->warmup()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_ips_warmup_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->ips()->warmup()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_ips_warmup__ip_address__get()
    {
        $query_params = json_decode('null');
        $ip_address = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->ips()->warmup()->_($ip_address)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_ips_warmup__ip_address__delete()
    {
        $query_params = json_decode('null');
        $ip_address = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->ips()->warmup()->_($ip_address)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_ips__ip_address__get()
    {
        $query_params = json_decode('null');
        $ip_address = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->ips()->_($ip_address)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_batch_post()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->mail()->batch()->post(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_mail_batch__batch_id__get()
    {
        $query_params = json_decode('null');
        $batch_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail()->batch()->_($batch_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_send_beta_post()
    {
        $request_body = json_decode('{
  "asm": {
    "group_id": 1,
    "groups_to_display": [
      1,
      2,
      3
    ]
  },
  "attachments": [
    {
      "content": "[BASE64 encoded content block here]",
      "content_id": "ii_139db99fdb5c3704",
      "disposition": "inline",
      "filename": "file1.jpg",
      "name": "file1",
      "type": "jpg"
    }
  ],
  "batch_id": "[YOUR BATCH ID GOES HERE]",
  "categories": [
    "category1",
    "category2"
  ],
  "content": [
    {
      "type": "text/html",
      "value": "<html><p>Hello, world!</p><img src=[CID GOES HERE]></img></html>"
    }
  ],
  "custom_args": {
    "New Argument 1": "New Value 1",
    "activationAttempt": "1",
    "customerAccountNumber": "[CUSTOMER ACCOUNT NUMBER GOES HERE]"
  },
  "from": {
    "email": "sam.smith@example.com",
    "name": "Sam Smith"
  },
  "headers": {},
  "ip_pool_name": "[YOUR POOL NAME GOES HERE]",
  "mail_settings": {
    "bcc": {
      "email": "ben.doe@example.com",
      "enable": True
    },
    "bypass_list_management": {
      "enable": True
    },
    "footer": {
      "enable": True,
      "html": "<p>Thanks</br>The SendGrid Team</p>",
      "text": "Thanks,/n The SendGrid Team"
    },
    "sandbox_mode": {
      "enable": False
    },
    "spam_check": {
      "enable": True,
      "post_to_url": "http://example.com/compliance",
      "threshold": 3
    }
  },
  "personalizations": [
    {
      "bcc": [
        {
          "email": "sam.doe@example.com",
          "name": "Sam Doe"
        }
      ],
      "cc": [
        {
          "email": "jane.doe@example.com",
          "name": "Jane Doe"
        }
      ],
      "custom_args": {
        "New Argument 1": "New Value 1",
        "activationAttempt": "1",
        "customerAccountNumber": "[CUSTOMER ACCOUNT NUMBER GOES HERE]"
      },
      "headers": {
        "X-Accept-Language": "en",
        "X-Mailer": "MyApp"
      },
      "send_at": 1409348513,
      "subject": "Hello, World!",
      "substitutions": {
        "sub": {
          "%name%": [
            "John",
            "Jane",
            "Sam"
          ]
        }
      },
      "to": [
        {
          "email": "john.doe@example.com",
          "name": "John Doe"
        }
      ]
    }
  ],
  "reply_to": {
    "email": "sam.smith@example.com",
    "name": "Sam Smith"
  },
  "sections": {
    "section": {
      ":sectionName1": "section 1 text",
      ":sectionName2": "section 2 text"
    }
  },
  "send_at": 1409348513,
  "subject": "Hello, World!",
  "template_id": "[YOUR TEMPLATE ID GOES HERE]",
  "tracking_settings": {
    "click_tracking": {
      "enable": True,
      "enable_text": True
    },
    "ganalytics": {
      "enable": True,
      "utm_campaign": "[NAME OF YOUR REFERRER SOURCE]",
      "utm_content": "[USE THIS SPACE TO DIFFERENTIATE YOUR EMAIL FROM ADS]",
      "utm_medium": "[NAME OF YOUR MARKETING MEDIUM e.g. email]",
      "utm_name": "[NAME OF YOUR CAMPAIGN]",
      "utm_term": "[IDENTIFY PAID KEYWORDS HERE]"
    },
    "open_tracking": {
      "enable": True,
      "substitution_tag": "%opentrack"
    },
    "subscription_tracking": {
      "enable": True,
      "html": "If you would like to unsubscribe and stop receiving these emails <% clickhere %>.",
      "substitution_tag": "<%click here%>",
      "text": "If you would like to unsubscribe and stop receiveing these emails <% click here %>."
    }
  }
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 202");
        $response = $this->sg->client->mail()->send()->beta()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 202);
    }
    public function test_mail_settings_get()
    {
        $query_params = json_decode('{"limit": 1, "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_address_whitelist_patch()
    {
        $request_body = json_decode('{
  "enabled": True,
  "list": [
    "email1@example.com",
    "example.com"
  ]
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->address_whitelist()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_address_whitelist_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->address_whitelist()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_bcc_patch()
    {
        $request_body = json_decode('{
  "email": "email@example.com",
  "enabled": False
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->bcc()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_bcc_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->bcc()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_bounce_purge_patch()
    {
        $request_body = json_decode('{
  "enabled": True,
  "hard_bounces": 5,
  "soft_bounces": 5
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->bounce_purge()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_bounce_purge_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->bounce_purge()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_footer_patch()
    {
        $request_body = json_decode('{
  "enabled": True,
  "html_content": "...",
  "plain_content": "..."
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->footer()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_footer_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->footer()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_forward_bounce_patch()
    {
        $request_body = json_decode('{
  "email": "example@example.com",
  "enabled": True
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->forward_bounce()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_forward_bounce_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->forward_bounce()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_forward_spam_patch()
    {
        $request_body = json_decode('{
  "email": "",
  "enabled": False
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->forward_spam()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_forward_spam_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->forward_spam()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_plain_content_patch()
    {
        $request_body = json_decode('{
  "enabled": False
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->plain_content()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_plain_content_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->plain_content()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_spam_check_patch()
    {
        $request_body = json_decode('{
  "enabled": True,
  "max_score": 5,
  "url": "url"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->spam_check()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_spam_check_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->spam_check()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_template_patch()
    {
        $request_body = json_decode('{
  "enabled": True,
  "html_content": "<% body %>"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->template()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mail_settings_template_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mail_settings()->template()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_mailbox_providers_stats_get()
    {
        $query_params = json_decode('{"end_date": "2016-04-01", "mailbox_providers": "test_string", "aggregated_by": "day", "limit": 1, "offset": 1, "start_date": "2016-01-01"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->mailbox_providers()->stats()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_partner_settings_get()
    {
        $query_params = json_decode('{"limit": 1, "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->partner_settings()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_partner_settings_new_relic_patch()
    {
        $request_body = json_decode('{
  "enable_subuser_statistics": True,
  "enabled": True,
  "license_key": ""
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->partner_settings()->new_relic()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_partner_settings_new_relic_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->partner_settings()->new_relic()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_scopes_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->scopes()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_stats_get()
    {
        $query_params = json_decode('{"aggregated_by": "day", "limit": 1, "start_date": "2016-01-01", "end_date": "2016-04-01", "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->stats()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_subusers_post()
    {
        $request_body = json_decode('{
  "email": "John@example.com",
  "ips": [
    "1.1.1.1",
    "2.2.2.2"
  ],
  "password": "johns_password",
  "username": "John@example.com"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->subusers()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_subusers_get()
    {
        $query_params = json_decode('{"username": "test_string", "limit": 0, "offset": 0}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->subusers()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_subusers_reputations_get()
    {
        $query_params = json_decode('{"usernames": "test_string"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->subusers()->reputations()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_subusers_stats_get()
    {
        $query_params = json_decode('{"end_date": "2016-04-01", "aggregated_by": "day", "limit": 1, "offset": 1, "start_date": "2016-01-01", "subusers": "test_string"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->subusers()->stats()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_subusers_stats_monthly_get()
    {
        $query_params = json_decode('{"subuser": "test_string", "limit": 1, "sort_by_metric": "test_string", "offset": 1, "date": "test_string", "sort_by_direction": "asc"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->subusers()->stats()->monthly()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_subusers_stats_sums_get()
    {
        $query_params = json_decode('{"end_date": "2016-04-01", "aggregated_by": "day", "limit": 1, "sort_by_metric": "test_string", "offset": 1, "start_date": "2016-01-01", "sort_by_direction": "asc"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->subusers()->stats()->sums()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_subusers__subuser_name__patch()
    {
        $request_body = json_decode('{
  "disabled": False
}');
        $query_params = json_decode('null');
        $subuser_name = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->subusers()->_($subuser_name)->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_subusers__subuser_name__delete()
    {
        $query_params = json_decode('null');
        $subuser_name = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->subusers()->_($subuser_name)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_subusers__subuser_name__ips_put()
    {
        $request_body = json_decode('[
  "127.0.0.1"
]');
        $query_params = json_decode('null');
        $subuser_name = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->subusers()->_($subuser_name)->ips()->put($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_subusers__subuser_name__monitor_put()
    {
        $request_body = json_decode('{
  "email": "example@example.com",
  "frequency": 500
}');
        $query_params = json_decode('null');
        $subuser_name = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->subusers()->_($subuser_name)->monitor()->put($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_subusers__subuser_name__monitor_post()
    {
        $request_body = json_decode('{
  "email": "example@example.com",
  "frequency": 50000
}');
        $query_params = json_decode('null');
        $subuser_name = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->subusers()->_($subuser_name)->monitor()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_subusers__subuser_name__monitor_get()
    {
        $query_params = json_decode('null');
        $subuser_name = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->subusers()->_($subuser_name)->monitor()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_subusers__subuser_name__monitor_delete()
    {
        $query_params = json_decode('null');
        $subuser_name = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->subusers()->_($subuser_name)->monitor()->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_subusers__subuser_name__stats_monthly_get()
    {
        $query_params = json_decode('{"date": "test_string", "sort_by_direction": "asc", "limit": 0, "sort_by_metric": "test_string", "offset": 1}');
        $subuser_name = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->subusers()->_($subuser_name)->stats()->monthly()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_suppression_blocks_get()
    {
        $query_params = json_decode('{"start_time": 1, "limit": 1, "end_time": 1, "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->suppression()->blocks()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_suppression_blocks_delete()
    {
        $request_body = json_decode('{
  "delete_all": False,
  "emails": [
    "example1@example.com",
    "example2@example.com"
  ]
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->suppression()->blocks()->delete($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_suppression_blocks__email__get()
    {
        $query_params = json_decode('null');
        $email = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->suppression()->blocks()->_($email)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_suppression_blocks__email__delete()
    {
        $query_params = json_decode('null');
        $email = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->suppression()->blocks()->_($email)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_suppression_bounces_get()
    {
        $query_params = json_decode('{"start_time": 0, "end_time": 0}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->suppression()->bounces()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_suppression_bounces_delete()
    {
        $request_body = json_decode('{
  "delete_all": True,
  "emails": [
    "example@example.com",
    "example2@example.com"
  ]
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->suppression()->bounces()->delete($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_suppression_bounces__email__get()
    {
        $query_params = json_decode('null');
        $email = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->suppression()->bounces()->_($email)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_suppression_bounces__email__delete()
    {
        $query_params = json_decode('{"email_address": "example@example.com"}');
        $email = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->suppression()->bounces()->_($email)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_suppression_invalid_emails_get()
    {
        $query_params = json_decode('{"start_time": 1, "limit": 1, "end_time": 1, "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->suppression()->invalid_emails()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_suppression_invalid_emails_delete()
    {
        $request_body = json_decode('{
  "delete_all": False,
  "emails": [
    "example1@example.com",
    "example2@example.com"
  ]
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->suppression()->invalid_emails()->delete($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_suppression_invalid_emails__email__get()
    {
        $query_params = json_decode('null');
        $email = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->suppression()->invalid_emails()->_($email)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_suppression_invalid_emails__email__delete()
    {
        $query_params = json_decode('null');
        $email = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->suppression()->invalid_emails()->_($email)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_suppression_spam_report__email__get()
    {
        $query_params = json_decode('null');
        $email = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->suppression()->spam_report()->_($email)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_suppression_spam_report__email__delete()
    {
        $query_params = json_decode('null');
        $email = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->suppression()->spam_report()->_($email)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_suppression_spam_reports_get()
    {
        $query_params = json_decode('{"start_time": 1, "limit": 1, "end_time": 1, "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->suppression()->spam_reports()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_suppression_spam_reports_delete()
    {
        $request_body = json_decode('{
  "delete_all": False,
  "emails": [
    "example1@example.com",
    "example2@example.com"
  ]
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->suppression()->spam_reports()->delete($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_suppression_unsubscribes_get()
    {
        $query_params = json_decode('{"start_time": 1, "limit": 1, "end_time": 1, "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->suppression()->unsubscribes()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_templates_post()
    {
        $request_body = json_decode('{
  "name": "example_name"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->templates()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_templates_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->templates()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_templates__template_id__patch()
    {
        $request_body = json_decode('{
  "name": "new_example_name"
}');
        $query_params = json_decode('null');
        $template_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->templates()->_($template_id)->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_templates__template_id__get()
    {
        $query_params = json_decode('null');
        $template_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->templates()->_($template_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_templates__template_id__delete()
    {
        $query_params = json_decode('null');
        $template_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->templates()->_($template_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_templates__template_id__versions_post()
    {
        $request_body = json_decode('{
  "active": 1,
  "html_content": "<%body%>",
  "name": "example_version_name",
  "plain_content": "<%body%>",
  "subject": "<%subject%>",
  "template_id": "ddb96bbc-9b92-425e-8979-99464621b543"
}');
        $query_params = json_decode('null');
        $template_id = "test_url_param";
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->templates()->_($template_id)->versions()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_templates__template_id__versions__version_id__patch()
    {
        $request_body = json_decode('{
  "active": 1,
  "html_content": "<%body%>",
  "name": "updated_example_name",
  "plain_content": "<%body%>",
  "subject": "<%subject%>"
}');
        $query_params = json_decode('null');
        $template_id = "test_url_param";
        $version_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->templates()->_($template_id)->versions()->_($version_id)->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_templates__template_id__versions__version_id__get()
    {
        $query_params = json_decode('null');
        $template_id = "test_url_param";
        $version_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->templates()->_($template_id)->versions()->_($version_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_templates__template_id__versions__version_id__delete()
    {
        $query_params = json_decode('null');
        $template_id = "test_url_param";
        $version_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->templates()->_($template_id)->versions()->_($version_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_templates__template_id__versions__version_id__activate_post()
    {
        $query_params = json_decode('null');
        $template_id = "test_url_param";
        $version_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->templates()->_($template_id)->versions()->_($version_id)->activate()->post(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_tracking_settings_get()
    {
        $query_params = json_decode('{"limit": 1, "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->tracking_settings()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_tracking_settings_click_patch()
    {
        $request_body = json_decode('{
  "enabled": True
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->tracking_settings()->click()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_tracking_settings_click_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->tracking_settings()->click()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_tracking_settings_google_analytics_patch()
    {
        $request_body = json_decode('{
  "enabled": True,
  "utm_campaign": "website",
  "utm_content": "",
  "utm_medium": "email",
  "utm_source": "sendgrid.com",
  "utm_term": ""
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->tracking_settings()->google_analytics()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_tracking_settings_google_analytics_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->tracking_settings()->google_analytics()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_tracking_settings_open_patch()
    {
        $request_body = json_decode('{
  "enabled": True
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->tracking_settings()->open()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_tracking_settings_open_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->tracking_settings()->open()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_tracking_settings_subscription_patch()
    {
        $request_body = json_decode('{
  "enabled": True,
  "html_content": "html content",
  "landing": "landing page html",
  "plain_content": "text content",
  "replace": "replacement tag",
  "url": "url"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->tracking_settings()->subscription()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_tracking_settings_subscription_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->tracking_settings()->subscription()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_account_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->account()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_credits_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->credits()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_email_put()
    {
        $request_body = json_decode('{
  "email": "example@example.com"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->email()->put($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_email_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->email()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_password_put()
    {
        $request_body = json_decode('{
  "new_password": "new_password",
  "old_password": "old_password"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->password()->put($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_profile_patch()
    {
        $request_body = json_decode('{
  "city": "Orange",
  "first_name": "Example",
  "last_name": "User"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->profile()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_profile_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->profile()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_scheduled_sends_post()
    {
        $request_body = json_decode('{
  "batch_id": "YOUR_BATCH_ID",
  "status": "pause"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->user()->scheduled_sends()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_user_scheduled_sends_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->scheduled_sends()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_scheduled_sends__batch_id__patch()
    {
        $request_body = json_decode('{
  "status": "pause"
}');
        $query_params = json_decode('null');
        $batch_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->user()->scheduled_sends()->_($batch_id)->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_user_scheduled_sends__batch_id__get()
    {
        $query_params = json_decode('null');
        $batch_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->scheduled_sends()->_($batch_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_scheduled_sends__batch_id__delete()
    {
        $query_params = json_decode('null');
        $batch_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->user()->scheduled_sends()->_($batch_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_user_settings_enforced_tls_patch()
    {
        $request_body = json_decode('{
  "require_tls": True,
  "require_valid_cert": False
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->settings()->enforced_tls()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_settings_enforced_tls_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->settings()->enforced_tls()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_username_put()
    {
        $request_body = json_decode('{
  "username": "test_username"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->username()->put($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_username_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->username()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_webhooks_event_settings_patch()
    {
        $request_body = json_decode('{
  "bounce": True,
  "click": True,
  "deferred": True,
  "delivered": True,
  "dropped": True,
  "enabled": True,
  "group_resubscribe": True,
  "group_unsubscribe": True,
  "open": True,
  "processed": True,
  "spam_report": True,
  "unsubscribe": True,
  "url": "url"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->webhooks()->event()->settings()->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_webhooks_event_settings_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->webhooks()->event()->settings()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_webhooks_event_test_post()
    {
        $request_body = json_decode('{
  "url": "url"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->user()->webhooks()->event()->test()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_user_webhooks_parse_settings_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->webhooks()->parse()->settings()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_user_webhooks_parse_stats_get()
    {
        $query_params = json_decode('{"aggregated_by": "day", "limit": "test_string", "start_date": "2016-01-01", "end_date": "2016-04-01", "offset": "test_string"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->user()->webhooks()->parse()->stats()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_domains_post()
    {
        $request_body = json_decode('{
  "automatic_security": False,
  "custom_spf": True,
  "default": True,
  "domain": "example.com",
  "ips": [
    "192.168.1.1",
    "192.168.1.2"
  ],
  "subdomain": "news",
  "username": "john@example.com"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->whitelabel()->domains()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_whitelabel_domains_get()
    {
        $query_params = json_decode('{"username": "test_string", "domain": "test_string", "exclude_subusers": "true", "limit": 1, "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->domains()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_domains_default_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->domains()->default()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_domains_subuser_get()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->domains()->subuser()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_domains_subuser_delete()
    {
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->whitelabel()->domains()->subuser()->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_whitelabel_domains__domain_id__patch()
    {
        $request_body = json_decode('{
  "custom_spf": True,
  "default": False
}');
        $query_params = json_decode('null');
        $domain_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->domains()->_($domain_id)->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_domains__domain_id__get()
    {
        $query_params = json_decode('null');
        $domain_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->domains()->_($domain_id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_domains__domain_id__delete()
    {
        $query_params = json_decode('null');
        $domain_id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->whitelabel()->domains()->_($domain_id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_whitelabel_domains__domain_id__subuser_post()
    {
        $request_body = json_decode('{
  "username": "jane@example.com"
}');
        $query_params = json_decode('null');
        $domain_id = "test_url_param";
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->whitelabel()->domains()->_($domain_id)->subuser()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_whitelabel_domains__id__ips_post()
    {
        $request_body = json_decode('{
  "ip": "192.168.0.1"
}');
        $query_params = json_decode('null');
        $id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->domains()->_($id)->ips()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_domains__id__ips__ip__delete()
    {
        $query_params = json_decode('null');
        $id = "test_url_param";
        $ip = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->domains()->_($id)->ips()->_($ip)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_domains__id__validate_post()
    {
        $query_params = json_decode('null');
        $id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->domains()->_($id)->validate()->post(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_ips_post()
    {
        $request_body = json_decode('{
  "domain": "example.com",
  "ip": "192.168.1.1",
  "subdomain": "email"
}');
        $query_params = json_decode('null');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->whitelabel()->ips()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_whitelabel_ips_get()
    {
        $query_params = json_decode('{"ip": "test_string", "limit": 1, "offset": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->ips()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_ips__id__get()
    {
        $query_params = json_decode('null');
        $id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->ips()->_($id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_ips__id__delete()
    {
        $query_params = json_decode('null');
        $id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->whitelabel()->ips()->_($id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_whitelabel_ips__id__validate_post()
    {
        $query_params = json_decode('null');
        $id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->ips()->_($id)->validate()->post(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_links_post()
    {
        $request_body = json_decode('{
  "default": True,
  "domain": "example.com",
  "subdomain": "mail"
}');
        $query_params = json_decode('{"limit": 1, "offset": 1}');
        $request_headers = array("X-Mock: 201");
        $response = $this->sg->client->whitelabel()->links()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 201);
    }
    public function test_whitelabel_links_get()
    {
        $query_params = json_decode('{"limit": 1}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->links()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_links_default_get()
    {
        $query_params = json_decode('{"domain": "test_string"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->links()->default()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_links_subuser_get()
    {
        $query_params = json_decode('{"username": "test_string"}');
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->links()->subuser()->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_links_subuser_delete()
    {
        $query_params = json_decode('{"username": "test_string"}');
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->whitelabel()->links()->subuser()->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_whitelabel_links__id__patch()
    {
        $request_body = json_decode('{
  "default": True
}');
        $query_params = json_decode('null');
        $id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->links()->_($id)->patch($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_links__id__get()
    {
        $query_params = json_decode('null');
        $id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->links()->_($id)->get(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_links__id__delete()
    {
        $query_params = json_decode('null');
        $id = "test_url_param";
        $request_headers = array("X-Mock: 204");
        $response = $this->sg->client->whitelabel()->links()->_($id)->delete(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 204);
    }
    public function test_whitelabel_links__id__validate_post()
    {
        $query_params = json_decode('null');
        $id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->links()->_($id)->validate()->post(null, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }
    public function test_whitelabel_links__link_id__subuser_post()
    {
        $request_body = json_decode('{
  "username": "jane@example.com"
}');
        $query_params = json_decode('null');
        $link_id = "test_url_param";
        $request_headers = array("X-Mock: 200");
        $response = $this->sg->client->whitelabel()->links()->_($link_id)->subuser()->post($request_body, $query_params, $request_headers);
        $this->assertEquals($response->statusCode(), 200);
    }}
