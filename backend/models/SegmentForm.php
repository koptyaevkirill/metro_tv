<?php
namespace backend\models;
use Yii;
use common\models\Segment;

class SegmentForm extends Segment {
    
    public function afterValidate() {
        if(!empty($this->valid_from)) {
            $this->valid_from = strtotime($this->valid_from);
        }
        if(!empty($this->valid_to)) {
            $this->valid_to = strtotime($this->valid_to);
        }
        if(!empty($this->videos) && is_array($this->videos)) {
            $this->videos = implode(";", $this->videos);
        }
        if(!empty($this->device_ids) && is_array($this->device_ids)) {
            $this->device_ids = implode(";", $this->device_ids);
        }
        return parent::afterValidate();
    }
}
