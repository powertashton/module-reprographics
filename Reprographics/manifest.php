<?php
/*
Gibbon, Flexible & Open School System
Copyright (C) 2010, Ross Parker

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http:// www.gnu.org/licenses/>.
*/

// This file describes the module, including database tables

// Basic variables
$name        = 'Reprographics';            // The name of the module as it appears to users. Needs to be unique to installation. Also the name of the folder that holds the unit.
$description = 'A Reprographic module for Gibbon';            // Short text description
$entryURL    = "reprographics_order.php";   // The landing page for the unit, used in the main menu
$type        = "Additional";  // Do not change.
$category    = 'Other';            // The main menu area to place the module in
$version     = '0.0.01';            // Version number
$author      = 'Ashton Power';            // Your name
$url         = 'https://github.com/powertashton/module-reprographics';            // Your URL

$tables = 0;
// Module tables & gibbonSettings entries
$moduleTables[$tables++] = 'CREATE TABLE `ItemCategory` (
    `categoryID` int(12) unsigned zerofill NOT NULL AUTO_INCREMENT,
    `categoryName` varchar(55) NOT NULL,
    PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
$moduleTables[$tables++] = 'CREATE TABLE `ItemSubCategory` (
    `subCategoryID` int(12) unsigned zerofill NOT NULL AUTO_INCREMENT,
    `categoryID` int(12) unsigned zerofill NOT NULL,
    `subCategoryName` varchar(55) NOT NULL,
    PRIMARY KEY (`subCategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;'; 
$moduleTables[$tables++] = 'CREATE TABLE `Item` (
    `itemID` int(12) unsigned zerofill NOT NULL AUTO_INCREMENT,
    `subCategoryID` int(12) unsigned zerofill NOT NULL,
    `categoryID` int(12) unsigned zerofill NOT NULL,
    `itemName` varchar(55) NOT NULL,
    `salePrice` int(12) NOT NULL,
    `realPrice` int(12) NOT NULL,
    `stock` int(12) NOT NULL,
    PRIMARY KEY (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
$moduleTables[$tables++] = 'CREATE TABLE `Order` (
    `orderID` int(12) unsigned zerofill NOT NULL AUTO_INCREMENT,
    `itemID` int(12) unsigned zerofill NOT NULL,
    `deptID` int(12) unsigned zerofill NOT NULL,
    `gibbonPersonID` int(10) unsigned zerofill NOT NULL,
    `orderStatus` varchar(55) NOT NULL,
    `orderDate` date NOT NULL,
    `quantity` int(12) NOT NULL,
    PRIMARY KEY (`orderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
$moduleTables[$tables++] = 'CREATE TABLE `ReprographicsDept` (
    `deptID` int(12) unsigned zerofill NOT NULL AUTO_INCREMENT,
    `deptName` varchar(55) NOT NULL,
    PRIMARY KEY (`deptID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
$moduleTables[$tables++] = 'CREATE TABLE `ReprographicsStaff` (
    `staffID` int(12) unsigned zerofill NOT NULL AUTO_INCREMENT,
    `gibbonPersonID` int(10) unsigned zerofill NOT NULL,
    `deptID` int(12) unsigned zerofill NOT NULL,
    PRIMARY KEY (`staffID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


// Action rows 
// One array per action
$actionCount = 0;

$actionRows[$actionCount++] = [
    'name'                      => 'Order Items', // The name of the action (appears to user in the right hand side module menu)
    'precedence'                => '0',// If it is a grouped action, the precedence controls which is highest action in group
    'category'                  => 'Order', // Optional: subgroups for the right hand side module menu
    'description'               => 'Allows the user to order items', // Text description
    'URLList'                   => 'reprographics_order.php', // List of pages included in this action
    'entryURL'                  => 'reprographics_order.php', // The landing action for the page.
    'entrySidebar'              => 'Y', // Whether or not there's a sidebar on entry to the action
    'menuShow'                  => 'Y', // Whether or not this action shows up in menus or if it's hidden
    'defaultPermissionAdmin'    => 'Y', // Default permission for built in role Admin
    'defaultPermissionTeacher'  => 'Y', // Default permission for built in role Teacher
    'defaultPermissionStudent'  => 'N', // Default permission for built in role Student
    'defaultPermissionParent'   => 'N', // Default permission for built in role Parent
    'defaultPermissionSupport'  => 'Y', // Default permission for built in role Support
    'categoryPermissionStaff'   => 'Y', // Should this action be available to user roles in the Staff category?
    'categoryPermissionStudent' => 'N', // Should this action be available to user roles in the Student category?
    'categoryPermissionParent'  => 'N', // Should this action be available to user roles in the Parent category?
    'categoryPermissionOther'   => 'N', // Should this action be available to user roles in the Other category?
];

$actionRows[$actionCount++] = [
    'name'                      => 'Manage Categories', // The name of the action (appears to user in the right hand side module menu)
    'precedence'                => '0',// If it is a grouped action, the precedence controls which is highest action in group
    'category'                  => 'Admin', // Optional: subgroups for the right hand side module menu
    'description'               => 'Allows the user to manage categories', // Text description
    'URLList'                   => 'reprographics_categoryManage.php', // List of pages included in this action
    'entryURL'                  => 'reprographics_categoryManage.php', // The landing action for the page.
    'entrySidebar'              => 'Y', // Whether or not there's a sidebar on entry to the action
    'menuShow'                  => 'Y', // Whether or not this action shows up in menus or if it's hidden
    'defaultPermissionAdmin'    => 'Y', // Default permission for built in role Admin
    'defaultPermissionTeacher'  => 'N', // Default permission for built in role Teacher
    'defaultPermissionStudent'  => 'N', // Default permission for built in role Student
    'defaultPermissionParent'   => 'N', // Default permission for built in role Parent
    'defaultPermissionSupport'  => 'N', // Default permission for built in role Support
    'categoryPermissionStaff'   => 'N', // Should this action be available to user roles in the Staff category?
    'categoryPermissionStudent' => 'N', // Should this action be available to user roles in the Student category?
    'categoryPermissionParent'  => 'N', // Should this action be available to user roles in the Parent category?
    'categoryPermissionOther'   => 'N', // Should this action be available to user roles in the Other category?
];

$actionRows[$actionCount++] = [
    'name'                      => 'Manage Items', // The name of the action (appears to user in the right hand side module menu)
    'precedence'                => '0',// If it is a grouped action, the precedence controls which is highest action in group
    'category'                  => 'Admin', // Optional: subgroups for the right hand side module menu
    'description'               => 'Allows the user to manage items', // Text description
    'URLList'                   => 'reprographics_itemsManage.php', // List of pages included in this action
    'entryURL'                  => 'reprographics_itemsManage.php', // The landing action for the page.
    'entrySidebar'              => 'Y', // Whether or not there's a sidebar on entry to the action
    'menuShow'                  => 'Y', // Whether or not this action shows up in menus or if it's hidden
    'defaultPermissionAdmin'    => 'Y', // Default permission for built in role Admin
    'defaultPermissionTeacher'  => 'N', // Default permission for built in role Teacher
    'defaultPermissionStudent'  => 'N', // Default permission for built in role Student
    'defaultPermissionParent'   => 'N', // Default permission for built in role Parent
    'defaultPermissionSupport'  => 'N', // Default permission for built in role Support
    'categoryPermissionStaff'   => 'N', // Should this action be available to user roles in the Staff category?
    'categoryPermissionStudent' => 'N', // Should this action be available to user roles in the Student category?
    'categoryPermissionParent'  => 'N', // Should this action be available to user roles in the Parent category?
    'categoryPermissionOther'   => 'N', // Should this action be available to user roles in the Other category?
];

$actionRows[$actionCount++] = [
    'name'                      => 'Manage Stock', // The name of the action (appears to user in the right hand side module menu)
    'precedence'                => '0',// If it is a grouped action, the precedence controls which is highest action in group
    'category'                  => 'Admin', // Optional: subgroups for the right hand side module menu
    'description'               => 'Allows the user to manage stock', // Text description
    'URLList'                   => 'reprographics_stock.php', // List of pages included in this action
    'entryURL'                  => 'reprographics_stock.php', // The landing action for the page.
    'entrySidebar'              => 'Y', // Whether or not there's a sidebar on entry to the action
    'menuShow'                  => 'Y', // Whether or not this action shows up in menus or if it's hidden
    'defaultPermissionAdmin'    => 'Y', // Default permission for built in role Admin
    'defaultPermissionTeacher'  => 'N', // Default permission for built in role Teacher
    'defaultPermissionStudent'  => 'N', // Default permission for built in role Student
    'defaultPermissionParent'   => 'N', // Default permission for built in role Parent
    'defaultPermissionSupport'  => 'N', // Default permission for built in role Support
    'categoryPermissionStaff'   => 'N', // Should this action be available to user roles in the Staff category?
    'categoryPermissionStudent' => 'N', // Should this action be available to user roles in the Student category?
    'categoryPermissionParent'  => 'N', // Should this action be available to user roles in the Parent category?
    'categoryPermissionOther'   => 'N', // Should this action be available to user roles in the Other category?
];

$actionRows[$actionCount++] = [
    'name'                      => 'Manage Orders', // The name of the action (appears to user in the right hand side module menu)
    'precedence'                => '0',// If it is a grouped action, the precedence controls which is highest action in group
    'category'                  => 'Admin', // Optional: subgroups for the right hand side module menu
    'description'               => 'Allows the user to manage orders', // Text description
    'URLList'                   => 'reprographics_orderManage.php', // List of pages included in this action
    'entryURL'                  => 'reprographics_orderManage.php', // The landing action for the page.
    'entrySidebar'              => 'Y', // Whether or not there's a sidebar on entry to the action
    'menuShow'                  => 'Y', // Whether or not this action shows up in menus or if it's hidden
    'defaultPermissionAdmin'    => 'Y', // Default permission for built in role Admin
    'defaultPermissionTeacher'  => 'N', // Default permission for built in role Teacher
    'defaultPermissionStudent'  => 'N', // Default permission for built in role Student
    'defaultPermissionParent'   => 'N', // Default permission for built in role Parent
    'defaultPermissionSupport'  => 'N', // Default permission for built in role Support
    'categoryPermissionStaff'   => 'N', // Should this action be available to user roles in the Staff category?
    'categoryPermissionStudent' => 'N', // Should this action be available to user roles in the Student category?
    'categoryPermissionParent'  => 'N', // Should this action be available to user roles in the Parent category?
    'categoryPermissionOther'   => 'N', // Should this action be available to user roles in the Other category?
];

$actionRows[$actionCount++] = [
    'name'                      => 'Manage Departments', // The name of the action (appears to user in the right hand side module menu)
    'precedence'                => '0',// If it is a grouped action, the precedence controls which is highest action in group
    'category'                  => 'Admin', // Optional: subgroups for the right hand side module menu
    'description'               => 'Allows the user to manage orders', // Text description
    'URLList'                   => 'reprographics_deptManage.php', // List of pages included in this action
    'entryURL'                  => 'reprographics_deptManage.php', // The landing action for the page.
    'entrySidebar'              => 'Y', // Whether or not there's a sidebar on entry to the action
    'menuShow'                  => 'Y', // Whether or not this action shows up in menus or if it's hidden
    'defaultPermissionAdmin'    => 'Y', // Default permission for built in role Admin
    'defaultPermissionTeacher'  => 'N', // Default permission for built in role Teacher
    'defaultPermissionStudent'  => 'N', // Default permission for built in role Student
    'defaultPermissionParent'   => 'N', // Default permission for built in role Parent
    'defaultPermissionSupport'  => 'N', // Default permission for built in role Support
    'categoryPermissionStaff'   => 'N', // Should this action be available to user roles in the Staff category?
    'categoryPermissionStudent' => 'N', // Should this action be available to user roles in the Student category?
    'categoryPermissionParent'  => 'N', // Should this action be available to user roles in the Parent category?
    'categoryPermissionOther'   => 'N', // Should this action be available to user roles in the Other category?
];


//TODO: organise this more and set stuff up properly lmao
