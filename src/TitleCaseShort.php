<?php
/**
 * selective text case converter
 * less than max. words: Title Case
 * longer than max. words: Sentence case
 */

namespace PhpTextFilters;

class TitleCaseShort extends Base
{
    protected $options = ['maxWords' => 6];

    public function run($txt)
    {
        if (str_word_count($txt) <= $this->options['maxWords']) {
            return $this->mbUcWordsUnlessUc($txt);
        }
        return $this->mbUcFirst($txt);
    }

    /**
     * uppercase the first letter in each word unless the word is all uppercase or MixedCASE
     * supports multibyte alphabet
     * @param $txt
     * @return string
     */
    protected function mbUcWordsUnlessUc($txt)
    {
        $arr = explode(' ', $txt);
        foreach ($arr as &$ww) {
            if (preg_match('@^[[:lower:]]+$@u', $ww)) {
                $ww = mb_convert_case($ww, MB_CASE_TITLE, 'UTF-8');
            }
        }
        return implode(' ', $arr);
    }

    /**
     * multibyte-safe ucfirst
     * @return string
     * @param $txt
     */
    protected function mbUcFirst($txt)
    {
        return mb_strtoupper(mb_substr($txt, 0, 1)) . mb_substr($txt, 1);
    }
}

