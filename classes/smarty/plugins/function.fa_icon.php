<?php

function smarty_function_fa_icon($params, &$smarty)
{
  return "<span class='fa fa-" . $params["name"] . "'>&nbsp;</span>";
}

?>