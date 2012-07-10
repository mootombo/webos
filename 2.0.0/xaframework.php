<?php
/**
 * @version SVN: $Id: builder.php 469 2011-07-29 19:03:30Z elkuku $
 * @package    Bootstrap
 * @subpackage Base
 * @author     OSTree Team {@link http://www.ostree.org}
 * @author     Created on 16-Jan-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

jimport('joomla.plugin.plugin');

/**
 * System Plugin.
 *
 * @package    Bootstrap
 * @subpackage Plugin
 */
class plgSystemXaframework extends JPlugin
{
    /**
     * Constructor
     *
     * @param object $subject The object to observe
     * @param array $config  An array that holds the plugin configuration
     */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
    }

    public function onBeforeRender()
    {
        $app = JFactory::getApplication();

        $onlyFrontside = $this->params->get("onlyFrontside", TRUE);

        //ignore admin
        if ($onlyFrontside && $app->isAdmin()) {
            return true;
        }
        $doc = JFactory::getDocument();

        $onlyHTML = $this->params->get("onlyHTML", TRUE);
        // ignore non html
        if ($onlyHTML && $doc->getType() != 'html') {
            return true;
        }
        // ignore modal pages or other incomplete pages
        $notModal = $this->params->get("notModal", TRUE);
        $nogo = array('component', 'raw');
        if ($notModal && in_array(JRequest::getString('tmpl'), $nogo)) {
            return true;
        }
        $loadCSS = $this->params->get("loadCSS", TRUE);
        if ($loadCSS) {
            $doc->addStyleSheet(JURI::root(true) . '/media/xaframework/bootstrap/css/bootstrap.css');
            $doc->addStyleSheet(JURI::root(true) . '/media/xaframework/bootstrap/css/bootstrap-responsive.css');
        }
        $loadFontAwesome = $this->params->get("loadFontAwesome", TRUE);
        if ($loadFontAwesome) {
            $doc->addStyleSheet(JURI::root(true) . '/media/xaframework/bootstrap/css/font-awesome.css');
            $doc->addStyleSheet(JURI::root(true) . '/media/xaframework/bootstrap/css/bootstrap-responsive.css');
        }
        $loadExtendedCSS = $this->params->get("loadExtendedCSS", TRUE);
        if ($loadExtendedCSS) {
            $doc->addStyleSheet(JURI::root(true) . '/media/xaframework/bootstrap/css/override.css');
            $doc->addStyleSheet(JURI::root(true) . '/media/xaframework/bootstrap/css/custom.css');
        }
        $loadGoogleCodePrettify = $this->params->get("loadGoogleCodePrettify", TRUE);
        if ($loadGoogleCodePrettify) {
			$doc->addScript(JURI::root(true) . '/media/xaframework/google/prettify.js');
			$doc->addStyleSheet(JURI::root(true) . '/media/xaframework/google/prettify.css');
        }
        $loadJS = $this->params->get("loadJS", TRUE);
        if ($loadJS) {

            $loadJQuery = $this->params->get("loadJQuery", TRUE);
            if ($loadJQuery) {
                $jQueryFromLocal = $this->params->get("jQueryFromLocal", TRUE);
                if ($jQueryFromLocal) {
                    $doc->addScript(JURI::root(true) . '/media/xaframework/jquery/jquery-1.7.2.min.js');
                }else{
                    $doc->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
                }
            }
            $doc->addScript(JURI::root(true) . '/media/xaframework/bootstrap/js/bootstrap.min.js');
        }

    }

}
