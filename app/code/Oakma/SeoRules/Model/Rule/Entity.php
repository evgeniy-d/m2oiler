<?php
namespace Oakma\SeoRule\Model\Rule;

use \Magento\Framework\Model\AbstractModel;

/**
 * Class Entity
 *
 * @package Oakma\SeoRule\Model\Rule
 */
class Entity extends AbstractModel
{
	/**
	 * Prefix of model events names
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'oakma_seorule_rule_entity';

	/**
	 * Constructor of model
	 */
	protected function _construct()
	{
		$this->_init('Oakma\SeoRule\Model\ResourceModel\Rule\Entity');
	}
}
