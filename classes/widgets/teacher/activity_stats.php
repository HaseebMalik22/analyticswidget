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

namespace block_analyticswidget\widgets\teacher;

/**
 * Activity stats for teacher
 */
class activity_stats implements \block_analyticswidget\widgetfacade {

    /**
     * courses
     * @var array $courses
     */
    public $courses = [];
    /**
     * Order of display
     * @var int $order
     */
    public $order = 3;
    /**
     * Intializing
     * @param array $courses
     */
    public function __construct($courses) {
        $this->courses = $courses;
    }

    /**
     * Export html
     * @return string Html content
     */
    public function export_html() {
        global $OUTPUT;
        if (get_config('block_analyticswidget', 'aw_teacher_stats_activity')) {
            $context  = array();
            // Get only visible and course.

            $context['data'] = $this->courses;
            $activities = 0;
            foreach ($this->courses as $course) {
                // Removing self.
                $cms = get_fast_modinfo($course)->get_cms();
                $activities += count($cms);
            }
            $context['count'] = $activities;
            return $OUTPUT->render_from_template('block_analyticswidget/teacher/activity_stats', $context);
        }
        return false;
    }
}
