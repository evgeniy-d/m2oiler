<?php
namespace Oakma\SeoRules\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Oakma_SeoRule::rule_delete';

	/**
	 * Rule repository
	 *
	 * @var \Oakma\SeoRules\Api\RuleRepository
	 */
    protected $ruleRepository;

	/**
	 * Delete constructor.
	 *
	 * @param Action\Context $context
	 * @param \Oakma\SeoRules\Api\RuleRepository $ruleRepository
	 */
    public function __construct(
    	Action\Context $context,
		\Oakma\SeoRules\Api\RuleRepositoryInterface $ruleRepository
    ) {
	    parent::__construct($context);
    	$this->ruleRepository = $ruleRepository;
    }

	/**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('rule_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
	            $model = $this->ruleRepository->getById($id);
	            $this->ruleRepository->delete($model);
                $this->messageManager->addSuccess(__('The rule has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['page_id' => $id]);
            }
        }

        $this->messageManager->addError(__('We can\'t find a seo rule to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
