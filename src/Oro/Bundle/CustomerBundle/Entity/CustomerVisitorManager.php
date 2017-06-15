<?php

namespace Oro\Bundle\CustomerBundle\Entity;

use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;

class CustomerVisitorManager
{
    /**
     * @var DoctrineHelper
     */
    private $doctrineHelper;

    /**
     * @param DoctrineHelper $doctrineHelper
     */
    public function __construct(DoctrineHelper $doctrineHelper)
    {
        $this->doctrineHelper = $doctrineHelper;
    }

    /**
     * @param integer|null $id
     * @param string|null  $sessionId
     * @return CustomerVisitor
     */
    public function findOrCreate($id = null, $sessionId = null)
    {
        if (null === $id) {
            return $this->createUser();
        }

        $user = $this->doctrineHelper
            ->getEntityRepositoryForClass(CustomerVisitor::class)
            ->findOneBy(['id' => $id, 'sessionId' => $sessionId]);

        if (null === $user) {
            return $this->createUser();
        }

        return $user;
    }

    /**
     * @param CustomerVisitor $user
     * @param integer         $updateLatency
     */
    public function updateLastVisitTime(CustomerVisitor $user, $updateLatency)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        if ($updateLatency < $user->getLastVisit()->diff($now)->s) {
            $user->setLastVisit($now);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return CustomerVisitor
     */
    private function createUser()
    {
        $user = new CustomerVisitor;

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this->doctrineHelper->getEntityManagerForClass(CustomerVisitor::class);
    }
}
