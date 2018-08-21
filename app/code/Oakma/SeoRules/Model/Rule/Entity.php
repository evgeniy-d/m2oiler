<?php
namespace Oakma\SeoRules\Model\Rule;

use Magento\Framework\Model\AbstractModel;
use Oakma\SeoRules\Api\Data\Rule\EntityInterface;

/**
 * Class Entity
 *
 * @package Oakma\SeoRules\Model\Rule
 */
class Entity extends AbstractModel implements EntityInterface
{
	/**
	 * Prefix of model events names
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'oakma_seorules_rule_entity';

	/**
	 * Constructor of model
	 */
	protected function _construct()
	{
		$this->_init('Oakma\SeoRules\Model\ResourceModel\Rule\Entity');
	}

    /**
     * Get name of entity
     *
     * @return string
     */
	public function getName()
    {
        return $this->getData(EntityInterface::ENTITY_NAME);
    }

    /**
     * Get key of entity
     *
     * @return string
     */
    public function getKey()
    {
        return $this->getData(EntityInterface::ENTITY_KEY);
    }
}
