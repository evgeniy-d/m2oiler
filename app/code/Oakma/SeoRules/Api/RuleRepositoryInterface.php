<?php
namespace Oakma\SeoRules\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Seo rule CRUD interface.
 * @api
 */
interface RuleRepositoryInterface
{
    /**
     * Save rule.
     *
     * @param \Oakma\SeoRules\Api\Data\RuleInterface $rule
     *
     * @return \Oakma\SeoRules\Api\Data\RuleInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Oakma\SeoRules\Api\Data\RuleInterface $rule);

    /**
     * Retrieve rule.
     *
     * @param int $pageId
     *
     * @return \Oakma\SeoRules\Api\Data\RuleInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($ruleId);

    /**
     * Retrieve rules matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \akma\SeoRule\Api\Data\RuleSearchResultsInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete rule.
     *
     * @param \Oakma\SeoRules\Api\Data\RuleInterface $rule
     *
     * @return bool true on success
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Oakma\SeoRules\Api\Data\RuleInterface $rule);

    /**
     * Delete rule by ID.
     *
     * @param int $ruleId
     *
     * @return bool true on success
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($ruleId);
}
