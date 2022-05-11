<?php

/**
 * This module adds a new item to main menu. 
 * In webtrees website it is used for link to webtrees Manuals.
 * The code is inspired by JustCarmen's jc-simple-menu-1.
 * Further amendments are done in collaboration with Hermann Hartenthaler.
 * Copyright (C) 2020 josef Prause
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace JpNamespace\Webtrees\Module\MainMenuManual;

use Fisharebest\Webtrees\I18N;
use Fisharebest\Localization\Translation;
use Fisharebest\Webtrees\Menu;
use Fisharebest\Webtrees\Tree;
use Fisharebest\Webtrees\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleMenuTrait;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Module\ModuleGlobalTrait;
use Fisharebest\Webtrees\Module\ModuleMenuInterface;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleGlobalInterface;

class MainMenuManual extends AbstractModule implements ModuleCustomInterface, ModuleMenuInterface, ModuleGlobalInterface
{
    use ModuleCustomTrait;
    use ModuleMenuTrait;
    use ModuleGlobalTrait;
    
    public const CUSTOM_MODULE = 'jp-main-menu-manual';
    public const CUSTOM_AUTHOR = 'Josef Prause';
    public const CUSTOM_WEBSITE = 'https://github.com/jpretired/' . self::CUSTOM_MODULE . '/';
    public const CUSTOM_VERSION = '2.1.0';
    public const CUSTOM_LAST = self::CUSTOM_WEBSITE . 'raw/main/latest-version.txt';
    public const CUSTOM_SUPPORT_URL = self::CUSTOM_WEBSITE . 'issues';

    /**
     * How should this module be identified in the control panel, etc.?
     *
     * @return string
     */
    public function title(): string
    {
        return I18N::translate('Main menu manual');
    }

    /**
     * A sentence describing what this module does.
     *
     * @return string
     */
    public function description(): string
    {
        /* I18N: Description of the “Simple Menu” module */
        return I18N::translate('Add an extra item to the main menu as a link to a webtrees manual.');
    }

    /**
     * {@inheritDoc}
     * @see \Fisharebest\Webtrees\Module\ModuleCustomInterface::customModuleAuthorName()
     */
    public function customModuleAuthorName(): string
    {
        return self::CUSTOM_AUTHOR;
    }

    /**
     * {@inheritDoc}
     * @see \Fisharebest\Webtrees\Module\ModuleCustomInterface::customModuleVersion()
     *
     * We use a system where the version number is equal to the latest version of webtrees
     * Interim versions get an extra sub number
     *
     * The dev version is always one step above the latest stable version of this module
     * The subsequent stable version depends on the version number of the latest stable version of webtrees
     *
     */
    public function customModuleVersion(): string
    {
        return self::CUSTOM_VERSION;
    }

    /**
     * A URL that will provide the latest stable version of this module.
     *
     * @return string
     */
    public function customModuleLatestVersionUrl(): string
    {
        return self::CUSTOM_LAST;
    }
    /**
     * {@inheritDoc}
     * @see \Fisharebest\Webtrees\Module\ModuleCustomInterface::customModuleSupportUrl()
     */
    public function customModuleSupportUrl(): string
    {
        return self::CUSTOM_SUPPORT_URL;
    }

    /**
     * Bootstrap the module
     */
    public function boot(): void
    {
        // Register a namespace for our views.
        View::registerNamespace($this->name(), $this->resourcesFolder() . 'views/');
    }

     /**
     * Where does this module store its resources
     *
     * @return string
     */
    public function resourcesFolder(): string
    {
        return __DIR__ . '/resources/';
    }

    /**
     * Additional/updated translations.
     *
     * @param string $language
     *
     * @return array<string,string>
     */
    public function customTranslations(string $language): array
    {
        $this->lang_switch = $language;
        $languageFile = $this->resourcesFolder() . 'lang/' . $language . '/messages.mo';

        return file_exists($languageFile) ? (new Translation($languageFile))->asArray() : [];
    }

    /**
     * The default position for this menu.  It can be changed in the control panel.
     *
     * @return int
     */
    public function defaultMenuOrder(): int
    {
        return 99;
    }

    /**
     * A menu, to be added to the main application menu.
     *
     * @param Tree $tree
     *
     * @return Menu|null
     */
    public function getMenu(Tree $tree): ?Menu
    {
        if ($tree === null) {
            return '';
        }

        $url = route('module', [
            'module' => $this->name(),
            'action' => 'Page',
            'tree'   => $tree ? $tree->name() : null,
        ]);

        $menu_title = I18N::translate('Manual');

        return new Menu($menu_title, e($url), 'jp-main-menu-manual');
    }

    /**
     * Generate the page that will be shown when we click the link in the footer.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function getPageAction(ServerRequestInterface $request): ResponseInterface
    {
        $page = '::page-manual';

        $tree = $request->getAttribute('tree');
        assert($tree instanceof Tree);

        return $this->viewResponse($this->name() . $page, [
            'title' => $this->title(),
            'tree'  => $request->getAttribute('tree'),
        ]);
    }

    /**
     * Raw content, to be added at the end of the <head> element.
     * Typically, this will be <link> and <meta> elements.
     *
     * @return string
     */
    public function headContent(): string
    {
        $url = $this->assetUrl('css/main-menu-manual.css');

        return '<link rel="stylesheet" href="' . e($url) . '">';
    }
    
};
