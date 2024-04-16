<?php

function ekhos_ids_admin_styles($hook) {
    if ($hook != 'tools_page_ekhos-ids') {
        return;
    }
    wp_enqueue_style('ekhos-ids-admin-style', plugin_dir_url(__FILE__) . 'styles/style.css');
}

add_action('admin_enqueue_scripts', 'ekhos_ids_admin_styles');
