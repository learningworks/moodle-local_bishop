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
 *  {{DESCRIPTION}}
 *
 * @package   local_bishop {@link https://docs.moodle.org/dev/Frankenstyle}
 * @copyright 2016 LearningWorks Ltd {@link http://www.learningworks.co.nz}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');


admin_externalpage_setup('local_bishop_test');

//$tableheaders = array(
//    get_string('id', 'local_bishop'),
//    get_string('timelogged', 'local_bishop'),
//    get_string('functionname', 'local_bishop'),
//    get_string('timetaken', 'local_bishop'),
//    get_string('uri', 'local_bishop'),
//    get_string('info', 'local_bishop'),
//    get_string('ip', 'local_bishop'),
//);
//
//if (!empty($clearlog)) {
//    $DB->delete_records('local_bishop_log');
//    redirect(new moodle_url('/local/mc/admin/log.php'));
//}
//
//$table = new html_table();
//$table->id = 'client-log-list-' . uniqid();
//$table->attributes['class'] = 'admintable generaltable';
//$table->head = $tableheaders;
//
//
//$rowsmatched = $DB->count_records('local_bishop_log');
//if ($rowsmatched) {
//    $limit = $perpage;
//    $offset = $page * $limit;
//    $rs = $DB->get_recordset('local_bishop_log', null, 'timelogged DESC', '*', $offset, $limit);
//    foreach ($rs as $record) {
//        $row = array();
//        $row[] = $record->id;
//        $row[] = userdate($record->timelogged);
//        $row[] = $record->functionname;
//        $row[] = $record->timetaken;
//        $row[] = $record->uri;
//        $row[] = empty($record->info) ? '' : html_writer::tag('pre', $record->info);
//        $row[] = $record->ip;
//        $table->data[] = $row;
//    }
//    $rs->close();
//}
//
echo $OUTPUT->header();
//$lastrunat = get_config('local_bishop', 'lastrunat');
//if (empty($lastrunat)) {
//    $heading = get_string('lastrunat', 'local_bishop', get_string('never'));
//} else {
//    $heading = get_string('lastrunat', 'local_bishop', userdate($lastrunat));
//}
echo $OUTPUT->heading($heading);
//if ($rowsmatched) {
//    $pagination = new paging_bar($rowsmatched, $page, $limit, $PAGE->url);
//    echo $OUTPUT->render($pagination);
//    echo html_writer::start_div('mo-flow');
//    echo html_writer::table($table);
//    echo html_writer::end_div();
//    echo $OUTPUT->render($pagination);
//    $message = get_string('clearlog', 'local_bishop');
//    $pageurl = clone($PAGE->url);
//    $pageurl->param('clearlog', 1);
//    echo $OUTPUT->single_button($pageurl, $message, 'get');
//} else {
//    echo $OUTPUT->heading(get_string('nothingtodisplay'));
//}
echo $OUTPUT->footer();