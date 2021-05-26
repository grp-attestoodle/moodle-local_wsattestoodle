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
 * Test only the web service method.
 *
 * @package    local_wsattestoodle
 * @copyright  2019 Pole de Ressource Numerique de l'Universite du Mans
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Main configuration importation (instanciate the $CFG global variable).
require_once(dirname(__FILE__) . '/../../../config.php');

// Libraries imports.
require_once(dirname(__FILE__) .'/../externallib.php');

/*
 * Imports of class files.
 */
$username = optional_param('username', 'rv0', PARAM_ALPHANUM);

$context = context_system::instance();
$PAGE->set_context($context);

require_login();

// Always create trainings.
$urlact = new moodle_url('/local/wsattestoodle/client/testmethode.php', ['username' => $username]);
$PAGE->set_url($urlact);

$PAGE->set_title("TEST");

echo $OUTPUT->header();

echo (get_string('info', 'local_wsattestoodle'));
echo ("username = " . $username . "<br>");

$rs = local_wsattestoodle_external::getdata($username);
echo (json_encode($rs));
echo $OUTPUT->footer();

