<?php

namespace App\Library;

class Utility
{
    public static function paginator($data, $paginate, $limit)
    {
        $data['paginator'] = array();

        // calculate next record
        if ($paginate->currentPage() < $paginate->lastPage()){
            $next = $paginate->currentPage()+1;
        } else {
            $next = null;
        }

        // calculate previous record
        if ($paginate->currentPage() > 1) {
            $previous = $paginate->currentPage()-1;
        } else {
          $previous = 1;
        }

        $data['paginator']['next']  = $next;
        $data['paginator']['previous'] = $previous;
        $data['paginator']['current']  = $paginate->currentPage();
        $data['paginator']['first']  = 1;
        $data['paginator']['last']  = $paginate->lastPage();
        $data['paginator']['total_pages']  = ceil($paginate->total() / $limit);  
        //        $data['pagination']['to']   = $paginate->getTo();
        //       $data['pagination']['from']  = $paginate->getFrom();
        $data['paginator']['total']  = $paginate->total();

        // return data and 200 response
        return $data;
    }
   
}
