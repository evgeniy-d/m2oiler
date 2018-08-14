<?php

namespace Oakma\SeoRule\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for rule search results.
 * @api
 */
interface PageSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get rules list.
     *
     * @return \Oakma\SeoRule\Api\Data\RuleInterface[]
     */
    public function getItems();

    /**
     * Set rules list.
     *
     * @param \Oakma\SeoRule\Api\Data\RuleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
