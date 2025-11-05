<?php
namespace App\Controller\Api;

use App\Entity\Customer;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Service\ShoppingService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[Route('/api/orders', name: 'api_order_')]
#[IsGranted('ROLE_USER')]
class ApiOrderController extends ApiController {

	const array ORDER_ATTRS = ['date_created', 'paid'];
	const array CONTRACT_ATTRS = ['id', 'date_start', 'date_end', 'price', 'status'];

	#[Route('/{id}/status')]
	public function status(int $id): JsonResponse {
		/** @var Customer $customer */
		$customer = $this->getUser();

		/** @var ?Order $order */
		$order = $this->getRessource(Order::class, $id);

		if ($order == null) {
			return $this->notFound();
		}

		if ($order->getCustomer() !== $customer) {
			return $this->permError();
		}
		
		try {
			$serialized = $this->serialize($order, self::ORDER_ATTRS);
		} catch (\Throwable $exception) {
			return $this->error($exception->getMessage());
		}

		return $this->success('no error', $serialized);
	}

	#[Route('/pending', name: 'show_pending')]
	public function showPending(OrderRepository $repository): JsonResponse {
		/** @var Customer $customer */
		$customer = $this->getUser();

		$orders = $repository->findBy([
			'customer' => $customer,
			'paid' => false,
			'in_cart' => false
		]);
		
		try {
			$serialized = $this->serialize($orders, self::ORDER_ATTRS);
		} catch (\Throwable $exception) {
			return $this->error($exception->getMessage());
		}

		return $this->success('no error', $serialized);
	}

	#[Route('{id}/details', name: 'details')]
	public function showDetails(OrderRepository $repository, ShoppingService $service, int $id): JsonResponse {
		/** @var Customer $customer */
		$customer = $this->getUser();

		$order = $repository->findOneBy([
			'customer' => $customer,
			'id' => $id
		]);

		if ($order == null) {
			return $this->notFound();
		}

		try {
			$contrat = $service->getContrat($order);
			$serialized = $this->serialize($contrat, self::CONTRACT_ATTRS);
		} catch (\Throwable $exception) {
			return $this->error($exception->getMessage());
		}

		return $this->success('found', $serialized);
	}

}
