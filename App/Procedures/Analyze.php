<?php

class Analyze{
    /**
     * A função substituteValues vai substituir todos os char
     * relacionados à ':' pelo valor da variável passada
     * 
     * Obs: é interessante para trazer prints muito grandes que
     * precisam de variáveis 
     */
    function substituteValues($entrada, $busca, $susbstitui) {

        $text = str_replace($busca, $susbstitui, $entrada);
        return $text;
        // foreach ($values as $key => $value) {
        //     echo $value . " " . $key;
        //     $text = str_replace('&'.$key, $value, $text);
        // }
        // return $text;
    }
    
    public function analyzeString($post, $search = " "){
        $split_post = explode($search, $post);
        //Limite minímo de letras para considerar a # ou @ como válido
        $limit = 2;
        $reserved_words = array(
                '#' => [],
                '@' => []
            ); 
        for($i = 0; $i < count($split_post); $i++){
            $split_word = str_split($split_post[$i]);
            if(count($split_word) >= $limit){

                if($split_word[0] == '#'){
                    array_push($reserved_words['#'], $split_post[$i]);
                }
                else if( $split_word[0] == '@'){
                    array_push($reserved_words['@'], $split_post[$i]);
                }
            }
            
        }
        return $reserved_words;
    }

}