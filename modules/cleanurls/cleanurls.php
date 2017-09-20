<?php
/*
* 2013 Ha!*!*y
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* It is available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
*
* DISCLAIMER
* This code is provided as is without any warranty.
* No promise of being safe or secure
*
*  @author      Ha!*!*y <ha99ys@gmail.com>
*  @copyright   2012-2013 Ha!*!*y
*  @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  @code sorce: http://prestashop.com
*/

class cleanurls extends Module
{
	public function __construct()
	{
		$this->name = 'cleanurls';
		$this->tab = 'seo';
		$this->version = '0.42';
		$this->need_instance = 0;
		$this->author = 'ha!*!*y';

		parent::__construct();

		$this->displayName = $this->l('Clean URLs');
		$this->description = $this->l('This override allows you to remove URL ID\'s.');
	}

	public function getContent()
	{
		$output = '';

		if (Tools::isSubmit('submitCleanURLS'))
		{
			
		}

		//Advanced Parameters > Performance > Clear Smarty cache 
		//On some versions you have to disable Cache save than open your shop home page than go back and enable it.<br/><br/>';

		$sql = 'SELECT * FROM `'._DB_PREFIX_.'product_lang`
				WHERE `link_rewrite`
					IN (SELECT `link_rewrite` FROM `'._DB_PREFIX_.'product_lang`
					GROUP BY `link_rewrite`, `id_lang`
					HAVING count(`link_rewrite`) > 1)';

		if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
		{
			$sql .= ' AND `id_shop` = '.(int)Shop::getContextShopID();
		}

		if ($results = Db::getInstance()->ExecuteS($sql))
		{
			$output .= 'You need to fix duplicate URL entries<br/>';
			foreach ($results AS $row)
			{
				$output .= $row['name'].' ('.$row['id_product'] .') - '. $row['link_rewrite'].'<br/>';
			}
		}
		else
		{
			$output .= 'Nice you don\'t have any duplicate URL entries.';
		}

		return $output;
	}

	public function install()
	{
		// add link_rewrite as index to improve search
		$table_list = array('category_lang','cms_category_lang','cms_lang','product_lang');
		foreach($table_list as $table)
		{
			if(!Db::getInstance()->ExecuteS('SHOW INDEX FROM `'._DB_PREFIX_.$table.'` WHERE Key_name = \'link_rewrite\''))
				Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.$table.'` ADD INDEX ( `link_rewrite` )');
		}

		if (!parent::install())
			return false;
		return true;
	}

	public function uninstall()
	{
		if (!parent::uninstall())
			return false;
		return true;
	}
}
