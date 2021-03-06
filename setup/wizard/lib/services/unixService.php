<?php
/**
* Unix Service Controller.
*
* KnowledgeTree Community Edition
* Document Management Made Simple
* Copyright(C) 2008,2009 KnowledgeTree Inc.
*
* This program is free software; you can redistribute it and/or modify it under
* the terms of the GNU General Public License version 3 as published by the
* Free Software Foundation.
*
* This program is distributed in the hope that it will be useful, but WITHOUT
* ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
* FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
* details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* You can contact KnowledgeTree Inc., PO Box 7775 #87847, San Francisco,
* California 94120-7775, or email info@knowledgetree.com.
*
* The interactive user interfaces in modified source and object code versions
* of this program must display Appropriate Legal Notices, as required under
* Section 5 of the GNU General Public License version 3.
*
* In accordance with Section 7(b) of the GNU General Public License version 3,
* these Appropriate Legal Notices must retain the display of the "Powered by
* KnowledgeTree" logo and retain the original copyright notice. If the display of the
* logo is not reasonably feasible for technical reasons, the Appropriate Legal Notices
* must display the words "Powered by KnowledgeTree" and retain the original
* copyright notice.
*
* @copyright 2008-2009, KnowledgeTree Inc.
* @license GNU General Public License version 3
* @author KnowledgeTree Team
* @package Installer
* @version Version 0.1
*/

class unixService extends Service {
	
	public $outputDir;
	public $varDir;
	
	/**
	* Reference to utility object
	*
	* @author KnowledgeTree Team
	* @access public
	* @param none
	* @return string
 	*/
	public $util;
	
    /**
     * Class constructor
     *
	 * @author KnowledgeTree Team
     * @access public
     */
	public function __construct() {
		$this->util = new InstallUtil();
		$this->setSystemDirs();
	}
	
	function setSystemDirs() {
		$conf = $this->util->getDataFromSession('configuration');
		$this->outputDir = $conf['paths']['logDirectory']['path'].DS;
		if($this->outputDir == '' || $this->outputDir == '/') {
			$this->outputDir = SYS_OUT_DIR;
		}
		$this->varDir = $conf['paths']['varDirectory']['path'].DS;
		if($this->varDir == '' || $this->varDir == '/') {
			$this->varDir = SYS_VAR_DIR;
		}
	}
	
	/**
	* Retrieve Service name
	*
	* @author KnowledgeTree Team
	* @access public
	* @param none
	* @return string
 	*/
	public function getName() {
		return $this->name;
	}
	
	/**
	* Load defaults needed by service
	*
	* @author KnowledgeTree Team
	* @access public
	* @param string
	* @return void
 	*/
	public function load() {}
	
	/**
	* Start Service
	*
	* @author KnowledgeTree Team
	* @access public
	* @param none
	* @return void
 	*/
	public function start() {

	}
	
	/**
	* Stop Service
	*
	* @author KnowledgeTree Team
	* @access public
	* @param none
	* @return void
 	*/
	public function stop() {

	}
	
	public function install() {}
	
	/**
	* Restart Service
	*
	* @author KnowledgeTree Team
	* @access public
	* @param none
	* @return mixed
 	*/
	public function restart() {

	}
	
	/**
	* Uninstall Service
	*
	* @author KnowledgeTree Team
	* @access public
	* @param none
	* @return mixed
 	*/
	public function uninstall() {

	}
	
	/**
	* Retrieve Status Service
	*
	* @author KnowledgeTree Team
	* @access public
	* @param none
	* @return mixed
 	*/
	public function status() {

	}
	
	/**
	* Pause Service
	*
	* @author KnowledgeTree Team
	* @access public
	* @param none
	* @return mixed
 	*/
	public function pause() {

	}
	
	/**
	* Continue Service
	*
	* @author KnowledgeTree Team
	* @access public
	* @param none
	* @return mixed
 	*/
	public function cont() {
		
	}
	
	
}
?>