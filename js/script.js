// variables
var ad = 0;
var cookieTimer = null;
var showCookieDelay = 3000;
var repeatCookieDelay = 15000;
var fadeDuration = 500;
var switchSpeed = 500;

// functions


function cookiesNo(){
	if(cookieTimer) {
		clearTimeout(cookieTimer);
	}
	
	$("#cookies_block").fadeTo(fadeDuration, 0, () => {
		cookieTimer = setTimeout(() => {
			$("#cookies_block").fadeTo(fadeDuration, 1);
		}, repeatCookieDelay);
	});
}

function cookiesYes() {
	$.cookie("cookie_applied", 'true', { expires : 10 }); 
	
	$("#cookies_block").fadeTo(fadeDuration, 0, () => {
		$("#cookies_block").remove();
	});
}

function cookiesInit() {
	var cookiesApplied = $.cookie("cookie_applied") === 'true';

	if (!cookiesApplied) {
		setTimeout(() => {
			$("#cookies_block").fadeTo(fadeDuration, 1);
		}, showCookieDelay);


		$("#cookies_yes").on("click", cookiesYes);
		$("#cookies_no").on("click", cookiesNo);
	} else {
		$("#cookies_block").remove();
	}
}

function goglobal_open(){

    document.getElementById('goglobal_block').style.display = 'block';
 
}

function goglobal_close(){

    document.getElementById('goglobal_block').style.display = 'none';
}

function admenu_open(){
	
	if(ad == 0){
		document.getElementById('admenu').style.display = 'block';
		ad = 1;
	}else{
		document.getElementById('admenu').style.display = 'none';
		ad = 0;
	}
	
}

function initFAQ() {
	$("[rel='faq']").each((i,e) => {
		$(e).find(".que_block_open_but").on("click", function() {
			$(this).toggleClass("opened");
			$(e).find(".que_text").slideToggle();
		});
	});
}

function initSwitch() {
	const scopesActivity = {};
	
	$("[rel='switch']").each((i, e) => {
		let dataId = $(e).attr("data-id");
		let scope = $(e).attr("data-scope");
		
		if($(e).hasClass("go_active")) {
			scopesActivity[scope] = dataId;
		}
		
		$(e).on("click", (evt) => {
			console.log(e);
			evt.preventDefault();
			
			let current = scopesActivity[scope];
			
			$("[data-scope='" + scope + "']").removeClass("go_active");
			$(e).addClass("go_active");
			
			$("#" + current).stop().fadeTo(switchSpeed, 0, function() {
				$(this).hide();
				scopesActivity[scope] = dataId;
				$("#" + dataId).fadeTo(switchSpeed, 1);
			});
			
			return false;
		});
	});	
}

function initFilter() {
	const filterScopes = {};

	$("[rel='filter']").each((i, e) => {
		$(e).on("click", (evt) => {
			evt.preventDefault();
			
			let scope = $(e).attr('data-scope');
			let filter = $(e).attr('data-filter');
			
			$('a[data-scope="'+scope+'"]').removeClass('go_active');
			$(e).addClass('go_active');
			
			//console.log("scope:", scope);
			//console.log("filter:", filter);
			
			if (scope) {
				let items = filterScopes[scope];
				
				if (!filter) {
					$(items).show();
				} else {
					for (let item of items) {
						if (item.filter.indexOf(filter) >= 0) {
							$(item).show();
						} else {
							$(item).hide();
						}
					}
				}
			}
			
		});
	});
	
	$("[rel='filtered']").each((i, e) => {
		let scope = $(e).attr('data-scope');
		let filter = $(e).attr('data-filter');
		
		if (filter) {
			e.filter = filter.split(',');
		}
		
		if (scope) {
			if (!filterScopes[scope]) {
				filterScopes[scope] = [];
			}
			
			filterScopes[scope].push(e);
		}
	});
}

// init

$(() => {
	cookiesInit();
	initFAQ();
	initSwitch();
	initFilter();
});
