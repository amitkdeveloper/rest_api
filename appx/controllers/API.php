<?php

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('book_model');
	}

	function booksearch_get() {
		$book_ids = "";
		$book_ids = $this->get('book_ids');
		$authors = "";
		$authors = $this->get('authors');

		$languages = "";
		$languages = $this->get('languages');
		$topics = "";
		$topics = $this->get('topics');
		$title = "";
		$title = $this->get('title');

		$result = $this->book_model->searchBooks($book_ids, $authors, $languages, $topics, $title);

		if ($result) {
			$this->response($result, 200);
			exit;
		} else {
			$this->response("No books found matching search criteria.", 404);
			exit;
		}
	}

}