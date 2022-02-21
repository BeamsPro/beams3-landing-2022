var d = 0;

function mobilemenu(){
    
    if(d == 0){
		document.getElementById('top_mobile').style.top = '50px';
        document.getElementById('top_mobile').style.opacity = '1';
        document.getElementById('burger_menu').style.opacity = '0.5';
        d = 1;
    }else{
		document.getElementById('top_mobile').style.top = '-300px';
        document.getElementById('top_mobile').style.opacity = '0';
        document.getElementById('burger_menu').style.opacity = '1';
        d = 0;
    }
    
}

function cookiesfiles(){

    document.getElementById('cookies_block').style.display = 'none';
 
}