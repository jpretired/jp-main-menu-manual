<?php

/**
 * This module adds a new item to main menu. 
 * In website Naše rodina it is used for link to webtrees Manual.
 * The code is inspired by JustCarmen's jc-simple-menu-1.
 * Copyright (C) 2020 josef
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

require __DIR__ . '/MainMenuManual.php';

// This script must return an object that implements ModuleCustomInterface.
// If the module's constructor does not take any parameters, you can simply instantiate it.
//
// If you are using dependency-injection in your module, you would ask webtrees to make the object for you.
// return Webtrees::make(ExampleModule::class);
// For an example, see the server-config module.

return new MainMenuManual();