<?php
namespace App\Command;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:delete_old_order', description: 'Delete the old orders')]
class DeleteOldOrderCommand extends Command {

	private EntityManagerInterface $em;

	public function __construct(EntityManagerInterface $em, ?string $name = null) {
		$this->em = $em;

		parent::__construct($name);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {
		$io = new SymfonyStyle($input, $output);
		$orderRepo = $this->em->getRepository(Order::class);

		$orders = $orderRepo->findStaleOrders();
		foreach ($orders as $order) {
			$this->em->remove($order);
		}

		try {
			$this->em->flush();
		} catch (\Throwable $exception) {
			$io->error('Exception occurred while deleting old orders: ' . $exception->getMessage());
		}

		return Command::SUCCESS;
	}

}
