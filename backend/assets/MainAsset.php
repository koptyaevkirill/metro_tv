<?php
namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class MainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/main.js'
    ];
    public $jsOptions = [
        'position' => View::POS_END,
        'defer' => ''       
    ];
}
