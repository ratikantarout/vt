<?php

if (isset(Context::getContext()->controller)) {
    $controller = Context::getContext()->controller;
} else {
    $controller = new FrontController();
    $controller->init();
}
Tools::displayFileAsDeprecated();
$controller->displayFooter();
