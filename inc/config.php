<?PHP
/*
 * Основной файл конфигурации сайта
 * Хранит в себе все основные настройки
 */
 
/*
 * Основные настройки сайта
 */
$title = 'Заголовок';
$charset = 'utf-8';
$subdir = '/'; // подпапка, в которой расположен сайт
$root_dir = $_SERVER['DOCUMENT_ROOT'].$subdir;
$url_path = 'http://'.$_SERVER['SERVER_NAME'];
$modules_path = $_SERVER['DOCUMENT_ROOT'].$subdir.'modules/';

/*
 * Настройки загрузкика модулей
 */
$def_module = 'news';

/*
 * Настройки БД
 * db_con_type - настройки типа соединения с БД
 * db_host, db_user, db_password - настройки для соединения с БД
 * db_name - имя БД
 * db_con_charset - настройка кодировки соединения с БД
 */
$db_host = 'localhost';
$db_user = 'root';
$db_password = ''; 
$db_name = 'guessbook';
$db_con_charset='utf8';
$db_con_type = 'MySQL';

/* Настройки изображения
 * moved_img_dir - папка, в которой лежат загруженные картинки
 * min_width, min_height - ширина, высота миниатюры
 * max_width, max_height - ширина, высота полной картинки
 */
$moved_img_dir = "res/img/";
$min_width = 200;
$max_width = 1000;
$min_height = 200;
$max_height = 1000;

?>