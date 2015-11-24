<?php

namespace ThijsKok\PHPCI\Plugin;

use PHPCI\Builder;
use PHPCI\Model\Build;

/**
 * Bower Plugin - Provides access to bower functionality.
 * @author       Thijs Kok <mail@thijskok.nl>
 * @package      PHPCI
 * @subpackage   Plugins
 */
class Bower implements \PHPCI\Plugin
{
    protected $directory;
    protected $production;
    protected $force;
    protected $preferDist;
    protected $phpci;
    protected $build;
    protected $bower;

    /**
     * Standard Constructor
     *
     * $options['directory']  Output Directory. Default: %BUILDPATH%
     * $options['production'] Production flag. Defaults to false (empty).
     * $options['force']      Force latest version flag. Defaults to false (empty).
     *
     * @param Builder $phpci
     * @param Build   $build
     * @param array   $options
     */
    public function __construct(Builder $phpci, Build $build, array $options = array())
    {
        $path = $phpci->buildPath;
        $this->build = $build;
        $this->phpci = $phpci;
        $this->directory = $path;
        $this->production = '';
        $this->force = '';
        $this->bower = $this->phpci->findBinary('bower');

        // Handle options:
        if (isset($options['directory'])) {
            $this->directory = $path . DIRECTORY_SEPARATOR . $options['directory'];
        }

        if (isset($options['production'])) {
            $this->production = $options['production'] ? '--production':'';
        }

        if (isset($options['force'])) {
            $this->force = $options['force'] ? '--force-latest':'';
        }
    }

    /**
     * Executes bower and runs a specified command (e.g. install / update)
     */
    public function execute()
    {
        // will not run without bower
        if (is_null($this->bower)) {
            return false;
        }

        // build the bower command
        $cmd = 'cd %s && ' . $this->bower;
        if (IS_WIN) {
            $cmd = 'cd /d %s && ' . $this->bower;
        }
        $cmd .= ' %s'; // production flag
        $cmd .= ' %s'; // force flag

        // and execute it
        return $this->phpci->executeCommand($cmd, $this->directory, $this->production, $this->force);
    }
}