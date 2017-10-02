<?php

class Core_Business_CMS_CMSRepository extends Core_Foundation_Database_EntityRepository {

    /**
     * Return CMSRepository lang associative table name
     * @return string
     */
    private function getLanguageTableNameWithPrefix() {
        return $this->getTableNameWithPrefix() . '_lang';
    }

    /**
     * Return all CMSRepositories depending on $id_lang/$id_shop tuple
     * @param $id_lang
     * @param $id_shop
     * @return array|null
     */
    public function i10nFindAll($id_lang, $id_shop) {
        $sql = '
			SELECT *
			FROM `' . $this->getTableNameWithPrefix() . '` c
			JOIN `' . $this->getPrefix() . 'cms_lang` cl ON c.`id_cms`= cl.`id_cms`
			WHERE cl.`id_lang` = ' . (int) $id_lang . '
			AND cl.`id_shop` = ' . (int) $id_shop . '

		';

        return $this->hydrateMany($this->db->select($sql));
    }

    /**
     * Return all CMSRepositories depending on $id_lang/$id_shop tuple
     * @param $id_cms
     * @param $id_lang
     * @param $id_shop
     * @return CMS|null
     * @throws Core_Foundation_Database_Exception
     */
    public function i10nFindOneById($id_cms, $id_lang, $id_shop) {
        $sql = '
			SELECT *
			FROM `' . $this->getTableNameWithPrefix() . '` c
			JOIN `' . $this->getPrefix() . 'cms_lang` cl ON c.`id_cms`= cl.`id_cms`
			WHERE c.`id_cms` = ' . (int) $id_cms . '
			AND cl.`id_lang` = ' . (int) $id_lang . '
			AND cl.`id_shop` = ' . (int) $id_shop . '
			LIMIT 0 , 1
		';

        return $this->hydrateOne($this->db->select($sql));
    }

}
