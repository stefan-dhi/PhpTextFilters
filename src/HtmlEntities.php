<?php

namespace PhpTextFilters;

class HtmlEntities extends Base
{
    /**
     * @var array
     */
    protected static $transTable = [];

    /**
     * @inheritdoc
     */
    protected $options = [
        'htmlVersion' => 'HTML4',
        'numeric' => false      // use XML-type numeric entity references?
    ];

    /**
     * @var string
     */
    protected $htmlVersion;

    /**
     * @inheritdoc
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->versionToConst();
        if ($this->options['numeric']) {
            self::$transTable = self::buildTransTable($this->htmlVersion);
        }
    }

    /**
     * @inheritdoc
     */
    public function run($txt)
    {
        $txt = htmlentities($txt, ENT_COMPAT | $this->htmlVersion, 'UTF-8', false);
        if ($this->options['numeric']) {
            $txt = str_replace(array_keys(self::$transTable), self::$transTable, $txt);
        }
        return $txt;
    }

    /**
     * assigns the appropriate PHP constant
     * @throws \InvalidArgumentException
     */
    protected function versionToConst()
    {
        switch ($this->options['htmlVersion']) {
            case 'HTML4':
                // this seems to work best
                $v = ENT_HTML401;
                break;
            case 'HTML5':
                // ENT_HTML5 converts all sorts of useless stuff like commas, brackets and full stops
                $v = ENT_HTML5;
                break;
            case 'XML':
                $v = ENT_XML1;
                break;
            case 'XHTML':
                $v = ENT_XHTML;
                break;
            default:
                throw new \InvalidArgumentException('Unsupported HTML version option: ' . $str);
        }
        $this->htmlVersion = $v;
    }

    /**
     * build a translation table that maps HTML entity references (e.g. &alpha; or &trade;)
     * to their numeric equivalent (e.g. &#0945; or &#8482;)
     * @param int $vv
     * @return array
     */
    protected static function buildTransTable($vv)
    {
        $tt = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES | $vv);
        $qq = [];
        foreach ($tt as $kk => $vv) {
            $k0 = mb_convert_encoding($kk, 'UCS-2LE', 'UTF-8');
            $k1 = ord(substr($k0, 0, 1));
            $k2 = ord(substr($k0, 1, 1));
            $qq[$vv] = '&#' . sprintf('%04d',$k2 * 256 + $k1) . ';';
        }
        unset($tt);
        return $qq;
    }
}

