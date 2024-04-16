<?php

function ekhos_activate_tables() {
    require(ABSPATH . 'wp-admin/includes/upgrade.php');
    ekhos_characters_table();
    ekhos_sounds_table();
    ekhos_linkeds_table();
}

function ekhos_characters_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_characters';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        sound_id mediumint(9) DEFAULT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    dbDelta($sql);
}

function ekhos_sounds_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_sounds';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        character_id mediumint(9) DEFAULT NULL,
        name tinytext NOT NULL,
        sound_url tinytext DEFAULT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    dbDelta($sql);
}

function ekhos_linkeds_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_linkeds';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        sound_id mediumint(9) DEFAULT NULL,
        page_url tinytext DEFAULT NULL,
        selector tinytext DEFAULT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    dbDelta($sql);
}

register_activation_hook(EKHOS_DIR, 'ekhos_activate_tables');
