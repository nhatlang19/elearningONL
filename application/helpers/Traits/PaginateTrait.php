<?php

trait PaginateTrait
{

    protected function configPagination($base_url, $total_rows, $per_page = 20, $uri_segment = 4)
    {
        $config = [];
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = 10;
        $config['uri_segment'] = "$uri_segment";
        $config['first_link'] = '&laquo; First';
        $config['last_link'] = 'Last &raquo;';
        $config['prev_link'] = '&laquo; Previous';
        $config['next_link'] = 'Next &raquo;';
        $config['anchor_class'] = 'class="number"';
        return $config;
    }
}