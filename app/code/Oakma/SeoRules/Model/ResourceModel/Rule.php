<?php
namespace Oakma\SeoRules\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Rule
 * @package Oakma\SeoRules\Model\ResourceModel
 */
class Rule extends AbstractDb
{
	/**
	 * Rule constructor.
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
		$this->_init('oakma_seorules', 'id');
	}
}
