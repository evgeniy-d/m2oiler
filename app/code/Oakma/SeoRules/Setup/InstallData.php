<?php

namespace Oakma\SeoRules\Setup;

use Oakma\SeoRules\Model\Rule\Entity;
use Oakma\SeoRules\Model\ResourceModel\Rule\Entity as EntityResource;
use Oakma\SeoRules\Model\Rule\EntityFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Entity factory
     *
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * @var EntityResource
     */
    protected $resource;

    /**
     * Init
     *
     * @param EntityFactory $entityFactory
     * @param EntityResource $resource
     */
    public function __construct(
        EntityFactory $entityFactory,
        EntityResource $resource
    ) {
        $this->entityFactory = $entityFactory;
        $this->resource = $resource;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $entities = [
            [
                'name'  => 'Default',
                'key'   => 'default'
            ],
            [
                'name'  => 'Category',
                'key'   => 'category'
            ],
            [
                'name'  => 'CMS Page',
                'key'   => 'cms_page'
            ]
        ];

        /**
         * Insert default entities
         */
        foreach ($entities as $data) {
            $this->resource->save($this->createEntity()->setData($data));
        }

        $setup->endSetup();
    }

    /**
     * Create seo rule entity
     *
     * @return Entity
     */
    public function createEntity()
    {
        return $this->entityFactory->create();
    }
}
