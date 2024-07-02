<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 *
 *
 * @package     local_stoodle
 * @copyright   2024 Jonathan Kong-Shi kongshij@wit.edu,
 *              Myles R. Sullivan sullivanm22@wit.edu,
 *              Jhonathan Deandrade deandradej@wit.edu
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/flashcard_create/index.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('flashcardcreate', 'local_stoodle'));
$PAGE->set_heading(get_string('flashcardcreate', 'local_stoodle'));

$createcardsform = new \local_stoodle\form\create_cards();

if ($createcardsform->is_cancelled()) {
    $url = new moodle_url('/local/stoodle/flashcard.php');
    redirect($url);
} else if ($data = $createcardsform->get_data()) {
    $set = required_param('set', PARAM_TEXT);
    $question = required_param_array('question', PARAM_TEXT);
    $answer = required_param_array('answer', PARAM_TEXT);

    if (!empty($set) && check_empty($question, $answer)) {
        $recordset = new stdClass;
        $record = new stdClass;

        $recordset->set_name = $set;
        $recordset->timemodified = time();

        if (!$DB->get_record_select('flashcard_set', 'set_name = ?', [$set])) {
            $DB->insert_record('flashcard_set', $recordset);
            $test = $DB->get_record_select('flashcard_set', 'set_name = ?', [$set]);

            for ($i = 0; $i <= count($question) - 1; $i++) {
                if (!empty($question[$i])&&!empty($answer[$i])) {
                    $record->flashcard_set = $test->id;
                    $record->card_number = $i+1;
                    $record->question = $question[$i];
                    $record->answer = $answer[$i];
                    $record->timemodified = time();
                    $DB->insert_record('flashcard_card', $record);
                }
            }
        }
    }
    $url = new moodle_url('/local/stoodle/flashcard.php');
    redirect($url);
}

/**
 * Checks if two arrays are empty
 *
 * @param array $arr1 First array
 * @param array $arr2 Second array
 */
function check_empty($arr1, $arr2) {
    for ($i = 0; $i < count($arr1); $i++) {
        if (!(empty($arr1[$i]) || empty($arr2[$i]))) {
            return true;
        }
    }
    return false;
}

echo $OUTPUT->header();

$createcardsform->display();

echo $OUTPUT->footer();
