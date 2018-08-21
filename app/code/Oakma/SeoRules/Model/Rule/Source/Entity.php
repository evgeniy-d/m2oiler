<?php

namespace Oakma\SeoRules\Model\Rule\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Oakma\SeoRules\Api\Rule\EntityManagementInterface;

/**
 * Class Entity
 */
class Entity implements OptionSourceInterface
{
    /**
     * @var EntityManagementInterface
     */
    protected $entityManagement;

    /**
     * Constructor
     *
     * @param EntityManagementInterface $entityManagement
     */
    public function __construct(EntityManagementInterface $entityManagement)
    {
        $this->entityManagement = $entityManagement;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->entityManagement->getAvailableEntities();
        $options = [];
        foreach ($availableOptions as $entity) {
            $options[] = [
                'label' => $entity->getName(),
                'value' => $entity->getId(),
            ];
        }
        return $options;
    }
}
