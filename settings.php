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
 * Plugin administration pages are defined here.
 *
 * @package     block_analyticswidget
 * @category    admin
 * @copyright   2022 Haseeb Malik <haseebmalik.info@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_heading('aw_teacher', '', get_string('aw_teacher_stats', 'block_analyticswidget')));
    // Teacher.
    $settings->add(new admin_setting_configcheckbox(
        'block_analyticswidget/aw_teacher_level',
        get_string('aw_teacher_level', 'block_analyticswidget'),
        '',
        1
    ));


    $options = get_default_enrol_roles(context_system::instance());
    $student = get_archetype_roles('student');
    $student = reset($student);
    $settings->add(new admin_setting_configselect('block_analyticswidget/student_roleid',
        get_string('student_role', 'block_analyticswidget'), '', $student->id, $options));



    $teacher = get_archetype_roles('editingteacher');
    $teacher = reset($teacher);
    $settings->add(new admin_setting_configselect('block_analyticswidget/teacher_roleid',
        get_string('teacher_role', 'block_analyticswidget'), '', $teacher->id, $options));

     $settings->add(new admin_setting_configcheckbox('block_analyticswidget/aw_teacher_stats_course',
                                                    get_string('aw_teacher_stats_course', 'block_analyticswidget'),
                                                    '',
                                                    1));
    $settings->add(new admin_setting_configcheckbox('block_analyticswidget/aw_teacher_stats_user',
                                                    get_string('aw_teacher_stats_user', 'block_analyticswidget'),
                                                    '',
                                                    1));
    $settings->add(new admin_setting_configcheckbox('block_analyticswidget/aw_teacher_stats_activity',
                                                    get_string('aw_teacher_stats_activity', 'block_analyticswidget'),
                                                    '',
                                                    1));

}
