<?php
namespace Drupal\axlrnt_custom\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

Class ExtendedSiteInformationForm extends SiteInformationForm {

  /**
   * @{inheritdoc}
   *
   * Extending the parent buildform of site information form and adding a field 'site api key'
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    $form = parent::buildForm($form, $form_state);
    $form['site_information']['siteapikey'] = [
      '#type' => 'textfield',
      '#title' => t('Site API Key'),
      '#default_value' => $site_config->get('siteapikey') ?: 'No API ket yet',
      '#description' => t("Custom field to the site API key"),
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('system.site')
      ->set('siteapikey', $form_state->getValue('siteapikey'))
      ->save();
    $message = t('The Site API Key has been saved as :siteapikey', array(':siteapikey' => $form_state->getValue('siteapikey')));
    $actions = $this->messenger()->addStatus($message);
    parent::submitForm($form, $form_state);
  }

}
