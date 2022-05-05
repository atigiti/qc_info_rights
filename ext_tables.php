<?php
defined('TYPO3_MODE') || die();

use Qc\QcInfoRights\Report\QcInfoRightsReport;

call_user_func(static function() {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_qcinforights_domain_model_qcinforights', 'EXT:qc_info_rights/Resources/Private/Language/locallang_csh_tx_qcinforights_domain_model_qcinforights.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_qcinforights_domain_model_qcinforights');
});

// Extend Module INFO with new Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
    'web_info',
    \Qc\QcInfoRights\Report\AccessRightsReport::class,
    '',
    'LLL:EXT:qc_info_rights/Resources/Private/Language/locallang.xlf:mod_qcInfoRight'
);

// Extend Module INFO with new Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
    'web_info',
    \Qc\QcInfoRights\Report\GroupsReport::class,
    '',
    'groupes',

);

// Extend Module INFO with new Element
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
    'web_info',
    \Qc\QcInfoRights\Report\UsersReport::class,
    '',
    'utilisateurs'
);

// Initialize Context Sensitive Help (CSH)
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'qcinforights',
    'EXT:qc_info_rights/Resources/Private/Language/Module/locallang_csh.xlf'
);
