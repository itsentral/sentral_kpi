<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
	public function index()
	{
		$this->template->title('Dashboard');
		$this->template->page_icon('fa fa-dashboard');
		$this->template->render('harapan');
	}
}
