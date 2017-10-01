<?php

class HelperShopCore extends Helper {

    /**
     * Render shop list
     *
     * @return string
     */
    public function getRenderedShopList() {
        if (!Shop::isFeatureActive() || Shop::getTotalShops(false, null) < 2) {
            return '';
        }

        $shop_context = Shop::getContext();
        $context = Context::getContext();
        $tree = Shop::getTree();

        if ($shop_context == Shop::CONTEXT_ALL || ($context->controller->multishop_context_group == false && $shop_context == Shop::CONTEXT_GROUP)) {
            $current_shop_value = '';
            $current_shop_name = Translate::getAdminTranslation('All shops');
        } elseif ($shop_context == Shop::CONTEXT_GROUP) {
            $current_shop_value = 'g-' . Shop::getContextShopGroupID();
            $current_shop_name = sprintf(Translate::getAdminTranslation('%s group'), $tree[Shop::getContextShopGroupID()]['name']);
        } else {
            $current_shop_value = 's-' . Shop::getContextShopID();

            foreach ($tree as $group_id => $group_data) {
                foreach ($group_data['shops'] as $shop_id => $shop_data) {
                    if ($shop_id == Shop::getContextShopID()) {
                        $current_shop_name = $shop_data['name'];
                        break;
                    }
                }
            }
        }

        $tpl = $this->createTemplate('helpers/shops_list/list.tpl');
        $tpl->assign(array(
            'tree' => $tree,
            'current_shop_name' => $current_shop_name,
            'current_shop_value' => $current_shop_value,
            'multishop_context' => $context->controller->multishop_context,
            'multishop_context_group' => $context->controller->multishop_context_group,
            'is_shop_context' => ($context->controller->multishop_context & Shop::CONTEXT_SHOP),
            'is_group_context' => ($context->controller->multishop_context & Shop::CONTEXT_GROUP),
            'shop_context' => $shop_context,
            'url' => $_SERVER['REQUEST_URI'] . (($_SERVER['QUERY_STRING']) ? '&' : '?') . 'setShopContext='
        ));

        return $tpl->fetch();
    }

}
