<?php

namespace Oakma\SeoRules\Model\Rule;

use Oakma\SeoRules\Api\Rule\EntityManagementInterface;
use Oakma\SeoRules\Model\Rule\Entity;
use Oakma\SeoRules\Model\Rule\EntityRegistry;


/**
 * Class EntityManagement
 */
class EntityManagement implements EntityManagementInterface
{
    /**
     * @var EntityRegistry
     */
    private $registry;

    /**
     * EntityManagement constructor.
     *
     * @param EntityRegistry $registry
     */
    public function __construct(
        EntityRegistry $registry
    ) {
        $this->registry = $registry;
    }

    /**
     * Get list of available entities
     *
     * @return EntityInterface[]
     */
    public function getAvailableEntities()
    {
        return [
            $this->registry->retrieveByCode(Entity::TYPE_DEFAULT_CODE),
            $this->registry->retrieveByCode(Entity::TYPE_CATEGORY_CODE),
            $this->registry->retrieveByCode(Entity::TYPE_CMS_PAGE_CODE),
        ];
    }
}
