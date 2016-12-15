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

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    $ADMIN->add('localplugins',
        new admin_category('local_bishop',
        new lang_string('pluginname', 'local_bishop')));

    $ADMIN->add('local_bishop',
        new admin_externalpage('mc_settings',
        new lang_string('settings'),
        $CFG->wwwroot.'/local/bishop/admin/settings.php'));

}