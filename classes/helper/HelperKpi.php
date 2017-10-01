<?php

class HelperKpiCore extends Helper {

    public $base_folder = 'helpers/kpi/';
    public $base_tpl = 'kpi.tpl';
    public $id;
    public $icon;
    public $chart;
    public $color;
    public $title;
    public $subtitle;
    public $value;
    public $data;
    public $source;
    public $refresh = true;
    public $href;
    public $tooltip;

    public function generate() {
        $this->tpl = $this->createTemplate($this->base_tpl);

        $this->tpl->assign(array(
            'id' => $this->id,
            'icon' => $this->icon,
            'chart' => (bool) $this->chart,
            'color' => $this->color,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'value' => $this->value,
            'data' => $this->data,
            'source' => $this->source,
            'refresh' => $this->refresh,
            'href' => $this->href,
            'tooltip' => $this->tooltip
        ));
        return $this->tpl->fetch();
    }

}
