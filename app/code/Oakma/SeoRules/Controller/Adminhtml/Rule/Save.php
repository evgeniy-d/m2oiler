<?php

namespace Oakma\SeoRules\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Oakma_SeoRule::rule_save';

    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Magento\Cms\Model\RuleFactory
     */
    private $ruleFactory;

    /**
     * @var \Oakma\SeoRules\Api\RuleRepositoryInterface
     */
    private $ruleRepository;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param \Oakma\SeoRules\Model\RuleFactory $ruleFactory
     * @param \Oakma\SeoRules\Api\RuleRepositoryInterface $ruleRepository
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        \Oakma\SeoRules\Model\RuleFactory $ruleFactory,
        \Oakma\SeoRules\Api\RuleRepositoryInterface $ruleRepository
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->ruleFactory = $ruleFactory;
        $this->ruleRepository = $ruleRepository;

        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $data = $this->dataProcessor->filter($data);

            $model = $this->ruleFactory->create();

            $id = $this->getRequest()->getParam('rule_id');
            if ($id) {
                try {
                    $model = $this->ruleRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This rule no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'oiler_seorules_rule_prepare_save',
                ['rule' => $model, 'request' => $this->getRequest()]
            );

            if (!$this->dataProcessor->validate($data)) {
                return $resultRedirect->setPath('*/*/edit', ['rule_id' => $model->getId(), '_current' => true]);
            }

            try {
                $this->ruleRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the rule.'));
                $this->dataPersistor->clear('seorules_rule');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['rule_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the seo rule.'));
            }

            $this->dataPersistor->set('seorules_rule', $data);
            return $resultRedirect->setPath('*/*/edit', ['rule_id' => $this->getRequest()->getParam('rule_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
