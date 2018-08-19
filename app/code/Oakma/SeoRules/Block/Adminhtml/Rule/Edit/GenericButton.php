<?php

namespace Oakma\SeoRules\Block\Adminhtml\Rule\Edit;

use Magento\Backend\Block\Widget\Context;
use Oakma\SeoRules\Api\RuleRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var RuleRepositoryInterface
     */
    protected $ruleRepository;

    /**
     * @param Context $context
     * @param RuleRepositoryInterface $ruleRepository
     */
    public function __construct(
        Context $context,
        RuleRepositoryInterface $ruleRepository
    ) {
        $this->context = $context;
        $this->ruleRepository = $ruleRepository;
    }

    /**
     * Return seo rule ID
     *
     * @return int|null
     */
    public function getRuleId()
    {
        try {
            return $this->ruleRepository->getById(
                $this->context->getRequest()->getParam('rule_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
