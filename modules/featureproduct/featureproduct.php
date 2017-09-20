<?php

if (!defined('_CAN_LOAD_FILES_'))
    exit;

class featureproduct extends Module {

    private $output = "";
    private $getall = array();

    public function __construct() {
        $this->bootstrap = true;
        $this->name = 'featureproduct';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        parent::__construct();
        $this->displayName = $this->l('Feature Product');
        $this->description = $this->l('It allows to add feature product in the Home Page of your shop');
    }

    public function install() {
        Db::getInstance()->execute("CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "featureproduct` (
  `feature_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feature_name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `list_status` enum('0','1') NOT NULL,
  `home_status` enum('1','0') NOT NULL,
  PRIMARY KEY (`feature_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        Db::getInstance()->execute("CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "featureproduct_product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feature_name` varchar(100) NOT NULL,
  `id_product` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        $success = (parent::install() && $this->registerHook('header') && $this->registerHook('displayHomeTab') && $this->registerHook('displayHomeTabContent')
                );

//
//        if (!parent::install() ||
//                !$this->registerHook('featureproduct') ||
//                !$this->registerHook('featureproductlist') ||
//                !$this->registerHook('top') ||
//                !$this->registerHook('header') ||
//                !$this->registerHook('displayMobileTopSiteMap'))
//            return false;
        return $success;
    }

    public function uninstall() {
//        Db::getInstance()->execute("DROP TABLE IF EXISTS " . _DB_PREFIX_ . "featureproduct;");
//        Db::getInstance()->execute("DROP TABLE IF EXISTS " . _DB_PREFIX_ . "featureproduct_product;");
        if (!parent::uninstall())
            return false;
        return true;
    }

    public function getContent() {
        $this->output .= "<script src='../modules/featureproduct/featureproduct.js'></script>";
        if (isset($_POST['featureu']) && $_POST['productId']) {
            $sql = "UPDATE " . _DB_PREFIX_ . "featureproduct_product set id_product=" . $_POST['productId'] . ",position=" . $_POST['featurepos'] . " where id=" . $_POST['productFeatureId'];
            DB::getInstance()->Execute($sql);
        }
        if (isset($_POST['featured']) && $_POST['productId']) {
            $sql = "DELETE FROM `" . _DB_PREFIX_ . "featureproduct_product` WHERE `id` =" . $_POST['productFeatureId'];

            DB::getInstance()->Execute($sql);
        }
        if (isset($_POST['hiddenFeatureId']) && $_POST['featureupdate']) {
            $sql = "UPDATE " . _DB_PREFIX_ . "featureproduct set feature_name='" . $_POST['featurename'] . "',category_name='" . $_POST['categoryname'] . "',list_status='" . $_POST['liststatus'] . "',home_status='" . $_POST['homestatus'] . "',category_id='" . $_POST['categoryid'] . "' where feature_id=" . $_POST['hiddenFeatureId'];
            DB::getInstance()->Execute($sql);
        }
        if (isset($_POST['hiddenFeatureId']) && $_POST['featuredelete']) {
            $sql = "DELETE FROM `" . _DB_PREFIX_ . "featureproduct` WHERE `feature_id` =" . $_POST['hiddenFeatureId'];
            DB::getInstance()->Execute($sql);
        }
        if (!empty($_POST['FeatureName']) && !empty($_POST['childParent'])) {
            $value = explode("->", $_POST['childParent']);
            $result = DB::getInstance()->Execute("INSERT INTO `" . _DB_PREFIX_ . "featureproduct` (`feature_name`,category_id,category_name) VALUES ('" . $_POST['FeatureName'] . "'," . $value[0] . ",'" . $value[1] . "')");
        }
        $getCategories = Db::getInstance()->executeS('select * from  ' . _DB_PREFIX_ . 'featureproduct');
        $getparentCategories = Db::getInstance()->executeS("SELECT DISTINCT(jc.id_parent),jcl.name FROM " . _DB_PREFIX_ . "category as jc LEFT JOIN " . _DB_PREFIX_ . "category_lang as jcl ON jc.id_parent=jcl.id_category WHERE jc.level_depth=3 AND jcl.id_shop=1");
        if (!empty($_POST['product_id'])) {
            $results = DB::getInstance()->Execute("INSERT INTO "
                    . "`" . _DB_PREFIX_ . "featureproduct_product` (feature_name,id_product) VALUES ('" . $_POST['feature_name'] . "'," . $_POST['product_id'] . ")");
        }
        $this->output .= "<table class='table'><tr><td><table class='table'><tr><td><form method='post' action='" . Tools::safeOutput($_SERVER['REQUEST_URI']) . "'>";
        $this->output .= "<input type='text' name='FeatureName' placeholder='Enter your feature name' value=''>";
        $this->output .= "<select name='FeatureCategory' id='FeatureCategory' onchange='getNextCatgory(this.value)'>";
        $this->output .= "<option>SELECT PARENT CATEGRY NAME</option>";
        foreach ($getparentCategories as $getparentCategory) {
            $this->output .= "<option >" . $getparentCategory['id_parent'] . "->" . $getparentCategory['name'] . "</option>";
        }
        $this->output .= "</select>";
        $this->output .= "<select id='childParent' name='childParent' onchange='getNextCatgory(this.value)'>"
                . "<option>SELET CHILD CATEGORY</opton>"
                . "</select>";
        $this->output .= "<input type='submit' class='btn btn-primary' value='Create A Feature'>";
        $this->output .= "</form></td></tr></table></td>";

        $getProducts = Db::getInstance()->executeS('select * from  ' . _DB_PREFIX_ . 'featureproduct_product order by feature_name,position DESC ');

        $this->output .= "<td style='float:right;'><table class='table'><tr><td>Name</td><td>ProductId</td><td>Addition</td></tr>";

        $this->output .= "<form name='product_add' method='post' action='" . Tools::safeOutput($_SERVER['REQUEST_URI']) . "'><tr><td>"
                . "<select name='feature_name'>";
        foreach ($getCategories as $getCategorie) {
            $this->output .="<option value='" . $getCategorie['feature_id'] . "'>" . $getCategorie['feature_name'] . "";
        }
        $this->output .= "</select>"
                . "</td>"
                . "<td><input type='text' value='' name='product_id'></td>"
                . "<td><input type='submit' class='btn btn-primary' value='add'></td>"
                . "</tr></form>";
        $this->output .= "</table></td></tr>";
        $this->output .="<tr><td><table class='table'>"
                . "<tr><td>SL No</td>"
                . "<td>Feature Name</td>"
                . "<td>Caegory Id</td>"
                . "<td>Cateory Name</td>"
                . "<td>List Page</td>"
                . "<td>Home Page</td>"
                . "<td>Update</td>"
                . "<td>Delete</td></tr>";

        $count = 1;
        foreach ($getCategories as $getCategori) {
            $this->output .="<form method='post' action='" . Tools::safeOutput($_SERVER['REQUEST_URI']) . "'>";
            $this->output .= "<tr>"
                    . "<td>" . $count
                    . "<input type='hidden' name='hiddenFeatureId' value='" . $getCategori['feature_id'] . "'></td>"
                    . "<td><input type='text' name='featurename' value='" . $getCategori['feature_name'] . "'></td>"
                    . "<td><input type='text' name='categoryid' value='" . $getCategori['category_id'] . "'></td>"
                    . "<td><input type='text' name='categoryname' value='" . $getCategori['category_name'] . "'></td>"
                    . "<td><input style='width:40px' type='text' name='liststatus' value='" . $getCategori['list_status'] . "'></td>"
                    . "<td><input style='width:40px' type='text' name='homestatus' value='" . $getCategori['home_status'] . "'></td>"
                    . "<td><input type='submit' class='btn btn-primary'  name='featureupdate' value='Update'></td>"
                    . "<td><input type='submit' class='btn btn-primary'  name='featuredelete' value='Delete'></td>"
                    . "</tr>";
            $count++;
            $this->output .= "</form>";
        }

        $this->output.= "</table></td>";
        $this->output .="<td><table class='table'><tr>"
                . "<td>Feature Name</td>"
                . "<td>Product ID</td>"
                . "<td>Quantity</td>"
                . "<td>Position by name</td>"
                . "<td>Update</td>"
                . "<td>Delete</td></tr>";
        foreach ($getProducts as $getProduct) {
            $quantitysql = "SELECT `quantity` FROM `" . _DB_PREFIX_ . "stock_available` WHERE id_product=" . $getProduct['id_product'] . " GROUP BY id_product";
            $getQuantity = Db::getInstance()->executeS($quantitysql);
            $this->output .="<form method='post' action='" . Tools::safeOutput($_SERVER['REQUEST_URI']) . "'>";

            if ($fea != $getProduct['feature_name']) {
                $this->output .= "<tr>"
                        . "<td>&nbsp</td>"
                        . "<td></td>"
                        . "<td></td>"
                        . "<td></td>"
                        . "<td></td>"
                        . "<td></td>"
                        . "</tr>";
                $fea = $getProduct['feature_name'];

                $this->output .= "<tr>"
                        . "<td>" . $getProduct['feature_name']
                        . "<input type='hidden' name='productFeatureId' value='" . $getProduct['id'] . "'></td>"
                        . "<td><input style='width:40px;' type='text' name='productId' value='" . $getProduct['id_product'] . "'></td>"
                        . "<td><input style='width:40px;' readonly name='productquantity' value='" . $getQuantity[0]['quantity'] . "'></td>"
                        . "<td><input style='width:90px;' name='featurepos' value='" . $getProduct['position'] . "'></td>"
                        . "<td><input type='submit'  name='featureu' value='Update'></td>"
                        . "<td><input type='submit'  name='featured' value='Delete'></td>"
                        . "</tr>";
            } else {


                $fea = $getProduct['feature_name'];

                $this->output .= "<tr>"
                        . "<td>" . $getProduct['feature_name']
                        . "<input type='hidden' name='productFeatureId' value='" . $getProduct['id'] . "'></td>"
                        . "<td><input style='width:40px;' type='text' name='productId' value='" . $getProduct['id_product'] . "'></td>"
                        . "<td><input style='width:40px;' readonly name='productquantity' value='" . $getQuantity[0]['quantity'] . "'></td>"
                        . "<td><input style='width:90px;' name='featurepos' value='" . $getProduct['position'] . "'></td>"
                        . "<td><input type='submit'  name='featureu' value='Update'></td>"
                        . "<td><input type='submit'  name='featured' value='Delete'></td>"
                        . "</tr>";
            }
            $this->output .= "</form>";
        }
        $this->output.= "</table></td></tr></table>";
        return $this->output;
    }

    public function hookdisplayHomeTabContent() {
        $ps = array();
        $sql = "SELECT fpp.feature_name as id_feature,"
                . "fpp.id_product,"
                . "fp.feature_name as feature_name,"
                . "pl.name,"
                . "pl.link_rewrite,"
                . "p.ean13,"
                . "p.reference,"
                . "i.id_image FROM " . _DB_PREFIX_ . "featureproduct_product as fpp "
                . "INNER JOIN " . _DB_PREFIX_ . "featureproduct as fp "
                . "ON fp.feature_id=fpp.feature_name "
                . "INNER JOIN " . _DB_PREFIX_ . "product as p "
                . "ON fpp.id_product=p.id_product "
                . "INNER JOIN " . _DB_PREFIX_ . "product_lang as pl "
                . "ON fpp.id_product=pl.id_product "
                . "INNER JOIN " . _DB_PREFIX_ . "image as i "
                . "ON fpp.id_product=i.id_product "
                . "WHERE i.cover='1' AND p.active='1'";
        $results = Db::getInstance()->executeS($sql);
        foreach ($results as $result) {
            $result['link'] = $this->context->link->getProductLink($result['id_product']);
            $id_feature = $result['id_feature'];
            $feature_name = $result['feature_name'];
            $ps[$id_feature]['feature_name'] = $feature_name;
            unset($result['id_feature'], $result['feature_name']);
            $ps[$id_feature]['data'][] = $result;
            unset($result);
        }

        $this->smarty->assign(array(
            'ps' => $ps
        ));
        return $this->display(__FILE__, 'featureproduct.tpl');
    }

}

?>
