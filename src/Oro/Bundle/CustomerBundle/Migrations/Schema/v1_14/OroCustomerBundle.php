<?php

namespace Oro\Bundle\CustomerBundle\Migrations\Schema\v1_14;

use Doctrine\DBAL\Schema\Schema;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Oro\Bundle\CustomerBundle\Entity\CustomerUserRole;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\MigrationBundle\Migration\Extension\DataStorageExtension;
use Oro\Bundle\MigrationBundle\Migration\Extension\DataStorageExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class OroCustomerBundle implements
    Migration,
    ContainerAwareInterface,
    DataStorageExtensionAwareInterface
{
    use ContainerAwareTrait;

    /** @var DataStorageExtension */
    private $dataStorageExtension;

    /**
     * {@inheritdoc}
     */
    public function setDataStorageExtension(DataStorageExtension $dataStorageExtension)
    {
        $this->dataStorageExtension = $dataStorageExtension;
    }

    /**
     * @inheritDoc
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables modifications **/
        $this->updateCustomerUserTable($schema);

        /** Tables generation **/
        $this->createCustomerVisitorTable($schema);

        $configManager = $this->container->get('oro_entity_config.config_manager');
        $provider = $configManager->getProvider('extend');

        $entityConfig = $provider->getConfig(CustomerUser::class);
        $entityConfig->set('is_extend', true);
        $entityConfig->set('state', ExtendScope::STATE_ACTIVE);
        $configManager->persist($entityConfig);

        $entityConfig = $provider->getConfig(CustomerUserRole::class);
        $entityConfig->set('is_extend', true);
        $entityConfig->set('state', ExtendScope::STATE_ACTIVE);
        $configManager->persist($entityConfig);

        // send migration message to queue. we should process this migration asynchronous because instances
        // could have a lot of customer user in system.
        $this->container->get('oro_message_queue.message_producer')
            ->send(ClearLostCustomerUsers::TOPIC_NAME, '');
    }

    /**
     * Update oro_customer_user table
     *
     * @param Schema $schema
     */
    private function updateCustomerUserTable(Schema $schema)
    {
        $table = $schema->getTable('oro_customer_user');
        $table->addColumn('is_guest', 'boolean', []);

        //remove uniq indices for name and email fields
        $table->dropIndex('UNIQ_9511CEB5F85E0677');
        $table->dropIndex('uniq_oro_customer_user_email');
    }

    /**
     * Create oro_customer_visitor table
     *
     * @param Schema $schema
     */
    protected function createCustomerVisitorTable(Schema $schema)
    {
        $table = $schema->createTable('oro_customer_visitor');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('last_visit', 'datetime', []);
        $table->addColumn('session_id', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['id', 'session_id'], 'id_session_id_idx');
    }
}
