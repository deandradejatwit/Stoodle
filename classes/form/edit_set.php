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

namespace local_stoodle\form;
defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');

/**
 * Class edit_set
 *
 * @package    local_stoodle
 * @copyright  2024 Jonathan Kong-Shi kongshij@wit.edu,
 *             Myles R. Sullivan sullivanm22@wit.edu,
 *             Jhonathan Deandrade deandradej@wit.edu
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class edit_set  extends \moodleform {
    public function definition() {
        global $DB, $SESSION;
        $mform = $this->_form;

        $setid = $SESSION->edit_set_id;
        $set = $DB->get_record('flashcard_set', array('id'=> $setid),'set_name');
        $setcards = $DB->get_records_list('flashcard_card', 'flashcard_set', array('flashcard_set' => $setid),'','*');

        $SESSION->test = $setcards;

        $mform->addElement('static', 'priorquestion', get_string('currrentsetname', 'local_stoodle'),  $set->set_name);
        $mform->addElement('textarea',  'setname' , get_string('setnamestr', 'local_stoodle'));
        $mform->setType('setname' , PARAM_TEXT);


        foreach ($setcards as $setcard) {

                $mform->addElement('static', 'priorquestion', get_string('currentquestion', 'local_stoodle'), $setcard->question);
                $mform->addElement('textarea',  'question', get_string('questionstr', 'local_stoodle'));
                $mform->addElement('static', 'prioranswer', get_string('currentanswer', 'local_stoodle'), $setcard->answer);
                $mform->addElement('textarea', 'answer', get_string('answerstr', 'local_stoodle'));

                $mform->setType('question', PARAM_TEXT);
                $mform->setType('answer', PARAM_TEXT);

        }
        $this->add_action_buttons();
    }
}
