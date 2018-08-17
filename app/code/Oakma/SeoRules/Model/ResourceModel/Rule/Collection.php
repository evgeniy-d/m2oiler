<?php
namespace Oakma\SeoRules\Model\ResourceModel\Rule;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Oakma\SeoRules\Model\ResourceModel\Rule
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
	protected $_eventPrefix = 'oakma_seorules_rule_collection';

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
		$this->_init('Oakma\SeoRules\Model\Rule', 'Oakma\SeoRules\Model\ResourceModel\Rule');
	}

}
