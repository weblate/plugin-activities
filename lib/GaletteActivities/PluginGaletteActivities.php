<?php

/**
 * Copyright © 2003-2026 The Galette Team
 *
 * This file is part of Galette (https://galette.eu).
 *
 * Galette is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Galette is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Galette. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace GaletteActivities;

use DI\Attribute\Inject;
use Galette\Core\Db;
use Galette\Core\Login;
use Galette\Core\Plugins\MemberActionProviderInterface;
use Galette\Core\Plugins\MenuProviderInterface;
use Galette\Entity\Adherent;
use Galette\Core\GalettePlugin;

/**
 * Galette Activities plugin
 *
 * @author Johan Cwiklinski <johan@x-tnd.be>
 */

class PluginGaletteActivities extends GalettePlugin implements MenuProviderInterface, MemberActionProviderInterface
{
    #[Inject]
    private readonly Db $zdb; //@phpstan-ignore property.uninitializedReadonly (injected from DI)

    /**
     * Get plugins menus
     *
     * @return array<string, string|array<string, mixed>>
     */
    public function getMenus(): array
    {
        /** @var Login $login */
        global $login;
        $menus = [];

        if ($login->isAdmin() || $login->isStaff()) {
            $menus['plugin_activities'] = [
                'title' => _T("Activities", "activities"),
                'icon' => 'calendar alternate',
                'items' => [
                    [
                        'label' => _T('Activities', 'activities'),
                        'route' => [
                            'name' => 'activities_activities',
                            'aliases' => ['activities_activity_add', 'activities_activity_edit']
                        ]
                    ],
                    [
                        'label' => _T('Subscriptions', 'activities'),
                        'route' => [
                            'name' => 'activities_subscriptions',
                            'aliases' => ['activities_subscription_add', 'activities_subscription_edit']
                        ]
                    ]
                ]
            ];
        }

        return $menus;
    }

    /**
     * Get plugins public menus
     *
     * @return array<int, string|array<string, mixed>>
     */
    public function getPublicMenus(): array
    {
        return [];
    }

    /**
     * Get member actions
     *
     * @param Adherent $member Member instance
     *
     * @return array<int, string|array<string, mixed>>
     */
    public function getListActions(Adherent $member): array
    {
        /** @var Login $login */
        global $login;

        if (!$login->isAdmin() && !$login->isStaff()) {
            return [];
        }

        return [
            [
                'label' => str_replace(
                    '%membername',
                    $member->sname,
                    //TRANS %membername will be replaced with current member name
                    _T("New subscription for %membername", "activities")
                ),
                'route' => [
                    'name' => 'activities_subscription_add',
                    'args' => [Adherent::PK => $member->id]
                ],
                'icon' => 'money check alternate grey'
            ],
        ];
    }

    /**
     * Get detailed member actions
     *
     * @param Adherent $member Member instance
     *
     * @return array<int, string|array<string, mixed>>
     */
    public function getDetailedActions(Adherent $member): array
    {
        return $this->getListActions($member);
    }

    /**
     * Get member batch actions
     *
     * @return array<int, string|array<string, mixed>>
     */
    public function getBatchActions(): array
    {
        return [];
    }
}
