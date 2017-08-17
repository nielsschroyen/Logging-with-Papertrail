<?php
namespace PapertrailForWP;
require_once 'papertrail-wordpress-wrapper.php';
require_once 'papertrail-settings-validator.php';

class PapertrailSettingsAdminValidator{

  public function __construct($settings, $originalValues){
    $this->settings = $settings;
    $this->originalValues = $originalValues;
    $this->sanitized_fields = [];
  }

  public function validate(){
    $this->sanitize();

    $validator = new PapertrailSettingsValidator($this->sanitized_fields);
    $errors = $validator->validate();

    foreach ($errors as $error) {
      $this->add_error_message($error);
      $this->restore_original_value($error);
    }
    return $this->sanitized_fields;
  }

  private function sanitize(){
    foreach (PapertrailSettingsValidator::$Fields as &$field) {
      $this->sanitize_field($field);
    }
  }

  private function sanitize_field($field){
    if(isset($this->settings[$field["Id"]])){
      $this->sanitized_fields[$field["Id"]] = WPWrapper::getInstance()->sanitize_text_field($this->settings[$field["Id"]]);
    }
  }

  private function add_error_message($error){
    $errorMessages =  ["NotEmpty"=>"cannot be empty"];

    $errorId = $error["field"]["Id"].$error["error"];
    $errorMessage = $error["field"]["Name"] ." " . $errorMessages[$error["error"]];

    add_settings_error($errorId ,'validationError', $errorMessage ,'error');
  }

  private function restore_original_value($error){
    $fieldId = $error["field"]["Id"];
    if(isset($this->originalValues[$fieldId])){
      $this->sanitized_fields[$fieldId] =  $this->originalValues[$fieldId];
    }
    else{
      if(isset($this->sanitized_fields[$fieldId])){
          unset($this->sanitized_fields[$fieldId]);
      }
    }
  }
}