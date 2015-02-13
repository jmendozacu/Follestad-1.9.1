<?php
#########################################################################################################################################################
# NOTICE - READ ME!!!
#########################################################################################################################################################
/**

This file is only a copy of the original file. A stack trace / exception containing this file does NOT indicate an error with Extendware.
No source code content has been modified from the original file. The only change has been in the hierachy of the classes.
Here is information about this file: 

Original Class: Mage_Adminhtml_Block_Notification_Window
Original File: /home/follexln/public_html/dev/app/code/core/Mage/Adminhtml/Block/Notification/Window.php

*/
#########################################################################################################################################################




?><?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class  Mage_Adminhtml_Block_Notification_WindowOverriddenClass  extends Mage_Adminhtml_Block_Notification_Toolbar
{
    /**
     * XML path of Severity icons url
     */
    const XML_SEVERITY_ICONS_URL_PATH  = 'system/adminnotification/severity_icons_url';

    /**
     * Severity icons url
     *
     * @var string
     */
    protected $_severityIconsUrl;

    /**
     * Is available flag
     *
     * @var bool
     */
    protected $_available = null;

    /**
     * Initialize block window
     *
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setHeaderText($this->escapeHtml($this->__('Incoming Message')));
        $this->setCloseText($this->escapeHtml($this->__('close')));
        $this->setReadDetailsText($this->escapeHtml($this->__('Read details')));
        $this->setNoticeText($this->escapeHtml($this->__('NOTICE')));
        $this->setMinorText($this->escapeHtml($this->__('MINOR')));
        $this->setMajorText($this->escapeHtml($this->__('MAJOR')));
        $this->setCriticalText($this->escapeHtml($this->__('CRITICAL')));


        $this->setNoticeMessageText($this->escapeHtml($this->getLastNotice()->getTitle()));
        $this->setNoticeMessageUrl($this->escapeUrl($this->getLastNotice()->getUrl()));

        switch ($this->getLastNotice()->getSeverity()) {
            default:
            case Mage_AdminNotification_Model_Inbox::SEVERITY_NOTICE:
                $severity = 'SEVERITY_NOTICE';
                break;
            case Mage_AdminNotification_Model_Inbox::SEVERITY_MINOR:
                $severity = 'SEVERITY_MINOR';
                break;
            case Mage_AdminNotification_Model_Inbox::SEVERITY_MAJOR:
                $severity = 'SEVERITY_MAJOR';
                break;
            case Mage_AdminNotification_Model_Inbox::SEVERITY_CRITICAL:
                $severity = 'SEVERITY_CRITICAL';
                break;
        }

        $this->setNoticeSeverity($severity);
    }

    /**
     * Can we show notification window
     *
     * @return bool
     */
    public function canShow()
    {
        if (!is_null($this->_available)) {
            return $this->_available;
        }

        if (!Mage::getSingleton('admin/session')->isFirstPageAfterLogin()) {
            $this->_available = false;
            return false;
        }

        if (!$this->isOutputEnabled('Mage_AdminNotification')) {
            $this->_available = false;
            return false;
        }

        if (!$this->_isAllowed()) {
            $this->_available = false;
            return false;
        }

        if (is_null($this->_available)) {
            $this->_available = $this->isShow();
        }
        return $this->_available;
    }


    /**
     * Return swf object url
     *
     * @return string
     */
    public function getObjectUrl()
    {
        return $this->_getHelper()->getPopupObjectUrl();
    }

    /**
     * Retrieve Last Notice object
     *
     * @return Mage_AdminNotification_Model_Inbox
     */
    public function getLastNotice()
    {
        return $this->_getHelper()->getLatestNotice();
    }

    /**
     * Retrieve severity icons url
     *
     * @return string
     */
    public function getSeverityIconsUrl()
    {
        if (is_null($this->_severityIconsUrl)) {
            $this->_severityIconsUrl =
                (Mage::app()->getFrontController()->getRequest()->isSecure() ? 'https://' : 'http://')
                . sprintf(Mage::getStoreConfig(self::XML_SEVERITY_ICONS_URL_PATH), Mage::getVersion(),
                    $this->getNoticeSeverity())
            ;
        }
        return $this->_severityIconsUrl;
    }

    /**
     * Retrieve severity text
     *
     * @return string
     */
    public function getSeverityText()
    {
        return strtolower(str_replace('SEVERITY_', '', $this->getNoticeSeverity()));
    }

    /**
     * Check if current block allowed in ACL
     *
     * @param string $resourcePath
     * @return bool
     */
    protected function _isAllowed()
    {
        if (!is_null($this->_aclResourcePath)) {
            return Mage::getSingleton('admin/session')
                ->isAllowed('admin/system/adminnotification/show_toolbar');
        }
        else {
            return true;
        }
    }
}

?><?php
if (class_exists('Extendware_EWCore_Block_Override_Mage_Adminhtml_Notification_Window_Bridge', false) === false) {
	abstract class Extendware_EWCore_Block_Override_Mage_Adminhtml_Notification_Window_Bridge extends Mage_Adminhtml_Block_Notification_WindowOverriddenClass  {

	}
} else {
	if (class_exists('Mage', false) === true) {
		Mage::log('Bridge class (Extendware_EWCore_Block_Override_Mage_Adminhtml_Notification_Window_Bridge) encountered twice');
	}
}
?><?php
class Mage_Adminhtml_Block_Notification_Window extends Extendware_EWCore_Block_Override_Mage_Adminhtml_Notification_Window {

}
?>