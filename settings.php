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

    $settings = new admin_settingpage('local_bishop_settings', get_string('settings'));

    $name = new lang_string('enabled','local_bishop');
    $description = '';
    $settings->add(new admin_setting_configcheckbox('local_bishop/enabled', $name, $description, 0));

    $name = new lang_string('usernameregex', 'local_bishop');
    $description = new lang_string('usernameregex_desc', 'local_bishop');
    $settings->add(new admin_setting_configtext('local_bishop/usernameregex', $name, $description, '^[0-9]{8}$'));

    $ADMIN->add('localplugins',
        new admin_category('local_bishop',
        new lang_string('pluginname', 'local_bishop')));

    // Add settings page to navigation tree.
    $ADMIN->add('local_bishop', $settings);

    $ADMIN->add('local_bishop',
        new admin_externalpage('local_bishop_template',
        new lang_string('template', 'local_bishop'),
        $CFG->wwwroot.'/local/bishop/admin/template.php'));

    $ADMIN->add('local_bishop',
        new admin_externalpage('local_bishop_log',
        new lang_string('log', 'local_bishop'),
        $CFG->wwwroot.'/local/bishop/admin/log.php'));

    $ADMIN->add('local_bishop',
        new admin_externalpage('local_bishop_test',
        new lang_string('test', 'local_bishop'),
        $CFG->wwwroot.'/local/bishop/admin/test.php'));
}