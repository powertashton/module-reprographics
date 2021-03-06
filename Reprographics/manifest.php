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
$version     = '0.0.02';            // Version number
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
    `salePrice` DECIMAL(12,2) NOT NULL,
    `realPrice` DECIMAL(12,2) NOT NULL,
    `stock` int(12) NOT NULL,
    PRIMARY KEY (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
$moduleTables[$tables++] = 'CREATE TABLE `ReprographicsOrder` (
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
$moduleTables[$tables++] = 'CREATE TABLE `Printing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `department` varchar(45) DEFAULT NULL,
  `BWA3Duplex` double DEFAULT NULL,
  `BWA3DuplexPrice` double DEFAULT NULL,
  `BWA3Simplex` double DEFAULT NULL,
  `BWA3SimplexPrice` double DEFAULT NULL,
  `BWA4Duplex` int(11) DEFAULT NULL,
  `BWA4DuplexPrice` double DEFAULT NULL,
  `BWA4Simplex` int(11) DEFAULT NULL,
  `BWA4SimplexPrice` double DEFAULT NULL,
  `FCA3Duplex` varchar(45) DEFAULT NULL,
  `FCA3DuplexPrice` varchar(45) DEFAULT NULL,
  `FCA3Simplex` varchar(45) DEFAULT NULL,
  `FCA3SimplexPrice` varchar(45) DEFAULT NULL,
  `FCA4Duplex` int(11) DEFAULT NULL,
  `FCA4DuplexPrice` double DEFAULT NULL,
  `FCA4Simplex` int(11) DEFAULT NULL,
  `FCA4SimplexPrice` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idPrinting_UNIQUE` (`id`)
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
    'categoryPermissionStaff'   => 'Y', // Should this action be available to user roles in the Staff category?
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
    'categoryPermissionStaff'   => 'Y', // Should this action be available to user roles in the Staff category?
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
    'categoryPermissionStaff'   => 'Y', // Should this action be available to user roles in the Staff category?
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
    'categoryPermissionStaff'   => 'Y', // Should this action be available to user roles in the Staff category?
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
    'categoryPermissionStaff'   => 'Y', // Should this action be available to user roles in the Staff category?
    'categoryPermissionStudent' => 'N', // Should this action be available to user roles in the Student category?
    'categoryPermissionParent'  => 'N', // Should this action be available to user roles in the Parent category?
    'categoryPermissionOther'   => 'N', // Should this action be available to user roles in the Other category?
];

$actionRows[$actionCount++] = [
    'name'                      => 'Admin Order', // The name of the action (appears to user in the right hand side module menu)
    'precedence'                => '0',// If it is a grouped action, the precedence controls which is highest action in group
    'category'                  => 'Admin', // Optional: subgroups for the right hand side module menu
    'description'               => 'Allows the user to create orders as an admin', // Text description
    'URLList'                   => 'reprographics_adminOrder.php', // List of pages included in this action
    'entryURL'                  => 'reprographics_adminOrder.php', // The landing action for the page.
    'entrySidebar'              => 'Y', // Whether or not there's a sidebar on entry to the action
    'menuShow'                  => 'Y', // Whether or not this action shows up in menus or if it's hidden
    'defaultPermissionAdmin'    => 'Y', // Default permission for built in role Admin
    'defaultPermissionTeacher'  => 'N', // Default permission for built in role Teacher
    'defaultPermissionStudent'  => 'N', // Default permission for built in role Student
    'defaultPermissionParent'   => 'N', // Default permission for built in role Parent
    'defaultPermissionSupport'  => 'N', // Default permission for built in role Support
    'categoryPermissionStaff'   => 'Y', // Should this action be available to user roles in the Staff category?
    'categoryPermissionStudent' => 'N', // Should this action be available to user roles in the Student category?
    'categoryPermissionParent'  => 'N', // Should this action be available to user roles in the Parent category?
    'categoryPermissionOther'   => 'N', // Should this action be available to user roles in the Other category?
];

$actionRows[$actionCount++] = [
    'name'                      => 'View Reports', // The name of the action (appears to user in the right hand side module menu)
    'precedence'                => '0',// If it is a grouped action, the precedence controls which is highest action in group
    'category'                  => 'Reports', // Optional: subgroups for the right hand side module menu
    'description'               => 'Allows the user to view reports', // Text description
    'URLList'                   => 'reprographics_reports.php', // List of pages included in this action
    'entryURL'                  => 'reprographics_reports.php', // The landing action for the page.
    'entrySidebar'              => 'Y', // Whether or not there's a sidebar on entry to the action
    'menuShow'                  => 'Y', // Whether or not this action shows up in menus or if it's hidden
    'defaultPermissionAdmin'    => 'Y', // Default permission for built in role Admin
    'defaultPermissionTeacher'  => 'N', // Default permission for built in role Teacher
    'defaultPermissionStudent'  => 'N', // Default permission for built in role Student
    'defaultPermissionParent'   => 'N', // Default permission for built in role Parent
    'defaultPermissionSupport'  => 'N', // Default permission for built in role Support
    'categoryPermissionStaff'   => 'Y', // Should this action be available to user roles in the Staff category?
    'categoryPermissionStudent' => 'N', // Should this action be available to user roles in the Student category?
    'categoryPermissionParent'  => 'N', // Should this action be available to user roles in the Parent category?
    'categoryPermissionOther'   => 'N', // Should this action be available to user roles in the Other category?
];

$actionRows[$actionCount++] = [
    'name'                      => 'Printers', // The name of the action (appears to user in the right hand side module menu)
    'precedence'                => '0',// If it is a grouped action, the precedence controls which is highest action in group
    'category'                  => 'Printer', // Optional: subgroups for the right hand side module menu
    'description'               => 'Allows the user to manage printing records', // Text description
    'URLList'                   => 'reprographics_printers.php', // List of pages included in this action
    'entryURL'                  => 'reprographics_printers.php', // The landing action for the page.
    'entrySidebar'              => 'Y', // Whether or not there's a sidebar on entry to the action
    'menuShow'                  => 'Y', // Whether or not this action shows up in menus or if it's hidden
    'defaultPermissionAdmin'    => 'Y', // Default permission for built in role Admin
    'defaultPermissionTeacher'  => 'N', // Default permission for built in role Teacher
    'defaultPermissionStudent'  => 'N', // Default permission for built in role Student
    'defaultPermissionParent'   => 'N', // Default permission for built in role Parent
    'defaultPermissionSupport'  => 'N', // Default permission for built in role Support
    'categoryPermissionStaff'   => 'Y', // Should this action be available to user roles in the Staff category?
    'categoryPermissionStudent' => 'N', // Should this action be available to user roles in the Student category?
    'categoryPermissionParent'  => 'N', // Should this action be available to user roles in the Parent category?
    'categoryPermissionOther'   => 'N', // Should this action be available to user roles in the Other category?
];


//TODO: organise this more and set stuff up properly lmao
