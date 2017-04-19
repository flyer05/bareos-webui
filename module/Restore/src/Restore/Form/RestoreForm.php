<?php

/**
*
* bareos-webui - Bareos Web-Frontend
*
* @link      https://github.com/bareos/bareos-webui for the canonical source repository
* @copyright Copyright (c) 2013-2015 dass-IT GmbH (http://www.dass-it.de/)
* @license   GNU Affero General Public License (http://www.gnu.org/licenses/)
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
*/

namespace Restore\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class RestoreForm extends Form
{

   protected $restore_params;
   //protected $jobs;
   protected $clients;
   protected $filesets;
   protected $restorejobs;
   protected $jobids;
   protected $backups;

   public function __construct($restore_params=null, /*$jobs=null,*/ $clients=null, $filesets=null, $restorejobs=null, $jobids=null, $backups=null)
   {

      parent::__construct('restore');

      $this->restore_params = $restore_params;
      //$this->jobs = $jobs;
      $this->clients = $clients;
      $this->filesets = $filesets;
      $this->restorejobs = $restorejobs;
      $this->jobids = $jobids;
      $this->backups = $backups;

/*
      // Job
      if(isset($restore_params['jobid'])) {
         $this->add(array(
            'name' => 'jobid',
            'type' => 'select',
            'options' => array(
               'label' => 'Job',
               'empty_option' => 'Please choose a job',
               'value_options' => $this->getJobList()
            ),
            'attributes' => array(
               'id' => 'jobid',
               'value' => $restore_params['jobid']
            )
         ));
      }
      else {
         $this->add(array(
            'name' => 'jobid',
            'type' => 'select',
            'options' => array(
               'label' => 'Job',
               'empty_option' => 'Please choose a job',
               'value_options' => $this->getJobList()
            ),
            'attributes' => array(
               'id' => 'jobid'
            )
         ));
      }
*/

      // Zálohovacie úloghy
      if(isset($restore_params['jobid'])) {
         $this->add(array(
            'name' => 'backups',
            'type' => 'select',
            'options' => array(
               'label' => 'Zálohovacie úlohy',
               //'empty_option' => 'Prosím vyberte zálohu',
               'value_options' => $this->getBackupList()
            ),
            'attributes' => array(
               'class' => 'form-control selectpicker show-tick',
               'data-live-search' => 'true',
               'id' => 'jobid',
               'value' => $restore_params['jobid']
            )
         ));
      }
      else {
         $this->add(array(
            'name' => 'backups',
            'type' => 'select',
            'options' => array(
               'label' => 'Zálohy',
               //'empty_option' => 'Prosím vyberte zálohu',
               'value_options' => $this->getBackupList()
            ),
            'attributes' => array(
               'class' => 'form-control selectpicker show-tick',
               'data-live-search' => 'true',
               'id' => 'jobid'
            )
         ));
      }

      // Client
      if(isset($restore_params['client'])) {
         if($restore_params['type'] == "client") {
            $this->add(array(
               'name' => 'client',
               'type' => 'select',
               'options' => array(
                  'label' => 'Klient',
                  //'empty_option' => 'Prosím vyberte klienta',
                  'value_options' => $this->getClientList()
               ),
               'attributes' => array(
                  'class' => 'form-control selectpicker show-tick',
                  'data-live-search' => 'true',
                  'id' => 'client',
                  'value' => $restore_params['client']
               )
            ));
         }
         else {
            $this->add(array(
               'name' => 'client',
               'type' => 'select',
               'options' => array(
                  'label' => 'Klient',
                  //'empty_option' => 'Prosím vyberte klienta',
                  'value_options' => $this->getClientList()
               ),
               'attributes' => array(
                  'class' => 'form-control selectpicker show-tick',
                  'data-live-search' => 'true',
                  'id' => 'client',
                  'value' => $restore_params['client']
               )
            ));
         }
      }
      else {
         $this->add(array(
            'name' => 'client',
            'type' => 'select',
            'options' => array(
               'label' => 'Klient',
               //'empty_option' => 'Prosím vyberte klienta',
               'value_options' => $this->getClientList()
            ),
            'attributes' => array(
               'class' => 'form-control selectpicker show-tick',
               'data-live-search' => 'true',
               'id' => 'client',
               'value' => @array_pop($this->getClientList())
            )
         ));
      }

      // Restore client
      if(isset($restore_params['restoreclient'])) {
         $this->add(array(
            'name' => 'restoreclient',
            'type' => 'select',
            'options' => array(
               'label' => 'Obnoviť na (iného) klienta',
               //'empty_option' => 'Prosím vyberte klienta',
               'value_options' => $this->getClientList()
            ),
            'attributes' => array(
               'class' => 'form-control selectpicker show-tick',
               'data-live-search' => 'true',
               'id' => 'restoreclient',
               'value' => $restore_params['restoreclient']
            )
         ));
      }
      elseif(!isset($restore_params['restoreclient']) && isset($restore_params['client']) ) {
         $this->add(array(
            'name' => 'restoreclient',
            'type' => 'select',
            'options' => array(
               'label' => 'Obnoviť na (iného) klienta',
               //'empty_option' => 'Prosím vyberte klienta',
               'value_options' => $this->getClientList()
            ),
            'attributes' => array(
               'class' => 'form-control selectpicker show-tick',
               'data-live-search' => 'true',
               'id' => 'restoreclient',
               'value' => $restore_params['client']
            )
         ));
      }
      else {
         $this->add(array(
            'name' => 'restoreclient',
            'type' => 'select',
            'options' => array(
               'label' => 'Obnoviť na (iného) klienta',
               //'empty_option' => 'Prosím vyberte klienta',
               'value_options' => $this->getClientList()
            ),
            'attributes' => array(
               'class' => 'form-control selectpicker show-tick',
               'data-live-search' => 'true',
               'id' => 'restoreclient'
            )
         ));
      }

      // Fileset
      if(isset($restore_params['fileset'])) {
         $this->add(array(
            'name' => 'fileset',
            'type' => 'select',
            'options' => array(
               'label' => 'Súborový set',
               'empty_option' => 'Prosím vyberte súborový set',
               'value_options' => $this->getFilesetList()
            ),
            'attributes' => array(
               'id' => 'fileset',
               'value' => $restore_params['fileset']
            )
         ));
      }
      else {
         $this->add(array(
            'name' => 'fileset',
            'type' => 'select',
            'options' => array(
               'label' => 'Súborový set',
               'empty_option' => 'Prosím vyberte súborový set',
               'value_options' => $this->getFilesetList()
            ),
            'attributes' => array(
               'id' => 'fileset'
            )
         ));
      }

      // Restore Job
      if(isset($restore_params['restorejob'])) {
         $this->add(array(
            'name' => 'restorejob',
            'type' => 'select',
            'options' => array(
               'label' => 'Restore job',
               //'empty_option' => 'Prosím vyberte dzob obnovenia',
               'value_options' => $this->getRestoreJobList()
            ),
            'attributes' => array(
               'class' => 'form-control selectpicker show-tick',
               'data-live-search' => 'true',
               'id' => 'restorejob',
               'value' => $restore_params['restorejob']
            )
         ));
      }
      else {
         if(count($this->getRestoreJobList()) == 1) {
            $this->add(array(
               'name' => 'restorejob',
               'type' => 'select',
               'options' => array(
                  'label' => 'Obnoviť úlohu',
                  //'empty_option' => 'Please choose a restore job',
                  'value_options' => $this->getRestoreJobList()
               ),
               'attributes' => array(
                  'class' => 'form-control selectpicker show-tick',
                  'data-live-search' => 'true',
                  'id' => 'restorejob',
                  'value' => @array_pop($this->getRestoreJobList())
               )
            ));
         }
         else {
            $this->add(array(
               'name' => 'restorejob',
               'type' => 'select',
               'options' => array(
                  'label' => 'Obnoviť úlohu',
                  //'empty_option' => 'Please choose a restore job',
                  'value_options' => $this->getRestoreJobList()
               ),
               'attributes' => array(
                  'class' => 'form-control selectpicker show-tick',
                  'data-live-search' => 'true',
                  'id' => 'restorejob'
               )
            ));
         }
      }

      // Merge filesets
      if(isset($restore_params['mergefilesets'])) {
         $this->add(array(
            'name' => 'mergefilesets',
            'type' => 'select',
            'options' => array(
               'label' => 'Zlúčiť všetky súborové sety na klientovi?',
               'value_options' => array(
                     '0' => 'Áno',
                     '1' => 'Nie'
                  )
               ),
            'attributes' => array(
                  'class' => 'form-control selectpicker show-tick',
                  'id' => 'mergefilesets',
                  'value' => $restore_params['mergefilesets']
               )
            )
         );
      }
      else {
         $this->add(array(
            'name' => 'mergefilesets',
            'type' => 'select',
            'options' => array(
               'label' => 'Zlúčiť všetky súborové sety na klientovi?',
               'value_options' => array(
                     '0' => 'Áno',
                     '1' => 'Nie'
                  )
               ),
            'attributes' => array(
                  'class' => 'form-control selectpicker show-tick',
                  'id' => 'mergefilesets',
                  'value' => '0'
               )
            )
         );
      }

      // Merge jobs
      if(isset($restore_params['mergejobs'])) {
         $this->add(array(
            'name' => 'mergejobs',
            'type' => 'select',
            'options' => array(
               'label' => 'Zlúčiť všetky súvisiace úlohy na poslednú úplnú zálohu zvolenej zálohovacej úlohy?',
               'value_options' => array(
                     '0' => 'Áno',
                     '1' => 'Nie'
                  )
               ),
            'attributes' => array(
                  'class' => 'form-control selectpicker show-tick',
                  'id' => 'mergejobs',
                  'value' => $restore_params['mergejobs']
               )
            )
         );
      }
      else {
         $this->add(array(
            'name' => 'mergejobs',
            'type' => 'select',
            'options' => array(
               'label' => 'Merge jobs?',
               'value_options' => array(
                     '0' => 'Áno',
                     '1' => 'Nie'
                  )
               ),
            'attributes' => array(
                  'class' => 'form-control selectpicker show-tick',
                  'id' => 'mergejobs',
                  'value' => '0'
               )
            )
         );
      }

      // Replace
      $this->add(array(
         'name' => 'replace',
         'type' => 'select',
         'options' => array(
            'label' => 'Nahradiť súbory na klientovi?',
            'value_options' => array(
                  'always' => 'vždy',
                  'never' => 'nikdy',
                  'ifolder' => 'ak sú staršie',
                  'ifnewer' => 'ak sú novšie'
               )
            ),
         'attributes' => array(
               'class' => 'form-control selectpicker show-tick',
               'id' => 'replace',
               'value' => 'nikdy'
            )
         )
      );

      // Where
      $this->add(array(
         'name' => 'where',
         'type' => 'text',
         'options' => array(
            'label' => 'Obnoviť miesto na klientovi'
            ),
         'attributes' => array(
            'class' => 'form-control selectpicker show-tick',
            'value' => '/tmp/bareos-restores/',
            'id' => 'where',
            'size' => '30',
            'placeholder' => 'e.g. / or /tmp/bareos-restores/'
            )
         )
      );

      // JobIds hidden
      $this->add(array(
         'name' => 'jobids_hidden',
         'type' => 'Zend\Form\Element\Hidden',
         'attributes' => array(
            'value' => $this->getJobIds(),
            'id' => 'jobids_hidden'
            )
         )
      );

      // JobIds display (for debugging)
      $this->add(array(
         'name' => 'jobids_display',
         'type' => 'text',
         'options' => array(
            'label' => 'Súvisiace úlohy po poslednom úplnom obnovení'
            ),
         'attributes' => array(
            'value' => $this->getJobIds(),
            'id' => 'jobids_display',
            'readonly' => true
            )
         )
      );

      // filebrowser checked files
      $this->add(array(
         'name' => 'checked_files',
         'type' => 'Zend\Form\Element\Hidden',
         'attributes' => array(
            'value' => '',
            'id' => 'checked_files'
            )
         )
      );

      // filebrowser checked directories
      $this->add(array(
         'name' => 'checked_directories',
         'type' => 'Zend\Form\Element\Hidden',
         'attributes' => array(
            'value' => '',
            'id' => 'checked_directories'
            )
         )
      );

      // Submit button
      $this->add(array(
         'name' => 'submit',
         'type' => 'submit',
         'attributes' => array(
            'value' => 'Obnoviť',
            'id' => 'submit'
         )
      ));

   }

