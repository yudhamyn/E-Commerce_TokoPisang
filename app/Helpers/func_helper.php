<?php
if(!function_exists('generate_pagination')){
    function generate_pagination($jml_data,$limit = 10,$page = 1)
    {
        $limit = !empty($limit) ? (int)$limit : 10;
        $page = !empty($page) ? (int)$page : 1;

        $jumlah_data = floatval($jml_data);
        $limit = floatval($limit);
        $jumlah_halaman = @ceil($jumlah_data/$limit);

        $start = ($limit * $page) - $limit;

        $start_plus = $start + 1;

        $show = "$start_plus - $limit";

        if ($start >= $limit || $jumlah_data < $limit) {
        $show = "$start_plus - $jumlah_data";
        }

        $page = (int)$page;

        $result['start'] = $start;
        $result['limit'] = $limit;
        $result['current_page'] = $page;
        $result['total'] = $jumlah_data;
        $result['last_page'] = $jumlah_halaman;

        return $result;
    }
}