<?php

require_once 'badgefield.civix.php';
use CRM_Badgefield_ExtensionUtil as E;

function badgefield_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  if ($objectName == 'Participant' && ($op == 'create' || $op == 'edit')) {
    $feeLevel = explode(' ', $objectRef->fee_level)[0];
    $membership = civicrm_api3('Membership', 'get', array(
      'contact_id' => $objectRef->contact_id,
      'status_id' => ['IN' => ["New", "Current", "Grace"]],
    ));
    if ($membership['count'] > 0) {
      foreach ($membership['values'] as $m) {
        if ($m['membership_type_id'] == 7) {
          $mem = 'L';
        }
        else {
          $mem = 'M';
        }
      }
    }
    else {
      $mem = '';
    }
    $role = '';
    foreach ($objectRef->role_id as $r) {
      switch ($r) {
        case 21:
          $role .= ' B';
          break;

        case 12:
          $role .= ' C';
          break;

        case 4:
          $role .= ' K';
          break;

        case 7:
          $role .= ' S';
          break;

        case 2:
          $role .= ' V';
          break;

        case 20:
          $role .= ' W';
          break;

        default:
          $role .= '';
          break;
      }
    }
    $customFieldID = civicrm_api3('CustomField', 'get', array(
      'name' => 'badge_field',
    ));
    $custom = 'custom_' . $customFieldID['id'];
    require_once 'CRM/Core/BAO/CustomValueTable.php';
    $set_params = array(
      'entityID' => $objectId,
      $custom => $feeLevel . ' ' . $mem . $role,
    );
    CRM_Core_BAO_CustomValueTable::setValues($set_params);
  }
}
/**
 * hook_civicrm_pre()
 */
/*function badgefield_civicrm_pre($op, $objectName, $id, &$params) {
  if ($objectName == 'Participant' && ($op == 'create' || $op == 'edit')) {
    $feeLevel = explode(' ', $params['fee_level'])[0];
    $membership = civicrm_api3('Membership', 'get', array(
      'contact_id' => $params['contact_id'],
      'status_id' => ['IN' => ["New", "Current", "Grace"]],
    ));
    if ($membership['count'] > 0) {
      foreach ($membership['values'] as $m) {
        if ($m['membership_type_id'] == 7) {
          $mem = 'L';
        }
        else {
          $mem = 'M';
        }
      }
    }
    else {
      $mem = '';
    }
    $role = '';
    foreach ($params['role_id'] as $r) {
      switch ($r) {
        case 21:
          $role .= ' B';
          break;

        case 12:
          $role .= ' C';
          break;

        case 4:
          $role .= ' K';
          break;

        case 7:
          $role .= ' S';
          break;

        case 2:
          $role .= ' V';
          break;

        case 20:
          $role .= ' W';
          break;

        default:
          $role .= '';
          break;
      }
    }
    $customFieldID = civicrm_api3('CustomField', 'get', array(
      'name' => 'badge_field',
    ));
    $custom = 'custom_' . $customFieldID['id'];
    require_once 'CRM/Core/BAO/CustomValueTable.php';
    $set_params = array(
      'entityID' => $id,
      $custom => $feeLevel . ' ' . $mem . $role,
    );
    CRM_Core_BAO_CustomValueTable::setValues($set_params);
  }
}*/

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function badgefield_civicrm_config(&$config) {
  _badgefield_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function badgefield_civicrm_xmlMenu(&$files) {
  _badgefield_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function badgefield_civicrm_install() {
  _badgefield_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function badgefield_civicrm_postInstall() {
  _badgefield_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function badgefield_civicrm_uninstall() {
  _badgefield_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function badgefield_civicrm_enable() {
  _badgefield_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function badgefield_civicrm_disable() {
  _badgefield_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function badgefield_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _badgefield_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function badgefield_civicrm_managed(&$entities) {
  _badgefield_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function badgefield_civicrm_caseTypes(&$caseTypes) {
  _badgefield_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function badgefield_civicrm_angularModules(&$angularModules) {
  _badgefield_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function badgefield_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _badgefield_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function badgefield_civicrm_entityTypes(&$entityTypes) {
  _badgefield_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function badgefield_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function badgefield_civicrm_navigationMenu(&$menu) {
  _badgefield_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _badgefield_civix_navigationMenu($menu);
} // */
