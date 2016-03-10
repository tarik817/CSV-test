<?php

class Storage 
{
	/**
	 * Get front page view.
	 * 
	 * @return view.
	 */
	public function index()
	{
		$data = $this->model('Products')->get_all();
		return $this->view('index', ['storage' => $data]);
	}

	/**
	 * Proccess new CSV data.
	 * 
	 * @return redirect.
	 */
	public function proccess()
	{
		if($_FILES)
		{
			$products = CSVHandler::csv_to_array($_FILES['file']['tmp_name'][0]);
			$model = $this->model('Products');
			$model->push_array($products);
		}

		header("Location: " . BASE_URL );
		die;
	}

	/**
	 * Open view.
	 * 
	 * @param string case sencetive name of the class.
	 * @param array $data array of parameters.
	 * 
	 * @return void
	 */
	public function view($view, $data = [])
	{
		//Check if given view exist. 
		if( file_exists('views/' . $view . '.php')){
			require_once 'views/' . $view . '.php';
			return;
		}
		//If view does not exist - throw exeption.
		throw new Exception('You have not view with name ' . $view );
	}

	/**
	 * Open model.
	 * 
	 * @param string case sencetive name of the class.
	 * 
	 * @return object.
	 */
	public function model($model)
	{
		//Check if given model exist. 
		if( file_exists('core/models/' . $model . '.php')){
			//Plug DB access class.
			require_once 'core/db/connection.php';
			//Plug model.
			require_once 'core/models/' . $model . '.php';
			return new $model;
		}
		//If model does not exist - throw exeption.
		throw new Exception('You have not model with name ' . $model );
	}
}
?>