<?php
/**
 * Vend plugin for Craft Commerce
 *
 * Connect your Craft Commerce store to Vend POS.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2019 Angell & Co
 */

namespace angellco\vend\web\assets\syncutils;

use craft\commerce\web\assets\commercecp\CommerceCpAsset;
use craft\web\AssetBundle;

/**
 * Widgets asset bundle
 *
 * @author    Angell & Co
 * @package   Vend
 * @since     2.0.0
 */
class SyncUtilsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = __DIR__ . '/dist';

        $this->depends = [
            CommerceCpAsset::class,
        ];

        $this->css = [];

        $this->js = [
            'js/VendFullFeedUtil.js',
            'js/VendFastFeedUtil.js',
        ];

        parent::init();
    }
}