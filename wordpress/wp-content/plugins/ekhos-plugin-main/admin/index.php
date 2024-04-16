<?php

add_action('admin_menu', 'ekhos_ids_add_to_menu');

function ekhos_ids_add_to_menu() {
    add_management_page(
        'IdSound paramètres',
        'IdSound paramètres',
        'manage_options',
        'ekhos-ids',
        'ekhos_ids_settings_page'
    );
}
