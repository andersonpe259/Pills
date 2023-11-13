<?php

class PathOrganizer{

    public function path($get, $post){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post;
          } else {
            $get;
          }
    }
}