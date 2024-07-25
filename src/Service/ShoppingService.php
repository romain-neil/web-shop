<?php
namespace App\Service;

use App\Entity\Order;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ShoppingService {

	private HttpClientInterface $client;

	private UrlGeneratorInterface $url;

	public function __construct(HttpClientInterface $client, UrlGeneratorInterface $urlGenerator) {
		$this->client = $client->withOptions([
			'headers' => [
				'X-Auth-Token' => '' //TODO
			],
			'base_uri' => $_ENV['ORDER_API_URL']
		]);

		$this->url = $urlGenerator;
	}

	/**
	 * Persist order, then return payment url
	 * @param \App\Entity\Order $order
	 * @throws \Exception
	 * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
	 * @return string
	 */
	public function persistOrder(Order $order): string {
		$params = [
			'isPro' => false,
			'customerId' => $order->getCustomer()->getId(),
			'document' => '', //TODO
			'months' => 1,
			'products' => []
		];

		$products = $order->getServices();
		foreach ($products as $product) {
			$plan = $product->getPlan();

			$params['products'][] = [
				'description' => $plan->getCommercialName(),
				'label' => '',
				'type' => '',
				'price' => $plan->getPrice()
			];
		}

		try {
			$req = $this->client->request('POST', '/api/contract/persist', [
				'body' => json_encode($params)
			]);

			if ($req->getStatusCode() !== 200) {
				throw new \Exception('Error when persisting order : ' . $req->getContent(false));
			}
		} catch (\Throwable $e) {
			throw new \Exception('An exception occurred when trying to persist order: ' . $e->getMessage(), $e->getCode(), $e);
		}

		$resp = json_decode($req->getContent(), true);
		if ($resp['status'] !== 'success') {
			throw new \Exception('Failed to create the contrat'); //TODO
		}

		$order = $resp['data'];

		//Get invoice url
		$req = $this->client->request('GET', '/api/orders/' . $order['ref'] . '/invoices/last');
		if ($req->getStatusCode() !== 200) {
			throw new \Exception('Error when retrieving last contract invoice : ' . $req->getContent(false));
		}

		$invoice = json_decode($req->getContent(), true);

		$req = $this->client->request('GET', '/api/invoice/' . $invoice['ref'] . '/pay', [
			'query' => [
				//'return' => 'https://shop.carow.fr/account/orders'
				'return' => $this->url->generate('account_orders_list')
			]
		]);
		if ($req->getStatusCode() !== 200) {
			throw new \Exception(''); //
		}

		$resp = json_decode($req->getContent(), true);

		return $resp['data'];
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
