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

/**
 *
 * @package   {{PLUGIN_NAME}} {@link https://docs.moodle.org/dev/Frankenstyle}
 * @copyright 2017 LearningWorks Ltd {@link http://www.learningworks.co.nz}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


function local_bishop_mail_user(stdClass $user, progress_trace $trace = null) {
    global $CFG, $DB;
    static $config;

    if (is_null($trace)) {
        $trace = new null_progress_trace();
    }

    if (!isset($user->auth)) {
        $trace->output('User auth not passed in user object');
        return false;
    }
    $authplugin = get_auth_plugin($user->auth);
    if ($authplugin->prevent_local_passwords()) {
        $trace->output('User auth method prevents internal passwords');
        return false;
    }

    if (! isset($config)) {
        $config = get_config('local_bishop');
    }

    if (empty($config->userfield) or empty($config->matchregex)) {
        $trace->output('Required config fields: userfield or matchregex not set');
        return false;
    }

    $userfield  = $config->userfield;
    $matchregex = $config->matchregex;

    if (empty($user->{$userfield})) {
        $trace->output('User field ' . $userfield . ' not in object');
        return false;
    }

    $matches = array();
    if (! preg_match($matchregex, $user->{$userfield}, $matches)) {
        $trace->output('No match found: ' . $matchregex . ' <> ' . $userfield);
        return false;
    }






    $site  = get_site();

    $newpassword = generate_password();
    update_internal_user_password($user, $newpassword, true);
    
    $a = new stdClass();

    $a->username    = $user->username;
    $a->newpassword = $newpassword;
    $a->siteurl     = $CFG->wwwroot .'/login/';
    $a->fullname    = fullname($user, true);
    $a->firstname   = $user->firstname;
    $a->lastname    = $user->lastname;
    $a->sitename    = format_string($site->fullname);
    $a->signoff     = generate_email_signoff();

    $required = array('username', 'newpassword', 'siteurl');

    $subject    = isset($config->subject) ? $config->subject : '';
    $body       = isset($config->body_text) ? $config->body_text : '';
    
    $usecustom = 0;

    
    //print_object($body);
    $replacedbody = $body;
    foreach (get_object_vars($a) as $name => $value) {
        $variable = '{{'. $name. '}}';
        $replacedbody = str_replace($variable, $value, $replacedbody, $count);
        if (in_array($name, $required)) {
            mtrace($count);
            if (! $count) {
                die('Fail to find placeholder' . $name);
            }
        }
        //mtrace($key);
    }
    
    //if (empty($config->))
    //print_object($replacedbody);


    //email_to_user();


}

