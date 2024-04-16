<?php

function ekhos_linked_add($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_linkeds';
    $body_params = $request->get_json_params();
    $page = isset($body_params['page']) ? $body_params['page'] : '';
    $sound = isset($body_params['sound']) ? $body_params['sound'] : '';
    $selector = isset($body_params['selector']) ? $body_params['selector'] : '';

    if ($sound == 'null') {
        $sound = null;
    }
    if ($page == 'null') {
        $page = null;
    }

    $wpdb->insert(
        $table_name,
        array(
            'selector' => $selector,
            'page_url' => $page,
            'sound_id' => $sound
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


function ekhos_linked_update($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_linkeds';
    $id = $request->get_param('id');
    $body_params = $request->get_json_params();
    $page = isset($body_params['page']) ? $body_params['page'] : '';
    $sound = isset($body_params['sound']) ? $body_params['sound'] : '';
    $selector = isset($body_params['selector']) ? $body_params['selector'] : '';

    if ($sound == 'null') {
        $sound = null;
    }
    if ($page == 'null') {
        $page = null;
    }

    $wpdb->update(
        $table_name,
        array(
            'selector' => $selector,
            'page_url' => $page,
            'sound_id' => $sound
        ),
        array('id' => $id),
        array(
            '%s',
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

function ekhos_linked_delete($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_linkeds';
    $body_params = $request->get_json_params();
    $id = isset($body_params['id']) ? $body_params['id'] : '';
    $wpdb->delete($table_name, array('id' => $id), array('%d'));

    return new WP_REST_Response(array(
        'status' => 'success',
        'id'=>$id
    ), 200);
}


function ekhos_linked_sound_list($request)
{
    global $wpdb;
    $sounds_table_name = $wpdb->prefix . 'ekhos_ids_sounds';
    $characters_table_name = $wpdb->prefix . 'ekhos_ids_characters';

    $query = "
        SELECT s.*, c.name as character_name
        FROM {$sounds_table_name} s
        LEFT JOIN {$characters_table_name} c ON s.character_id = c.id
    ";

    // Exécuter la requête
    $items = $wpdb->get_results($query);

    return new WP_REST_Response(array(
        'status' => 'success',
        'items' => $items
    ), 200);
}



function ekhos_linked_page_list($request) {
    $post_types = get_post_types(array('public' => true), 'names');
    $args = array(
        'post_type' => $post_types,
        'posts_per_page' => -1,
    );
    $query = new WP_Query($args);
    $items = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $items[] = array(
                'name' => get_the_title(),
                'url' => get_permalink()
            );
        }
    }

    wp_reset_postdata();

    return new WP_REST_Response(array(
        'status' => 'success',
        'items' => $items
    ), 200);
}


function find_post_by_url($url) {
    $post_id = url_to_postid($url);

    if ($post_id) {
        $post = get_post($post_id);
        return $post;
    } else {
        return null;
    }
}


function ekhos_linked_list($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'ekhos_ids_linkeds';
    $items = $wpdb->get_results("SELECT * FROM {$table_name}");

    $results = [];

    foreach ($items as $item) {
        $sound_table_name = $wpdb->prefix . 'ekhos_ids_sounds';
        $sound_query = $wpdb->prepare("SELECT * FROM $sound_table_name WHERE id = %d", $item->sound_id);
        $sound_row = $wpdb->get_row($sound_query);
        $character_table_name = $wpdb->prefix . 'ekhos_ids_characters';
        $character_query = $wpdb->prepare("SELECT * FROM $character_table_name WHERE id = %d", $sound_row ? $sound_row->character_id : null);
        $character_row = $wpdb->get_row($character_query);
        $page = find_post_by_url($item->page_url);

        $results[] = [
            'id' => $item->id,
            'sound_id' => $item->sound_id,
            'page_url' => $item->page_url,
            'selector' => $item->selector,
            'page_name' => $page ? $page->post_title : '',
            'character_name' => $character_row ? $character_row->name : '',
            'sound_name' => $sound_row ? $sound_row->name : '',
            'sound_url' => $sound_row ? $sound_row->sound_url : '',
        ];
    }

    // Retourner la réponse JSON avec 'items' au lieu de 'html'
    return new WP_REST_Response(array(
        'status' => 'success',
        'items' => $results
    ), 200);
}
