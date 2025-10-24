<?php
function textSafe($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
?>