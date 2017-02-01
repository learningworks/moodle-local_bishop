<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

define('CLI_SCRIPT', true);

require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/clilib.php');
require_once($CFG->dirroot . '/local/bishop/locallib.php');

// Now get cli options.
list($options, $unrecognized) = cli_get_params(
    array('verbose' => false, 'cleanup' => true,'help' => false),
    array('v' => 'verbose', 'h' => 'help'));

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

if ($options['help']) {
    $help =
        "Test sending email.

Options:
-v, --verbose         Print verbose progress information
-h, --help            Print out this help

Example:
\$ sudo -u www-data /usr/bin/php local/bishop/cli/test.php
";

    echo $help;
    die;
}

$config = get_config('local_bishop');
if (empty($config->enabled)) {
    cli_error('local_bishop plugin is disabled, process stopped', 2);
}

if (empty($options['verbose'])) {
    $trace = new null_progress_trace();
} else {
    $trace = new text_progress_trace();
}

require_once($CFG->libdir . '/testing/generator/lib.php');
$generator = new testing_data_generator();
$user = $generator->create_user(array('idnumber'=>'00000000', 'email' => 'learnersupport@learningworks.co.nz'));
local_bishop_queue_user($user, $trace);
local_bishop_process_queue($trace);
if ((int) $options['cleanup']) {
    delete_user($user);
}

