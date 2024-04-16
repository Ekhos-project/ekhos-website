<?php

function ekhos_character_add($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_characters';
    $body_params = $request->get_json_params();
    $name = isset($body_params['name']) ? $body_params['name'] : '';
    $sound = isset($body_params['sound']) ? $body_params['sound'] : '';

    if ($sound == 'null') {
        $sound = null;
    }

    $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'sound_id' => $sound
        ),
        array(
            '%s',
            '%s'
        )
    );

    return new WP_REST_Response(array(
        'status' => 'success',
    ), 200);
}

function ekhos_character_update($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_characters';
    $id = $request->get_param('id');
    $body_params = $request->get_json_params();
    $name = isset($body_params['name']) ? $body_params['name'] : '';
    $sound = isset($body_params['sound']) ? $body_params['sound'] : '';

    if ($sound == 'null') {
        $sound = null;
    }

    $wpdb->update(
        $table_name,
        array(
            'name' => $name,
            'sound_id' => $sound
        ),
        array('id' => $id),
        array(
            '%s',
            '%s'
        ),
        array('%d')
    );

    return new WP_REST_Response(array(
        'status' => 'success',
        'id' => $id
    ), 200);
}


function ekhos_character_delete($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_characters';
    $body_params = $request->get_json_params();
    $id = isset($body_params['id']) ? $body_params['id'] : '';
    $wpdb->delete($table_name, array('id' => $id), array('%d'));

    return new WP_REST_Response(array(
        'status' => 'success',
        'id'=>$id
    ), 200);
}


function ekhos_character_sound_list($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_sounds';
    $body_params = $request->get_body_params();
    $items = $wpdb->get_results("SELECT * FROM {$table_name}");

    return new WP_REST_Response(array(
        'status' => 'success',
        'items' => $items
    ), 200);
}


function ekhos_character_list($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_characters';
    $sound_table_name = $wpdb->prefix . 'ekhos_ids_sounds';
    $body_params = $request->get_body_params();

    $results = $wpdb->get_results("
        SELECT c.*, s.sound_url
        FROM $table_name c
        LEFT JOIN $sound_table_name s ON c.sound_id = s.id
        ORDER BY c.id ASC
    ");

    return new WP_REST_Response(array(
        'status' => 'success',
        'items' => $results
    ), 200);
}