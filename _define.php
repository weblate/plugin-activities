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

/** @var \Galette\Core\Plugins $this */
$this->register(
    name: 'Galette Activities',    //Name
    desc: 'Activities management', //Short description
    author: 'Johan Cwiklinski',    //Author
    version: '1.1.2',              //Version
    compver: '1.2.0',              //Galette compatible version
    route: 'activities',           //routing name and translation domain
    date: '2025-12-08',            //Release date
    acls: [                        //Permissions needed
        '/activities_.*/'           => 'staff'
    ]
);
