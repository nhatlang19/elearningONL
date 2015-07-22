<?php
class Topic_manage_model extends Ext_Model {
	const STATUS_DELETED = 'DELETED';
	const STATUS_ACTIVE = 'ACTIVE';
	const REVIEW_SHOW = 'SHOW';
	const REVIEW_HIDE = 'HIDE';
	
	public function __construct() {
		parent::__construct('topic_manage', 'topic_manage_id');
	}

	function getTopicList($academic_id = NULL, $exam_id = NULL, $subjects_id = NULL, $count = NULL, $start = NULL) {
		// start cache
		$this->db->start_cache();

		$this->db->select('t.*, ay.academic_name, e.title as etitle');
		$this->db->from('topic_manage as t');
		$this->db->join('academic_year as ay', 'ay.academic_id = t.academic_id', 'left');
		$this->db->join('exam as e', 'e.exam_id = t.exam_id', 'left');
		$this->db->where('t.status', self::STATUS_ACTIVE);

		if($academic_id) {
			$this->db->where('t.academic_id', $academic_id);
		}

		if($exam_id) {
			$this->db->where('t.exam_id', $exam_id);
		}
		
		if($subjects_id) {
			$this->db->where('t.subjects_id', $subjects_id);
		}

		$query = $this->db->get();

		// stop cache
		$this->db->stop_cache();

		// get total records before filter by limit
		$this->table_record_count = $query->num_rows();

		$this->db->order_by('t.created_time', 'desc');


		if(!is_null($start)) {
			if(!is_null($count)) {
				$this->db->limit($count, $start);
			}
			else {
				$this->db->limit($start);
			}
		}

		$query = $this->db->get();
		$results = array();
		if(!empty($query) && $query->num_rows() > 0) {
			$results = $query->result_array();
		}

		// flush cache
		$this->db->flush_cache();
		return $results;
	}
	
	function getTopicListTrash($academic_id = NULL, $exam_id = NULL, $subjects_id = NULL, $count = NULL, $start = NULL) {
		// start cache
		$this->db->start_cache();
	
		$this->db->select('t.*, ay.academic_name, e.title as etitle');
		$this->db->from('topic_manage as t');
		$this->db->join('academic_year as ay', 'ay.academic_id = t.academic_id', 'left');
		$this->db->join('exam as e', 'e.exam_id = t.exam_id', 'left');
		$this->db->where('t.status', self::STATUS_DELETED);
	
		if($academic_id) {
			$this->db->where('t.academic_id', $academic_id);
		}
	
		if($exam_id) {
			$this->db->where('t.exam_id', $exam_id);
		}
		
		if($subjects_id) {
			$this->db->where('t.subjects_id', $subjects_id);
		}
	
		$query = $this->db->get();
	
		// stop cache
		$this->db->stop_cache();
	
		// get total records before filter by limit
		$this->table_record_count = $query->num_rows();
	
		$this->db->order_by('t.created_time', 'desc');
	
	
		if(!is_null($start)) {
			if(!is_null($count)) {
				$this->db->limit($count, $start);
			}
			else {
				$this->db->limit($start);
			}
		}
	
		$query = $this->db->get();
		$results = array();
		if(!empty($query) && $query->num_rows() > 0) {
			$results = $query->result_array();
		}
	
		// flush cache
		$this->db->flush_cache();
		return $results;
	}
	
	function published($topic_manage_id) {
		if($this->unPublishedAll()) {
			$data = array('published' => 1);
			return $this->update_by_pkey($topic_manage_id, $data);
		}
		return false;
	}
	
	function delete($topic_manage_id) {
		$data = array('status' => self::STATUS_DELETED);
		return $this->update_by_pkey($topic_manage_id, $data);
	}
	
	function restore($topic_manage_id) {
		$data = array('status' => self::STATUS_ACTIVE);
		return $this->update_by_pkey($topic_manage_id, $data);
	}
	
	function change_review ( $topic_manage_id, $change_to ) {
		$data = array('review' => $change_to);
		return $this->update_by_pkey($topic_manage_id, $data);
	}
	
	function unPublishedAll() {
		$filters = array('published' => 1);
		$data = array('published' => 0);
		return $this->update($filters, $data);
	}

	function getAllTopicManage() {
		return $this->findAll(NULL, NULL, 'title', 'ASC');
	}

	function getPublishedDistinct() {
		// start cache
		$this->db->start_cache();

		$this->db->select('ay.academic_name, e.title, e.time, t.created_time, t.topic_manage_id');
		$this->db->from('topic_manage as t');
		$this->db->join('academic_year as ay', 'ay.academic_id = t.academic_id', 'left');
		$this->db->join('exam as e', 'e.exam_id = t.exam_id', 'left');
		$this->db->where('t.published', 1);
		$this->db->where('t.status', self::STATUS_ACTIVE);
		//$this->db->distinct();
		$this->db->limit(1);
		// stop cache
		$this->db->stop_cache();

		$query = $this->db->get();
		$results = array();
		if(!empty($query) && $query->num_rows() > 0) {
			$temp = $query->result_array();
			$results = $temp[0];
			unset($temp);
		}

		// flush cache
		$this->db->flush_cache();
		return $results;
	}

	function findById($id = NULL) {
		// start cache
		$this->db->start_cache();

		$this->db->select('ay.academic_name, e.title, t.created_time');
		$this->db->from('topic_manage as t');
		$this->db->join('academic_year as ay', 'ay.academic_id = t.academic_id', 'left');
		$this->db->join('exam as e', 'e.exam_id = t.exam_id', 'left');

		if($id) {
			$this->db->where('t.topic_manage_id', $id);
		}

		// stop cache
		$this->db->stop_cache();

		$query = $this->db->get();
		$results = array();
		if(!empty($query) && $query->num_rows() > 0) {
			$temp = $query->result_array();
			$results = $temp[0];
			unset($temp);
		}

		// flush cache
		$this->db->flush_cache();
		return $results;
	}
	
	function getByIdNoJoin($id, $fields = 't.*') {
		$this->db->from('topic_manage as t');
		$this->db->select($fields);
		$this->db->where('t.topic_manage_id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	function getReviewStatus($id) {
		return $this->getByIdNoJoin($id, 't.review');
	}
}