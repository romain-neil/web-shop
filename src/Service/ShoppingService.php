<?php
namespace App\Service;

use App\Entity\Order;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ShoppingService {

	private HttpClientInterface $client;

	public function __construct(HttpClientInterface $client) {
		$this->client = $client->withOptions([
			'headers' => [
				'X-Auth-Token' => ''
			],
			'base_uri' => $_ENV['ORDER_API_URL']
		]);
	}

	/**
	 * Persist order, then redirect user to payment url
	 * @param \App\Entity\Order $order
	 * @throws \Exception
	 * @return string
	 */
	public function persistOrder(Order $order): string {
		$params = [];

		try {
			$req = $this->client->request('POST', '/api/contract/persist', [
				'body' => json_encode($params)
			]);

			if ($req->getStatusCode() !== 200) {
				throw new \Exception('Error when persisting order : ' . $req->getContent(false));
			}
		} catch (\Throwable $e) {
			throw new \Exception('An exception occured when trying to persist order: ' . $e->getMessage(), $e->getCode(), $e);
		}

		return '';
	}

	/**
	 * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
	 * @throws \Exception
	 */
	public function getContrat(Order $order): array {
		$req = $this->client->request('GET', '/api/contract' . $order->getId(), [
			'body' => [
				'order_id' => $order->getId()
			]
		]);

		if ($req->getStatusCode() !== 200) {
			throw new \Exception('Error when trying to get contract : ' . $req->getContent(false));
		}

		return json_decode($req->getContent(), true);
	}

}
