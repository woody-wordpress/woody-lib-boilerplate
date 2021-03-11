<?php

/**
 * Woody Library DropZone
 * @author Léo POIROUX
 * @copyright Raccourci Agency 2021
 */

namespace Woody\Lib\DropZone\Commands;

use Woody\App\Container;

// WP_SITE_KEY=superot wp woody:dropzone get %key%
// WP_SITE_KEY=superot wp woody:dropzone set %key% %data% %expired% %action%
// WP_SITE_KEY=superot wp woody:dropzone delete %key%

class DropZoneCommand
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->dropZoneManager = $this->container->get('dropzone.manager');
    }

    public function get($args, $assoc_args)
    {
        $this->dropZoneManager->get($key);
    }

    public function set($args, $assoc_args)
    {
        $this->dropZoneManager->set($key, $data, $expired, $action);
    }

    public function delete($args, $assoc_args)
    {
        $this->dropZoneManager->delete($key);
    }
}
