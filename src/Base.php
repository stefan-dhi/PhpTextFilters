<?php

namespace PhpTextFilters;

abstract class Base
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * Base constructor.
     * @param array $options
     */
    public function __construct($options = []) {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Run the filter on a string.
     * @param string $txt
     * @return string
     */
    abstract public function run($txt);
}

