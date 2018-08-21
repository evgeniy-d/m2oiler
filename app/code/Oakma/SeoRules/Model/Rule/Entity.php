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
}
