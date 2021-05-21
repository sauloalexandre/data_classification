<?php
function cmpJudge($a, $b)
{
    return strcmp($a->get("judge"), $b->get("judge"));
}

function cmpProcess($a, $b)
{
    return strcmp($a->get("process"), $b->get("process"));
}

function createFile($nm, $content)
{
    $arquivo = fopen($nm.'.txt','w');
    if ($arquivo == false) die('Não foi possível criar o arquivo.');
    $texto = json_encode($content);
    fwrite($arquivo, $texto);
    fclose($arquivo);
}
?>