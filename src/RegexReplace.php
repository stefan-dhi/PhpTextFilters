<?php

namespace PhpTextFilters;

class RegexReplace extends Base
{
    protected $options = ['pattern' => '@[^[:alnum:]]@ui', 'replacement' => ''];

    public function run($txt)
    {
        return preg_replace($this->options['pattern'], $this->options['replacement'], $txt);
    }
}

