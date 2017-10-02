<?php

class HistoryControllerCore extends FrontController {

    public $auth = true;
    public $php_self = 'history';
    public $authRedirection = 'history';
    public $ssl = true;

    public function setMedia() {
        parent::setMedia();
        $this->addCSS(array(
            _THEME_CSS_DIR_ . 'history.css',
            _THEME_CSS_DIR_ . 'addresses.css'
        ));
        $this->addJS(array(
            _THEME_JS_DIR_ . 'history.js',
            _THEME_JS_DIR_ . 'tools.js' // retro compat themes 1.5
        ));
        $this->addJqueryPlugin(array('scrollTo', 'footable', 'footable-sort'));
    }

    /**
     * Assign template vars related to page content
     * @see FrontController::initContent()
     */
    public function initContent() {
        parent::initContent();

        if ($orders = Order::getCustomerOrders($this->context->customer->id)) {
            foreach ($orders as &$order) {
                $myOrder = new Order((int) $order['id_order']);
                if (Validate::isLoadedObject($myOrder)) {
                    $order['virtual'] = $myOrder->isVirtual(false);
                }
            }
        }
        $this->context->smarty->assign(array(
            'orders' => $orders,
            'invoiceAllowed' => (int) Configuration::get('PS_INVOICE'),
            'reorderingAllowed' => !(bool) Configuration::get('PS_DISALLOW_HISTORY_REORDERING'),
            'slowValidation' => Tools::isSubmit('slowvalidation')
        ));

        $this->setTemplate(_PS_THEME_DIR_ . 'history.tpl');
    }

}
