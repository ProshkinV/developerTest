<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Главная');?>

<?
class MyIBlock {
	/**
	 * @var int $cache_time - время кеширования
	 */
	protected $cache_time;

	function __construct($cache_time = 3600) {
		$this->cache_time = $cache_time;
	}

	/**
	 * Кешированный метод получения списка элементов инфоблока
	 *
	 * @param array $arOrder - массив сортировки элементов
	 * @param array $arFilter - массив фильтра
	 * @param array $arSelect - массив выбора свойств
	 *
	 * @return array $arResult
	 */
	public function getList($arOrder = array(), $arFilter = array(), $arSelect = array()) {
		Bitrix\Main\Loader::includeModule('iblock');
		$arResult = array();
		$query = \Bitrix\Iblock\ElementTable::getList(array(
			'order' => $arOrder,
			'filter' => $arFilter,
			'select' => $arSelect,
			'cache' => array(
				'ttl' => $this->cache_time,
				'cache_joins' => true
			)
		));
		while ($arElem = $query->fetch()) {
			$arResult[] = $arElem;
		}
		return $arResult;
	}
}

$myObj = new MyIBlock();
$arOrder = array('SORT' => 'DESC');
$arFilter = array('IBLOCK_ID' => 1);
$arSelect = array('ID', 'NAME', 'SORT');
$res = $myObj->getList($arOrder, $arFilter, $arSelect);
//print_r($res);
?>

<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>