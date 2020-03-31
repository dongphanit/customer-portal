<?php

namespace Oro\Bundle\CustomerBundle\Api\Processor;

use Oro\Bundle\ApiBundle\Processor\CustomizeFormData\CustomizeFormDataContext;
use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Oro\Bundle\SecurityBundle\Authentication\TokenAccessorInterface;
use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Oro\Bundle\CustomerBundle\Entity\CustomerUserManager;
/**
 * Assigns an entity to the current customer.
 */
class ComputeCustomers implements ProcessorInterface
{
    /** @var CustomerUserManager */
    private $propertyAccessor;

    /** @var TokenAccessorInterface */
    private $tokenAccessor;


    /**
     * @param PropertyAccessorInterface $propertyAccessor
     * @param TokenAccessorInterface    $tokenAccessor
     */
    public function __construct(
        CustomerUserManager $propertyAccessor,
        TokenAccessorInterface $tokenAccessor
    ) {
        $this->propertyAccessor = $propertyAccessor;
        $this->tokenAccessor = $tokenAccessor;
    }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContextInterface $context)
    {
        $out = array();
        /** @var CustomizeFormDataContext $context */
        $user = $this->tokenAccessor->getUser();
        // $customer = $user->getCustomer();
        $linkCustomersOrganizations = $context->getResultFieldName('linkCustomersOrganizations');
        // $organization = $context->getResultFieldName('organization');
        // $idname = $context->getResultFieldName('id');
        $data = $context->getData();
        $str = json_encode($data);
        $dataJson = json_decode($str);
        $index = 0;
        foreach ($data as $key => $item) {
            $itemJson = $dataJson[$index];
            $links = $itemJson->linkCustomersOrganizations;
            if (sizeof($links) > 0){
                if (property_exists($links[0], 'organization')){
                    foreach ($links as &$value) {
                        $organization = $value->organization;
                        if ($organization->id == $user->getOrganization()->getId() and $value->status==1){
                            array_push($out, $item);
                        }
                    }
                    
                }
            }
            $index = $index + 1;
        }
        
        if (sizeof($out) != sizeof($dataJson)){
            $context->setData($out);
        }

    }

    /**
     * Returns a customer a processing entity should be assigned to.
     *
     * @return Customer|null
     */
    private function getCustomer(): ?Customer
    {
        $user = $this->tokenAccessor->getUser();
        if (!$user instanceof CustomerUser) {
            return null;
        }

        return $user->getCustomer();
    }

    /**
     * Assigns the given entity to a customer returned by getCustomer() method.
     * The entity's customer property will not be changed if the getCustomer() method returns NULL
     * or the entity is already assigned to a customer.
     *
     * @param object $entity
     */
    private function setCustomer($entity): void
    {
        $entityCustomer = $this->propertyAccessor->getValue($entity, $this->customerFieldName);
        if (null === $entityCustomer) {
            $customer = $this->getCustomer();
            if (null !== $customer) {
                $this->propertyAccessor->setValue($entity, $this->customerFieldName, $customer);
            }
        }
    }
}
