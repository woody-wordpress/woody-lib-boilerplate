<?php

/**
 * Woody Library DropZone
 * @author Léo POIROUX
 * @copyright Raccourci Agency 2021
 */

namespace Woody\Lib\DropZone\Commands;

use Woody\App\Container;

// WP_SITE_KEY=superot wp woody:dropzone action

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

    public function action($args, $assoc_args)
    {
        $this->dropZoneManager->action($args, $assoc_args);
    }
}
