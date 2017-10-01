<?php

class HelperKpiRowCore extends Helper {

    public $base_folder = 'helpers/kpi/';
    public $base_tpl = 'row.tpl';
    public $kpis = array();

    public function generate() {
        $this->tpl = $this->createTemplate($this->base_tpl);

        $this->tpl->assign('kpis', $this->kpis);
        return $this->tpl->fetch();
    }

}
