<?php

/**
 * Woody Library DropZone
 * @author Léo POIROUX
 * @copyright Raccourci Agency 2021
 */

namespace Woody\Lib\DropZone\Services;

class DropZoneManager
{
    public function __construct()
    {
    }

    public function get($key = null)
    {
        if (!empty($key)) {
            $key = sanitize_title($key);
            $data = wp_cache_get('dropzone_' . $key, 'woody');
            if (empty($return)) {
                global $wpdb;
                $data = $wpdb->get_results(sprintf("SELECT data FROM {$wpdb->prefix}woody_dropzone WHERE key = %s", $key), OBJECT);
                $data = current($data);
                wp_cache_set('dropzone_' . $key, $data, 'woody');
            }
            return $data;
        }
    }

    public function set($key = null, $data = null, $expired = null, $action = null)
    {
        if (!empty($key)) {
            $key = sanitize_title($key);

            global $wpdb;
            $wpdb->insert("{$wpdb->prefix}woody_dropzone", [
                'key' => $key,
                'data' => maybe_serialize($data),
                'created' => current_time('mysql'),
                'expired' => $expired,
                'action' => $action,
            ]);

            wp_cache_set('dropzone_' . $key, $data, 'woody');
        }
    }

    public function delete($key = null)
    {
        if (!empty($key)) {
            $key = sanitize_title($key);

            global $wpdb;
            $wpdb->delete("{$wpdb->prefix}woody_dropzone", [
                'key' => $key,
            ]);

            wp_cache_delete('dropzone_' . $key, 'woody');
        }
    }
}
