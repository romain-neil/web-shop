<?php

namespace App\Controller\Api;

use App\Controller\AController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiController extends AController {

	/**
	 * Function to get ressource of type $class by id
	 * @param string $class
	 * @param int $id
	 * @return object|null
	 */
	protected function getResource(string $class, int $id): ?object {
		return $this->em->getRepository($class)->findOneBy(['id' => $id]);
	}

	/**
	 * Helper to normalize object or array of objects
	 * @throws ExceptionInterface
	 */
	protected function serialize(object|array $object, array $attributes): mixed {
		$encoder = new JsonEncoder();
		$serialize = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()], [$encoder]);

		if (is_array($object)) {
			$data = [];

			foreach ($object as $item) {
				$data[] = $serialize->normalize($item, null, [AbstractNormalizer::ATTRIBUTES => $attributes]);
			}

			return $data;
		}

		return $serialize->normalize($object,
			null, [
				AbstractNormalizer::ATTRIBUTES => $attributes
			]);
	}

	/**
	 * Helper function to send json formatted response to client
	 * @param string $response Message to return
	 * @param mixed|null $data
	 * @param int $code HTTP response code (200 by default)
	 * @return JsonResponse
	 */
	protected function success(string $response, mixed $data = null, int $code = 200): JsonResponse {
		return $this->json([
			'status' => 'success',
			'response' => $response,
			'data' => $data
		], $code);
	}

	/**
	 * Helper function to send json formatted error response to client
	 * @param string $message Message to return
	 * @param int $code HTTP response code (400 by default)
	 * @return JsonResponse
	 */
	protected function error(string $message = 'Client error during request', int $code = 400): JsonResponse {
		return $this->json([
			'status' => 'error',
			'response' => $message
		], $code);
	}

	/**
	 * Function helper to send json formatted error, indicating ressource access denied
	 * @return JsonResponse
	 */
	protected function permError(): JsonResponse {
		return $this->json([
			'status' => 'error',
			'message' => 'you cannot access to this ressource'
		], 403);
	}

	/**
	 * Function helper to send json formatted error, indicated that request missing mandatory fields
	 * @return JsonResponse
	 */
	protected function missData(): JsonResponse {
		return $this->json([
			'status' => 'error',
			'message' => 'missing mandatory parameters'
		], 400);
	}

	protected function notFound(): JsonResponse {
		return $this->json([
			'status' => 'error',
			'message' => 'no ressource found'
		], 404);
	}

}
