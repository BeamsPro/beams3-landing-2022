function cookiesfiles(){

    document.getElementById('cookies_block').style.display = 'none';
 
}

function goglobal_open(){

    document.getElementById('goglobal_block').style.display = 'block';
 
}

function goglobal_close(){

    document.getElementById('goglobal_block').style.display = 'none';
 
}

ad = 0;

function admenu_open(){
	
	if(ad == 0){
		document.getElementById('admenu').style.display = 'block';
		ad = 1;
	}else{
		document.getElementById('admenu').style.display = 'none';
		ad = 0;
	}
	
}