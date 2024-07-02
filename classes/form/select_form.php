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
 * Class select_form
 *
 * @package    local_stoodle
 * @copyright  2024 Jonathan Kong-Shi kongshij@wit.edu,
 *              Myles R. Sullivan sullivanm22@wit.edu,
 *              Jhonathan Deandrade deandradej@wit.edu
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_stoodle\form;
defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');
/**
 * create flashcard select form.
 *
 */
class select_form extends \moodleform {
    /**
     * defining the functionality and structure of form
     *
     */
    public function definition() {
        global $DB;
        $mform = $this->_form;

        $sets = $DB->get_records('flashcard_set', null);
        if (!empty($sets)) {
            $options = $DB->get_records_menu('flashcard_set', [], 'id', 'id, set_name');
        } else {
            $options['-1'] = 'None';
        }

        $mform->addElement('select', 'card_sets', get_string('selectstr', 'local_stoodle'), $options);

        $submitlabel = get_string('submit');
        $mform->registerNoSubmitButton('editset');

        $align = [
            $mform->createElement('submit', 'submitform', $submitlabel),
            $mform->createElement('submit', 'editset', get_string('edit')),
        ];
        $mform->addGroup($align,'buttons', '','',false);
    }
}
