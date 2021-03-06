<?php

/**
 *
 * bareos-webui - Bareos Web-Frontend
 *
 * @link      https://github.com/bareos/bareos-webui for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Bareos GmbH & Co. KG (http://www.bareos.org/)
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

namespace Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

class MediaController extends AbstractActionController
{
   protected $mediaModel;

   public function indexAction()
   {
      if($_SESSION['bareos']['authenticated'] == true && $this->SessionTimeoutPlugin()->timeout()) {

            $volumes = $this->getMediaModel()->getVolumes();

            return new ViewModel(
               array(
                  'volumes' => $volumes,
               )
            );

      }
      else {
            return $this->redirect()->toRoute('auth', array('action' => 'login'));
      }
   }

   public function detailsAction()
   {
      if($_SESSION['bareos']['authenticated'] == true && $this->SessionTimeoutPlugin()->timeout()) {

         $volumename = $this->params()->fromRoute('id');
         $volume = $this->getMediaModel()->getVolume($volumename);

         return new ViewModel(array(
            'media' => $volume,
         ));

      }
      else {
         return $this->redirect()->toRoute('auth', array('action' => 'login'));
      }
   }

   public function getDataAction()
   {
      if($_SESSION['bareos']['authenticated'] == true && $this->SessionTimeoutPlugin()->timeout()){

         $data = $this->params()->fromQuery('data');

         if($data == "all") {
            $result = $this->getMediaModel()->getVolumes();
         }
         else {
            $result = null;
         }

         $response = $this->getResponse();
         $response->getHeaders()->addHeaderLine('Content-Type','application/json');

         if(isset($result)) {
            $response->setContent(JSON::encode($result));
         }

         return $response;

      }
      else {
         return $this->redirect()->toRoute('auth', array('action' => 'login'));
      }
   }

   public function getMediaModel()
   {
      if(!$this->mediaModel) {
         $sm = $this->getServiceLocator();
         $this->mediaModel = $sm->get('Media\Model\MediaModel');
      }
      return $this->mediaModel;
   }

}
