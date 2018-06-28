function inputFocus(self,e){
	self.style.background = "#DDFFDE";
	var d = document.getElementById("zhuce_top").getElementsByTagName("span");
	d[e].className = "zhuce_06";

	switch(e){
		case 0:
			d[e].innerHTML = "<font class='fontcolor'>您在网站的登录帐户，5-15个英文或数字组成</font>";
			break;
		case 1:
			d[e].innerHTML = "<font class='fontcolor'>请牢记您的密码</font>"
			break;
		case 2:
			d[e].innerHTML = "<font class='fontcolor'>请重复密码，必须和上面输入的密码一致</font>"
			break;
		case 3:
			d[e].innerHTML = "<font class='fontcolor'>名字必须与您用于提款及存款的银行户口所用名字相同</font>"
			break;
		case 4: 
			d[e].innerHTML = "<font class='fontcolor'>请填写您正确的电话号码</font>"
			break;
		case 5:
			d[e].innerHTML = "<font class='fontcolor'>请填写您正确的电子邮箱或QQ</font>"
			break;
		case 6:
			d[e].innerHTML = "<font class='fontcolor'>请填写您正确的微信号</font>"
			break;
        case 8:
			d[e].innerHTML = "<font class='fontcolor'>请牢记您的密码答案</font>"
			break;
		case 9:
			d[e].innerHTML = "<font class='fontcolor'>请输入6位数字取款密码</font>";
			break;
		case 10:
			d[e].innerHTML = "<font class='fontcolor'>请输入右图中的验证码</font>";
			break;
		case 11:
			d[e].innerHTML = "<font class='fontcolor'>您在网站的登录帐户，5-15个英文或数字组成</font>";
			break;
	}
	
}

function inputBlur(self,e){
	self.style.background = "#ffffff";
	var d = document.getElementById("zhuce_top").getElementsByTagName("span");
	if(self.value == ""){
		switch(e){
			case 0:
				d[e].innerHTML = "<font class='zhuce_03'>请输入用户名</font>";
				self.pd = "no";
				break;
			case 1:
				d[e].innerHTML = "<font class='zhuce_03'>请输入密码</font>";
				self.pd = "no";
				break;
			case 2:
				d[e].innerHTML = "<font class='zhuce_03'>请重复密码</font>";
				self.pd = "no";
				break;
			case 3:
				d[e].innerHTML = "<font class='zhuce_03'>请输入真实的姓名</font>";
				self.pd = "no";
				break;
			case 4:
				d[e].innerHTML = "<font class='zhuce_03'>请填写电话</font>";
				self.pd = "no";
				break;
			case 5:
				d[e].innerHTML = "<font class='zhuce_03'>请填写邮箱或QQ</font>";
				self.pd = "no";
				break;
			case 6:
				d[e].innerHTML = "<font class='zhuce_03'>请填写微信号</font>";
				self.pd = "no";
				break;	
				
            case 8:
				d[e].innerHTML = "<font class='zhuce_03'>请填写密码答案</font>";
				self.pd = "no";
				break;
            case 9:
				d[e].innerHTML = "<font class='zhuce_03'>请输入取款密码</font>";
				self.pd = "no";
				break;
			case 10:
				d[e].innerHTML = "<font class='zhuce_03'>验证码不能为空</font>";
				self.pd = "no";
				break;
			
		}
	}else{
		switch(e){
			case 0: 
				var zz = /^[0-9a-zA-Z]{5,15}$/;
				if(!zz.test(self.value)){
					d[e].innerHTML = "<font class='zhuce_03'>您在网站的登录帐户，5-15个英文或数字组成</font>";
					self.pd = "no";
				}else{
					var url = "check_username.php?username="+self.value;
					xhr(url);
				}
				break;
			case 1: 
				var zz = /^.{6,20}$/;
				if(!zz.test(self.value)){
					d[e].innerHTML = "<font class='zhuce_03'>请输入密码，6-20位间任意字符组成</font>";
					self.pd = "no";
				}else{
					d[e].className = "zhuce_04";
					d[e].innerHTML = "<font color='green'>填写正确</font>";
					self.pd = "yes";
				}
				break;
			case 2: 
				var xx = /^.{6,20}$/;
				if(self.value != document.getElementById("pwd1").value || !xx.test(self.value)){
					d[e].innerHTML = "<font class='zhuce_03'>密码格式有误或和上面输入的密码不一致，请检查</font>";
					self.pd = "no";
				}else{
					d[e].className = "zhuce_04";
					d[e].innerHTML = "<font color='green'>填写正确</font>";
					self.pd = "yes";
				}
				break;
			case 3: 
				if(self.value.length > 20 ){
					d[e].innerHTML = "<font class='zhuce_03'>用户名长度不应超过20个字符</font>";
					self.pd = "no";
				}else{
                    d[e].className = "zhuce_04";
                    d[e].innerHTML = "<font color='green'>填写正确</font>";
                    self.pd = "yes";
				}
				break;
			case 4: 
				var tel = /^\d{6,13}$/;
				if(!tel.test(self.value)){
					d[e].innerHTML = "<font class='zhuce_03'>请输入纯数字正确的电话号码</font>";
					self.pd = "no";
				}else{
					d[e].className = "zhuce_04";
					d[e].innerHTML = "<font color='green'>填写正确</font>";
					self.pd = "yes";
				}
				break;
			case 5: 
				var em = /^[1-9][0-9]{4,}$|[\w!#$%&'*+/=?^_`{|}~-]+(?:\.[\w!#$%&'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?/
				if(!em.test(self.value)){
					d[e].innerHTML = "<font class='zhuce_03'>邮箱或QQ格式不正确，如user@domain.com</font>";
					self.pd = "no";
				}else{
					d[e].className = "zhuce_04";
					d[e].innerHTML = "<font color='green'>填写正确</font>";
					self.pd = "yes";
				}
				break;
		  case 6: 
				d[e].className = "zhuce_04";
				d[e].innerHTML = "<font color='green'>填写正确</font>";
				self.pd = "yes";
				break;
            case 8: 
				d[e].className = "zhuce_04";
				d[e].innerHTML = "<font color='green'>填写正确</font>";
				self.pd = "yes";
				break;
			case 9: 
				var qkpass = /^\d{6}$/;
				if(!qkpass.test(self.value)){
					d[e].innerHTML = "<font class='zhuce_03'>请输入6位数字取款密码</font>";
					self.pd = "no";
				}else{
					d[e].className = "zhuce_04";
					d[e].innerHTML = "<font color='green'>填写正确</font>";
					self.pd = "yes";
				}
				break;
			case 10: 
				d[e].className = "zhuce_04";
				d[e].innerHTML = "<font color='green'>填写正确</font>";
				self.pd = "yes";
				break;
			case 11: 
				d[e].className = "zhuce_04";
				d[e].innerHTML = "<font color='green'>填写正确</font>";
				self.pd = "yes";
				break;
		}
	}
}

function formsubmit(obja){
	var d = document.getElementById("zhuce_top").getElementsByTagName("span");
	var bool = true;

	for(i=0; i<obja.length; i++){
		if(obja.elements[i].value == "" && obja.elements[i].name != "jsr"){
			obja.elements[i].style.background = "#DDFFDE";
			d[i].innerHTML = "<font class='zhuce_03'>此项不能为空</font>";
			bool = false;
		}
	}

	if(!bool) return false;
	for(i=0; i<obja.length; i++){
		if(obja.elements[i].pd == "no"){
			obja.elements[i].style.background = "#DDFFDE";
			d[i].className = "zhuce_03";
			bool = false;
		}
	}
	if(!bool) return false;

	if(obja.zccheck.checked == false){
		alert("如果您已满十八岁而且同意本站[条款及规则]，请在该项打勾");
		return false;
	}
}

function change_zc_yzm(id){
	document.getElementById(id).src = "yzm.php?"+Math.random();
	return false;
}

function getreturn(){
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200) {
			var text = xmlhttp.responseText;
			
			if(text == "y"){
				document.getElementById("nameid").className = "zhuce_04";
				document.getElementById("nameid").innerHTML = "<font color='green'>恭喜您，用户名可用</font>";
				document.getElementById("zcusername").pd = "yes";
			}else{
				document.getElementById("nameid").className = "zhuce_03";
				document.getElementById("nameid").innerHTML = "<font'>抱歉，用户名已经被占用</font>";
				document.getElementById("zcusername").pd = "no";
			}
			
		} else {
			alert('系统错误提示：'+xmlhttp.status);
			document.getElementById("nameid").innerHTML = "操作失败";
			document.getElementById("zcusername").pd = "no";
		}
	}
}

