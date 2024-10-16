function abrirformulario(idmodal) {
    console.log("A função abrirformulario foi chamada");
    document.getElementById(idmodal).style.display = "block";
}

function fecharformulario(idmodal) {
    document.getElementById(idmodal).style.display = "none";
}