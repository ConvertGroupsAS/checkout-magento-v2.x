<?php
/**
 * Bambora Online
 *
 * @category    Online Payment Gatway
 * @package     Bambora_Online_Checkout
 * @author      Bambora
 * @copyright   Bambora (http://bambora.com)
 */
namespace Bambora\Online\Controller\Checkout;

abstract class AbstractCheckout extends \Magento\Framework\App\Action\Action
{
    /**
     * @var string
     */
    const METHOD_CODE = 'bambora_checkout';

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Bambora\Online\Helper\Data
     */
    protected $_bamboraHelper;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;

    /**
     * @var \Bambora\Online\Logger\BamboraLogger
     */
    protected $_bamboraLogger;

    /**
     * @var \Magento\Payment\Helper\Data
     */
    protected $_paymentHelper;

    /**
     * @var \Magento\Sales\Model\Order
     */
    private $_order;

    /**
     * AbstractCheckout constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Bambora\Online\Helper\Data $bamboraHelper
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Bambora\Online\Logger\BamboraLogger $bamboraLogger
     * @param \Magento\Payment\Helper\Data $paymentHelper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Bambora\Online\Helper\Data $bamboraHelper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Bambora\Online\Logger\BamboraLogger $bamboraLogger,
        \Magento\Payment\Helper\Data $paymentHelper
    ) {
        parent::__construct($context);
        $this->_orderFactory = $orderFactory;
        $this->_checkoutSession = $checkoutSession;
        $this->_bamboraHelper = $bamboraHelper;
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_bamboraLogger = $bamboraLogger;
        $this->_paymentHelper = $paymentHelper;
    }

    /**
     * Get Payment method instance object
     *
     * @return {MethodInstance}
     */
    protected function _getPaymentMethodInstance()
    {
        return $this->_paymentHelper->getMethodInstance(self::METHOD_CODE);
    }

    /**
     * Get order object
     *
     * @return \Magento\Sales\Model\Order
     */
    protected function _getOrder()
    {
        if (!$this->_order)
        {
            $incrementId = $this->_checkoutSession->getLastRealOrderId();
            $this->_order = $this->_orderFactory->create()->loadByIncrementId($incrementId);
        }

        return $this->_order;
    }

    /**
     * @param $incrementId
     * @return \Magento\Sales\Model\Order
     */
    protected function _getOrderByIncrementId($incrementId)
    {
        if (!$this->_order)
        {
            $this->_order = $this->_orderFactory->create()->loadByIncrementId($incrementId);
        }

        return $this->_order;
    }

}