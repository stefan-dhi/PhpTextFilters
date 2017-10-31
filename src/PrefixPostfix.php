<?php

namespace PhpTextFilters;

class PrefixPostfix extends Base
{

    protected $options = [
                            'prefix' => '', 
                            'postfix' => ''
                         ];

    public function run($txt)
    {
        return $this->options['prefix'] . $txt . $this->options['postfix'];
    }
}
