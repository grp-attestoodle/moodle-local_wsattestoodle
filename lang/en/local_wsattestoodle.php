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
 * Plugin strings are defined here.
 *
 * @package     local_wsattestoodle
 * @category    string
 * @copyright   2019 Universite du Mans
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Web service Attestoodle';
$string['description'] = 'Provided the last certificate for the requested student';
$string['logintxt'] = 'The username';
$string['returntxt'] = 'JSON structure containing the learner\'s last certificate';
$string['usernotexist'] = 'The user does not exist !';
$string['nocertificate'] = 'No certificate exists for this learner !';
$string['privacy:metadata'] = 'The Attestoodle\'s Web Service plugin does not store any personal data.';
$string['info'] = 'Test only processing (excluding web service call)<br>
You can enter username in the url to consult another Certificate';