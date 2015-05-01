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
 * tdmcreate module
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         tdmcreate
 * @since           2.5.0
 * @author          Txmod Xoops http://www.txmodxoops.org
 * @version         $Id: objects.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * Class UserObjects
 */
class UserObjects
{
    /*
    *  @static function &getInstance
    *  @param null
    */
    /**
     * @return UserObjects
     */
    public static function &getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /*
    *  @public function getUserHeader
    *  @param string $moduleDirname
    *  @param string $tableName
    */
    /**
     * @param $moduleDirname
     * @param $tableName
     * @return string
     */
    public function getUserHeader($moduleDirname, $tableName)
    {
        $ret = <<<EOT
include_once 'header.php';
\$GLOBALS['xoopsOption']['template_main'] = '{$moduleDirname}_{$tableName}.tpl';
include_once XOOPS_ROOT_PATH.'/header.php';\n
EOT;

        return $ret;
    }

    /*
    *  @public function getUserIndex
    *  @param string $moduleDirname
    */
    /**
     * @param $moduleDirname
     * @return string
     */
    public function getUserIndex($moduleDirname)
    {
        $ret = <<<EOT
include_once 'header.php';
\$GLOBALS['xoopsOption']['template_main'] = '{$moduleDirname}_index.tpl';
include_once XOOPS_ROOT_PATH.'/header.php';\n
EOT;

        return $ret;
    }

    /*
    *  @public function getUserFooter
    *  @param null
    */
    /**
     * @return string
     */
    public function getUserFooter()
    {
        $ret = <<<EOT
include_once 'footer.php';
EOT;

        return $ret;
    }

    /**
    *  @public function getSimpleGetVar
    *  
     * @param $lpFieldName
     * @param $rpFieldName
     * @param $tableName
     * @param $fieldName
     * @return string
     */
    public function getSimpleGetVar($lpFieldName, $rpFieldName, $tableName, $fieldName)
    {
        $ret = <<<EOT
\t\t// Get Var {$fieldName}
\t\t\${$lpFieldName}['{$rpFieldName}'] = \${$tableName}All[\$i]->getVar('{$fieldName}');\n
EOT;

        return $ret;
    }

    /**
    *  @public function getTopicGetVar
    * 
     * @param $lpFieldName
     * @param $rpFieldName
     * @param $tableName
     * @param $tableNameTopic
     * @param $fieldNameParent
     * @param $fieldNameTopic
     * @return string
     */
    public function getTopicGetVar($lpFieldName, $rpFieldName, $tableName, $tableNameTopic, $fieldNameParent, $fieldNameTopic)
    {
        $ret = <<<EOT
\t\t// Get Var {$fieldNameParent}
\t\t\${$rpFieldName} =& \${$tableNameTopic}Handler->get(\${$tableName}All[\$i]->getVar('{$fieldNameParent}'));
\t\t\${$lpFieldName}['{$rpFieldName}'] = \${$rpFieldName}->getVar('{$fieldNameTopic}');\n
EOT;

        return $ret;
    }

    /**
    *  @public function getUploadImageGetVar
    *  
    * @param $lpFieldName
    * @param $rpFieldName
    * @param $tableName
    * @param $fieldName
    * @return string
    */
    public function getUploadImageGetVar($lpFieldName, $rpFieldName, $tableName, $fieldName)
    {
        $ret = <<<EOT
\t\t// Get Var {$fieldName}
\t\t\${$fieldName} = \${$tableName}All[\$i]->getVar('{$fieldName}');
\t\t\$upload_image = \${$fieldName} ? \${$fieldName} : 'blank.gif';
\t\t\${$lpFieldName}['{$rpFieldName}'] = \$upload_image;\n
EOT;

        return $ret;
    }

   /**
    *  @public function getUrlFileGetVar
    *
    *  @param $lpFieldName
    *  @param $rpFieldName
    *  @param $tableName
    *  @param $fieldName
    *  @return string
    */
    public function getUrlFileGetVar($lpFieldName, $rpFieldName, $tableName, $fieldName)
    {
        $ret = <<<EOT
\t\t\t\t// Get Var {$fieldName}
\t\t\t\t\${$lpFieldName}['{$rpFieldName}'] = \${$tableName}All[\$i]->getVar('{$fieldName}');\n
EOT;
        return $ret;
    }

    /**
    *  @public function getTextAreaGetVar
    *  
     * @param $lpFieldName
     * @param $rpFieldName
     * @param $tableName
     * @param $fieldName
     * @return string
     */
    public function getTextAreaGetVar($lpFieldName, $rpFieldName, $tableName, $fieldName)
    {
        $ret = <<<EOT
\t\t// Get Var {$fieldName}
\t\t\${$lpFieldName}['{$rpFieldName}'] = strip_tags(\${$tableName}All[\$i]->getVar('{$fieldName}'));\n
EOT;

        return $ret;
    }

    /**
    *  @public function getSelectUserGetVar
    *  
     * @param $lpFieldName
     * @param $rpFieldName
     * @param $tableName
     * @param $fieldName
     * @return string
     */
    public function getSelectUserGetVar($lpFieldName, $rpFieldName, $tableName, $fieldName)
    {
        $ret = <<<EOT
\t\t// Get Var {$fieldName}
\t\t\${$lpFieldName}['{$rpFieldName}'] = XoopsUser::getUnameFromId(\${$tableName}All[\$i]->getVar('{$fieldName}'), 's');\n
EOT;

        return $ret;
    }

    /**
    *  @public function getTextDateSelectGetVar
    * 
     * @param $lpFieldName
     * @param $rpFieldName
     * @param $tableName
     * @param $fieldName
     * @return string
     */
    public function getTextDateSelectGetVar($lpFieldName, $rpFieldName, $tableName, $fieldName)
    {
        $ret = <<<EOT
\t\t// Get Var {$fieldName}
\t\t\${$lpFieldName}['{$rpFieldName}'] = formatTimeStamp(\${$tableName}All[\$i]->getVar('{$fieldName}'), 's');\n
EOT;

        return $ret;
    }
}
