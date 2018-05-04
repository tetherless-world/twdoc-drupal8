<?php

namespace Drupal\twdocs\Form;

// Need this for base class of the form.
use Drupal\Core\Form\ConfigFormBase;

use Drupal\Core\Form\FormStateInterface;

// Necessary for URL.
use Drupal\Core\Url;

/**
 * Form with the settings for the module.
 */
class TWDocsSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'twdocs_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'twdocs.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('twdocs.settings');

    $form['settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('TW Docs settings'),
      '#collapsible' => FALSE,
    ];

    $form['settings']['baseuri'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Base URI for Document Store:'),
      '#default_value' => $config->get('baseuri'),
      '#description' => $this->t('Location where media will be uploaded and semantic information stored'),
    ];
    $form['settings']['serviceid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Service ID:'),
      '#default_value' => $config->get('serviceid'),
      '#description' => $this->t('The service identifier the module should use when talking to the media manager.'),
    ];
    $form['settings']['apikey'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key:'),
      '#default_value' => $config->get('apikey'),
      '#description' => $this->t('The API key needed for hashing the request for authentication purposes.'),
    ];
    $form['settings']['defaultdocpage'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Default Document Page:'),
      '#default_value' => $config->get('defaultdocpage'),
      '#description' => $this->t('The default document page when one does not exist for the media file.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Check if automatically managed style sheet is posible.
    if ($form_state->getValue('baseuri') == "") {
      $form_state->setErrorByName('baseuri', $this->t('The base URI for media must be specified in order to upload media and store information'));
    }
    if ($form_state->getValue('serviceid') == "") {
      $form_state->setErrorByName('serviceid', $this->t('The service ID is required in order to upload media and store information'));
    }
    if ($form_state->getValue('apikey') == "") {
      $form_state->setErrorByName('apikey', $this->t('The api key is required in order to upload media and store information'));
    }
    if ($form_state->getValue('defaultdocpage') == "") {
      $form_state->setErrorByName('defaultdocpage', $this->t('The default document page is required in order to display semantic representation of the media'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $errors = $form_state->getErrors();
    if (count($errors) == 0) {
      $config = $this->config('twdocs.settings');
      $config->set('baseuri', $form_state->getValue('baseuri'))
        ->set('serviceid', $form_state->getValue('serviceid'))
        ->set('apikey', $form_state->getValue('apikey'))
        ->set('defaultdocpage', $form_state->getValue('defaultdocpage'));
      $config->save();
      parent::submitForm($form, $form_state);
    }
  }
}

