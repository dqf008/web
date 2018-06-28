// version: 1.1.0
// moved the actual file to iframe server
// egame iframe
(function(){
	var ele,s;
	s = document.createElement("script");
	ele = document.querySelector('[data-toggle="egame"]');
	try {
		if (ele) {
			url = ele.getAttribute('data-url');
			//s.src= url + '/web/frame.js';
			ele.appendChild(s);
		}
	} catch(err) {console.log(err);}
})();