<?php

/**
 * @property PrestaShopLogger $object
 */
class AdminLogsControllerCore extends AdminController {

    public function __construct() {
        $this->bootstrap = true;
        $this->table = 'log';
        $this->className = 'PrestaShopLogger';
        $this->lang = false;
        $this->noLink = true;

        $this->fields_list = array(
            'id_log' => array(
                'title' => $this->l('ID'),
                'align' => 'text-center',
                'class' => 'fixed-width-xs'
            ),
            'employee' => array(
                'title' => $this->l('Employee'),
                'havingFilter' => true,
                'callback' => 'displayEmployee',
                'callback_object' => $this
            ),
            'severity' => array(
                'title' => $this->l('Severity (1-4)'),
                'align' => 'text-center',
                'class' => 'fixed-width-xs'
            ),
            'message' => array(
                'title' => $this->l('Message')
            ),
            'object_type' => array(
                'title' => $this->l('Object type'),
                'class' => 'fixed-width-sm'
            ),
            'object_id' => array(
                'title' => $this->l('Object ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'error_code' => array(
                'title' => $this->l('Error code'),
                'align' => 'center',
                'prefix' => '0x',
                'class' => 'fixed-width-xs'
            ),
            'date_add' => array(
                'title' => $this->l('Date'),
                'align' => 'right',
                'type' => 'datetime'
            )
        );

        $this->fields_options = array(
            'general' => array(
                'title' => $this->l('Logs by email'),
                'icon' => 'icon-envelope',
                'fields' => array(
                    'PS_LOGS_BY_EMAIL' => array(
                        'title' => $this->l('Minimum severity level'),
                        'hint' => $this->l('Enter "5" if you do not want to receive any emails.') . '<br />' . $this->l('Emails will be sent to the shop owner.'),
                        'cast' => 'intval',
                        'type' => 'text'
                    )
                ),
                'submit' => array('title' => $this->l('Save'))
            )
        );
        $this->list_no_link = true;
        $this->_select .= 'CONCAT(LEFT(e.firstname, 1), \'. \', e.lastname) employee';
        $this->_join .= ' LEFT JOIN ' . _DB_PREFIX_ . 'employee e ON (a.id_employee = e.id_employee)';
        $this->_use_found_rows = false;
        parent::__construct();
    }

    public function processDelete() {
        if (PrestaShopLogger::eraseAllLogs()) {
            Tools::redirectAdmin(Context::getContext()->link->getAdminLink('AdminLogs'));
        }
    }

    public function initToolbar() {
        parent::initToolbar();
        $this->toolbar_btn['delete'] = array(
            'short' => 'Erase',
            'desc' => $this->l('Erase all'),
            'js' => 'if (confirm(\'' . $this->l('Are you sure?') . '\')) document.location = \'' . Tools::safeOutput($this->context->link->getAdminLink('AdminLogs')) . '&amp;token=' . $this->token . '&amp;deletelog=1\';'
        );
        unset($this->toolbar_btn['new']);
    }

    public function displayEmployee($value, $tr) {
        $template = $this->context->smarty->createTemplate('controllers/logs/employee_field.tpl', $this->context->smarty);
        $employee = new Employee((int) $tr['id_employee']);
        $template->assign(array(
            'employee_image' => $employee->getImage(),
            'employee_name' => $value
        ));
        return $template->fetch();
    }

}
