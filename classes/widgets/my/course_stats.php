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

namespace block_analyticswidget\widgets\my;

/**
 *  course stats for me
 */
class course_stats implements \block_analyticswidget\widgetfacade {

    /**
     *  courses
     * @var array $courses
     */
    public $courses = [];
    /**
     * userid
     * @var int $userid
     */
    public $userid;
    /**
     * order
     * @var int $order
     */
    public $order = 1;
    /**
     * active courses
     * @var array $activecourses
     */
    public $activecourses = [];
    /**
     * stuyding in
     * @var array $studingin
     */
    public $studingin  = [];

     /**
      * Initializes class member variables.
      * @param int $userid
      * @param array $courses
      * @param array $activecourses
      * @param array $studingin
      */
    public function __construct($userid, $courses, $activecourses, $studingin) {
        $this->courses = $courses;
        $this->userid = $userid;
        $this->active_courses = $activecourses;
        $this->studing_in = $studingin;

        if (!$this->userid) {
            throw new \moodle_exception("missing user");
        }
    }

    /**
     * Returns the html contents.
     *
     * @return  string  block contents.
     */
    public function export_html() {
        global $OUTPUT;
        $context  = array();
        $context['enrolment'] = $this->enrolment();
        if (!empty($this->courses)) {
            $context['chart_enrolment']['label'] = json_encode($context['enrolment']['label']);
            $context['chart_enrolment']['dataset'] = json_encode($context['enrolment']['data']);
            $context['completion'] = $this->completed();
            $context['chart_completion']['label'] = json_encode($context['completion']['label']);
            $context['chart_completion']['dataset'] = json_encode($context['completion']['data']);
        }

        $context['enrolasstudent'] = count($this->studing_in);
        return $OUTPUT->render_from_template('block_analyticswidget/my/course_stats', $context);
    }

    /**
     * showing the data for the enrolment of my widget
     *
     * @return  array  data | label.
     */
    private function enrolment() {
        return array(
            'data' => array(count($this->active_courses), (count($this->courses) - count($this->active_courses))),
            'label' => array(get_string('active', 'block_analyticswidget'), get_string('inactive', 'block_analyticswidget'))
        );
    }

    /**
     * Returns the completed courses
     *
     * @return  array  data | label.
     */
    private function completed() {
        global $CFG;
        require_once($CFG->libdir . "/completionlib.php");
        $completed = [];
        $progress = [];
        foreach ($this->active_courses as $course) {
            $cinfo = new \completion_info($course);
            if ($cctimestamp = $cinfo->is_course_complete($this->userid)) {
                $completed[$course->id] = $cctimestamp;
            } else {
                $progress[$course->id] = \core_completion\progress::get_course_progress_percentage($course, $this->userid);
            }
        }

        return array(
            'data' => array(count($this->active_courses), count($completed), count($progress)),
            'label' => array(get_string('active', 'block_analyticswidget'), get_string('completed', 'block_analyticswidget'),
             get_string('inprogress', 'block_analyticswidget'))
        );
    }
}
