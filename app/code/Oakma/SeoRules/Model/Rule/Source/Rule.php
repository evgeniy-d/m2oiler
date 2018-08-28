<?php

namespace Oakma\SeoRules\Model\Rule\Source;

use \Magento\Framework\Data\OptionSourceInterface;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Registry;
use \Oakma\SeoRules\Api\RuleRepositoryInterface;

/**
 * Class Rules
 */
class Rule implements OptionSourceInterface
{
	/**
	 * @var RuleRepositoryInterface
	 */
	protected $ruleRepository;

	/**
	 * @var RuleRepositoryInterface
	 */
	protected $searchCriteria;

	/**
	 * @var Registry
	 */
	protected $registry;

	/**
	 * Rule constructor.
	 *
	 * @param RuleRepositoryInterface $ruleRepository
	 * @param SearchCriteriaInterface $searchCriteria
	 * @param DataPersistorInterface $dataPersistor
	 */
	public function __construct(
		RuleRepositoryInterface $ruleRepository,
		SearchCriteriaInterface $searchCriteria,
		Registry $registry
	) {
		$this->ruleRepository = $ruleRepository;
		$this->searchCriteria = $searchCriteria;
		$this->registry = $registry;
	}

	/**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $items = $this->ruleRepository->getList($this->searchCriteria);
	    $data = $this->registry->registry('seorules');
	    $options = [];

	    foreach ($items->getItems() as $item) {
	    	if ($data && $data->getId() == $item->getId()) {
	    		continue;
		    }

		    $options[] = [
		    	'value' => $item->getId(),
			    'label' => $item->getRuleName()
		    ];
	    }

        return $options;
    }
}
