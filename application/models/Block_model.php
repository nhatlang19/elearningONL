<?php

class Block_model extends Ext_Model
{

    public function __construct()
    {
        parent::__construct('block', 'block_id');
    }
}