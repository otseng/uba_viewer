<?php
include_once('config.php');

function getValue($var,$val=null) {
    if (isset($_POST[$var])) {
        $val = $_POST[$var];
    }
    else if (isset($_GET[$var])) {
        $val = $_GET[$var];
    }
    return $val;
}

$content = "";
$code = getValue('code');

try {
    if ($code) {
        $object = UbaHtmlContentService::retrieveByCode($code);
        $content = $object->content;
    }
} catch (Exception $e) {
    Log::debug($e);
}

echo($content);

?>