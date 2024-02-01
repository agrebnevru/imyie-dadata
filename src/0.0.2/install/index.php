<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class imyie_dadata extends CModule
{

    public $MODULE_ID = 'imyie.dadata';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_CSS;
    public $MODULE_GROUP_RIGHTS = 'Y';

    public function __construct()
    {
        $arModuleVersion = array();

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path . "/version.php");
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = GetMessage('IMYIE_INSTALL_NAME');
        $this->MODULE_DESCRIPTION = GetMessage('IMYIE_INSTALL_DESCRIPTION');
        $this->PARTNER_NAME = GetMessage('IMYIE_INSTALL_COPMPANY_NAME');
        $this->PARTNER_URI = 'https://agrebnev.ru/';
    }

    public function InstallDB($install_wizard = true)
    {
        ModuleManager::registerModule($this->MODULE_ID);

        return true;
    }

    public function UnInstallDB($arParams = array())
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);

        return true;
    }

    public function InstallEvents()
    {
        return true;
    }

    public function UnInstallEvents()
    {
        return true;
    }

    public function InstallFiles()
    {
        return true;
    }

    public function InstallPublic()
    {
        return true;
    }

    public function InstallOptions()
    {
        return true;
    }

    public function UnInstallFiles()
    {
        return true;
    }

    public function DoInstall()
    {
        global $APPLICATION, $step;

        $this->InstallFiles();
        $this->InstallDB(false);
        $this->InstallEvents();
        $this->InstallPublic();

        return true;
    }

    public function DoUninstall()
    {
        global $APPLICATION, $step;

        $this->UnInstallDB();
        $this->UnInstallFiles();
        $this->UnInstallEvents();

        return true;
    }
}
