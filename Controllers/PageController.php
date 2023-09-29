<?php
class PageController{
    /**
     * - Principal: 1
     * - Pesquisa: 2
     * - Salvos: 3
     * - Perfil: 4
     *
     */
    public function pages_bar(){
        echo "<div>
        
        <nav id='menu-h'>
            <ul class='lista'>
                <li><a href=''>Principal<li>
                <li><a href=''>Pesquisa<li>
                <li><a href=''>Salvos<li>
                <li><a href=''>Perfil<li>
            </ul>
        </nav>
        
        </div>";

    }
}