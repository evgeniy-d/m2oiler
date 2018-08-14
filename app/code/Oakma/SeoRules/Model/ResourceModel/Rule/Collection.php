<?php
namespace Oakma\SeoRule\Model\ResourceModel\Rule;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Oakma\SeoRule\Model\ResourceModel\Rule
 */
class Collection extends AbstractCollection
{
	/**
	 * Primery key field
	 *
	 * @var string
	 */
	protected $_idFieldName = 'id';

	/**
	 * Event prefix
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'oakma_seorule_rule_collection';

	/**
	 * Event object
	 *
	 * @var string
	 */
	protected $_eventObject = 'rule_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Oakma\SeoRule\Model\Rule', 'Oakma\SeoRule\Model\ResourceModel\Rule');
	}

}
