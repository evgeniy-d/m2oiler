<?php

namespace Magento\Cms\Setup;

use Oakma\SeoRules\Model\Rule\Entity;
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
    private $entityFactory;

    /**
     * Init
     *
     * @param EntityFactory $entityFactory
     */
    public function __construct(EntityFactory $entityFactory)
    {
        $this->entityFactory = $entityFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $entities = [
            [
                'id'    => 1,
                'name'  => 'Default',
                'key'   => 'default'
            ],
            [
                'id'    => 2,
                'name'  => 'Category',
                'key'   => 'category'
            ],
            [
                'id'    => 3,
                'name'  => 'CMS Page',
                'key'   => 'cms_page'
            ]
        ];

        /**
         * Insert default entities
         */
        foreach ($entities as $data) {
            $this->createEntity()->setData($data)->save();
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
