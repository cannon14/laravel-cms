<?php
/**
 * Content Service
 *
 * @copyright 2009 CreditCards.com
 * @author Patrick J. Mizer
 * @package affiliate.scripts.services
 */
class Affiliate_Scripts_Services_ContentService
{

    public function processRequest($params) {

        switch($params['action']) {
            case 'content':
                return $this->_getContent();
                break;

            case 'image':
                return $this->_getImage($params['image']);
                break;

            default:
                break;
        }
    }

    private function _getContent() {
        return <<<CONTENT

        <a href="#"><img src="/actions/img/KFM0910B.jpg" border="0" /></a>

CONTENT;

    }

    private function _getImage($image) {
        return <<<CONTENT

        <img src="/actions/img/$image" />

CONTENT;

    }
}
?>