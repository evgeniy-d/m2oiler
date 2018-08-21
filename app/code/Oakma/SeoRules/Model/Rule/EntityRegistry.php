<?php

namespace Oakma\SeoRules\Model\Rule;

use Oakma\SeoRules\Model\Rule\EntityFactory;
use Oakma\SeoRules\Model\ResourceModel\Rule\Entity as EntityResource;
use Oakma\SeoRules\Api\Data\Rule\EntityInterface;

/**
 * Registry for \Oakma\SeoRules\Model\Rule\Entity
 */
class EntityRegistry
{
    /**
     * @var EntityFactory
     */
    private $entityFactory;

    /**
     * @var EntityResource
     */
    private $resource;

    /**
     * @var array
     */
    private $entityRegistryByCode = [];

    /**
     * @var array
     */
    private $entityRegistryById = [];

	/**
	 * EntityRegistry constructor.
	 *
	 * @param EntityFactory $entityFactory
     * @param EntityResource $entityResource
	 */
    public function __construct(
	    EntityFactory $entityFactory,
        EntityResource $entityResource
    ) {
        $this->entityFactory = $entityFactory;
        $this->resource = $entityResource;
    }

	/**
	 * Retrieve entity from registry given an code
	 *
	 * @param string $code
	 *
	 * @return EntityInterface|null
	 */
    public function retrieveByCode(
        string $code
    ) {
	    if (!isset($this->entityRegistryByCode[$code])) {
		    $entity = $this->entityFactory->create();
            $this->resource->load($entity, $code,'key');

		    $this->entityRegistryByCode[$code] = $entity->getId() ? $entity : null;

		    if ($entity->getId()) {
                $this->entityRegistryById[$entity->getId()] = $entity;
            }

	    }

	    return $this->entityRegistryByCode[$code];
    }

    /**
     * Retrieve entity from registry given ID
     *
     * @param int $id
     *
     * @return EntityInterface|null
     */
    public function retrieveById(
        int $id
    ) {
        if (!isset($this->entityRegistryById[$id])) {
            $entity = $this->entityFactory->create();
            $this->resource->load($entity, $id);

            $this->entityRegistryById[$id] = $entity->getId() ? $entity : null;

            if ($entity->getId()) {
                $this->entityRegistryByCode[$entity->getKey()] = $entity;
            }

        }

        return $this->entityRegistryByCode[$id];
    }
}
