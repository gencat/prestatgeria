<?php
function smarty_function_getDateFormat($params)
{
	return date($params['format'], $params['date']);
}
