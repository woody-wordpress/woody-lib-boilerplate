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
    }
}
