var first = null;
mui.back = function() {
	//首次按键，提示‘再按一次退出应用’
	if (!first) {
		first = new Date().getTime();
		mui.toast('再按一次退出应用');
		setTimeout(function() {
			first = null;
		}, 1000);
	} else if (new Date().getTime() - first < 1000) {
		plus.runtime.quit();
	} else {
		first = null;
	}
};
function remove(selector){
	var header = document.getElementById("header")
	var elem = header.querySelector(selector);
	if(elem){
		header.removeChild(elem);
	}
}
function navbar($function,$icon,$text){
	var lefticon = document.createElement('a'),
		righticon = document.createElement('a'),
		leftbtn = document.createElement('button'),
		rightbtn = document.createElement('button'),
		text = document.createTextNode($text);
		lefticon.className ='mui-icon '+ $icon +' mui-pull-left';
		leftbtn.className ='mui-btn mui-btn-blue mui-btn-link mui-pull-left';
		leftbtn.appendChild(lefticon);
		leftbtn.appendChild(text);
		
		righticon.className ='mui-icon '+ $icon +' mui-pull-right';
		rightbtn.className ='mui-btn mui-btn-blue mui-btn-link mui-pull-right';
		rightbtn.innerText = $text;
	switch ($function){
		case 'left-none':
			remove('.mui-pull-left')
			break;
		case 'left-icon':
			remove('.mui-pull-left');
			header.appendChild(lefticon);
			break;
		case 'left-btn':
			remove('.mui-pull-left');
			header.appendChild(leftbtn);
			break;
		case 'right-none':
			remove('.mui-pull-right');
			break;
		case 'right-icon':
			remove('.mui-pull-right')
			header.appendChild(righticon);
			break;
		case 'right-btn':
			remove('.mui-pull-right');
			header.appendChild(rightbtn);
			break;
		}
}