function isNoChinese(v){
	var reg=/^([\u4E00-\u9FA5]|[\uFE30-\uFFA0])+$/gi;
	if (reg.test(v)) return true;
	else return false;
}

function CharMode(iN) {
	if (iN>=48 && iN <=57) //数字
		return 1;
	if (iN>=65 && iN <=90) //大写字母
		return 2;
	if (iN>=97 && iN <=122) //小写
		return 4;
	else
		return 8; //特殊字符
}

function bitTotal(num) {
	var modes=0;
	for (i=0;i<4;i++) {
		if (num & 1) modes++;
		num>>>=1;
	}
	return modes;
}

function checkStrong(sPW) {
    if (sPW.length<=6) return 0; 
	var Modes=0;
	for (i=0;i<sPW.length;i++) { 
		Modes|=CharMode(sPW.charCodeAt(i));
	}
	return bitTotal(Modes);
}

function pwStrength(pwd,num) {
	var O_color="#eeeeee";
	var L_color="#FF0000";
	var M_color="#FF9900";
	var H_color="#33CC00";
	if (pwd==null||pwd==''){
		Lcolor=Mcolor=Hcolor=O_color;
	}else{
		S_level=checkStrong(pwd);
		switch(S_level) {
			case 0://最强
				Lcolor=Mcolor=Hcolor=O_color;
			case 1://最弱
				Lcolor=L_color;
				Mcolor=Hcolor=O_color;
				break;
			case 2://中等
				Lcolor=Mcolor=M_color;
				Hcolor=O_color;
				break;
			default://默认
				Lcolor=Mcolor=Hcolor=H_color;
		}
	}
	document.getElementById("strength_L"+num).style.background=Lcolor;
	document.getElementById("strength_M"+num).style.background=Mcolor;
	document.getElementById("strength_H"+num).style.background=Hcolor;
	return;
}