<?php

namespace Oakma\SeoRules\Model\ResourceModel\Rule\Relation\Store;

use Oakma\SeoRules\Api\Data\RuleInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Class SaveHandler
 */
class SaveHandler implements ExtensionInterface
{
	/**
	 * @var MetadataPool
	 */
	protected $metadataPool;

	/**
	 * @param MetadataPool $metadataPool
	 * @param Page $resourcePage
	 */
	public function __construct(
		MetadataPool $metadataPool
	) {
		$this->metadataPool = $metadataPool;
	}

	/**
	 * @param RuleInterface $entity
	 * @param array $arguments
	 *
	 * @return object
	 *
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function execute($entity, $arguments = [])
	{
		if ($entity->getId() && is_array($entity->getData(RuleInterface::STORE_IDS))) {
			$entity->setData(RuleInterface::STORE_IDS, implode(',', $entity->getData(RuleInterface::STORE_IDS)));
		}

		return $entity;
	}
}