   /**
    *
    */
   private function getJobList()
   {
      $selectData = array();
      if(!empty($this->jobs)) {
         foreach($this->jobs as $job) {
            $selectData[$job['jobid']] = $job['jobid'] . " - " . $job['name'];
         }
      }
      return $selectData;
   }

   /**
    *
    */
   private function getBackupList()
   {
      $selectData = array();
      if(!empty($this->backups)) {

         foreach($this->backups as $backup) {
            switch($backup['level']) {
               case 'I':
                  $level = "Incremental";
                  break;
               case 'D':
                  $level = "Differential";
                  break;
               case 'F':
                  $level = "Full";
                  break;
            }
            $selectData[$backup['jobid']] = "(" . $backup['jobid']  . ") " . $backup['starttime'] . " - " . $backup['name'] . " - " . $level;
         }
      }
      return $selectData;
   }

   /**
    *
    */
   private function getJobIds()
   {
      return $this->jobids;
   }

   /**
    *
    */
   private function getClientList()
   {
      $selectData = array();
      if(!empty($this->clients)) {
         foreach($this->clients as $client) {
            $selectData[$client['name']] = $client['name'];
         }
      }
      ksort($selectData);
      return $selectData;
   }

   /**
    *
    */
   private function getFilesetList()
   {
      $selectData = array();
      if(!empty($this->filesets)) {
         foreach($this->filesets as $fileset) {
            $selectData[$fileset['name']] = $fileset['name'];
         }
      }
      return $selectData;
   }

   /**
    *
    */
   private function getRestoreJobList()
   {
      $selectData = array();
      if(!empty($this->restorejobs)) {
         foreach($this->restorejobs as $restorejob) {
            $selectData[$restorejob['name']] = $restorejob['name'];
         }
      }
      return $selectData;
   }

}
