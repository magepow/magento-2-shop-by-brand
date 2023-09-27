<?php

/**
 * @Author: Alex Dong
 * @Date:   2023-09-27 14:42:40
 * @Last Modified by:   Alex Dong
 * @Last Modified time: 2023-09-27 14:42:56
 */

namespace Magiccart\Shopbrand\Block\System\Config\Form\Field;

class Snippet extends \Magento\Config\Block\System\Config\Form\Field\Heading
{

    /**
     * Render element html
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->_getElementHtml($element);
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        // $html = $element->getElementHtml();
        $html  = '';
        $value = $element->getData('value');
        $shortcodeWidget = '{{widget type="Magiccart\Shopbrand\Block\Widget\Brand" template="brand.phtml"}}';
        $shortcodeBlock  = $this->_escaper->escapeHtml('<?= $block->getLayout()->createBlock(\'Magiccart\Shopbrand\Block\Widget\Brand\')->setTemplate(\'brand.phtml\')->toHtml();?>');
        $html = '<ol class="shopbrand-snippet"><li>';
        $html .= '<p>' . __('Add Widget name "Magiccart Shop Logo widget".') . '</p>';
        $html .= '</li><li>';
        $html .= '<span>' . __('Copy Short code add to CMS Page/Static Block.') . '</span>';
        $html .= '<code style="display: block;background: #f5f5f5;padding: 15px; margin-top:15px">' . $shortcodeWidget . '</code>';
        $html .= '</li><li>';
        $html .= '<span>' . __('Template .phtml file. Open a .phtml file and insert where you want to display Brand Slider.') . '</span>';
        $html .= '<code style="display: block;background: #f5f5f5;padding: 15px; margin-top:15px">' . $shortcodeBlock . '</code>';
        $html .= '</li></ol>';

        return $html;
    }
}