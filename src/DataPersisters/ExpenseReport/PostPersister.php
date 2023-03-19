<?php

namespace App\DataPersisters\ExpenseReport;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\ExpenseReport;
use Doctrine\ORM\EntityManagerInterface;

class PostPersister implements DataPersisterInterface
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
        $data->setCreatedAt( new \DateTimeImmutable());
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}