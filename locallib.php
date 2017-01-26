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


function local_bishop_mail_user(stdClass $user) {
    static $config;

    if (! isset($config)) {
        $config = get_config('local_bishop');
    }

    if (empty($config->userfield) or empty($config->matchregex)) {
        return;
    }

    $userfield  = $config->userfield;
    $matchregex = $config->matchregex;

    if (empty($user->{$userfield})) {
        return;
    }

    $matches = array();
    if (! preg_match($config->matchregex, $user->{$userfield}, $matches)) {
        return;
    }




    //email_to_user();


}

