<?php

namespace Drupal\axlrnt_custom\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pagejson Controller
 */
class PagejsonController extends ControllerBase {

  /**
   * @{inheritdoc}
   */
  public function content($siteapikey = NULL, $node = NULL, Request $request) {

    //creating the Jsonresponse object
    $response = new JsonResponse();

    //fetching the system.site config to validate the siteapikey
    $config = \Drupal::config('system.site');

    //if the siteapikey fails to validate, return access denied
    if ($siteapikey !== $config->get('siteapikey')) {
      $data = t('Access Denied');
      $response->setData($data);
    } else {

      //load the node from the arguments
      $node_data = Node::load($node);

      //if the node is of type page and the node id is valid , retrieve the details
      if ( $node_data !== NULL && $node_data->get('type')->getValue()[0]['target_id'] == 'page') {
        $data = [
          node_json_data => [
            'title' => $node_data->get('title')->getValue()[0]['value'],
            'description' => $node_data->get('body')->getValue()[0]['value'],
          ]
        ];

        $response->setData($data);
      } else {
        $data = t('Access Denied');
        $response->setData($data);
      }
    }



    return $response;
  }
}
