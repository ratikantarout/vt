<?php

/**
 * @property Configuration $object
 */
class AdminCustomerPreferencesControllerCore extends AdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->className = 'Configuration';
        $this->table = 'configuration';

        parent::__construct();

        $registration_process_type = array(
            array(
                'value' => PS_REGISTRATION_PROCESS_STANDARD,
                'name' => $this->l('Only account creation')
            ),
            array(
                'value' => PS_REGISTRATION_PROCESS_AIO,
                'name' => $this->l('Standard (account creation and address creation)')
            )
        );

        $this->fields_options = array(
            'general' => array(
                'title' =>    $this->l('General'),
                'icon' =>    'icon-cogs',
                'fields' =>    array(
                    'PS_REGISTRATION_PROCESS_TYPE' => array(
                        'title' => $this->l('Registration process type'),
                        'hint' => $this->l('The "Only account creation" registration option allows the customer to register faster, and create his/her address later.'),
                        'validation' => 'isInt',
                        'cast' => 'intval',
                        'type' => 'select',
                        'list' => $registration_process_type,
                        'identifier' => 'value'
                    ),
                    'PS_ONE_PHONE_AT_LEAST' => array(
                        'title' => $this->l('Phone number is mandatory'),
                        'hint' => $this->l('If you chose yes, your customer will have to provide at least one phone number to register.'),
                        'validation' => 'isBool',
                        'cast' => 'intval',
                        'type' => 'bool'
                    ),
                    'PS_CART_FOLLOWING' => array(
                        'title' => $this->l('Re-display cart at login'),
                        'hint' => $this->l('After a customer logs in, you can recall and display the content of his/her last shopping cart.'),
                        'validation' => 'isBool',
                        'cast' => 'intval',
                        'type' => 'bool'
                    ),
                    'PS_CUSTOMER_CREATION_EMAIL' => array(
                        'title' => $this->l('Send an email after registration'),
                        'hint' => $this->l('Send an email with summary of the account information (email, password) after registration.'),
                        'validation' => 'isBool',
                        'cast' => 'intval',
                        'type' => 'bool'
                    ),
                    'PS_PASSWD_TIME_FRONT' => array(
                        'title' => $this->l('Password reset delay'),
                        'hint' => $this->l('Minimum time required between two requests for a password reset.'),
                        'validation' => 'isUnsignedInt',
                        'cast' => 'intval',
                        'size' => 5,
                        'type' => 'text',
                        'suffix' => $this->l('minutes')
                    ),
                    'PS_B2B_ENABLE' => array(
                        'title' => $this->l('Enable B2B mode'),
                        'hint' => $this->l('Activate or deactivate B2B mode. When this option is enabled, B2B features will be made available.'),
                        'validation' => 'isBool',
                        'cast' => 'intval',
                        'type' => 'bool'
                    ),
                    'PS_CUSTOMER_NWSL' => array(
                        'title' => $this->l('Enable newsletter registration'),
                        'hint' => $this->l('Display or not the newsletter registration tick box.'),
                        'validation' => 'isBool',
                        'cast' => 'intval',
                        'type' => 'bool'
                    ),
                    'PS_CUSTOMER_OPTIN' => array(
                        'title' => $this->l('Enable opt-in'),
                        'hint' => $this->l('Display or not the opt-in tick box, to receive offers from the store\'s partners.'),
                        'validation' => 'isBool',
                        'cast' => 'intval',
                        'type' => 'bool'
                    ),
                ),
                'submit' => array('title' => $this->l('Save')),
            ),
        );
    }

    /**
     * Update PS_B2B_ENABLE and enables / disables the associated tabs
     * @param $value integer Value of option
     */
    public function updateOptionPsB2bEnable($value)
    {
        $value = (int)$value;

        $tabs_class_name = array('AdminOutstanding');
        if (!empty($tabs_class_name)) {
            foreach ($tabs_class_name as $tab_class_name) {
                $tab = Tab::getInstanceFromClassName($tab_class_name);
                if (Validate::isLoadedObject($tab)) {
                    $tab->active = $value;
                    $tab->save();
                }
            }
        }
        Configuration::updateValue('PS_B2B_ENABLE', $value);
    }
}
