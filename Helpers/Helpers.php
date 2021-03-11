<?php

/**
 * Woody Library DropZone
 * @author Léo POIROUX
 * @copyright Raccourci Agency 2021
 */

function dropzone_get($key = null)
{
    return do_action('woody_dropzone_get', $key);
}

function dropzone_set($key = null, $data = null, $expired = null, $action = null)
{
    do_action('woody_dropzone_set', $key, $data, $expired, $action);
}

function dropzone_delete($key = null)
{
    do_action('woody_dropzone_delete', $key);
}
