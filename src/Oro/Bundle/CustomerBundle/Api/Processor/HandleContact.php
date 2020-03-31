<?php

namespace Oro\Bundle\CustomerBundle\Api\Processor;

use Oro\Bundle\ApiBundle\Processor\Create\CreateContext;
use Oro\Bundle\ApiBundle\Util\DoctrineHelper;
use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\CustomerBundle\Api\Model\Contact;
use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Oro\Bundle\CustomerBundle\Entity\CustomerUserApi;
use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Oro\Bundle\CustomerBundle\Provider\CustomerContactProvider;
/**
 * Checks whether the login credentials are valid
 * and if so, sets API access key of authenticated customer user to the model.
 */
class HandleContact implements ProcessorInterface
{
    /** @var string */
    private $authenticationProviderKey;

    /** @var AuthenticationProviderInterface */
    private $customerContactProvider;

    /** @var ConfigManager */
    private $configManager;

    /** @var DoctrineHelper */
    private $doctrineHelper;

    /** @var TranslatorInterface */
    private $translator;

    /**
     * @param string                          $authenticationProviderKey
     */
    public function __construct(
        string $authenticationProviderKey,
        CustomerContactProvider $customerContactProvider
    ) {
        $this->customerContactProvider = $customerContactProvider;
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
        /** @var CreateContext $context */

        $model = $context->getResult();
        $lstPhone = explode(",", $model -> getLstPhone());
        $results = $this->customerContactProvider->getCustomerContactWithPhones($lstPhone);
        $model-> setData($results);
    

        // $repository = $this->getCustomerRepository();
        // $children = $repository->getCustomersWithLstPhone($model->getLstPhone(), $this->aclHelper);

        // throw new \LogicException(sprintf(
        //     'Invalid authentication provider. The provider key is "%s".',
        //     $model->getLstPhone()
        // ));
       
        // if (!$model instanceof Contact || $model->getApiKey()) {
        //     // the request is already handled
        //     return;
        // }
        // $this -> debug_to_console('hahha');
        // $model->setApiKey($apiKey);
    }

    /**
     * @return CustomerRepository
     */
    protected function getCustomerRepository()
    {
        return $this->doctrine->getManagerForClass(Customer::class)->getRepository(Customer::class);
    }

}
