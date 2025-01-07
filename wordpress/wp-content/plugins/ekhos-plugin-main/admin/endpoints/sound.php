<?php

function ekhos_sound_add($request)
{
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_sounds';
    $body_params = $request->get_body_params();
    $character = isset($body_params['character']) ? $body_params['character'] : '';
    $name = isset($body_params['name']) ? $body_params['name'] : '';
    $files = $request->get_file_params();
    $upload_overrides = array('test_form' => false);

    $movefile = wp_handle_upload($files['file'], $upload_overrides);

    if ($character == 'null') {
        $character = null;
    }
    if($movefile && !isset($movefile['error'])) {
        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'character_id' => $character,
                'sound_url' => $movefile['url']
            ),
            array(
                '%s',
                '%s',
                '%s'
            )
        );

        return new WP_REST_Response(array(
            'status' => 'success',
        ), 200);
    }


    return new WP_REST_Response(array(
        'status' => 'error',
        'error' => $movefile['error']
    ), 200);
}


function ekhos_sound_update($request) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_sounds';
    $id = $request->get_param('id');

    $body_params = $request->get_body_params();
    $character = isset($body_params['character']) ? $body_params['character'] : '';
    $name = isset($body_params['name']) ? $body_params['name'] : '';
    $files = $request->get_file_params();
    $upload_overrides = array('test_form' => false);

    if ($character == 'null') {
        $character = null;
    }

    if (!empty($files['file'])) {
        $movefile = wp_handle_upload($files['file'], $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            $data = array(
                'name' => $name,
                'character_id' => $character,
                'sound_url' => $movefile['url']
            );
            $data_format = array('%s', '%d', '%s');
        } else {
            return new WP_REST_Response(array(
                'status' => 'error',
                'error' => $movefile['error']
            ), 200);
        }
    } else {
        $data = array(
            'name' => $name,
            'character_id' => $character
        );
        $data_format = array('%s', '%d');
    }

    $wpdb->update($table_name, $data, array('id' => $id), $data_format, array('%d'));

    return new WP_REST_Response(array(
        'status' => 'success',
        'id' => $id
    ), 200);
}


function ekhos_sound_delete($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_sounds';
    $body_params = $request->get_json_params();
    $id = isset($body_params['id']) ? $body_params['id'] : '';
    $sound = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

    if ($sound) {
        $file_path = str_replace(content_url(), WP_CONTENT_DIR, $sound->sound_url);
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $wpdb->delete($table_name, array('id' => $id), array('%d'));
    }

    return new WP_REST_Response(array(
        'status' => 'success',
        'id'=>$id
    ), 200);
}


function ekhos_sound_character_list($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_characters';
    $body_params = $request->get_body_params();
    $items = $wpdb->get_results("SELECT * FROM {$table_name}");

    return new WP_REST_Response(array(
        'status' => 'success',
        'items' => $items
    ), 200);
}


function ekhos_sound_list($request)
{
    global $wpdb;
    $sounds_table_name = $wpdb->prefix . 'ekhos_ids_sounds';
    $characters_table_name = $wpdb->prefix . 'ekhos_ids_characters';

    $query = "
        SELECT s.*, c.name as character_name
        FROM {$sounds_table_name} s
        LEFT JOIN {$characters_table_name} c ON s.character_id = c.id
        ORDER BY s.id ASC
    ";

    $results = $wpdb->get_results($query);

    return new WP_REST_Response(array(
        'status' => 'success',
        'items' => $results
    ), 200);
}
