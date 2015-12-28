<?php

class Subject_model extends Ext_Model
{
    public function __construct()
    {
        parent::__construct('subjects', 'subjects_id');
    }
}