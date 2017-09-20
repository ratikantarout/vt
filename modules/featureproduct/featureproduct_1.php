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
  `list_status` enum('1','0') NOT NULL,
  `home_status` enum('0','1') NOT NULL,
  PRIMARY KEY (`feature_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

        Db::getInstance()->execute("CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "featureproduct_product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feature_name` varchar(100) NOT NULL,
  `id_product` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        if (!parent::install() || !$this->registerHook('featureproduct') || !$this->registerHook('featureproductlist') || !$this->registerHook('top') || !$this->registerHook('header') || !$this->registerHook('displayMobileTopSiteMap'))
            return false;
        return true;
    }

    public function uninstall() {
        Db::getInstance()->execute("DROP TABLE IF EXISTS " . _DB_PREFIX_ . "featureproduct;");
        Db::getInstance()->execute("DROP TABLE IF EXISTS " . _DB_PREFIX_ . "featureproduct_product;");
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
            $this->output .="<option>" . $getCategorie['feature_name'] . "";
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

    public function Hookfeatureproduct($params) {
        echo "hello";
        die;
        $selectFeatureProducts = Db::getInstance()->executeS("SELECT *  FROM `" . _DB_PREFIX_ . "featureproduct` WHERE `home_status` = '1'");
        foreach ($selectFeatureProducts as $selectFeatureProduct) {
            $query1 = "SELECT jfpp.position,
                p.id_product,
                p.id_category_default,
                p.reference,
                p.ean13,
                p.active,
                GROUP_CONCAT(DISTINCT(i.id_image)) as allimages,
                count(distinct(i.id_image)) as countimage, 
                pl.`link_rewrite`, 
                pl.`name`
                FROM `" . _DB_PREFIX_ . "category_product` cp "
                    . "LEFT JOIN `" . _DB_PREFIX_ . "product` p "
                    . "ON p.`id_product` = cp.`id_product` "
                    . "LEFT JOIN `" . _DB_PREFIX_ . "featureproduct_product` jfpp "
                    . "ON jfpp.`id_product` = cp.`id_product` "
                    . "LEFT JOIN `" . _DB_PREFIX_ . "category_lang` cl "
                    . "ON (product_shop.`id_category_default` = cl.`id_category` "
                    . "AND cl.`id_lang` = 1 "
                    . "AND cl.id_shop = 1 ) "
                    . "LEFT JOIN `" . _DB_PREFIX_ . "product_lang` pl "
                    . "ON (p.`id_product` = pl.`id_product` "
                    . "AND pl.`id_lang` = 1 AND pl.id_shop = 1 ) "
                    . "LEFT JOIN `" . _DB_PREFIX_ . "image` i "
                    . "ON (i.`id_product` = p.`id_product`) "
                    . "LEFT JOIN " . _DB_PREFIX_ . "image_shop image_shop "
                    . "ON (image_shop.id_image = i.id_image "
                    . "AND image_shop.id_shop = 1 "
                    . "AND image_shop.cover=1) "
                    . "LEFT JOIN `" . _DB_PREFIX_ . "image_lang` il "
                    . "ON (image_shop.`id_image` = il.`id_image` "
                    . "AND il.`id_lang` = 1) "
                    . "WHERE product_shop.`id_shop` = 1 "
                    . "AND p.`id_product` "
                    . "IN (select id_product from " . _DB_PREFIX_ . "featureproduct_product "
                    . "WHERE feature_name='" . $selectFeatureProduct['feature_name'] . "') "
                    . "AND product_shop.`active` = 1 "
                    . "AND product_shop.`visibility` "
                    . "IN ('both', 'catalog') "
                    . "GROUP BY product_shop.id_product "
                    . "ORDER BY jfpp.position limit 0,10";

            echo $sql;
            die;

            $getCategories = Db::getInstance()->executeS($query1);
            $this->getall[$selectFeatureProduct['feature_name']] = $getCategories;
        }
        $this->smarty->assign(array('getCategory' => $this->getall, 'static_token' => Tools::getToken(false)));

        return $this->display(__FILE__, 'featureproduct.tpl');
    }

}

?>
