/*
 * jQuery Masked Input Plugin
 * Copyright (c) 2007 - 2015 Josh Bush (digitalbush.com)
 * Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license)
 * Version: 1.4.1
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a){var b,c=navigator.userAgent,d=/iphone/i.test(c),e=/chrome/i.test(c),f=/android/i.test(c);a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},autoclear:!0,dataName:"rawMaskFn",placeholder:"_"},a.fn.extend({caret:function(a,b){var c;if(0!==this.length&&!this.is(":hidden"))return"number"==typeof a?(b="number"==typeof b?b:a,this.each(function(){this.setSelectionRange?this.setSelectionRange(a,b):this.createTextRange&&(c=this.createTextRange(),c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select())})):(this[0].setSelectionRange?(a=this[0].selectionStart,b=this[0].selectionEnd):document.selection&&document.selection.createRange&&(c=document.selection.createRange(),a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length),{begin:a,end:b})},unmask:function(){return this.trigger("unmask")},mask:function(c,g){var h,i,j,k,l,m,n,o;if(!c&&this.length>0){h=a(this[0]);var p=h.data(a.mask.dataName);return p?p():void 0}return g=a.extend({autoclear:a.mask.autoclear,placeholder:a.mask.placeholder,completed:null},g),i=a.mask.definitions,j=[],k=n=c.length,l=null,a.each(c.split(""),function(a,b){"?"==b?(n--,k=a):i[b]?(j.push(new RegExp(i[b])),null===l&&(l=j.length-1),k>a&&(m=j.length-1)):j.push(null)}),this.trigger("unmask").each(function(){function h(){if(g.completed){for(var a=l;m>=a;a++)if(j[a]&&C[a]===p(a))return;g.completed.call(B)}}function p(a){return g.placeholder.charAt(a<g.placeholder.length?a:0)}function q(a){for(;++a<n&&!j[a];);return a}function r(a){for(;--a>=0&&!j[a];);return a}function s(a,b){var c,d;if(!(0>a)){for(c=a,d=q(b);n>c;c++)if(j[c]){if(!(n>d&&j[c].test(C[d])))break;C[c]=C[d],C[d]=p(d),d=q(d)}z(),B.caret(Math.max(l,a))}}function t(a){var b,c,d,e;for(b=a,c=p(a);n>b;b++)if(j[b]){if(d=q(b),e=C[b],C[b]=c,!(n>d&&j[d].test(e)))break;c=e}}function u(){var a=B.val(),b=B.caret();if(o&&o.length&&o.length>a.length){for(A(!0);b.begin>0&&!j[b.begin-1];)b.begin--;if(0===b.begin)for(;b.begin<l&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}else{for(A(!0);b.begin<n&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}h()}function v(){A(),B.val()!=E&&B.change()}function w(a){if(!B.prop("readonly")){var b,c,e,f=a.which||a.keyCode;o=B.val(),8===f||46===f||d&&127===f?(b=B.caret(),c=b.begin,e=b.end,e-c===0&&(c=46!==f?r(c):e=q(c-1),e=46===f?q(e):e),y(c,e),s(c,e-1),a.preventDefault()):13===f?v.call(this,a):27===f&&(B.val(E),B.caret(0,A()),a.preventDefault())}}function x(b){if(!B.prop("readonly")){var c,d,e,g=b.which||b.keyCode,i=B.caret();if(!(b.ctrlKey||b.altKey||b.metaKey||32>g)&&g&&13!==g){if(i.end-i.begin!==0&&(y(i.begin,i.end),s(i.begin,i.end-1)),c=q(i.begin-1),n>c&&(d=String.fromCharCode(g),j[c].test(d))){if(t(c),C[c]=d,z(),e=q(c),f){var k=function(){a.proxy(a.fn.caret,B,e)()};setTimeout(k,0)}else B.caret(e);i.begin<=m&&h()}b.preventDefault()}}}function y(a,b){var c;for(c=a;b>c&&n>c;c++)j[c]&&(C[c]=p(c))}function z(){B.val(C.join(""))}function A(a){var b,c,d,e=B.val(),f=-1;for(b=0,d=0;n>b;b++)if(j[b]){for(C[b]=p(b);d++<e.length;)if(c=e.charAt(d-1),j[b].test(c)){C[b]=c,f=b;break}if(d>e.length){y(b+1,n);break}}else C[b]===e.charAt(d)&&d++,k>b&&(f=b);return a?z():k>f+1?g.autoclear||C.join("")===D?(B.val()&&B.val(""),y(0,n)):z():(z(),B.val(B.val().substring(0,f+1))),k?b:l}var B=a(this),C=a.map(c.split(""),function(a,b){return"?"!=a?i[a]?p(b):a:void 0}),D=C.join(""),E=B.val();B.data(a.mask.dataName,function(){return a.map(C,function(a,b){return j[b]&&a!=p(b)?a:null}).join("")}),B.one("unmask",function(){B.off(".mask").removeData(a.mask.dataName)}).on("focus.mask",function(){if(!B.prop("readonly")){clearTimeout(b);var a;E=B.val(),a=A(),b=setTimeout(function(){B.get(0)===document.activeElement&&(z(),a==c.replace("?","").length?B.caret(0,a):B.caret(a))},10)}}).on("blur.mask",v).on("keydown.mask",w).on("keypress.mask",x).on("input.mask paste.mask",function(){B.prop("readonly")||setTimeout(function(){var a=A(!0);B.caret(a),h()},0)}),e&&f&&B.off("input.mask").on("input.mask",u),A()})}})});

var LSSWidget = (function ( $, LSSW_data ) {
	'use strict';

	var pub = {}, toSend = {}, $widgetWindow = $('#LSSW_next_step'), $loading = $('#LSSW_loading'), results;

	// Set up jQeury Validator
	$.validator.addMethod("phoneUS", function(phone_number, element) {
		phone_number = phone_number.replace(/\s+/g, "");
		return this.optional(element) || phone_number.length > 9 &&
			phone_number.match(/^(\+?1-?)?(\([2-9]([02-9]\d|1[02-9])\)|[2-9]([02-9]\d|1[02-9]))-?[2-9]([02-9]\d|1[02-9])-?\d{4}$/);
	}, "Please specify a valid phone number");

	$('#LSSW_form').validate({
		onkeyup: false,
		onfocusout: false,
		rules: {
			LSSW_field_query: {
				required: true
			}
		},
		submitHandler: function(form) { return LSSWidget.doSearch(); }
	});

	function validateStepTwo() {
		var ruleset = {};
		if ( toSend.new === true ) {
			ruleset = {
				LSSW_field_business_name: {
					required: true
				},
				LSSW_field_address: {
					required: true
				},
				LSSW_field_city: {
					required: true
				},
				LSSW_field_state: {
					required: true
				},
				LSSW_field_zipcode: {
					required: true
				},
				LSSW_field_country: {
					required: true
				},
				LSSW_field_business_phone: {
					required: true,
					phoneUS: true
				},
				LSSW_field_website: {
					required: false,
					url: true
				}
			};
		}
		if (LSSW_data.keyword) {
			ruleset.LSSW_field_keyword = {
				required: true
			};
		}
		if (LSSW_data.contact) {
			ruleset.LSSW_field_name = {
				required: true
			};
			ruleset.LSSW_field_phone = {
				required: true,
				phoneUS: true
			};
			ruleset.LSSW_field_email = {
				required: true
			};
		}
		$('#LSSWStepTwo').validate({
			onkeyup: false,
			onfocusout: false,
			rules: ruleset,
			submitHandler: function(form) { return LSSWidget.signUp(); }
		});
	}

	// Private functions that render html
	function startLoading() {
		//
		$loading.fadeIn(400);
		$widgetWindow.before($widgetWindow.clone().attr('id', 'LSSWclone'));
		$('#LSSWclone').css('z-index', 500).css('position', 'absolute');
	}

	function stopLoading() {
		$widgetWindow.fadeIn(400);
		$loading.fadeOut(400, function() {
			$loading.hide();
		});
		$('#LSSWclone').fadeOut(500, function() {
			$('#LSSWclone').remove();
		});
	}
	function renderResults() {
		var resultSize = results.data.length, output;

		// header
		if (resultSize == 0) {
			output  = '<div id="LSSW_Alert_Wrap"><span id="LSSW_Alert" class="LSSW_x">' + results.title + "</span></div>";
			output += '<p id="LSSW_Alert_more">'  + results.more +  "</p>";
			output += '<div class="LSSW_results">';
		} else {
			output  = '<div id="LSSW_Alert_Wrap"><span id="LSSW_Alert" class="LSSW_c">' + results.title + "</span></div>";
			output += '<p id="LSSW_Alert_more">'  + results.more +  "</p>";
			output += '<div class="LSSW_results">';
		}

		for (var i = 0; i < resultSize; ++i) {
			output += '<div class="LSSW_Col"><div class="LSSW_Block"><div class="LSSW_Biz_Title">' + results.data[i].business_name + '</div>';
			output += '<div class="LSSW_Address">' + results.data[i].street + '<br>' + results.data[i].city + ', ' + results.data[i].state + " ";
			output += results.data[i].zipcode + ', ' + results.data[i].country + '<br>' + results.data[i].phone + '</div>';
			output += '<a href="' + results.data[i].website + '" target="_blank" class="LSSW_URL">' + results.data[i].website + '</a><br>';
			output += '<button class="LSSW_btn" onClick="LSSWidget.select(' + i + ');">This is My Business</button>';
			output += '</div></div>';

			if ( 0 == (i + 1) % 2) {
				output += '</div><div class="LSSW_results">';
			}
		}

		output += '<div class="LSSW_Col"><div class="LSSW_Block"><p>If your business is not listed, please click below to enter it in.</p>';
		output += '<button class="LSSW_btn" onclick="LSSWidget.newBusiness();">Get Listed Now</button></div>';
		output += '</div></div></div>';

		return output;
	}

	function renderStepTwo() {
		var output = '';

		if (LSSW_data.keyword) {
			output += '<div id="LSSW_keyword" class="LSSW_fields"><h3>Enter Keyword</h3>'
			+ '<p>What is or would be the main keyword customers would use to search for you on Google, Yahoo or Bing?</p>'
			+ '<p>Your keyword can be anything from "pizza" to "carpet cleaners" depending on what your business does.</p>'
			+ '<span class="LSSW_keyword_wrap"> <input type="text" id="LSSW_field_keyword" name="LSSW_field_keyword" '
			+ 'value="" placeholder="Enter Keyword Here"></span></div>';
		}

		if (LSSW_data.contact) {
			output += '<div id="LSSW_contact" class="LSSW_fields"><h3>Contact Information</h3><span class="LSSW_name_wrap">'
				+ '<label class="LSSW_label">Full Name</label><input type="text" id="LSSW_field_name" name="LSSW_field_name" placeholder="Full Name">'
				+ '</span><span class="LSSW_phone_wrap"><label class="LSSW_label">Phone</label>'
				+ '<input type="text" id="LSSW_field_phone" name="LSSW_field_phone" placeholder="(XXX) XXX-XXXX"></span>'
				+ '<span class="LSSW_email_wrap"><label class="LSSW_label">Email</label>'
				+ '<input id="LSSW_field_email" type="text" name="LSSW_field_email" placeholder="email@example.com"></span></div>';
		}

		output += '<div id="LSSW_step_two_footer" class="LSSW_fields"><input type="submit" id="LSSW_signUp" class="LSSW_btn" value="Get Listed Now"></div>';

		return output;
	}

	function renderNewBusiness() {
		var output = '';

		output += '<div id="LSSW_new_business" class="LSSW_fields"><h3>Business Information</h3><span class="LSSW_business_name_wrap">'
			+ '<label class="LSSW_label">Business Name</label><input type="text" id="LSSW_field_business_name" '
			+ 'name="LSSW_field_business_name" placeholder="Enter Business Name"></span><span class="LSSW_address_wrap">'
			+ '<label class="LSSW_label">Address</label><input type="text" id="LSSW_field_address" name="LSSW_field_address" '
			+ 'placeholder="Enter Address"></span><span class="LSSW_city_wrap"><label class="LSSW_label">City</label>'
			+ '<input id="LSSW_field_city" type="text" name="LSSW_field_city" placeholder="Enter City"></span>'
			+ '<label class="LSSW_label">State / Province</label><!-- state dropdown goes here --><select id="LSSW_field_state" name="LSSW_field_state">'
			+ '<option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option> <option value="CT">Connecticut</option> <option value="DE">Delaware</option> <option value="DC">District of Columbia</option> <option value="FL">Florida</option> <option value="GA">Georgia</option> <option value="HI">Hawaii</option> <option value="ID">Idaho</option> <option value="IL">Illinois</option> <option value="IN">Indiana</option> <option value="IA">Iowa</option> <option value="KS">Kansas</option> <option value="KY">Kentucky</option> <option value="LA">Louisiana</option> <option value="ME">Maine</option> <option value="MD">Maryland</option> <option value="MA">Massachusetts</option> <option value="MI">Michigan</option> <option value="MN">Minnesota</option> <option value="MS">Mississippi</option> <option value="MO">Missouri</option> <option value="MT">Montana</option> <option value="NE">Nebraska</option> <option value="NV">Nevada</option> <option value="NH">New Hampshire</option> <option value="NJ">New Jersey</option> <option value="NM">New Mexico</option> <option value="NY">New York</option> <option value="NC">North Carolina</option> <option value="ND">North Dakota</option> <option value="OH">Ohio</option> <option value="OK">Oklahoma</option> <option value="OR">Oregon</option> <option value="PA">Pennsylvania</option> <option value="PR">Puerto Rico</option> <option value="RI">Rhode Island</option> <option value="SC">South Carolina</option> <option value="SD">South Dakota</option> <option value="TN">Tennessee</option> <option value="TX">Texas</option><option value="UT">Utah</option><option value="VI">Virgin Islands</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option>'
			+ '</select></span><span class="LSSW_zipcode_wrap"><label class="LSSW_label">Postal Code</label>'
			+ '<input type="text" id="LSSW_field_zipcode" name="LSSW_field_zipcode" placeholder="Enter Postal Code"></span>'
			+ '<span class="LSSW_country_wrap"><label class="LSSW_label">Country</label><select id="LSSW_field_country" name="LSSW_field_country">'
				+ '<option value="US">United States</option>'
				+ '<option value="CA">Canada</option>'
				+ '<option value="BS">Bahamas</option>'
			+ '</select></span><span class="LSSW_business_phone_wrap"><label class="LSSW_label">Business Phone</label>'
			+ '<input type="tel" id="LSSW_field_business_phone" name="LSSW_field_business_phone" placeholder="Enter Business Phone">'
			+ '</span><span class="LSSW_business_phone_wrap"><label class="LSSW_label">Website</label>'
			+ '<input type="text" id="LSSW_field_website" name="LSSW_field_website" placeholder="Enter Website">'
			+ '</span></div>';

		output += renderStepTwo();
		return output;
	}

	// Sends off the final package
	function sendData ( data ) {
		startLoading();

		$.ajax({
			url : LSSW_data.base + LSSW_data.signup,
			type : 'POST',
			data : data,
			tryCount : 0,
			retryLimit : 2,
			success : function(ret) { // http://jhenke.dev.lssdev.com/?page=site/clients/baseline&client_id=103051&public=ed88a4c673d97d7fc99cb927fc1ca558
				var url = LSSW_data.dashboard + '/?page=site/clients/baseline&client_id=' + ret.data.client_id + '&public=' + ret.data.public;

				$widgetWindow.html( '<div class="LSSW_fields"><a href="' + url + '" target="_blank" class="LSSW_btn">Click here to view your report</a></div>' );
				stopLoading();
			},
			error : function(xhr, textStatus, errorThrown ) {
				if (textStatus == 'timeout') {
					this.tryCount++;
					if (this.tryCount <= this.retryLimit) {
						//try again
						console.log( this.tryCount );
						$.ajax(this);
					}
				}
			}
		});

		return false;
	}

	pub.signUp = function () {
		// Get the form data
		if (LSSW_data.keyword) {
			if (!toSend.keywords || toSend.keywords.constructor !== Array) {
				toSend.keywords = [];
			}
			// put in the front of the array.
			toSend.keywords.unshift($('#LSSW_field_keyword').val());
		}
		if (LSSW_data.contact) {
			toSend.name = $('#LSSW_field_name').val();
			toSend.contact_phone = $('#LSSW_field_phone').val();
			toSend.email = $('#LSSW_field_email').val();
		}

		if (toSend.new === true) {
			toSend.business_name = $('#LSSW_field_business_name').val();
			toSend.street = $('#LSSW_field_address').val();
			toSend.city = $('#LSSW_field_city').val();
			toSend.state = $('#LSSW_field_state').val();
			toSend.zipcode = $('#LSSW_field_zipcode').val();
			toSend.country = $('#LSSW_field_country').val();
			toSend.phone = $('#LSSW_field_business_phone').val();
			toSend.website = $('#LSSW_field_website').val();
		}

		sendData( toSend );
	};

	pub.select = function (selected) {
		toSend = results.data[selected];
		// If we're not capturing keyword or contact, there's no step 2
		if ( !LSSW_data.keyword && !LSSW_data.contact ) {
			return signUp( results.data[selected] );
		}

		startLoading();
		$widgetWindow.html( '<form id="LSSWStepTwo"">' + renderStepTwo() + '</form>' );
		validateStepTwo();
		stopLoading();
		return false;
	};

	pub.newBusiness = function () {
		toSend.new = true;

		startLoading();
		$widgetWindow.html( '<form id="LSSWStepTwo"">' + renderNewBusiness() + '</form>' );
		validateStepTwo();
		stopLoading();
	};

	pub.doSearch = function() {
		startLoading();
		var query = {'search': $('#LSSW_field_query').val()};

		$.ajax({
			url : LSSW_data.base + LSSW_data.search,
			type : 'GET',
			data : query,
			tryCount : 0,
			retryLimit : 5,
			success : function(ret) {
				results = ret;
				$widgetWindow.html( renderResults() );
				stopLoading();
			},
			error : function(xhr, textStatus, errorThrown ) {
				if (textStatus == 'timeout') {
					this.tryCount++;
					if (this.tryCount <= this.retryLimit) {
						//try again
						console.log( this.tryCount );
						$.ajax(this);
					}
				}
			}
		});
		return false;
	};

	return pub;
})( jQuery, LSSW_data );
