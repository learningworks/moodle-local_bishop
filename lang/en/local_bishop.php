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
 * Definition of language strings.
 *
 * @package     local_bishop {@link https://docs.moodle.org/dev/Frankenstyle}
 * @copyright   2016 LearningWorks Ltd {@link http://www.learningworks.co.nz}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['css'] = 'CSS';
$string['csshead'] = 'CSS head';
$string['csshead_help'] = 'Will inject custom CSS inside a <strong>&lt;style&gt;</strong> element';
$string['pluginname'] = 'Bishop';
$string['plugindescription'] = 'Listens and does';
$string['subject'] = 'Subject';
$string['message'] = 'Message';
$string['message_help'] = 'A custom new user message that can include HTML tags.

The following placeholders are required in the message:

* Username: {username}
* Password: {newpassword}
* Site URL: {siteurl}

The following placeholders are optional in the message:

* User firstname: {firstname} 
* User fullname: {fullname}
* Site name: {sitename}
* Sign off: {signoff}
';
$string['savechanges'] = 'Save changes';
$string['attachment'] = 'Attachment';
$string['emailmessagetemplate'] = 'Email message template';

$string['enabled'] = 'Enabled';
$string['template'] = 'Template';
$string['matchregex'] = 'Match regular expression';
$string['matchregex_desc'] = 'Regular expression to match chosen user field on. Delimiters required!';
$string['log'] = 'Log';
$string['test'] = 'Test';
$string['templatemessagetext'] = 'Hi {$a->firstname},

A new account has been created for you at \'{$a->sitename}\'
and you have been issued with a new temporary password.

Your current login information is now:
   username: {$a->username}
   password: {$a->newpassword}
             (you will have to change your password
              when you login for the first time)

To start using \'{$a->sitename}\', login at
   {$a->link}

In most mail programs, this should appear as a blue link
which you can just click on.  If that doesn\'t work,
then cut and paste the address into the address
line at the top of your web browser window.

Cheers from the \'{$a->sitename}\' administrator,
{$a->signoff}';
$string['templatesubject'] = 'Welcome to Moodle';
$string['lastrunat'] = 'Last ran at: {$a}';
$string['userfield'] = 'User field';
$string['userfield_desc'] = 'User field to match on';
$string['sent'] = 'Sent on';
$string['delivered'] = 'Delivered';
$string['success'] = 'Success';
$string['fail'] = 'Fail';
$string['clearlog'] = 'Clear log';
