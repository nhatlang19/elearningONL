<?php

class Academic_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('academic_year', 'academic_id');
    }
}