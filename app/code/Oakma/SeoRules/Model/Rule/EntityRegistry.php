<?php

namespace Oakma\SeoRule\Model\Rule;

use Oakma\SeoRule\Model\Rule\EntityFactory;
use Oakma\SeoRule\Model\Rule\Entity;

/**
 * Registry for \Oakma\SeoRule\Model\Rule\Entity
 */
class EntityRegistry
{
    const REGISTRY_SEPARATOR = ':';

    /**
     * @var EntityFactory
     */
    private $entityFactory;

    /**
     * @var array
     */
    private $entityRegistryByCode = [];

	/**
	 * EntityRegistry constructor.
	 *
	 * @param \Oakma\SeoRule\Model\Rule\EntityFactory $entityFactory
	 */
    public function __construct(
	    EntityFactory $entityFactory
    ) {
        $this->entityFactory = $entityFactory;
    }

	/**
	 * Retrieve ID of enityt from registry given an code
	 *
	 * @param string $code
	 *
	 * @return mixed
	 */
    public function retrieveIdByCode(
        string $code
    ) {
	    if (!isset($this->entityRegistryByCode[$entityKey])) {
		    $entity = $this->entityFactory->create();
		    $entity->load($entityKey,'key');

		    $this->entityRegistryByCode[$entityKey] = $entity->getId() ?: 0;
	    }

	    return $this->entityRegistryByCode[$entityKey];
    }
}
