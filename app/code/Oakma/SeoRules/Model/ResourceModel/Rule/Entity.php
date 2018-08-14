<?php
namespace Oakma\SeoRule\Model\ResourceModel\Rule;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Entity
 *
 * @package Oakma\SeoRule\Model\ResourceModel\Rule
 */
class Entity extends AbstractDb
{
	/**
	 * Entity constructor.
	 *
	 * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
	 */
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}

	/**
	 * Init resource model
	 */
	protected function _construct()
	{
		$this->_init('oakma_seorule_entity', 'id');
	}
}
