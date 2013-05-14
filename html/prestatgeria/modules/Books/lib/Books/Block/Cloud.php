<?php

class Books_Block_Cloud extends Zikula_Controller_AbstractBlock {

    public function init() {
        SecurityUtil::registerPermissionSchema("Books:cloudblock:", "Block title::");
    }

    public function info() {
        return array('text_type' => 'Cloud',
            'module' => 'Books',
            'text_type_long' => $this->__('Mostra un núvol de descriptors'),
            'allow_multiple' => true,
            'form_content' => false,
            'form_refresh' => false,
            'show_preview' => true);
    }

    /**
     * Show the list of forms for choosed categories
     * @autor:	Albert Pérez Monfort
     * return:	The list of forms
     */
    public function display($blockinfo) {
        // Security check
        if (!SecurityUtil::checkPermission("Books:cloudblock:", $blockinfo['title'] . "::", ACCESS_READ)) {
            return;
        }
        // Check if the module is available
        if (!ModUtil::available('Books'))
            return;

        $max_font_size = 30;
        $min_font_size = 12;
        $maximum_count = 0;
        $minimum_count = 10000;
        $tags = ModUtil::apiFunc('Books', 'user', 'getAllDescriptors', array('number' => 25));
        $cloudArray = array(); // create an array to hold tag code
        if (count($tags) > 0) {
            foreach ($tags as $tag) {
                if ($tag['number'] > $maximum_count)
                    $maximum_count = $tag['number'];

                if ($tag['number'] < $minimum_count)
                    $minimum_count = $tag['number'];
            }
            $spread = $maximum_count - $minimum_count;
            if ($spread == 0)
                $spread = 1;

            //Finally we start the HTML building process to display our tags. For this demo the tag simply searches Google using the provided tag.
            foreach ($tags as $tag) {
                $size = $min_font_size + ($tag['number'] - $minimum_count) * ($max_font_size - $min_font_size) / $spread;
                $cloudArray[] = array('tag' => htmlspecialchars(stripslashes($tag['descriptor'])),
                    'size' => floor($size),
                    'count' => $tag['number']);
            }
        }
        asort($cloudArray);
        // Create output object
        $view = Zikula_View::getInstance('Books', true);
        $view->assign('cloud', $cloudArray);
        $s = $view->fetch('books_block_cloud.tpl');
        // Populate block info and pass to theme
        $blockinfo['content'] = $s;
        return BlockUtil::themesideblock($blockinfo);
    }

}