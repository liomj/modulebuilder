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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 *
 * @since           2.5.0
 *
 * @author          Txmod Xoops http://www.txmodxoops.org
 *
 * @version         $Id: UserSearch.php 12258 2014-01-02 09:33:29Z timgno $
 */
defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class UserSearch.
 */
class UserSearch extends TDMCreateFile
{
    /*
    * @var mixed
    */
    private $usercode = null;

    /*
    * @var mixed
    */
    private $phpcode = null;

    /*
    * @var string
    */
    private $xoopscode;

    /*
    *  @public function constructor
    *  @param null
    */
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->xoopscode = TDMCreateXoopsCode::getInstance();
        $this->phpcode = TDMCreatePhpCode::getInstance();
        $this->usercode = UserXoopsCode::getInstance();
    }

    /*
    *  @static function &getInstance
    *  @param null
    */
    /**
     * @return UserSearch
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
    *  @public function write
    *  @param string $module
    *  @param mixed $table
    *  @param string $filename
    */
    /**
     * @param $module
     * @param $table
     * @param $filename
     */
    public function write($module, $table, $filename)
    {
        $this->setModule($module);
        $this->setTable($table);
        $this->setFileName($filename);
    }

    /**
     * @private function getUserSearchHeader
     *
     * @param $moduleDirname
     *
     * @return string
     */
    private function getUserSearchHeader($moduleDirname, $table, $fields)
    {
        $ret = $this->getInclude();
        foreach (array_keys($fields) as $f) {
            $fieldName = $fields[$f]->getVar('field_name');
            if (0 == $f) {
                $fieldId = $fieldName;
            }
            if (1 == $fields[$f]->getVar('field_parent')) {
                $fieldPid = $fieldName;
            }
        }
        if ($table->getVar('table_category') == 1) {
            $ccFieldPid = $this->getCamelCase($fieldPid, false, true);
            $ret .= $this->xoopscode->getXoopsCodeXoopsRequest("{$ccFieldPid}", "{$fieldPid}", '0', 'Int');
        }
        $ccFieldId = $this->getCamelCase($fieldId, false, true);
        $ret .= $this->xoopscode->getXoopsCodeXoopsRequest("{$ccFieldId}", "{$fieldId}", '0', 'Int');
        $ret .= $this->usercode->getUserTplMain($moduleDirname);
        $ret .= $this->phpcode->getPhpCodeIncludeDir('XOOPS_ROOT_PATH', 'header', true);
        $ret .= $this->getCommentLine('Define Stylesheet');
        $ret .= $this->xoopscode->getXoopsCodeAddStylesheet();

        return $ret;
    }

    /*
    *  @public function getAdminPagesList
    *  @param string $tableName
    *  @param string $language
    */
    /**
     * @param $module
     * @param $tableName
     * @param $language
     *
     * @return string
     */
    public function getUserSearch($moduleDirname, $tableName, $language)
    {
        $ret = <<<EOT

EOT;
        $ret .= $this->getSimpleString('$keywords = array();');

        return $ret;
    }

    /**
     * @private function getUserSearchFooter
     *
     * @param $moduleDirname
     * @param $tableName
     * @param $language
     *
     * @return string
     */
    private function getUserSearchFooter($moduleDirname, $tableName, $language)
    {
        $stuModuleDirname = strtoupper($moduleDirname);
        $stuTableName = strtoupper($tableName);
        $ret = $this->getCommentLine('Breadcrumbs');
        $ret .= $this->usercode->getUserBreadcrumbs("{$stuTableName}", $language);
        $ret .= $this->getCommentLine('Keywords');
        $ret .= $this->usercode->getUserMetaKeywords($moduleDirname);
        $ret .= $this->phpcode->getPhpCodeUnset('keywords');
        $ret .= $this->getCommentLine('Description');
        $ret .= $this->usercode->getUserMetaDesc($moduleDirname, 'DESC', $language);
        $ret .= $this->xoopscode->getXoopsCodeTplAssign('xoops_mpageurl', "{$stuModuleDirname}_URL.'/index.php'");
        $ret .= $this->xoopscode->getXoopsCodeTplAssign('xoops_icons32_url', 'XOOPS_ICONS32_URL');
        $ret .= $this->xoopscode->getXoopsCodeTplAssign("{$moduleDirname}_upload_url", "{$stuModuleDirname}_UPLOAD_URL");
        $ret .= $this->getInclude('footer');

        return $ret;
    }

    /*
    *  @public function render
    *  @param null
    */
    /**
     * @return bool|string
     */
    public function render()
    {
        $module = $this->getModule();
        $table = $this->getTable();
        $filename = $this->getFileName();
        $moduleDirname = $module->getVar('mod_dirname');
        $tableId = $table->getVar('table_id');
        $tableMid = $table->getVar('table_mid');
        $tableName = $table->getVar('table_name');
        $fields = $this->getTableFields($tableMid, $tableId);
        $language = $this->getLanguage($moduleDirname, 'MA');
        $content = $this->getHeaderFilesComments($module, $filename);
        $content .= $this->getUserSearchHeader($moduleDirname, $table, $fields);
        $content .= $this->getUserSearch($moduleDirname, $tableName, $language);
        $content .= $this->getUserSearchFooter($moduleDirname, $tableName, $language);

        $this->create($moduleDirname, '/', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);

        return $this->renderFile();
    }
}
