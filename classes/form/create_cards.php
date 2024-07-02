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
namespace local_stoodle\form;
defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');

/**
 * create repeating flashcard form.
 *
 */
class create_cards extends \moodleform {
    /**
     * defining the functionality and structure of form
     *
     */
    public function definition() {
        global $DB;
        $mform = $this->_form;

        $mform->addElement('textarea', 'set', get_string('setnamestr', 'local_stoodle'));

        $submitlabel = get_string('submit');

        $startarray = [
            $mform->createElement('textarea', 'question', get_string('questionstr', 'local_stoodle')),
            $mform->createElement('textarea', 'answer', get_string('answerstr', 'local_stoodle')),
        ];

        $repeatarray = [
            $mform->createElement('textarea', 'question', get_string('questionstr', 'local_stoodle')),
            $mform->createElement('textarea', 'answer', get_string('answerstr', 'local_stoodle')),
            $mform->createElement('submit', 'delete', get_string('deletestr', 'local_stoodle'), [], false),
        ];

        $repeatno = 3;

        $repeateloptions = [
            'question' => [],
            'answer' => [],
        ];

        $mform->setType('set', PARAM_TEXT);
        $mform->setType('question', PARAM_TEXT);
        $mform->setType('answer', PARAM_TEXT);

        $this->repeat_elements(
            $startarray,
            $repeatno,
            $repeateloptions,
            'option_repeats',
            'option_add_fields',
            1,
            null,
            true,
            'delete',
        );

        $mform->addElement('submit', 'submitcards', $submitlabel);

    }
}
