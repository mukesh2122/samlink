<?php
/**
 * ErrorController
 * Feel free to change this and customize your own error message
 *
 * @author Me
 */
class ErrorController extends SnController {
    
    function error404() {
		$data['title'] = 'Page not found!';
		$data['content'] = 'default 404 error';
		$this->render1Col($data);
	}
	
	public function enableJs(){	
		$data['content'] = 'enable';
		$this->view()->render('enable_js', $data);
	}
	
	public function enableCookie(){	
		$data['content'] = 'enable';
		$this->view()->render('enable_cookie', $data);
	}

}
?>