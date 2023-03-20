<?php

declare(strict_types=1);

namespace App\DataPersisters\ExpenseReport;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\ExpenseReport;
use Doctrine\ORM\EntityManagerInterface;

final class PostPersister implements DataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports($data): bool
    {
        return $data instanceof ExpenseReport;
    }

    public function persist($data)
    {
        $data->setCreatedAt( new \DateTime());
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}