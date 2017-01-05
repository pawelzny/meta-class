<?php

namespace Pawelzny\Discovery\Services;

class Environment
{
    public $name = null;
    protected $composer = null;

    public function __construct()
    {
        $this->readComposerJson();
    }

    public function getComposer()
    {
        return $this->composer;
    }

    protected function readComposerJson()
    {
        $path = [
            __DIR__,
            '..', '..', '..', '..', '..', '..', // go to maybe project root directory
            'composer.json',
        ];
        $composer_json = file_get_contents(join(DIRECTORY_SEPARATOR, $path));
        if ($composer_json !== false) {
            $this->composer = json_decode($composer_json);
        }
    }

    protected function searchForFramework()
    {
        // TODO: Parse composer.json and search for required framework.
    }
}
