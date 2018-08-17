<?php

namespace Oakma\SeoRules\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Cms page grid inline edit controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Oakma_SeoRule::rule_save';

    /**
     * @var \Oakma\SeoRules\Controller\Adminhtml\Rule\PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var \Oakma\SeoRules\Api\RuleRepositoryInterface
     */
    protected $ruleRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param \Oakma\SeoRules\Controller\Adminhtml\Rule\PostDataProcessor $dataProcessor
     * @param \Oakma\SeoRules\Api\RuleRepositoryInterface $ruleRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        \Oakma\SeoRules\Controller\Adminhtml\Rule\PostDataProcessor $dataProcessor,
        \Oakma\SeoRules\Api\RuleRepositoryInterface $ruleRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->dataProcessor = $dataProcessor;
        $this->ruleRepository = $ruleRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $ruleId) {
            $rule = $this->ruleRepository->getById($ruleId);

            try {
                $ruleData = $this->filterPost($postItems[$ruleId]);

                $this->validatePost($ruleData, $rule, $error, $messages);

	            $extendedRuleData = $rule->getData();

                $this->setRuleData($rule, $extendedRuleData, $ruleData);

                $this->ruleRepository->save($rule);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithRuleId($rule, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithRuleId($rule, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithRuleId(
                    $page,
                    __('Something went wrong while saving the seo rule.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Filtering posted data.
     *
     * @param array $postData
     * @return array
     */
    protected function filterPost($postData = [])
    {
        $ruleData = $this->dataProcessor->filter($postData);
        return $ruleData;
    }

    /**
     * Validate post data
     *
     * @param array $ruleData
     * @param \Oakma\SeoRules\Api\Data\RuleInterface $rule
     * @param bool $error
     * @param array $messages
     * @return void
     */
    protected function validatePost(
    	array $ruleData,
	    \Oakma\SeoRules\Api\Data\RuleInterface $rule,
	    &$error,
	    array &$messages
    ) {
        if (!($this->dataProcessor->validate($ruleData) && $this->dataProcessor->validateRequireEntry($ruleData))) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithRuleId($rule, $error->getText());
            }
        }
    }

    /**
     * Add rule id to error message
     *
     * @param \Oakma\SeoRules\Api\Data\RuleInterface $rule
     * @param string $errorText
     *
     * @return string
     */
    protected function getErrorWithRuleId(
	    \Oakma\SeoRules\Api\Data\RuleInterface $rule,
	    string $errorText
    ) {
        return '[Rule ID: ' . $rule->getId() . '] ' . $errorText;
    }

    /**
     * Set seo rule data
     *
     * @param \Oakma\SeoRules\Api\Data\RuleInterface $rule
     * @param array $extendedRuleData
     * @param array $ruleData
     * @return $this
     */
    public function setCmsPageData(
	    \Oakma\SeoRules\Api\Data\RuleInterface $rule,
	    array $extendedRuleData,
	    array $ruleData
    ) {
	    $rule->setData(array_merge($rule->getData(), $extendedRuleData, $ruleData));

        return $this;
    }
}
