<?php

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', array(
                'tx_abtestpages_b_id' => array (
                        'exclude' => 1,
                        'label' => 'LLL:EXT:abtestpages/Resources/Private/Language/locallang_db.xlf:pages.tx_abtestpages_b_id',
                        'config' => array (
                                'type' => 'group',
                                'internal_type' => 'db',
                                'allowed' => 'pages',
                                'maxitems' => 1,
                                'size' => 1
                        )
                ),
                'tx_abtestpages_cookie_time' => array (
                        'exclude' => 1,  
                        'label' => 'LLL:EXT:abtestpages/Resources/Private/Language/locallang_db.xlf:pages.tx_abtestpages_cookie_time',
                        'config' => array (
                                'type' => 'select',
                                'renderType' => 'selectSingle',
                                'items' => array (
                                        ['LLL:EXT:abtestpages/Resources/Private/Language/locallang_db.xlf:cookie_1_month', 2419200],
                                        ['LLL:EXT:abtestpages/Resources/Private/Language/locallang_db.xlf:cookie_1_week', 604800],
                                        ['LLL:EXT:abtestpages/Resources/Private/Language/locallang_db.xlf:cookie_1_day', 86400],
                                        ['LLL:EXT:abtestpages/Resources/Private/Language/locallang_db.xlf:cookie_12_day', 43200],
                                        ['LLL:EXT:abtestpages/Resources/Private/Language/locallang_db.xlf:cookie_1_hour', 3600],
                                        ['LLL:EXT:abtestpages/Resources/Private/Language/locallang_db.xlf:cookie_1_minute', 60]
                                )
                        )
                ),
                'tx_abtestpages_header' => array (
                        'exclude' => 1,
                        'label' => 'LLL:EXT:abtestpages/Resources/Private/Language/locallang_db.xlf:pages.tx_abtestpages_header',
                        'config' => array (
                                'type' => 'text'
                        )
                )
	));

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', '--palette--;LLL:EXT:abtestpages/Resources/Private/Language/locallang_db.xlf:palette_title;tx_abtestpages', '', 'after:subtitle');

	$GLOBALS['TCA']['pages']['palettes']['tx_abtestpages'] = array(
		'showitem' => 'tx_abtestpages_b_id,--linebreak--,tx_abtestpages_header,tx_abtestpages_cookie_time'
	);

?>