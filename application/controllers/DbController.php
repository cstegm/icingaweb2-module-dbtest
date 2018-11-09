<?php
namespace Icinga\Module\Dbtest\Controllers;
#use Icinga\Web\Controller;
use Icinga\Module\Monitoring\Backend\MonitoringBackend;
use Icinga\Module\Monitoring\DataView\DataView;
use Icinga\Module\Monitoring\Controller;
use Icinga\Data\Filter\Filter;

class DbController extends Controller
{
  public function indexAction()
  {
    // Monitoring Backend holen
   

    // Icinga\Module\Monitoring\DataView  <-- da finde ich die spalten für servicestatus z.b customvars beginnen mit _

    $services = MonitoringBackend::instance()->select()->from("servicestatus",["host_name","service_description","service_state","service_output"]);
    
    // filtern 
    $services->where("service_description","swap");

    foreach($services as $service){
      var_dump($service);
    }
    //$this->view->test = "Hallo Welt ";
  }
  public function filterAction(){
	// filter über url:
	// http://127.0.0.1/icingaweb2/dbtest/db/filter?service_description=swap
    
    $services = MonitoringBackend::instance()->select()->from("servicestatus",["host_name","service_description","service_state","service_output"]);

    // filtern 
    
    $this->filterQuery($services);

    #foreach($services as $service){
    #  var_dump($service);
    #}
    $this->view->services=$services;
  }
  protected function filterQuery(DataView $dataView)
    {
        $this->setupFilterControl($dataView, null, null, array(
            'format', // handleFormatRequest()
            'stateType', // hostsAction() and servicesAction()
            'addColumns', // addColumns()
            'problems', // servicegridAction()
            'flipped' // servicegridAction()
        ));
        $this->handleFormatRequest($dataView);
        return $dataView;
    }
}
