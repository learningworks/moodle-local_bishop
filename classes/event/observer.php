<?php
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package   local_bishop {@link https://docs.moodle.org/dev/Frankenstyle}
 * @copyright 2016 LearningWorks Ltd {@link http://www.learningworks.co.nz}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_bishop\event;

defined('MOODLE_INTERNAL') || die();

class observer {
    public static function user_created(\core\event\base $event) {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/local/bishop/locallib.php');

        $user = $event->get_record_snapshot('user', $event->relateduserid);
        local_bishop_queue_user($user);
    }
}