<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 23:27
 */

namespace backend\modules\WorkSpace\modules\Config\widgets;

use cza\base\widgets\Widget;
use Yii;

class GeneralPanel extends Widget
{
    protected $_tabs = [];
    public $tabTitle = '';
    public $withBusinessTab = true;
    public $withAccountTab = true;

    public function getTabsId() {
        return 'general-panel-tabs';
    }

    public function getTabItems() {
        $items = [];
        if ($this->withBusinessTab) {
            $items[] = $this->getBusinessTab();
        }
        if ($this->withAccountTab) {
            $items[] = $this->getAccountTab();
        }
        $items[] = [
            'label' => '<a href="#" class="text-muted"><i class="fa fa-gear"></i></a>',
            'onlyLabel' => true,
            'headerOptions' => [
                'class' => 'pull-right',
            ],
        ];
        return $items;
    }

    public function getBusinessTab() {
        if (!isset($this->_tabs['BusinessTab'])) {
            $this->_tabs['BusinessTab'] = [
                'label' => "常规设置",
                'content' => \backend\modules\WorkSpace\modules\Config\widgets\BusinessSettings::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['BusinessTab'];
    }

    public function getAccountTab() {
        if (!isset($this->_tabs['AccountTab'])) {
            $this->_tabs['AccountTab'] = [
                'label' => "账号设置",
                'content' => \backend\modules\WorkSpace\modules\Config\widgets\AccountSettings::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['AccountTab'];
    }

}