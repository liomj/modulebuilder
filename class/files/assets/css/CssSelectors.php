<?php

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * tdmcreate module.
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 *
 * @since           2.5.0
 *
 * @author          Txmod Xoops http://www.txmodxoops.org
 *
 * @version         $Id: 1.91 CssSelectors.php 12258 2014-01-02 09:33:29Z timgno $
 */

/**
 * Class CssSelectors.
 */
class CssSelectors
{
    /**
     *  @static function getInstance
     *  @param null
     *
     * @return CssSelectors
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * @public function geCssComment
     * @param string $comment
     * @param string $t
     * @return string
     */
    public function geCssComment($comment, $t)
    {
        $ret = ('' != $comment) ? "{$t}/* {$comment} */" : '';
        
        return $ret;
    }

    /**
     * @public function geCssSelector
     * @param string $selector
     * @param mixed  $content
     * @param string $t
     * @return string
     */
    public function geCssSelector($selector, $content, $t)
    {
        $ret = '';
        if (is_array($selector)) {
            $ret .= $t. implode("\n", $selector) . ' {';
        } else {
            $ret .= $selector . ' {';
        }
        if (is_array($content)) {
            $ret .= $t. implode("\n", $content) . ';';
        } else {
            $ret .= $content . ';';
        }
        $ret = '}';
        
        return $ret;
    }
}