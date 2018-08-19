<?php

namespace Oakma\SeoRules\Ui\Component\Listing\Column\Rule;

use Oakma\SeoRules\Api\RuleRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Oakma\SeoRules\Api\Data\RuleSearchResultsInterface;

/**
 * Options for seo rules
 */
class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var RuleSearchResultsInterface
     */
    protected $rules;

    /**
     * Options constructor.
     *
     * @param RuleRepositoryInterface $ruleRepository
     */
    public function __construct(
        RuleRepositoryInterface $ruleRepository,
        SearchCriteriaInterface $searchCriteria
    ) {
      $this->rules = $ruleRepository->getList($searchCriteria);
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $this->options[0]['label'] = __('No parent rule');
        $this->options[0]['value'] = 0;


        foreach ($this->rules as $rule) {
            $this->options[] = [
                'label' => __('ID') . ': ' . $rule->getId() . ' ' . $rule->getRuleName(),
                'value' => $rule->getId()
            ];
        }


        return $this->options;
    }
}
