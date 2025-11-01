<?php
namespace App\Controller\Api;

use App\Repository\OrderRepository;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/webhook', name: 'api_webhook_')]
class ApiWebhookController extends ApiController {

	#[Route('/update-order', name: 'order_update', methods: ['POST'])]
	public function updateOrder(Request $request, OrderRepository $repository): JsonResponse {
		//Verify request is signed

		//propagate events
		$orderId = $request->request->getInt('order');
		$order = $repository->findOneBy(['id' => $orderId]);

		if ($order == null) {
			return $this->error('order not found');
		}

		$nextDueDate = $request->request->getInt('expire-date');
		$expire = DateTime::createFromFormat('U', $nextDueDate);

		if ($expire < ( new \DateTime('now'))) {
			return $this->error('invalid next due date');
		}

		$order->setDateEndValid($expire);
		$this->em->flush();

		return $this->success('update order successfully');
	}

}
