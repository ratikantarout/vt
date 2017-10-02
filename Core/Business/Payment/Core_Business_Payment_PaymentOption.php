<?php

class Core_Business_Payment_PaymentOption {

    private $callToActionText;
    private $logo;
    private $action;
    private $method;
    private $inputs;
    private $form;
    private $moduleName;

    /**
     * Return Call to Action Text
     * @return string
     */
    public function getCallToActionText() {
        return $this->callToActionText;
    }

    /**
     * Set Call To Action Text
     * @param $callToActionText
     * @return $this
     */
    public function setCallToActionText($callToActionText) {
        $this->callToActionText = $callToActionText;
        return $this;
    }

    /**
     * Return logo path
     * @return string
     */
    public function getLogo() {
        return $this->logo;
    }

    /**
     * Set logo path
     * @param $logo
     * @return $this
     */
    public function setLogo($logo) {
        $this->logo = $logo;
        return $this;
    }

    /**
     * Return action to perform (POST/GET)
     * @return string
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * Set action to be performed by this option
     * @param $action
     * @return $this
     */
    public function setAction($action) {
        $this->action = $action;
        return $this;
    }

    public function getMethod() {
        return $this->method;
    }

    public function setMethod($method) {
        $this->method = $method;
        return $this;
    }

    /**
     * Return inputs contained in this payment option
     * @return mixed
     */
    public function getInputs() {
        return $this->inputs;
    }

    /**
     * Set inputs for this payment option
     * @param $inputs
     * @return $this
     */
    public function setInputs($inputs) {
        $this->inputs = $inputs;
        return $this;
    }

    /**
     * Get payment option form
     * @return mixed
     */
    public function getForm() {
        return $this->form;
    }

    /**
     * Set payment option form
     * @param $form
     * @return $this
     */
    public function setForm($form) {
        $this->form = $form;
        return $this;
    }

    /**
     * Get related module name to this payment option
     * @return string
     */
    public function getModuleName() {
        return $this->moduleName;
    }

    /**
     * Set related module name to this payment option
     * @param $moduleName
     * @return $this
     */
    public function setModuleName($moduleName) {
        $this->moduleName = $moduleName;
        return $this;
    }

    /**
     * Legacy options were specified this way:
     * - either an array with a top level property 'cta_text'
     * 	and then the other properties
     * - or a numerically indexed array or arrays as described above
     * Since this was a mess, this method is provided to convert them.
     * It takes as input a legacy option (in either form) and always
     * returns an array of instances of Core_Business_Payment_PaymentOption
     */
    public static function convertLegacyOption(array $legacyOption) {
        if (!$legacyOption) {
            return;
        }

        if (array_key_exists('cta_text', $legacyOption)) {
            $legacyOption = array($legacyOption);
        }

        $newOptions = array();

        $defaults = array(
            'action' => null,
            'form' => null,
            'method' => null,
            'inputs' => array(),
            'logo' => null
        );

        foreach ($legacyOption as $option) {
            $option = array_merge($defaults, $option);

            $newOption = new Core_Business_Payment_PaymentOption();
            $newOption->setCallToActionText($option['cta_text'])
                    ->setAction($option['action'])
                    ->setForm($option['form'])
                    ->setInputs($option['inputs'])
                    ->setLogo($option['logo'])
                    ->setMethod($option['method']);

            $newOptions[] = $newOption;
        }

        return $newOptions;
    }

}
