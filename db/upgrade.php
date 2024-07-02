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
 * This file is used to upgarde the database for stoodle.
 *
 * @package     local_stoodle
 * @copyright   2024 Jonathan Kong-Shi kongshij@wit.edu,
 *              Myles R. Sullivan sullivanm22@wit.edu,
 *              Jhonathan Deandrade deandradej@wit.edu
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

 /**
  * This function updates the database of the local plugin.
  *
  * @param mixed $oldversion
  *
  * @return bool
  */
function xmldb_local_stoodle_upgrade($oldversion): bool {
    global $CFG, $DB;
    $dbman = $DB->get_manager();
    if ($oldversion < 2024062601) {
        // Define table flashcard_card to be dropped.
        $table = new xmldb_table('flashcard_test');

        // Conditionally launch drop table for flashcard_card.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }
        // Define field usermodified to be added to flashcard_set.
        $table = new xmldb_table('flashcard_set');
        $field = new xmldb_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'timemodified');

        // Conditionally launch add field usermodified.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
         // Define key usermodified (foreign) to be added to flashcard_set.
         $table = new xmldb_table('flashcard_set');
         $key = new xmldb_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

         // Launch add key usermodified.
         $dbman->add_key($table, $key);
          // Changing type of field set_name on table flashcard_set to char.
        $table = new xmldb_table('flashcard_set');
        $field = new xmldb_field('set_name', XMLDB_TYPE_CHAR, '128', null, XMLDB_NOTNULL, null, null, 'id');

        // Launch change of type for field set_name.
        $dbman->change_field_type($table, $field);
        // Define field card_number to be added to flashcard_card.
        $table = new xmldb_table('flashcard_card');
        $field = new xmldb_field('card_number', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0', 'flashcard_set');

        // Conditionally launch add field card_number.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Stoodle savepoint reached.
        upgrade_plugin_savepoint(true, 2024062601, 'local', 'stoodle');
    }
    return true;
}
