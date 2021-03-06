<?php

namespace Oro\Bundle\CustomerBundle\Tests\Behat;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Oro\Bundle\CustomerBundle\Entity\CustomerUserRole;
use Oro\Bundle\CustomerBundle\Entity\Repository\CustomerUserRoleRepository;
use Oro\Bundle\TestFrameworkBundle\Behat\Isolation\ReferenceRepositoryInitializerInterface;
use Oro\Bundle\TestFrameworkBundle\Test\DataFixtures\Collection;

class ReferenceRepositoryInitializer implements ReferenceRepositoryInitializerInterface
{
    /**
     * {@inheritdoc}
     */
    public function init(Registry $doctrine, Collection $referenceRepository)
    {
        /** @var CustomerUserRoleRepository $repository */
        $repository = $doctrine->getManager()->getRepository('OroCustomerBundle:CustomerUserRole');
        /** @var CustomerUserRole buyer */
        $buyer = $repository->findOneBy(['role' => 'ROLE_FRONTEND_BUYER']);
        $referenceRepository->set('buyer', $buyer);

        /** @var CustomerUserRole $administrator */
        $administrator = $repository->findOneBy(['role' => 'ROLE_FRONTEND_ADMINISTRATOR']);
        $referenceRepository->set('front_admin', $administrator);
    }
}
