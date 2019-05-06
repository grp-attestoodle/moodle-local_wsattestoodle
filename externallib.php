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
 * External Web Service Attestoodle
 *
 * @package    local_wsattestoodle
 * @copyright  2019 Universite du Mans
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->libdir . "/externallib.php");

/**
 * Definition of attestoodle web services.
 * @copyright  2019 Universite du Mans
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_wsattestoodle_external extends external_api {

    /**
     * Define the description of the web service parameters.
     * @return the description of the web service parameters.
     */
    public static function getlastcertificate_parameters() {
        $logintxt = get_string('logintxt', 'local_wsattestoodle');
        return new external_function_parameters(array(
            'login' => new external_value(PARAM_TEXT, $logintxt, VALUE_DEFAULT, 'rv1' ),
            ));
    }

    /**
     * The web service method.
     * @param string $login The username.
     * @return the last certificate for the requested student.
     */
    public static function getlastcertificate($login) {
        global $USER;
        global $DB;

        $params = self::validate_parameters (self::getlastcertificate_parameters (), array ('login' => $login));

        // Context validation.
        $context = context_user::instance($USER->id);
        self::validate_context($context);

        // Processing.
        $ret = self::getdata($login);

        return json_encode($ret);
    }

    /**
     * Define return values for getlastcertificate methode.
     * @return the description of the returned values.
     */
    public static function getlastcertificate_returns() {
        $returntxt = get_string('returntxt', 'local_wsattestoodle');
        return new external_value ( PARAM_TEXT, $returntxt);
    }

    /**
     * Search for the user's last certificate.
     * If it exists it will be returned in json format.
     *
     * @param string $username login associated with the last certificate searched for.
     * @return returns a json structure with the search result.
     */
    public static function getdata($username) {
        global $DB;
        $testuser = $DB->get_record('user', array('username' => $username));
        $ret = new stdClass();

        if (!isset($testuser->id)) {
            $ret->result = "false";
            $ret->cause = get_string('usernotexist', 'local_wsattestoodle');
            return $ret;
        }

        $userid = $testuser->id;
        if ($DB->count_records('tool_attestoodle_certif_log', array('learnerid' => $userid)) == 0) {
            $ret->result = "false";
            $ret->cause = get_string('nocertificate', 'local_wsattestoodle');
            return $ret;
        }

        $req = "select max(id) as id from {tool_attestoodle_certif_log} where learnerid = ?";
        $testlaunch = $DB->get_record_sql($req, array($userid));

        $rowcertif = $DB->get_record('tool_attestoodle_certif_log', array('id' => $testlaunch->id));
        $training = $DB->get_record('tool_attestoodle_training', array('id' => $rowcertif->trainingid));
        $certif = new \stdClass();

        if (empty($training->name)) {
            $categ = $DB->get_record('course_categories', array('id' => $training->categoryid));
            $training->name = $categ->name;
        }
        $certif->training = $training->name;
        $certif->lastname = $testuser->lastname;
        $certif->firstname = $testuser->firstname;

        $launch = $DB->get_record('tool_attestoodle_launch_log', array('id' => $rowcertif->launchid));
        $period = get_string('fromdate', 'tool_attestoodle', $launch->begindate)
                    . ' ' . get_string('todate', 'tool_attestoodle', $launch->enddate);
        $certif->period = $period;

        $result2 = $DB->get_records('tool_attestoodle_value_log', array('certificateid' => $rowcertif->id));
        $contextdata = [];
        $total = 0;
        foreach ($result2 as $row) {
            $req = "select distinct name as name
                      from {tool_attestoodle_milestone}
                     where moduleid = :moduleid";
            $module = $DB->get_record_sql($req, array('moduleid' => $row->moduleid));
            $name = get_string('error_unknown_item', 'tool_attestoodle');
            if (!empty($module->name)) {
                $name = $module->name;
            }
            $total += $row->creditedtime;
            $contextdata[] = [
                'module' => $name,
                'creditedtime' => $row->creditedtime,
                ];
        }
        $certif->total = $total;
        $certif->milestones = $contextdata;

        $ret->result = "true";
        $ret->certif = $certif;
        return $ret;
    }

}