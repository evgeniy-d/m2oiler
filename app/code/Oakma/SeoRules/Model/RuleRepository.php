<?php

namespace Oakma\SeoRules\Model;

use Oakma\SeoRules\Api\RuleRepositoryInterface;
use Oakma\SeoRules\Api\Data\RuleInterface;
use Oakma\SeoRules\Api\Data\RuleSearchResultsInterfaceFactory;
use Oakma\SeoRules\Model\ResourceModel\Rule as ResourceRule;
use Oakma\SeoRules\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

/**
 * Class RuleRepository
 */
class RuleRepository implements RuleRepositoryInterface
{
    /**
     * @var ResourceRule
     */
    protected $resource;

    /**
     * @var RuleFactory
     */
    protected $pageFactory;

    /**
     * @var RuleCollectionFactory
     */
    protected $ruleCollectionFactory;

    /**
     * @var RuleSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;


    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceRule $resource
     * @param RuleFactory $ruleFactory
     * @param RuleCollectionFactory $ruleCollectionFactory
     * @param RuleSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceRule $resource,
        RuleFactory $ruleFactory,
        RuleCollectionFactory $ruleCollectionFactory,
        RuleSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->ruleFactory = $ruleFactory;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save Seo Rule data
     *
     * @param RuleInterface $rule
     * @return RuleInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(RuleInterface $rule)
    {
        if ($rule->getStoreId() === null) {
            $rule->setStoreIds(0);
        }

        try {
            $this->resource->save($rule);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the rule: %1', $exception->getMessage()),
                $exception
            );
        }

        return $rule;
    }

    /**
     * Load rule data by given ID
     *
     * @param integer $ruleId
     *
     * @return RuleInterface
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($ruleId)
    {
        $rule = $this->ruleFactory->create();
        $rule->load($ruleId);

        if (!$rule->getId()) {
            throw new NoSuchEntityException(__('Seo rule with id "%1" does not exist.', $ruleId));
        }

        return $rule;
    }

    /**
     * Load rule data collection by given search criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     *
     * @return \Oakma\SeoRules\Api\Data\RuleSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $collection = $this->ruleCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete rule
     *
     * @param RuleInterface $rule
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     */
    public function delete(RuleInterface $rule)
    {
        try {
            $this->resource->delete($rule);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the rule: %1',
                $exception->getMessage()
            ));
        }

        return true;
    }

    /**
     * Delete rule by given ID
     *
     * @param string $ruleId
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($ruleId)
    {
        return $this->delete($this->getById($ruleId));
    }
}
