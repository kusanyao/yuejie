/**
 * 基础方法
 */
var baseMethod = {
	/**
	 * 获取链接参数
	 * @param {Object} name
	 */
	getQueryString: function(name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
		var r = window.location.search.substr(1).match(reg);
		if(r != null) {
			return unescape(r[2]);
		}
		return null;
	},
	/**
	 * 获取链接上的全部参数
	 * @param {Object} name
	 */
	getAllQueryString: function() {
		//		var hrefURL = location.href;
		//		return hrefURL.substring(hrefURL.indexOf("?") + 1);
		var reg_url = /^[^\?]+\?([\w\W]+)$/,
			reg_para = /([^&=]+)=([\w\W]*?)(&|$|#)/g,
			arr_url = reg_url.exec(location.href),
			ret;
		if(arr_url && arr_url[1]) {
			var str_para = arr_url[1],
				result;
			ret = {};
			while((result = reg_para.exec(str_para)) != null) {
				ret[result[1]] = result[2];
			}
		}
		return ret;
	},
	/**
	 * 判断传入的内容是否为空
	 * @param {Object} content
	 */
	isEmpty: function(content) {
		if(content != null && content != "" && content != "undefined" && content != "null" && content != "unknown") {
			return false;
		} else {
			return true;
		}
	},
	/**
	 * 获取控件
	 * @param {Object} id
	 */
	getView: function(id) {
		return document.getElementById(id);
	},
	/**
	 * 设置控件innerText<br>
	 * document.getElementById("id").innerText
	 * @param {Object} id 
	 * @param {Object} text
	 */
	setViewInnerText: function(id, text) {
		var v = this.getView(id);
		if(!this.isEmpty(v)) {
			v.innerText = text;
		}
	},
	/**
	 * 获取控件text
	 * @param {Object} id
	 * @param {Object} text
	 */
	getViewInnerText: function(id, text) {
		var v = this.getView(id);
		if(!this.isEmpty(v)) {
			return this.isEmpty(v.innerText) ? text : v.innerText;
		} else {
			return text;
		}
	},
	/**
	 * 设置控件value
	 * document.getElementById("id").value
	 * @param {Object} id
	 * @param {Object} value
	 */
	setViewValue: function(id, value) {
		var v = this.getView(id);
		if(!this.isEmpty(v)) {
			v.value = value;
		}
	},
	/**
	 * 获取控件value
	 * @param {Object} id
	 * @param {Object} value
	 */
	getViewValue: function(id, value) {
		var v = this.getView(id);
		if(!this.isEmpty(v)) {
			return this.isEmpty(v.value) ? value : v.value;
		} else {
			return value;
		}
	},
	/**
	 * 设置控件隐藏或是显示
	 * @param {Object} id
	 * @param {Object} type=》block ,none
	 */
	setViewDisplay: function(id, type) {
		var v = this.getView(id);
		if(!this.isEmpty(v)) {
			v.style.display = type;
		}
	},
	/**
	 * 设置cookie
	 * @param {Object} operator=》获取运营商,cu=联通,ct=电信，cm=移动，为空时默认为cu类型
	 * @param {Object} key 
	 * @param {Object} value
	 */
	setCookie: function(operator, key, value) {
		//联通：
		//unicom_phonenum
		//unicom_channelId
		//unicom_state
		//电信：
		//telecom_phonenum
		//telecom_channelId
		//telecom_state
		//移动：
		//mobile_phonenum
		//mobile_channelId
		//mobile_state
		if(operator == "cu") {
			key = "unicom_" + key;
		} else if(operator == "ct") {
			key = "telecom_" + key;
		} else if(operator == "cm") {
			key = "mobile_" + key;
		}
		document.cookie = key + "=" + value;
	},
	/**
	 * 是否为手机号码
	 * @param {Object} num
	 */
	isMobile: function(num) {
		var reg = /^(13[0-9]|15[0-9]|17[0-9]|18[0-9]|14[57])\d{8}$/;
		return reg.test(num);
	}
}

var urlMethod = {

	indexURL: function() {
		location.href = "Index.html";
	},
	schoolURL: function() {
		location.href = "School.html";
	},
	myURL: function() {
		location.href = "My.html";
	}
}

var KeyValue = {
	differentKey: "differentKey"
}