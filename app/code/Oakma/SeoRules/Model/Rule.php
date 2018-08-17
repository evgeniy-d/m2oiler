<?php
namespace Oakma\SeoRules\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Rule
 *
 * @package Oakma\SeoRules\Model
 */
class Rule extends AbstractModel implements IdentityInterface
{
	/**
	 * Seo rule cache tag
	 */
	const CACHE_TAG = 'oakma_seorules';

	/**
	 * @var string
	 */
	protected $_cacheTag = 'oakma_seorules_rule';

	/**
	 * Prefix of model events names
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'oakma_seorules_rule';

	/**
	 * Constructor of model
	 */
	protected function _construct()
	{
		$this->_init('Oakma\SeoRules\Model\ResourceModel\Rule');
	}

	/**
	 * Get identities
	 *
	 * @return array|string[]
	 */
	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	/**
	 * Before save model
	 *
	 * @return $this
	 *
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function beforeSave()
	{
		if ($this->hasDataChanges()) {
			$this->setUpdateTime(null);
		}

		return parent::beforeSave();
	}
}
