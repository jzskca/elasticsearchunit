<?php

use Zumba\PHPUnit\Extensions\ElasticSearch\Client\Connector;

class ConnectorTest extends \PHPUnit\Framework\TestCase {

	public function testGeneralConnection() {
		$clientBuilder = \Elasticsearch\ClientBuilder::create();
		if (getenv('ES_TEST_HOST')) {
			$clientBuilder->setHosts([getenv('ES_TEST_HOST')]);
		}
		$connector = new Connector($clientBuilder->build());
		$this->assertInstanceOf('Zumba\PHPUnit\Extensions\ElasticSearch\Client\Connector', $connector);
		$connection = $connector->getConnection();
		$response = $connection->index([
			'index' => 'testing',
			'type' => 'test',
			'id' => 1,
			'body' => ['testfield' => 'testvalue']
		]);
		$this->assertEquals('created', $response['result']);
		$this->assertEquals(1, $response['_id']);

		$response = $connection->delete([
			'index' => 'testing',
			'type' => 'test',
			'id' => 1
		]);
		$this->assertEquals('deleted', $response['result']);
	}

}
