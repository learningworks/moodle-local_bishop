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

$page         = optional_param('page', 0, PARAM_INT);
$perpage      = optional_param('perpage', 50, PARAM_INT);
$clearlog     = optional_param('clearlog', 0, PARAM_INT);
$filterfailed = optional_param('filterfailed', 0, PARAM_INT);

admin_externalpage_setup('local_bishop_log');

$params = array();
$filtersql = '';
if ($filterfailed) {
    $params[] = $filterfailed;
    $filtersql = ' AND l.delivered = ? ';
}

$namefields = get_all_user_name_fields(true, 'u');
$sql = "SELECT u.id, u.username, u.idnumber, $namefields, u.email, l.delivered, l.time, u.deleted  
          FROM {user} u
          JOIN {local_bishop_email_log} l 
            ON l.userid = u.id
         WHERE u.deleted <> 1 $filtersql
      ORDER BY l.time DESC";

$tableheaders = array(
    get_string('username'),
    get_string('name'),
    get_string('email'),
    get_string('idnumber'),
    get_string('sent', 'local_bishop'),
    get_string('delivered', 'local_bishop'),
    ''
);

if (!empty($clearlog)) {
    $DB->delete_records('local_bishop_email_log');
    redirect(new moodle_url('/local/bishop/admin/log.php'));
}

$table = new html_table();
$table->id = 'email-log-list-' . uniqid();
$table->attributes['class'] = 'admintable generaltable';
$table->head = $tableheaders;


$rowsmatched = $DB->count_records('local_bishop_email_log');
if ($rowsmatched) {
    $limit = $perpage;
    $offset = $page * $limit;
    $rs = $DB->get_recordset_sql($sql, $params, $offset, $limit);
    foreach ($rs as $record) {
        $row = array();
        $row[] = $record->username;
        $row[] = fullname($record);
        $row[] = $record->email;
        $row[] = $record->idnumber;
        $row[] = userdate($record->time);
        if ($record->delivered) {
            $delivered = $OUTPUT->pix_icon('i/valid', get_string('success', 'local_bishop'));
        } else {
            $delivered = $OUTPUT->pix_icon('i/invalid', get_string('fail', 'local_bishop'));
        }
        $row[] = $delivered;
        $editlink = html_writer::link(new moodle_url('/user/editadvanced.php', array('id' => $record->id)),
            get_string('edit'));
        $row[] = $editlink;
        $table->data[] = $row;
    }
    $rs->close();
}

echo $OUTPUT->header();
$lastrunat = get_config('local_bishop', 'lastrunat');
if (empty($lastrunat)) {
    $heading = get_string('lastrunat', 'local_bishop', get_string('never'));
} else {
    $heading = get_string('lastrunat', 'local_bishop', userdate($lastrunat));
}
echo $OUTPUT->heading($heading);
if ($rowsmatched) {
    $pagination = new paging_bar($rowsmatched, $page, $limit, $PAGE->url);
    echo $OUTPUT->render($pagination);
    echo html_writer::start_div('mo-flow');
    echo html_writer::table($table);
    echo html_writer::end_div();
    echo $OUTPUT->render($pagination);
    $message = get_string('clearlog', 'local_bishop');
    $pageurl = clone($PAGE->url);
    $pageurl->param('clearlog', 1);
    echo $OUTPUT->single_button($pageurl, $message, 'get');
} else {
    echo $OUTPUT->heading(get_string('nothingtodisplay'));
}
echo $OUTPUT->footer();
