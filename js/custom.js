function maskCPF(numberCPF){
    var cpf = numberCPF.value;
    
    if (isNaN(cpf[cpf.length - 1])) { // Proibir caractere que não seja número
        numberCPF.value = cpf.substring(0, cpf.length - 1);
        return;
    }
    
    if(cpf.length === 3 || cpf.length === 7){
        numberCPF.value += ".";
    }
    if(cpf.length === 11){
        numberCPF.value += "-";
    }
}



function maskPhone(numberPhone){
    var phone = numberPhone.value;
    
    if(phone.length < 14){
        phone = phone.replace(/\D/g, "");
        phone = phone.replace(/^(\d{2})(\d)/g, "($1)$2");
        phone = phone.replace(/(\d)(\d{3})$/, "$1-$2");
        numberPhone.value = phone;
    }
}



function moeda(a, e, r, t) {
    let n = ""
      , h = j = 0
      , u = tamanho2 = 0
      , l = ajd2 = ""
      , o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
        return !0;
    if (n = String.fromCharCode(o),
    -1 == "0123456789".indexOf(n))
        return !1;
    for (u = a.value.length,
    h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
        ;
    for (l = ""; h < u; h++)
        -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
    0 == (u = l.length) && (a.value = ""),
    1 == u && (a.value = "0" + r + "0" + l),
    2 == u && (a.value = "0" + r + l),
    u > 2) {
        for (ajd2 = "",
        j = 0,
        h = u - 3; h >= 0; h--)
            3 == j && (ajd2 += e,
            j = 0),
            ajd2 += l.charAt(h),
            j++;
        for (a.value = "",
        tamanho2 = ajd2.length,
        h = tamanho2 - 1; h >= 0; h--)
            a.value += ajd2.charAt(h);
        a.value += r + l.substr(u - 2, u)
    }
    return !1
}



function checkoutClient(){
    var cpf = document.getElementById("cpf").value;
    $.get("admin/checkout-client.php?cpf="+cpf, function(dados) {
        console.log(cpf);
    });
}




$(window).on('load', function () {
    $('#preloader .inner').fadeOut();
    $('#preloader').delay(350).fadeOut('slow');     
    $('body').delay(350).css({'overflow': 'visible'});
});