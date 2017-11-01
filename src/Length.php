<?php

namespace PhpTextFilters;

class Length extends Base
{

    protected $options = [
        'min' => 0,                 // min. length
        'max' => 100,               // max. length
        'breakWords' => false       // if false, attempt to not cut through words - does not work well if text contains extremely long words
    ];

    /**
     * @inheritdoc
     */
    public function run($txt)
    {
        $txt = trim($txt);
        if (strlen($txt) < $this->options['min']) {
            // TODO - not sure what should happen if text is too short?
            return '';
        }
        if (strlen($txt) <= $this->options['max']) {
            return $txt;
        }

        if ($this->options['breakWords']) {
            // cut through the middle of a word to get to exactly max. characters
            return mb_substr($txt, 0, $this->options['max']);
        }
        // try to cut at a natural word boundary
        return self::truncate($txt, $this->options['max']);
    }


    /**
     * @param string $txt
     * @param int $len
     * @return string
     */
    protected static function truncate($txt, $len)
    {
        $txt = rtrim($txt);
        $words = explode(' ', $txt);
        $txt = '';
        $actual = '';
        foreach ($words as $ii => $word) {
            if (mb_strlen($actual . $word) <= $len) {
                $actual .= $word . ' ';
            } else {
                if ($ii == 0) {
		    // first word is already longer than the limit...
                    return mb_substr($word, 0, $len);
                }
                if ($actual != '') {
                    $txt .= rtrim($actual);
                }
                $actual = $word;
                $actual .= ' ';
            }
        }
        return trim($txt);
    }
}


