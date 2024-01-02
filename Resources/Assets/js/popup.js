function exibirPopup(id = false) { 
    if(id !== false){
        document.getElementById('popup-container'+id).style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }else{
        document.getElementById('popup-container').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }
        
}


function fecharPopup(id = false) {
    if(id !== false){
        document.getElementById('popup-container'+id).style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }else{
        document.getElementById('popup-container').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
}

function confirmarSaida() {
    window.location.href = 'Index.php'; // Adicione aqui a lógica desejada ao confirmar "Sim"
    fecharPopup();
}