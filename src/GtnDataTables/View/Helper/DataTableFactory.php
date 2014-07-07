<?php
/**
 * @copyright Copyright (c) 2014 Emmanuel BOUTON - Rémi VEYNE-MARTI
 * @link      http://github.com/multimediabs/kamba for the canonical source repository
 *
 * This file is part of GtnDataTables.
 *
 * GtnDataTables is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * GtnDataTables is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GtnDataTables.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace GtnDataTables\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DataTableFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $helper = new DataTable();
        $helper->setServiceLocator($serviceLocator);
        return $helper;
    }
}
