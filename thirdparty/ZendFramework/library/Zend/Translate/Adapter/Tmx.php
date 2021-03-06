<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Translate
 * @copyright  Copyright (c) 2005-2007 Zend Technologies USA Inc. (http://www.zend.com)
 * @version    $Id: Date.php 2498 2006-12-23 22:13:38Z thomas $
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */


/** Zend_Locale */
require_once 'Zend/Locale.php';

/** Zend_Translate_Exception */
require_once 'Zend/Translate/Exception.php';

/** Zend_Translate_Adapter */
require_once 'Zend/Translate/Adapter.php';


/**
 * @category   Zend
 * @package    Zend_Translate
 * @copyright  Copyright (c) 2005-2007 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Translate_Adapter_Tmx extends Zend_Translate_Adapter {
    // Internal variables
    private $_file        = false;
    private $_cleared     = array();
    private $_tu          = null;
    private $_tuv         = null;
    private $_seg         = null;
    private $_content     = null;

    /**
     * Generates the tmx adapter
     * This adapter reads with php's xml_parser
     *
     * @param  array               $options  Options for this adapter
     * @param  string|Zend_Locale  $locale   OPTIONAL Locale/Language to set, identical with locale identifier,
     *                                       see Zend_Locale for more information
     */
    public function __construct($options, $locale = null)
    {
        parent::__construct($options, $locale);
    }


    /**
     * Load translation data (TMX file reader)
     *
     * @param  string  $filename  TMX file to add, full path must be given for access
     * @param  string  $locale    Locale has no effect for TMX because TMX defines all languages within 
     *                            the source file
     * @param  boolean $option    Clears the complete translation, because TMX defines all languages in one file
     * @throws Zend_Translation_Exception
     */
    protected function _loadTranslationData($filename, $locale, $option = null)
    {
        if ($option) {
            $this->_translate = array();
        }

        if (!is_readable($filename)) {
            throw new Zend_Translate_Exception('Translation file \'' . $filename . '\' is not readable.');
        }

        $this->_file = xml_parser_create();
        xml_set_object($this->_file, $this);
        xml_parser_set_option($this->_file, XML_OPTION_CASE_FOLDING, 0);
        xml_set_element_handler($this->_file, "_startElement", "_endElement");
        xml_set_character_data_handler($this->_file, "_contentElement");

        if (!xml_parse($this->_file, file_get_contents($filename))) {
            throw new Zend_Translate_Exception(sprintf('XML error: %s at line %d', 
                      xml_error_string(xml_get_error_code($this->_file)),
                      xml_get_current_line_number($this->_file)));
            xml_parser_free($this->_file);
        }
    }

    private function _startElement($file, $name, $attrib)
    {
        switch(strtolower($name)) {
            case 'tu':
                if (array_key_exists('tuid', $attrib)) {
                    $this->_tu = $attrib['tuid'];
                }
                break;
            case 'tuv':
                if (array_key_exists('xml:lang', $attrib)) {
                    $this->_tuv = $attrib['xml:lang'];
                    if (!array_key_exists($this->_tuv, $this->_translate)) {
                        $this->_translate[$this->_tuv] = array();
                    }
                }
                break;
            case 'seg':
                $this->_seg     = true;
                $this->_content = null;
                break;
            default:
                break;
        }
    }

    private function _endElement($file, $name)
    {
        switch (strtolower($name)) {
            case 'tu':
                $this->_tu = null;
                break;
            case 'tuv':
                $this->_tuv = null;
                break;
            case 'seg':
                $this->_seg = null;
                if (!empty($this->_content) or !array_key_exists($this->_tu, $this->_translate[$this->_tuv])) {
                    $this->_translate[$this->_tuv][$this->_tu] = $this->_content;
                }
                break;
            default:
                break;
        }
    }

    private function _contentElement($file, $data)
    {
        if (($this->_seg !== null) and ($this->_tu !== null) and ($this->_tuv !== null)) {
            $this->_content .= $data;
        }
    }

    /**
     * Returns the adapter name
     *
     * @return string
     */
    public function toString()
    {
        return "Tmx";
    }
}
