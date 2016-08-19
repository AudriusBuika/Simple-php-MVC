<?php

class HomeController
{
	public function index()
	{
		global $smarty;

		$smarty->assign("name", "Audrius Buika");
		$smarty->display('index.tpl');
	}
}