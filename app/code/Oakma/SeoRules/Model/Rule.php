<?php
namespace Oakma\SeoRules\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;
use \Oakma\SeoRules\Api\Data\RuleInterface;

/**
 * Class Rule
 *
 * @package Oakma\SeoRules\Model
 */
class Rule extends AbstractModel implements IdentityInterface, RuleInterface
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

	/**
	 * @return string
	 */
	public function getPageTitle()
	{
		return $this->getData(self::PAGE_TITLE);
	}

	/**
	 * @return string
	 */
	public function getMetaDescription()
	{
		return $this->getData(self::META_DESCRIPTION);
	}

	/**
	 * @return string
	 */
	public function getMetaKeywords()
	{
		return $this->getData(self::META_KEYWORDS);
	}

	/**
	 * @return string
	 */
	public function getSeoH1()
	{
		return $this->getData(self::SEO_H1);
	}

	/**
	 * @return string
	 */
	public function getSeoText()
	{
		return $this->getData(self::SEO_TEXT);
	}

	/**
	 * @return \Oakma\SeoRules\Model\Rule
	 */
	public function getParentRule()
	{
		return $this->getData(self::PARENT_RULE_ID);
	}
}
