<?php

require_once DOL_DOCUMENT_ROOT.'/fichinter/class/fichinter.class.php';
require_once DOL_DOCUMENT_ROOT.'/comm/action/class/actioncomm.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.form.class.php';
require_once DOL_DOCUMENT_ROOT.'/societe/class/societe.class.php';

/**
 * Class Actionsthmtasktime
 */
class Actionsthmtasktime
{
	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * @var array Errors
	 */
	public $errors = array();

	/**
	 * Constructor
	 */

	function __construct($db){
		
		$this->db = $db;
	}

	function doActions($parameters, &$object, &$action, $hookmanager){
		global $conf, $langs, $user, $confirm, $db;

		$context = explode(':', $parameters['context']);

		return 0;
	}


	function formConfirm($parameters, &$object, &$action, $hookmanager){
		global $conf, $langs, $user, $confirm, $db;

		$context = explode(':', $parameters['context']);

		if($action == 'addtimespent') {
			$sql = 'UPDATE '.MAIN_DB_PREFIX.'projet_task_time SET thm = '.(float) GETPOST('timespent_thm').' WHERE rowid = '.$object->timespent_id.';';
            $resql = $this->db->query($sql);
		}
		
		return 0;
	}


	public function printFieldListOption($parameters, &$object, &$action, $hookmanager){
		global $conf, $langs, $form, $user, $db, $search_project_ref;

		$currentpage = (explode(':', $parameters['context']));

		if(in_array('projecttasktime', $currentpage)) {

			$moreforfilter .= '<td class="liste_titre">';

			// $formproject = new FormProjets($db);
			// $socid = 0;
			// if ($user->socid) {
			// 	$socid = $user->socid;
			// }
			// $moreforfilter .= $formproject->select_projects(($socid > 0 ? $socid : -1), $search_project_ref, 'search_project_ref', 0, 0, 1, 0, 0, 0, 0, '', 1, 0, 'maxwidth200');
			// $moreforfilter .= '<input class="flat maxwidth50imp" type="text" name="search_project_ref" value="'.$search_project_ref.'">';

			$moreforfilter .= '</td>';

			print $moreforfilter;
		}
	}

	public function printFieldListTitle($parameters=false, &$object, &$action='', $hookmanager)
	{
		global $conf, $langs, $form;

		$currentpage = (explode(':', $parameters['context']));
		
		if(in_array('projecttasktime', $currentpage)) {
			$langs->loadLangs(array('salaries'));

			print_liste_field_titre($langs->trans('THM'), $_SERVER['PHP_SELF'], "", '', $param, 'class="right"', $sortfield, $sortorder);
		}
	}

	public function printFieldListValue($parameters=false, &$object, &$action='', $hookmanager)
	{
		global $conf, $user, $db;

		$currentpage = (explode(':', $parameters['context']));

		if (empty($conf->thmtasktime->enabled)) return 0;

		if(in_array('projecttasktime', $currentpage)) {

			$sc = '';
			$obj = $parameters['obj'];

			global $action;

			$sc .= '<td class="nocellnopadd nowraponall right">';

			if (($action == 'editline' && $_GET['lineid'] == $obj->rowid) || ($action == 'createtime' && !$obj->rowid)) {
				$sc .= '<input size="5" type="number" class="width75 thmtasktime_timespent_thm" name="timespent_thm" value="'.price2num(GETPOST('timespent_thm') ?GETPOST('timespent_thm') : $obj->thm).'">';

			} else {
				$sc .= ($obj->thm != '' ?price($obj->thm, '', $langs, 1, -1, -1, $conf->currency) : '');
			}

			$sc .= '</td>';

			$this->resprints = $sc;
		}
	}


	function formObjectOptions($parameters, &$object, &$action, $hookmanager){
		global $conf, $langs, $user, $confirm, $db;

		$context = explode(':', $parameters['context']);

		if(in_array('projecttasktime', $context)) {
			?>
			<script type="text/javascript">
		        jQuery(document).ready(function() {
		        	if($('table:not(.liste) select#userid').length > 0) {
		        		thmtasktime_getThmUser();
		        	}
		            $('table:not(.liste) select#userid').change(function() {
		                thmtasktime_getThmUser();
		            });
		        });

		        function thmtasktime_getThmUser(){
		            var userid     = $('select#userid').val();

		            $.ajax({
		                url:'<?php echo dol_escape_js(dol_buildpath("/thmtasktime/ajax.php",1)); ?>',
		                type:"POST",
		                data:{'userid':userid, 'action':'getthm'},
		                success:function(ajaxr){
		                    var result = $.parseJSON(ajaxr);
		                    
	                        $('table:not(.liste) .thmtasktime_timespent_thm').val(result.thm);
		                }
		            });
		        }
		    </script>
			<?php
		}
		return 0;
	}
}
