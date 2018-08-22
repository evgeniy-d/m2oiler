<?php
namespace Oakma\SeoRules\Model\ResourceModel\Rule;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use \Oakma\SeoRules\Api\Data\RuleInterface;

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

	/**
	 * Perform operations after collection load
	 *
	 * @param string $tableName
	 * @param string|null $linkField
	 * @return void
	 */
	protected function performAfterLoad($tableName, $linkField)
	{
		$linkedIds = $this->getColumnValues($linkField);
		if (count($linkedIds)) {
			$connection = $this->getConnection();
			$select = $connection->select()->from(['cms_entity_store' => $this->getTable($tableName)])
				->where('cms_entity_store.' . $linkField . ' IN (?)', $linkedIds);
			$result = $connection->fetchAll($select);
			if ($result) {
				$storesData = [];
				foreach ($result as $storeData) {
					$storesData[$storeData[$linkField]][] = $storeData['store_id'];
				}

				foreach ($this as $item) {
					$linkedId = $item->getData($linkField);
					if (!isset($storesData[$linkedId])) {
						continue;
					}
					$storeIdKey = array_search(Store::DEFAULT_STORE_ID, $storesData[$linkedId], true);
					if ($storeIdKey !== false) {
						$stores = $this->storeManager->getStores(false, true);
						$storeId = current($stores)->getId();
						$storeCode = key($stores);
					} else {
						$storeId = current($storesData[$linkedId]);
						$storeCode = $this->storeManager->getStore($storeId)->getCode();
					}
					$item->setData('_first_store_id', $storeId);
					$item->setData('store_code', $storeCode);
					$item->setData('store_id', $storesData[$linkedId]);
				}
			}
		}
	}

	/**
	 * Perform operations after collection load
	 *
	 * @return $this
	 */
	protected function _afterLoad()
	{
		foreach ($this->_items as $item) {
			$item->setData(RuleInterface::STORE_IDS, explode(',', $item->getData(RuleInterface::STORE_IDS)));
		}

		return parent::_afterLoad();
	}
}
