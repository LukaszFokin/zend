<?php
namespace Estoque;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\I18n\Translator;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array (
                 'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                },
            )
        );
    }

    public function onBootstrap(MvcEvent $e) {
        $translator = $e->getApplication()->getServiceManager()->get('MvcTranslator');
        $translator->addTranslationFile(
            'phpArray',
            'vendor/zendframework/zend-i18n-resources/languages/pt_BR/Zend_Validate.php'
        );

        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    }
}
