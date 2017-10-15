<?PHP
/*
 * Класс для работы с шаблонами
 * Шаблоны хранятся в папке с ресурсами в подпапке tpl
 * 
 */
class Templ {
	private $tpl_dir;
	function __construct ($resdir) {
		global $root_dir;
		$this->tpl_dir = $root_dir.$resdir."res/tpl/";
	}
	
	/*
	 * Функция получения шаблона
	 * На вход имя нужного шаблона и массив замен
	 * На выход готовый кусок раметки
	 */
	private function get_tpl_ready($name, $replacement) {
		$tpl = file_get_contents($this->tpl_dir.$name);
		return str_replace(array_keys($replacement), array_values($replacement), $tpl);
	}

	/*
	 * Получение заголовка страницы
	 * На вход передается название страницы
	 * На выход готовая "шапка"
	 */
	function GetHeader($page_title, $active_module){
		global $charset,$url_path;
		$replacement = array(
			'{charset}' => $charset,
			'{page_title}' => $page_title,
			'{url}' => $url_path.'/'.$active_module
		);
		return $this->get_tpl_ready("header.tpl", $replacement);
	}

	/*
	 * Получение элемента
	 * На вход передается ассоциативный массив из элементов для замены,
	 * А так же имя шаблона для отобажения элемента
	 * На выход элемент
	 */
	function GetGood ($good, $tpl_name) {
		$replacement = array();
		foreach ($good AS $key => $value) {
			$replacement['{'.$key.'}'] = $value;
		}
		return $this->get_tpl_ready($tpl_name,$replacement);
		
	}

	/*
	 * Получение списка элементов
	 * На вход передается массив из ассоциативный массив из элементов для замены,
	 * А так же имя шаблона для отобажения элементов
	 * На выход готовый список из элементов
	 */
	function GetGoods ($goods, $tpl_name) {
		$buffer = '';
		foreach ($goods AS $tmp) {
			$replacement = array();
			foreach ($tmp AS $key => $value) {
				$replacement['{'.$key.'}'] = $value;
			}
			$str_tmp = $this->get_tpl_ready($tpl_name,$replacement);
			$buffer .= $str_tmp;
		}
		return $buffer;
	}

	/*
	 * Получение подвала страницы
	 * На вход передается название страницы
	 * На выход готовый подвал
	 */
	function GetFooter ($page_title) {
		global $url_path;
		$replacement = array(
			'{year}' => date("y"),
			'{title}' => $page_title,
			'{url}' => $url_path
		);
		return $this->get_tpl_ready("footer.tpl",$replacement);
	}
}
?>