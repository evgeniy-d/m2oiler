<?php
namespace Oakma\SeoRules\Test\Unit\Model;

use Oakma\SeoRules\Model\RuleRepository;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

/**
 * Test for Oakma\SeoRules\Model\RuleRepository
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RuleRepositoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var RuleRepository
     */
    protected $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Oakma\SeoRules\Model\ResourceModel\Rule
     */
    protected $ruleResource;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Oakma\SeoRules\Model\Rule
     */
    protected $rule;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Oakma\SeoRules\Api\Data\RuleInterface
     */
    protected $ruleData;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Oakma\SeoRules\Api\Data\RuleSearchResultsInterface
     */
    protected $ruleSearchResult;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Api\DataObjectHelper
     */
    protected $dataHelper;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Oakma\SeoRules\Model\ResourceModel\Rule\Collection
     */
    protected $collection;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $collectionProcessor;

    /**
     * Initialize repository
     */
    protected function setUp()
    {
        $this->ruleResource = $this->getMockBuilder(\Oakma\SeoRules\Model\ResourceModel\Rule::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dataObjectProcessor = $this->getMockBuilder(\Magento\Framework\Reflection\DataObjectProcessor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $ruleFactory = $this->getMockBuilder(\Oakma\SeoRules\Model\RuleFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $ruleDataFactory = $this->getMockBuilder(\Oakma\SeoRules\Api\Data\RuleInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $ruleSearchResultFactory = $this->getMockBuilder(\Oakma\SeoRules\Api\Data\RuleSearchResultsInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $collectionFactory = $this->getMockBuilder(\Oakma\SeoRules\Model\ResourceModel\Rule\CollectionFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->storeManager = $this->getMockBuilder(\Magento\Store\Model\StoreManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $store = $this->getMockBuilder(\Magento\Store\Api\Data\StoreInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $store->expects($this->any())->method('getId')->willReturn(0);
        $this->storeManager->expects($this->any())->method('getStore')->willReturn($store);

        $this->rule = $this->getMockBuilder(\Oakma\SeoRules\Model\Rule::class)->disableOriginalConstructor()->getMock();
        $this->ruleData = $this->getMockBuilder(\Oakma\SeoRules\Api\Data\RuleInterface::class)
            ->getMock();
        $this->ruleSearchResult = $this->getMockBuilder(\Oakma\SeoRules\Api\Data\RuleSearchResultsInterface::class)
            ->getMock();
        $this->collection = $this->getMockBuilder(\Oakma\SeoRules\Model\ResourceModel\Rule\Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSize', 'setCurRule', 'setRuleSize', 'load', 'addOrder'])
            ->getMock();

        $ruleFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->rule);
        $ruleDataFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->ruleData);
        $ruleSearchResultFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->ruleSearchResult);
        $collectionFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->collection);
        /**
         * @var \Oakma\SeoRules\Model\RuleFactory $ruleFactory
         * @var \Oakma\SeoRules\Api\Data\RuleInterfaceFactory $ruleDataFactory
         * @var \Oakma\SeoRules\Api\Data\RuleSearchResultsInterfaceFactory $ruleSearchResultFactory
         * @var \Oakma\SeoRules\Model\ResourceModel\Rule\CollectionFactory $collectionFactory
         */

        $this->dataHelper = $this->getMockBuilder(\Magento\Framework\Api\DataObjectHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collectionProcessor = $this->getMockBuilder(CollectionProcessorInterface::class)
            ->getMockForAbstractClass();

        $this->repository = new RuleRepository(
            $this->ruleResource,
            $ruleFactory,
            $ruleDataFactory,
            $collectionFactory,
            $ruleSearchResultFactory,
            $this->dataHelper,
            $this->dataObjectProcessor,
            $this->storeManager,
            $this->collectionProcessor
        );
    }

    /**
     * @test
     */
    public function testSave()
    {
        $this->ruleResource->expects($this->once())
            ->method('save')
            ->with($this->rule)
            ->willReturnSelf();

        $this->assertEquals($this->rule, $this->repository->save($this->rule));
    }

    /**
     * @test
     */
    public function testDeleteById()
    {
        $ruleId = '123';

        $this->rule->expects($this->once())
            ->method('getId')
            ->willReturn(true);
        $this->rule->expects($this->once())
            ->method('load')
            ->with($ruleId)
            ->willReturnSelf();
        $this->ruleResource->expects($this->once())
            ->method('delete')
            ->with($this->rule)
            ->willReturnSelf();

        $this->assertTrue($this->repository->deleteById($ruleId));
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\CouldNotSaveException
     */
    public function testSaveException()
    {
        $this->ruleResource->expects($this->once())
            ->method('save')
            ->with($this->rule)
            ->willThrowException(new \Exception());

        $this->repository->save($this->rule);
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function testDeleteException()
    {
        $this->ruleResource->expects($this->once())
            ->method('delete')
            ->with($this->rule)
            ->willThrowException(new \Exception());

        $this->repository->delete($this->rule);
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\NoSuchEntityException
     */
    public function testGetByIdException()
    {
        $ruleId = '123';

        $this->rule->expects($this->once())
            ->method('getId')
            ->willReturn(false);
        $this->rule->expects($this->once())
            ->method('load')
            ->with($ruleId)
            ->willReturnSelf();

        $this->repository->getById($ruleId);
    }

    /**
     * @test
     */
    public function testGetList()
    {
        $total = 10;

        /** @var \Magento\Framework\Api\SearchCriteriaInterface $criteria */
        $criteria = $this->getMockBuilder(\Magento\Framework\Api\SearchCriteriaInterface::class)->getMock();

        $this->collection->addItem($this->rule);
        $this->collection->expects($this->once())
            ->method('getSize')
            ->willReturn($total);

        $this->collectionProcessor->expects($this->once())
            ->method('process')
            ->with($criteria, $this->collection)
            ->willReturnSelf();

        $this->ruleSearchResult->expects($this->once())
            ->method('setSearchCriteria')
            ->with($criteria)
            ->willReturnSelf();

        $this->ruleSearchResult->expects($this->once())
            ->method('setTotalCount')
            ->with($total)
            ->willReturnSelf();

        $this->ruleSearchResult->expects($this->once())
            ->method('setItems')
            ->with([$this->rule])
            ->willReturnSelf();

        $this->assertEquals($this->ruleSearchResult, $this->repository->getList($criteria));
    }
}
