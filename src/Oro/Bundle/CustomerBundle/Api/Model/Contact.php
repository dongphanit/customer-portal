<?php

namespace Oro\Bundle\CustomerBundle\Api\Model;

/**
 * The model for frontend API resource to retrieve API access key by customer user email and password.
 */
class Contact
{
    /** @var string */
    private $lstPhone;

    /**
     * Sets the email.
     *
     * @param string $email
     */
    public function setLstPhone($lstPhone)
    {
        $this->lstPhone = $lstPhone;
    }

    /**
     * Gets the password.
     *
     * @return string
     */
    public function getLstPhone()
    {
        return $this->lstPhone;
    }

}