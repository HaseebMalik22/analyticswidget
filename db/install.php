<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Code to be executed after the plugin's database scheme has been installed is defined here.
 *
 * @package     block_analyticswidget
 * @category    upgrade
 * @copyright   2022 Haseeb Malik <haseebmalik.info@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Custom code to be run on installing the plugin.
 */
function xmldb_block_analyticswidget_install() {

    $systemcontext = context_system::instance();
    $page = new moodle_page();
    $page->set_context($systemcontext);
    $page->set_pagetype('my-index');
    $page->set_pagelayout('mydashboard');
    $page->blocks->add_region(BLOCK_POS_LEFT);
    $defaultblocks = array(
        'content' => array('analyticswidget'),
    );
    $page->blocks->add_blocks($defaultblocks);

    return true;
}
