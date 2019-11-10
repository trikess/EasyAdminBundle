<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Configuration;

use EasyCorp\Bundle\EasyAdminBundle\Context\AssetContext;
use EasyCorp\Bundle\EasyAdminBundle\Context\CrudContext;
use EasyCorp\Bundle\EasyAdminBundle\Context\DashboardContext;
use EasyCorp\Bundle\EasyAdminBundle\Context\UserMenuContext;
use EasyCorp\Bundle\EasyAdminBundle\Dashboard\DashboardConfig;
use EasyCorp\Bundle\EasyAdminBundle\Menu\MenuBuilderInterface;

final class Configuration
{
    private $dashboardContext;
    private $assets;
    private $userMenuContext;
    private $crudContext;
    private $pageConfig;
    private $menuBuilder;
    private $locale;

    public function __construct(DashboardContext $dashboardContext, AssetContext $assets, UserMenuContext $userMenuContext, ?CrudContext $crudContext, ?CrudPageConfigInterface $pageConfig, MenuBuilderInterface $menuBuilder, string $locale)
    {
        $this->dashboardContext = $dashboardContext;
        $this->assets = $assets;
        $this->userMenuContext = $userMenuContext;
        $this->crudContext = $crudContext;
        $this->pageConfig = $pageConfig;
        $this->menuBuilder = $menuBuilder;
        $this->locale = $locale;
    }

    public function getFaviconPath(): string
    {
        return $this->dashboardContext->getFaviconPath();
    }

    public function getAssets(): AssetContext
    {
        return $this->assets;
    }

    public function getSiteName(): string
    {
        return $this->dashboardContext->getSiteName();
    }

    public function getTranslationDomain(): string
    {
        return $this->dashboardContext->getTranslationDomain();
    }

    public function getTextDirection(): string
    {
        if (null !== $textDirection = $this->dashboardContext->getTextDirection()) {
            return $textDirection;
        }

        $localePrefix = strtolower(substr($this->locale, 0, 2));

        return \in_array($localePrefix, ['ar', 'fa', 'he']) ? 'rtl' : 'ltr';
    }

    public function getUserMenu(): UserMenuContext
    {
        return $this->userMenuContext;
    }

    public function getPageTitle(): ?string
    {
        if (null === $this->pageConfig) {
            return null;
        }

        return $this->pageConfig->getTitle();
    }

    public function getPageHelp(): ?string
    {
        if (null === $this->pageConfig) {
            return null;
        }

        return $this->pageConfig->getHelp();
    }

    public function getTemplate(string $name): string
    {
        if (null !== $this->crudContext && null !== $templatePath = $this->crudContext->getCustomTemplate($name)) {
            return $templatePath;
        }

        return $this->dashboardContext->getCustomTemplate($name)
            ?? $this->dashboardContext->getDefaultTemplate($name);
    }
}