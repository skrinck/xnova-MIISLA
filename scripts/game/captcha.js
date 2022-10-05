(function(){
	const fonts = ["cursive", "sans-serif", "serif", "monoscape"];
	let captchaValue = "";
	function generateCaptcha(){
		let value = btoa(Math.random()*1000000000);
		value = value.substr(0,5+Math.random()*5);
		captchaValue = value;
	}

	function setCaptcha(){
		let html = captchaValue.split("").map((char)=>{
			const rotate = -20 + Math.trunc(Math.random()*30);
			const font = Mat.trunc(Math.random()*fonts.length);
			return `<spanstyle="transform:rotate(${rotate}deg);font-family:${fonst[fonts]}">${char}</span>`
		}).join("");
		document.querySelector(".login-form .captcha .preview").innerHTML = html;
	}
	function initCaptcha(){
		document.querySelector(".login-form .captcha .captcha-refresh").addEventListener("click",function(){
			generateCaptcha();
			setCaptcha();
		});
		generateCaptcha();
		setCaptcha();
	}
	initCaptcha();

	document.querySelector(".login-form #login-btn").addEventListener("click",function(){
		let inputCaptchaValue = document.querySelector(".login-form .captcha .captcha-input").value;
		if(inputCaptchaValue === captchaValue){
			alert('SI');
		}else {
			alert('NO');
		}
	});
})();