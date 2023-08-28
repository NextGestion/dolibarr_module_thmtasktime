<?php
/* Copyright (C) 2023 	   NextGestion          <contact@nextgestion.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 	\defgroup   thmtasktime     Module thmtasktime
 *  \file       /custom/thmtasktime/core/modules/modthmtasktime.class.php
 *  \ingroup    thmtasktime
 *  \brief      Description and activation file for module thmtasktime
 */
include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';


/**
 *  Description and activation class for module thmtasktime
 */

class modthmtasktime extends DolibarrModules
{
	/**
	 *   Constructor. Define names, constants, directories, boxes, permissions
	 *
	 *   @param      DoliDB		$db      Database handler
	 */

	function __construct($db)
	{
        global $langs,$conf;

        $this->db = $db;
		
		// Author
		$this->editor_name = 'NextGestion';
		$this->editor_url = 'https://www.nextgestion.com';
		
		$this->numero = 19054700; 
		$this->rights_class = 'thmtasktime';
		$this->family = "NextGestion";
		$this->name = preg_replace('/^mod/i','',get_class($this));
		$this->description = "Module19054700Desc";
		$this->version = '1.2';
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		$this->special = 0;
		$this->picto='thmtasktime@thmtasktime';

		$this->module_parts = array(
			'models' => 0,
			'hooks' => array('projecttasktime'), 
			'triggers' => 1
		);

		$this->dirs = array();

		$this->config_page_url = array();

		$this->hidden = false;			
		$this->depends = array();		
		$this->requiredby = array();	
		$this->conflictwith = array();	
		$this->phpmin = array(5,0);					
		$this->need_dolibarr_version = array(3,0);	
		$this->langfiles = array("thmtasktime@thmtasktime");
		$this->const = array();
        $this->tabs = array();
        $this->cronjobs = array();
        // Dictionaries
	    if (! isset($conf->thmtasktime->enabled))
        {
        	$conf->thmtasktime=new stdClass();
        	$conf->thmtasktime->enabled=0;
        }
		$this->dictionaries=array();
        $this->boxes = array();	
		$this->rights = array();

		$this->menu = array();	
		$r=0;

		// -----------------------------------------------------------------------------------------------------------------------------
	}

	/**
	 *		Function called when module is enabled.
	 *		The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *		It also creates data directories
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
	 */
	function init($options='')
	{
		global $conf, $langs;
		
		$msql = array();
		
		$langs->load('thmtasktime@thmtasktime');

		return $this->_init($msql, $options);
	}

	/**
	 *		Function called when module is disabled.
	 *      Remove from database constants, boxes and permissions from Dolibarr database.
	 *		Data directories are not deleted
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
	 */

	function remove($options='')
	{
		global $langs;

		$sql = array();

		$langs->load('thmtasktime@thmtasktime');

		return $this->_remove($sql, $options);

	}

}
