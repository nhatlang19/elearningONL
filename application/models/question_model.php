<?php
class Question_model extends Ext_Model {
	public function __construct() {
		parent::__construct('question', 'question_id');
	}
}