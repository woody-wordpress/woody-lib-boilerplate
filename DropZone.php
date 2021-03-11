<?php

/**
 * Woody Library DropZone
 * @author Léo POIROUX
 * @copyright Raccourci Agency 2021
 */

namespace Woody\Lib\DropZone;

use Woody\App\Container;
use Woody\Modules\Module;
use Woody\Services\ParameterManager;

final class DropZone extends Module
{
    protected static $key = 'woody_lib_dropzone';

    public function initialize(ParameterManager $parameters, Container $container)
    {
        define('WOODY_LIB_DROPZONE_VERSION', '1.0.0');
        define('WOODY_LIB_DROPZONE_ROOT', __FILE__);
        define('WOODY_LIB_DROPZONE_DIR_ROOT', dirname(WOODY_LIB_DROPZONE_ROOT));

        parent::initialize($parameters, $container);
        $this->dropZoneManager = $this->container->get('dropzone.manager');
    }

    public function registerCommands()
    {
        \WP_CLI::add_command('woody:dropzone', new DropZoneCommand($this->container));
    }

    public static function dependencyServiceDefinitions()
    {
        return \Woody\Lib\DropZone\Configurations\Services::loadDefinitions();
    }

    public function subscribeHooks()
    {
        register_activation_hook(WOODY_LIB_DROPZONE_ROOT, [$this, 'activate']);
        register_deactivation_hook(WOODY_LIB_DROPZONE_ROOT, [$this, 'deactivate']);

        add_action('init', [$this, 'upgrade']);
        add_action('woody_dropzone_get', [$this, 'get'], 10, 1);
        add_action('woody_dropzone_set', [$this, 'set'], 10, 4);
        add_action('woody_dropzone_delete', [$this, 'delete'], 10, 1);
    }

    public function get($key = null)
    {
        $this->dropZoneManager->get($key);
    }

    public function set($key = null, $data = null, $expired = null, $action = null)
    {
        $this->dropZoneManager->set($key, $data, $expired, $action);
    }

    public function delete($key = null)
    {
        $this->dropZoneManager->delete($key);
    }

    public function upgrade()
    {
        $saved_version = (int) get_option('woody_dropzone_db_version');
        if ($saved_version < 100 && $this->upgrade_100()) {
            update_option('woody_dropzone_db_version', 100);
        }
    }

    private function upgrade_100()
    {
        global $wpdb;

        // Apply upgrade
        $sql = [];
        $charset_collate = $wpdb->get_charset_collate();
        $sql[] = "CREATE TABLE `{$wpdb->base_prefix}woody_dropzone` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `data` longtext CHARACTER SET utf8 NOT NULL,
            `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            `expired` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            `action` longtext CHARACTER SET utf8 NOT NULL,
            PRIMARY KEY (`id`, `key`),
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        return empty($wpdb->last_error);
    }
}
