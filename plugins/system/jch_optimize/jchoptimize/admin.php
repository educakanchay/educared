<?php

/**
 * JCH Optimize - Plugin to aggregate and minify external resources for
 * optmized downloads
 * @author Samuel Marshall <sdmarshall73@gmail.com>
 * @copyright Copyright (c) 2010 Samuel Marshall
 * @license GNU/GPLv3, See LICENSE file
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */
defined('_JCH_EXEC') or die('Restricted access');

class JchOptimizeAdmin
{

        protected $bBackend;
        protected $params;

        /**
         * 
         * @param type $params
         * @param type $bBackend
         */
        public function __construct($params, $bBackend = FALSE)
        {
                $this->params   = $params;
                $this->bBackend = $bBackend;
        }

        /**
         * 
         * @param type $oObj
         * @param type $iItemid
         * @param type $sCss
         * @return type
         */
        public function getAdminLinks($oObj, $iItemid, $sCss = '')
        {
                JCH_DEBUG ? JchPlatformProfiler::mark('beforeGetAdminLinks plgSystem (JCH Optimize)') : null;
                                
                if (!defined('JCH_VERSION'))
                {
                        define('JCH_VERSION', '4.2.0');
                }
                
                $sId       = md5('getAdminLinks' . JCH_VERSION . serialize($iItemid . $this->params->get('pro_searchBody')));
                $aFunction = array($this, 'generateAdminLinks');
                $aArgs     = array($oObj, $sCss);
                $iLifeTime = (int) $this->params->get('lifetime', '30') * 24 * 60 * 60;

                $aLinks = JchPlatformCache::getCallbackCache($sId, $iLifeTime, $aFunction, $aArgs);

                JCH_DEBUG ? JchPlatformProfiler::mark('afterGetAdminLinks plgSystem (JCH Optimize)') : null;

                return $aLinks;
        }

        /**
         * 
         * @param type $oObj
         * @param type $sCss
         * @return type
         */
        public function generateAdminLinks($oObj, $sCss)
        {
                JCH_DEBUG ? JchPlatformProfiler::mark('beforeGenerateAdminLinks plgSystem (JCH Optimize)') : null;

                $params = clone $this->params;
                $params->set('javascript', '1');
                $params->set('css', '1');
                $params->set('excludeAllExtensions', '0');
                $params->set('css_minify', '0');
                $params->set('debug', '0');
                $params->set('bottom_js', '2');
                

                $sHtml   = $oObj->getOriginalHtml();
                $oParser = new JchOptimizeParser($params, $sHtml, JchOptimizeFileRetriever::getInstance());

                $aLinks = $oParser->getReplacedFiles();

                if ($sCss == '')
                {
                        $oCombiner  = new JchOptimizeCombiner($params, $this->bBackend);
                        $oCssParser = new JchOptimizeCssParser($params, $this->bBackend);

                        $oCombiner->combineFiles($aLinks['css'][0], 'css', $oCssParser);
                        $sCss = $oCombiner->css;
                }

                $oSpriteGenerator = new JchOptimizeSpriteGenerator($params);
                $aLinks['images'] = $oSpriteGenerator->processCssUrls($sCss, TRUE);

                

                JCH_DEBUG ? JchPlatformProfiler::mark('afterGenerateAdminLinks plgSystem (JCH Optimize)') : null;

                return $aLinks;
        }

        /**
         * 
         * @param type $aButtons
         * @return string
         */
        public static function generateIcons($aButtons)
        {
                $sField = '<div class="container-icons clearfix">';

                foreach ($aButtons as $sButton)
                {
                        $sField .= <<<JFIELD
<div class="icon {$sButton['class']}">
        <a href="{$sButton['link']}"  {$sButton['script']}  >
                <div style="text-align: center;">
                        <i class="fa {$sButton['icon']} fa-3x" style="margin: 7px 0; color: {$sButton['color']}"></i>
                </div>
                <span >{$sButton['text']}</span><br>
                <i id="toggle" class="fa"></i>
        </a>
</div>
JFIELD;
                }

                $sField .= '</div>';

                return $sField;
        }

}
