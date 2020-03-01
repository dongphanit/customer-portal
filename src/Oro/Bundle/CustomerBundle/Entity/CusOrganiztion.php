<?php
namespace Oro\Bundle\CustomerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\CustomerBundle\Model\ExtendCustomer;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;


/** @ORM\Table(name="oro_cus_organiztion") 
 * @ORM\Entity
 */
class CusOrganiztion
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ConfigField(
     *     defaultValues={
     *         "importexport"={
     *             "order"=10,
     *             "identity"=true
     *         }
     *     }
     * )
     */
    public $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          },
     *          "importexport"={
     *              "identity"=true,
     *              "order"=30
     *          }
     *      }
     * )
     */
    public $cus_status;

    /** 
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\CustomerBundle\Entity\Customer", inversedBy="cusOrganizations") 
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=false) 
     */
    public $customer;

    /** 
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\Organization", inversedBy="cusOrganizations") 
     * @ORM\JoinColumn(name="organiztion_id", referencedColumnName="id", nullable=false) 
     */
    public $organiztion;

}