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

namespace local_bishop\form;

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

require_once($CFG->libdir . '/formslib.php');

class admin_settings extends \moodleform {

    public function definition() {

        $form = $this->_form;

        $form->addElement('header', 'emailmessagetemplate', get_string('emailmessagetemplate', 'local_bishop'));

        $form->addElement('text', 'subject', get_string('subject', 'local_bishop'), array('class' => 'input-xxlarge'));
        $form->setType('subject', PARAM_TEXT);
        $form->addRule('subject', null, 'required', null, 'client');

        $form->addElement('editor', 'body', get_string('message', 'local_bishop'), null, self::editor_options());
        $form->setType('body', PARAM_RAW);
        $form->addHelpButton('body', 'message', 'local_bishop');
        $form->addRule('body', null, 'required', null, 'client');

        $form->addElement('filemanager', 'attachment[itemid]', get_string('attachment', 'local_bishop'), null, self::attachment_options());

        $this->add_action_buttons(true, get_string('savechanges', 'local_bishop'));
    }

    /**
     * Returns the options array to use in text editor.
     *
     * @return array
     */
    public static function editor_options() {
        global $CFG, $PAGE;

        $maxbytes = get_user_max_upload_file_size($PAGE->context, $CFG->maxbytes);
        return array(
            'collapsed' => true,
            'maxfiles' => 0,
            'maxbytes' => $maxbytes,
            'trusttext'=> true,
            'accepted_types' => 'web_image',
            'return_types'=> FILE_INTERNAL | FILE_EXTERNAL
        );
    }

    /**
     * Returns the options array to use in filemanager attachments.
     *
     * @return array
     */
    public static function attachment_options() {
        global $CFG, $PAGE;
        $maxbytes = get_user_max_upload_file_size($PAGE->context, $CFG->maxbytes);
        return array(
            'subdirs' => 0,
            'maxbytes' => $maxbytes,
            'maxfiles' => 1,
            'accepted_types' => '*',
            'return_types' => FILE_INTERNAL
        );
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        return $errors;
    }



}