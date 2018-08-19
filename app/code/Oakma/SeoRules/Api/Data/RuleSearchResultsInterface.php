<?php

namespace Oakma\SeoRules\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for rule search results.
 * @api
 */
interface RuleSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get rules list.
     *
     * @return \Oakma\SeoRules\Api\Data\RuleInterface[]
     */
    public function getItems();

    /**
     * Set rules list.
     *
     * @param \Oakma\SeoRules\Api\Data\RuleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
