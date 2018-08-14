<?php
namespace Oakma\SeoRule\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Rule
 *
 * @package Oakma\SeoRule\Model
 */
class Rule extends AbstractModel implements IdentityInterface
{
	/**
	 * Seo rule cache tag
	 */
	const CACHE_TAG = 'oakma_seorule';

	/**
	 * @var string
	 */
	protected $_cacheTag = 'oakma_seorule_rule';

	/**
	 * Prefix of model events names
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'oakma_seorule_rule';

	/**
	 * Constructor of model
	 */
	protected function _construct()
	{
		$this->_init('Oakma\SeoRule\Model\ResourceModel\Rule');
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
