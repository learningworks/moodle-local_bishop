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

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

admin_externalpage_setup('local_bishop_template');

$config = get_config('local_bishop');
$form = new \local_bishop\form\template();
$data = $form->get_submitted_data();
if ($data) {
    set_config('subject', $data->subject, 'local_bishop');
    set_config('body_text', $data->body['text'], 'local_bishop');
    set_config('body_format', $data->body['format'], 'local_bishop');
    file_save_draft_area_files($data->attachment['itemid'],
        $PAGE->context->id,
        'local_bishop', 'attachment', 1);

print_object($data);
    redirect($PAGE->url, get_string('changessaved'), 1);
} else {

    $attachmentsdraftid = 0;
    file_prepare_draft_area($attachmentsdraftid,
        $PAGE->context->id,
        'local_bishop',
        'attachment',
        1,
        \local_bishop\form\template::editor_options());

    $form->set_data(
        array(
            'subject' => $config->subject,
            'body' => array(
                'text' => $config->body_text,
                'format' => $config->body_format),
            'attachment' => array('itemid' => $attachmentsdraftid)
        )
    );


}
echo $OUTPUT->header();
//email_to_user();
//echo $OUTPUT->heading(get_string('organisationstoinstitutions', 'local_mc'));
$form->display();
echo $OUTPUT->footer();
