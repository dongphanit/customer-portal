<?php

namespace Oro\Bundle\CustomerBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Bundle\CustomerBundle\Entity\CustomerGroup;
use Oro\Bundle\EntityBundle\ORM\Repository\BatchIteratorInterface;
use Oro\Bundle\EntityBundle\ORM\Repository\BatchIteratorTrait;
use Oro\Bundle\SecurityBundle\ORM\Walker\AclHelper;
use Doctrine\ORM\Query\Expr;

/**
 * Doctrine repository for Oro\Bundle\CustomerBundle\Entity\Customer entity
 */
class CustomerRepository extends EntityRepository implements BatchIteratorInterface
{
    use BatchIteratorTrait;

    /**
     * @param string $name
     *
     * @return null|Customer
     */
    public function findOneByName($name)
    {
        return $this->findOneBy(['name' => $name]);
    }

    /**
     * @param CustomerGroup $customerGroup
     * @return array|int[]
     */
    public function getIdsByCustomerGroup(CustomerGroup $customerGroup)
    {
        $qb = $this->createQueryBuilder('customer');

        $result = $qb->select('customer.id')
            ->where($qb->expr()->eq('customer.group', ':customerGroup'))
            ->setParameter('customerGroup', $customerGroup)
            ->getQuery()
            ->getScalarResult();

        return array_column($result, 'id');
    }

    /**
     * @param int $customerId
     * @param AclHelper $aclHelper
     * @return array
     */
    public function getCustomersByPhone($phone, $countryCode, AclHelper $aclHelper = null)
    {
        $qb = $this->createQueryBuilder('customer');
        $qb->select()
            ->leftJoin('customer.avatar', 'avatar')->addSelect("avatar.filename") 
             ->andWhere($qb->expr()->andX(
                $qb->expr()->eq('customer.phone', $phone),
                $qb->expr()->orX(
                    $qb->expr()->eq('customer.countryCode', $countryCode),
                    $qb->expr()->isNull('customer.countryCode')
                    ) 
            ));

        $query = $qb->getQuery();    
        return $query->getArrayResult();
    }

    /**
     * @param int $customerId
     * @param AclHelper $aclHelper
     * @return array
     */
    public function suggestCustomersByPhones($lstPhone, $organizationId, AclHelper $aclHelper = null)
    {
        $phones = array($lstPhone);
        $qb = $this->createQueryBuilder('customer');
        $qb->select()
            ->leftJoin('customer.linkCustomersOrganizations', 'cus_org',  Expr\Join::WITH, 'cus_org.organization = :organization')->addSelect("cus_org") 
            ->leftJoin('customer.avatar', 'avatar')->addSelect("avatar.filename") 
            ->andWhere($qb->expr()->orX(
                $qb->expr()->eq('cus_org.status', '2'),// 2 customer requested friends
                $qb->expr()->andX(
                    $qb->expr()->in('customer.phone', $lstPhone),
                    $qb->expr()->orX(
                        $qb->expr()->isNull('cus_org.status'),
                        $qb->expr()->eq('cus_org.status', '2')
                    )
                    ) 
            ))
            ->setParameter('organization', $organizationId);

        $query = $qb->getQuery();    
        return $query->getArrayResult();
    }

    /**
     * @param int $customerId
     * @param AclHelper $aclHelper
     * @return array
     */
    public function getChildrenIds($customerId, AclHelper $aclHelper = null)
    {
        $qb = $this->createQueryBuilder('customer');
        $qb->select('customer.id as customer_id')
            ->where($qb->expr()->eq('IDENTITY(customer.parent)', ':parent'))
            ->setParameter('parent', $customerId);

        if ($aclHelper) {
            $query = $aclHelper->apply($qb);
        } else {
            $query = $qb->getQuery();
        }

        $result = array_map(
            function ($item) {
                return $item['customer_id'];
            },
            $query->getArrayResult()
        );
        $children = $result;

        if ($result) {
            foreach ($result as $childId) {
                $children = array_merge($children, $this->getChildrenIds($childId, $aclHelper));
            }
        }

        return $children;
    }
}
