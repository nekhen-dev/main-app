function isNumeric(n){
    return !isNaN(parseFloat(n)) && isFinite(n);
}
function num_virgula_para_ponto(n){
    return parseFloat(n.replace(',','.'));
}
function num_ponto_para_virgulo(n){
    return n.replace('.',',');
}
