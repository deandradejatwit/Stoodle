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
 * TODO describe file flashcard_edit
 *
 * @package    local_stoodle
 * @copyright  2024 Jonathan Kong-Shi kongshij@wit.edu,
 *             Myles R. Sullivan sullivanm22@wit.edu,
 *             Jhonathan Deandrade deandradej@wit.edu
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

require_login();

$url = new moodle_url('/local/stoodle/flashcard_edit.php', []);
$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('flashcardedit', 'local_stoodle'));
$PAGE->set_heading(get_string('flashcardedit', 'local_stoodle'));

$editsetform = new \local_stoodle\form\edit_set();

if ($editsetform->is_cancelled()) {
    $url = new moodle_url('/local/stoodle/flashcard.php');
    redirect($url);
} else if ($data = $editsetform->get_data()){
    $set = required_param('set', PARAM_TEXT);
    $questions = required_param_array('question', PARAM_TEXT);
    $answers = required_param_array('answer', PARAM_TEXT);

    foreach ($questions as $question) {
        # code...
    }

    $DB->update_record("flashcard_set",)
    $DB->update_record("")
}

echo $OUTPUT->header();

$editsetform->display();
$test= $SESSION->test;
var_dump($test);

echo $OUTPUT->footer();
