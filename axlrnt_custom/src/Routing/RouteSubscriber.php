<?php
namespace Drupal\axlrnt_custom\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the route events
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * @{inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {

    //if the route is of the site information form, set the default form to custom
    if ($route = $collection->get('system.site_information_settings'))
      $route->setDefault('_form', 'Drupal\axlrnt_custom\Form\ExtendedSiteInformationForm');

  }

}
