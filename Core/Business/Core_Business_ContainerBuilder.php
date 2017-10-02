<?php

class Core_Business_ContainerBuilder {

    /**
     * Construct PrestaShop Core Service container
     * @return Core_Foundation_IoC_Container
     * @throws Core_Foundation_IoC_Exception
     */
    public function build() {
        $container = new Core_Foundation_IoC_Container;

        $container->bind('Core_Business_ConfigurationInterface', 'Adapter_Configuration', true);
        $container->bind('Core_Foundation_Database_DatabaseInterface', 'Adapter_Database', true);

        return $container;
    }

}
