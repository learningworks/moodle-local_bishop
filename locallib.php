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

    // Following mustache variables are required in html message.
    $required = array('username', 'newpassword', 'siteurl');
    // Flag to use custom html message or default back to text lang string.
    $usecustomhtmlmessage = false;
    // Get site.
    $site  = get_site();
    // Generate a new password.
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

    // Get subject and body.
    $subject    = isset($config->subject) ? $config->subject : '';
    $body       = isset($config->body_text) ? $config->body_text : '';
    $message = $body;
    if ($subject <> '' && $message <> '') {
        foreach (get_object_vars($a) as $name => $value) {
            $variable = '{{'. $name. '}}';
            $message = str_replace($variable, $value, $message, $count);
            if (in_array($name, $required)) {
                if (! $count) {
                    $trace->output('Failed to find placeholder' . $name);
                    break;
                }
            }
        }
        // We have all fields we need can use custom message.
        $usecustomhtmlmessage = true;
    }

    if (! $usecustomhtmlmessage) {
        // Plain text only.
        $subject = get_string('templatesubject');
        $messagetext = get_string('templatemessagetext', 'local_bishop', $a);
        $messagehtml = text_to_html($messagetext, null, false, true);
    } else {
        // HTML custom.
        $messagehtml = format_text($message, FORMAT_HTML);
        $messagetext = html_to_text($messagehtml);
        $user->mailformat = FORMAT_HTML;
    }

    // Deal with attachment.
    $fs = get_file_storage();
    $files = $fs->get_area_files(
                            context_system::instance()->id,
                            'local_bishop',
                            'attachment',
                            1,
                            'itemid, filepath, filename',
                            false
    );
    if ($files) {
        $file = reset($files);
        $attachment = $file->copy_content_to_temp();
        $attachmentname = $file->get_filename();
    }

    // Mail out from support user.
    $contact = core_user::get_support_user();

    // Directly emailing welcome message rather than using messaging.
    if (isset($attachment)) {
        $status = email_to_user($user, $contact, $subject, $messagetext, $messagehtml, $attachment, $attachmentname);
    } else {
        $status = email_to_user($user, $contact, $subject, $messagetext, $messagehtml);
    }

    // Log delivery.
    $log = new stdClass();
    $log->userid = $user->id;
    $log->delivered = $status;
    $log->time = time();
    $DB->insert_record('local_bishop_email_log', $log);

    if ($status) {
        $trace->output('SUCESSFULLY sent '. $a->fullname . ' new user details.');
    } else {
        $trace->output('FAILED to sent '. $a->fullname . ' new user details.');
    }

    return $status;
}

