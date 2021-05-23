<?php
include_once('./utils/log.php');
include_once('./utils/uba_html_content_service.php');

try {
    $json = json_decode(file_get_contents('php://input'), true);
    $code = "";
    $content = "";
    if (isset($json["code"]) && isset($json["content"])) {
        $code = $json["code"];
        $content = $json["content"];

        try {
            $object = UbaHtmlContentService::retrieveByCode($code);
            $object->content = $content;
            UbaHtmlContentService::update($object);
        } catch (Exception $e) {
            $object = new UbaHtmlContentMO();
            $object->code = $code;
            $object->content = $content;
            UbaHtmlContentService::create($object);
        }
        
        echo("OK");
    } else {
        echo("ok");
    }
} catch (Exception $e) {
    echo($e->getMessage());
}
?>