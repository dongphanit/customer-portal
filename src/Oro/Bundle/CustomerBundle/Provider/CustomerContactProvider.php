<?php

namespace Oro\Bundle\CustomerBundle\Provider;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ManagerRegistry;
use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Bundle\EmailBundle\Entity\Provider\EmailOwnerProviderInterface;
use Oro\Bundle\SecurityBundle\ORM\Walker\AclHelper;
use Oro\Bundle\CustomerBundle\Entity\Repository\CustomerRepository;
/**
 * Email owner provider for Customer User
 */
class CustomerContactProvider 
{

     /** @var ManagerRegistry */
     private $registry;

     /** @var AclHelper */
     private $aclHelper;

     /**
      * @param ManagerRegistry $registry
      * @param AclHelper $aclHelper
      * @param string $customerAddressClass
      * @param string $customerUserAddressClass
      */
     public function __construct(
         ManagerRegistry $registry,
         AclHelper $aclHelper
     ) {
         $this->registry = $registry;
         $this->aclHelper = $aclHelper;
     }

     
    /**
     * {@inheritdoc}
     */
    public function getEmailOwnerClass()
    {
        return CustomerUser::class;
    }

     /**
     * @return []
     */
    public function searchCustomerByPhone($phone, $countryCode)
    {
        $repository = $this->getCustomerContactRepository();
        $result = $repository->getCustomersByPhone($phone, $countryCode, $this->aclHelper);
        return $result;
    }

    /**
     * @return []
     */
    public function suggestCustomersByPhones($lstPhone, $organizationId)
    {
        
        $repository = $this->getCustomerContactRepository();
        
        $result = $repository->suggestCustomersByPhones($lstPhone, $organizationId, $this->aclHelper);


        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function findEmailOwner(EntityManager $em, $email)
    {
        return $em->getRepository(CustomerUser::class)->findOneBy(['email' => $email]);
    }

    /**
     * @return CustomerRepository
     */
    protected function getCustomerContactRepository()
    {
        return $this->registry->getManagerForClass(Customer::class)->getRepository(Customer::class);
    }

}
