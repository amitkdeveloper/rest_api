<?php
class Book_model extends CI_Model {

	public function __construct() {

		$this->load->database();

	}

	public function searchBooks($book_ids, $authors, $languages, $topics, $title) {

		$this->db->select("books_book.id as book_id,books_book.gutenberg_id as book_gutenberg_id, books_book.title as book_title, books_book.download_count as book_download_count, books_book.gutenberg_id as book_gutenberg_id, books_book.media_type as book_media_type, books_bookshelf.name as book_bookshelf_name,books_book_bookshelves.bookshelf_id as book_bookshelf_id,books_book_authors.author_id as book_author_id,books_author.name as book_author_name, books_author.birth_year as book_author_birth_date, books_author.death_year as book_author_death_year , books_language.code as book_language_code,books_subject.name as book_subject_name,books_format.mime_type as book_mime_type, books_format.url as book_url");

		$this->db->from('books_book');

		$this->db->join('books_book_authors', 'books_book_authors.book_id = books_book.id', 'left');
		$this->db->join('books_author', 'books_book_authors.author_id = books_author.id', 'left');

		$this->db->join('books_book_bookshelves', 'books_book_bookshelves.book_id = books_book.id', 'left');
		$this->db->join('books_bookshelf', 'books_book_bookshelves.id = books_bookshelf.id', 'left');

		$this->db->join('books_book_subjects', 'books_book_subjects.book_id = books_book.id', 'left');
		$this->db->join('books_subject', 'books_subject.id = books_book_subjects.subject_id', 'left');

		$this->db->join('books_book_languages', 'books_book_languages.book_id = books_book.id', 'left');
		$this->db->join('books_language', 'books_book_languages.language_id = books_language.id', 'left');

		$this->db->join('books_format', 'books_format.book_id = books_book.id', 'left');

		if ($book_ids !== "") {

			$searchString = ',';

			if (strpos($book_ids, $searchString) !== false) {

				$str_arr = explode(",", $book_ids);
				foreach ($str_arr as $key => $value) {
					$this->db->or_where("books_book.gutenberg_id", $value);
				}

			} else {
				$this->db->or_where("books_book.gutenberg_id", $book_ids);
			}

		}

		if ($authors !== "") {

			$searchString = ',';

			if (strpos($authors, $searchString) !== false) {

				$str_arr = explode(",", $authors);
				foreach ($str_arr as $key => $value) {
					$this->db->or_where("books_author.name", $value);
				}

			} else {
				$this->db->or_where("books_author.name", $authors);
			}

		}

		if ($languages !== "") {

			$searchString = ',';

			if (strpos($languages, $searchString) !== false) {

				$str_arr = explode(",", $languages);
				foreach ($str_arr as $key => $value) {
					$this->db->or_where("books_language.code", $value);
				}

			} else {
				$this->db->or_where("books_language.code", $languages);
			}

		}

		if ($topics !== "") {

			$searchString = ',';

			if (strpos($topics, $searchString) !== false) {

				$str_arr = explode(",", $topics);
				foreach ($str_arr as $key => $value) {
					$this->db->or_where("books_subject.name", $value);
				}

			} else {
				$this->db->or_where("books_subject.name", $topics);
			}

		}

		if ($title !== "") {

			$searchString = ',';

			if (strpos($title, $searchString) !== false) {

				$str_arr = explode(",", $title);
				foreach ($str_arr as $key => $value) {
					$this->db->or_where("books_book.title", $value);
				}

			} else {
				$this->db->or_where("books_book.title", $title);
			}

		}

		$this->db->limit(25);

		$this->db->order_by("books_book.download_count", "desc");

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result_array();
		} else {
			return 0;
		}
	}

}