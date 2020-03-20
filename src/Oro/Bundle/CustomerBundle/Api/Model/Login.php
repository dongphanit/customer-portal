<?php

namespace Oro\Bundle\CustomerBundle\Api\Model;

/**
 * The model for frontend API resource to retrieve API access key by customer user email and password.
 */
class Login
{
    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $apiKey;

    /** @var string */
    private $customerId;

    /** @var string */
    private $customerUserId;

    /**
     * Gets the email.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the email.
     *
     * @param string $email
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Gets the password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the password.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Gets the API access key that should be used for subsequent API requests.
     *
     * @return string|null
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Sets the API access key belongs to the customer user with the given email and password.
     *
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Gets the API access key that should be used for subsequent API requests.
     *
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Sets the API access key belongs to the customer user with the given email and password.
     *
     * @param string $apiKey
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * Gets the API access key that should be used for subsequent API requests.
     *
     * @return string|null
     */
    public function getCustomerUserId()
    {
        return $this->customerUserId;
    }

    /**
     * Sets the API access key belongs to the customer user with the given email and password.
     *
     * @param string $apiKey
     */
    public function setCustomerUserId($customerUserId)
    {
        $this->customerUserId = $customerUserId;
    }
}
