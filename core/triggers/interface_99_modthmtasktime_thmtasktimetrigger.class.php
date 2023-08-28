<?php

require_once DOL_DOCUMENT_ROOT.'/core/triggers/dolibarrtriggers.class.php';


/**
 *  Class of triggers 
 */
class Interfacethmtasktimetrigger extends DolibarrTriggers
{

    /**
     * Constructor
     *
     *  @param      DoliDB      $db     Database handler
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->name = preg_replace('/^Interface/i', '', get_class($this));
        $this->family = "NextConcept";
        $this->description = "Triggers of this module are empty functions.";
        $this->version   = 'development';
        $this->picto = 'thmtasktime@thmtasktime';
    }

    /**
     * Function called when a Dolibarrr security audit event is done.
     * All functions "runTrigger" are triggered if file is inside directory htdocs/core/triggers or htdocs/module/code/triggers (and declared)
     *
     * @param string        $action     Event action code
     * @param Object        $object     Object
     * @param User          $user       Object user
     * @param Translate     $langs      Object langs
     * @param conf          $conf       Object conf
     * @return int                      <0 if KO, 0 if no triggered ran, >0 if OK
     */
    public function runTrigger($action, $object, User $user, Translate $langs, Conf $conf)
    {
        global $conf;

        if($action == 'TASK_TIMESPENT_MODIFY' || $action == 'TIMESPENT_MODIFY') {

            $tablename = (floatval(DOL_VERSION) > 18) ? 'element_time' : 'projet_task_time';

            $sql = 'UPDATE '.MAIN_DB_PREFIX.$tablename.' SET thm = '.(float) GETPOST('timespent_thm').' WHERE rowid = '.$object->timespent_id.';';
            $resql = $this->db->query($sql);
        }

        return 1;
    }

}
