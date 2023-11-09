<?php
// require_once (__DIR__."/../../Controllers/CommentController.php");
require_once (__DIR__."/Analyze.php");

class Drawing{
    private $analyze;

    public function __construct(){
        // $this->comentarios = new CommentController();
        $this->analyze = new Analyze();
    }
/***
     * - drawing_post é responsável por fazer a montagem do código Html que será renderizado
     * $result -> Dados do Banco de Dados
     * $html -> String do html básico(Sem os valores, como nome, post, etc)
     * $keywords -> São as palavras "reservadas" do html básico
     * 
     * Como Funciona: 
     * A função usará da função substituteValues para substituir as $keywords do $html pelos 
     * valores de $result, que serão exibidos com o echo.
     */
    public function drawing_post($result, $html, $keywords, $required_row){

        if (!$result) {
            throw new Exception("Erro na consulta");
        }
        else{
            //Processar o resultado, se necessário
            switch($required_row){
                case "viewPost":
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rows = [
                            $row['usu_avatar'],
                            $row['usu_nome'],
                            $row['pos_data_postagem'],
                            $row['pos_conteudo'],
                        ];
                        
                        $showHtml = $this->analyze->substituteValues($html, $keywords, $rows);
                        echo $showHtml;
                       
                    }
                    
                    break;
                    
                case "tagPost":
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rows = [
                            $row["has_id"],
                            $row["has_hashtag"]
                        ];
                        $showHtml = $this->analyze->substituteValues($html, $keywords, $rows);
                        echo $showHtml;
                    }
                    break;
                
                case "viewComment":
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rows = [
                            
                            $row['usu_nome'],
                            $row['com_data_comentario'],
                            $row['com_texto']
                        ];
                        $showHtml = $this->analyze->substituteValues($html, $keywords, $rows);
                        echo $showHtml;
                    }
                    break;
            }
            
        }
    }
}