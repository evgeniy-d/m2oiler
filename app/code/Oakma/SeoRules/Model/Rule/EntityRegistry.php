<?php

namespace Oakma\SeoRules\Model\Rule;

use Oakma\SeoRules\Model\Rule\EntityFactory;
use Oakma\SeoRules\Model\Rule\Entity;

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
     * @var array
     */
    private $entityRegistryByCode = [];

	/**
	 * EntityRegistry constructor.
	 *
	 * @param \Oakma\SeoRules\Model\Rule\EntityFactory $entityFactory
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
