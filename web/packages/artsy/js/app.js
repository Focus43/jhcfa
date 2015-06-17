!function(e,t){"use strict";t.module("artsy",["artsy.common","ngSanitize"]).config(["$provide",function(){document.querySelectorAll("[fb-sdk]").length&&(e.fbAsyncInit=function(){FB.init({appId:"884434574982022",xfbml:!0,version:"v2.3"}),console.log("✓ FacebookSDK")},function(e,t,n){var o=e.createElement("div");o.id="fb-root",e.body.appendChild(o);var r,a=e.getElementsByTagName(t)[0];e.getElementById(n)||(r=e.createElement(t),r.id=n,r.src="//connect.facebook.net/en_US/sdk.js",a.parentNode.insertBefore(r,a))}(document,"script","facebook-jssdk"))}]).run(["$rootScope","$window","$timeout","$q","FastClick","BrowserDetect","$compile",function(e,n,o,r,a,i,s){a.attach(document.body),document.documentElement.setAttribute("data-ua",i.browser);var c=document.querySelectorAll('[class*="wrap-theme-"]');if(c.length)for(var l=0,u=c.length;u>l;l++){for(var d=t.element(c[l]);!d.hasClass("container")&&d.length;)console.log("locating_parent_container"),d=t.element(d.parent());d.length&&d.addClass("overflowable-x")}t.element(document.documentElement).hasClass("cms-edit-mode")&&r(function(e){!function t(){o(function(){return n.ConcreteEvent?(e(n.ConcreteEvent),void 0):(t(),void 0)},200)}()}).then(function(t){t.subscribe("EditModeAddBlockComplete EditModeUpdateBlockComplete EditModeExitInlineSaved EditModeExitInline",function(){o(function(){console.log("Recompiling DOM"),s(document.body)(e)},2e3)})})}]),t.element(document).ready(function(){t.bootstrap(document.body,["artsy"])})}(window,window.angular),angular.module("artsy.common",[]),angular.module("artsy.common").controller("CtrlCalendarPage",["$scope","Schedulizer","moment",function(e,t,n){e.eventData=[],e.uiState={fetchInProgress:!1,showSearchExtras:!1,showTagList:!1,initialFetchComplete:!1},e.overrideDateRange={start:n().startOf("month"),end:n().add(5,"months").endOf("month")},e.isTextSearch=!1,e.filters={fields:["calendarID"],keywords:null,calendars:"",tags:"",categories:1,filepath:!0,start:n().startOf("month").format("YYYY-MM-DD"),end:n().endOf("month").format("YYYY-MM-DD"),attributes:"presenting_organization,date_display,ticket_link,event_not_ticketed"},e.fetch=function(){e.uiState.fetchInProgress=!0;var n=e.isTextSearch===!1?e.filters:angular.extend({},e.filters,{start:e.overrideDateRange.start.format("YYYY-MM-DD"),end:e.overrideDateRange.end.format("YYYY-MM-DD")});t.fetch(n).success(function(t){e.eventData=t,e.uiState.fetchInProgress=!1,e.uiState.initialFetchComplete=!0}).error(function(){console.log("err")})},e.setCategory=function(t){e.filters.categories=t},e.$watch("filters",function(t){e.isTextSearch=angular.isString(t.keywords)&&t.keywords.length,t&&e.fetch()},!0);var o=n();o._selected=!0,e.monthsToView=[o];for(var r=1;5>=r;r++){var a=o.clone().add(r,"month");a._selected=!1,e.monthsToView.push(a)}e.selectedMonthIndex=0,e.selectMonth=function(t){for(var n=0,o=e.monthsToView.length;o>n;n++)e.monthsToView[n]._selected=!1;e.monthsToView[t]._selected=!0,e.selectedMonthIndex=t,e.filters.start=e.monthsToView[t].clone().startOf("month").format("YYYY-MM-DD"),e.filters.end=e.monthsToView[t].clone().endOf("month").format("YYYY-MM-DD")},e.funcKeyup=function(t){e.uiState.showSearchExtras=0!==t.target.value.length,e.uiState.fetchInProgress=!0},e.clearSearch=function(){e.uiState.showSearchExtras=!1,e.filters.keywords=null},e.selectedTags=[],e.toggleTag=function(t){return-1!==e.selectedTags.indexOf(t)?(e.selectedTags.splice(e.selectedTags.indexOf(t),1),e.filters.tags=e.selectedTags.join(","),void 0):(e.selectedTags.push(t),e.filters.tags=e.selectedTags.join(","),void 0)},e.nextMonth=function(){var t=e.selectedMonthIndex+1;e.monthsToView[t]&&e.selectMonth(t)},e.prevMonth=function(){var t=e.selectedMonthIndex-1;e.monthsToView[t]&&e.selectMonth(t)}}]),angular.module("artsy.common").controller("CtrlFeaturedEvents",["$scope","Schedulizer","moment",function(e,t,n){e.eventData=[],e.$watch("featuredTagID",function(o){o&&t.fetch({fields:["tags"],filepath:!0,limit:10,start:n().format("YYYY-MM-DD"),end:n().add(6,"months").format("YYYY-MM-DD"),attributes:"date_display",tags:o}).success(function(t){e.eventData=t})})}]),angular.module("artsy.common").provider("Modernizr",function(){this.$get=["$window","$log",function(e,t){return e.Modernizr||(t.warn("Modernizr unavailable!"),!1)}]}).provider("Tween",function(){this.$get=["$window","$log",function(e,t){return e.TweenMax||e.TweenLite||(t.warn("Greensock Tween library unavailable!"),!1)}]}).provider("moment",function(){this.$get=["$window","$log",function(e,t){return e.moment||(t.warn("MomentJS library unavailable!"),!1)}]}).provider("Masonry",function(){this.$get=["$window","$log",function(e,t){return e.Masonry||(t.warn("Masonry unavailable!"),!1)}]}).provider("imagesLoaded",function(){this.$get=["$window","$log",function(e,t){return e.imagesLoaded||(t.warn("imagesLoaded unavailable!"),!1)}]}).provider("FastClick",function(){this.$get=["$window","$log",function(e,t){return e.FastClick||(t.warn("FastClick unavailable!"),!1)}]}).provider("SVG",function(){this.$get=["$window","$log",function(e,t){return e.SVG||(t.warn("SVG.js unavailable!"),!1)}]}).provider("BrowserDetect",function(){this.$get=[function(){var e={init:function(){this.browser=this.searchString(this.dataBrowser)||"Other",this.version=this.searchVersion(navigator.userAgent)||this.searchVersion(navigator.appVersion)||"Unknown"},searchString:function(e){for(var t=0;t<e.length;t++){var n=e[t].string;if(this.versionSearchString=e[t].subString,-1!==n.indexOf(e[t].subString))return e[t].identity}},searchVersion:function(e){var t=e.indexOf(this.versionSearchString);if(-1!==t){var n=e.indexOf("rv:");return"Trident"===this.versionSearchString&&-1!==n?parseFloat(e.substring(n+3)):parseFloat(e.substring(t+this.versionSearchString.length+1))}},dataBrowser:[{string:navigator.userAgent,subString:"Chrome",identity:"Chrome"},{string:navigator.userAgent,subString:"MSIE",identity:"Explorer"},{string:navigator.userAgent,subString:"Trident",identity:"Explorer"},{string:navigator.userAgent,subString:"Firefox",identity:"Firefox"},{string:navigator.userAgent,subString:"Safari",identity:"Safari"},{string:navigator.userAgent,subString:"Opera",identity:"Opera"}]};return e.init(),e}]}),angular.module("artsy.common").service("Schedulizer",["$http",function(e){function t(e,t){var n=e.concat(t);return n.filter(function(e,t){return n.indexOf(e)===t})}var n="/_schedulizer/event_list",o={fields:["computedStartLocal","computedStartUTC","title"],pagepath:!0,grouping:!0};this.fetch=function(r,a){var i=angular.extend({},r,{fields:t(r.fields||[],o.fields)});return e.get(n,{cache:a===!1?!1:!0,params:angular.extend({},o,i)})}}]),angular.module("artsy.common").directive("accordion",[function(){function e(e,t){var n=angular.element(t[0].querySelectorAll(".group"));n.on("click",function(){angular.element(this).toggleClass("active")})}return{restrict:"A",link:e}}]),angular.module("artsy.common").directive("eventList",["moment",function(e){function t(t,n,o,r,a){var i=[],s=[];t.$watch("_data",function(o){if(o){for(var r;r=i.pop();)r.remove();for(var c;c=s.pop();)c.$destroy();o.forEach(function(o){var r=t.$new();r.eventObj=o,r.moment=e(o.computedStartLocal),a(r,function(e,t){n.append(e),i.push(e),s.push(t)})})}},!0)}return{link:t,transclude:!0,scope:{_data:"=eventList"},controller:[function(){}]}}]),angular.module("artsy.common").directive("imageSlider",["Tween","imagesLoaded",function(){function e(e,t){function n(e){var t=s[l+1]?l+1:0,n=s[l],o=s[t];u=!0,l=t,angular.element(n).removeClass("active"),angular.element(o).addClass("active"),angular.isFunction(e)&&e()}function o(e){var t=s[l-1]?l-1:c-1,n=s[l],o=s[t];u=!0,l=t,angular.element(n).removeClass("active"),angular.element(o).addClass("active"),angular.isFunction(e)&&e()}var r=t[0],a=(r.clientWidth,r.querySelector("[prev]")),i=r.querySelector("[next]"),s=r.querySelectorAll(".item"),c=s.length,l=0,u=!1;angular.element(a).on("click",o),angular.element(i).on("click",n),function d(){setTimeout(function(){return u?(u=!1,d(),void 0):(n(d),void 0)},4e3)}()}return{restrict:"A",scope:!0,link:e}}]),angular.module("artsy.common").directive("introAnim",["$rootScope","Tween",function(){function e(){}return{link:e,scope:!1}}]),angular.module("artsy.common").directive("masonry",["Masonry","imagesLoaded",function(e){function t(t,n){var o=n[0];t.masonry=new e(o,{itemSelector:"[node]",percentPosition:!0})}return{restrict:"A",scope:!0,link:t}}]),angular.module("artsy.common").directive("moreEventTimes",[function(){function e(e,t){t.on("click",function(){angular.element(t[0].parentNode.querySelectorAll(".more-hidden")).removeClass("more-hidden"),t.remove()})}return{restrict:"A",link:e}}]),angular.module("artsy.common").directive("nav",["Tween",function(e){function t(t,n){var o,r=angular.element(document.documentElement),a=angular.element(n[0].querySelector(".majority"));t.status={open:!1},t.toggle=function(){t.status.open=!t.status.open},t.$watch("status.open",function(e){angular.element(document.documentElement).toggleClass("nav-open",e)}),angular.element(n[0].querySelectorAll(".sub-trigger")).on("click",function(){o=angular.element(this.parentNode),o.toggleClass("sub-active"),a.toggleClass("show-subs")}),angular.element(n[0].querySelectorAll(".unsub")).on("click",function(){o.toggleClass("sub-active"),a.toggleClass("show-subs")});var i=0,s=50,c=!1;e.ticker.addEventListener("tick",function(){i!==window.pageYOffset&&(i=window.pageYOffset,i>s!==c&&(c=!c,r.toggleClass("dock-nav-icon",c)))})}return{restrict:"E",link:t}}]),angular.module("artsy.common").directive("scrollTo",["$window","$rootScope","Tween",function(e,t,n){function o(t,o,r){var a=document.querySelector(r.scrollTo);a&&o.on("click",function(t){t.preventDefault(),n.to(e,.65,{scrollTo:{y:a.offsetTop},ease:Power2.easeOut}),angular.element(o[0].parentNode.children).removeClass("active"),o.addClass("active")})}return{link:o,scope:!1}}]),angular.module("artsy.common").directive("searchable",["$http","$compile","$templateCache",function(e,t,n){function o(e,o){var r=angular.element(document.documentElement);t(o.contents())(e);var a=angular.element(n.get("/search-form-tpl")),i=t(a),s=i(e);angular.element(document.body).append(s),e.$watch("status.open",function(e,t){e!==t&&r.toggleClass("search-results-open",e)})}return{scope:{searchPath:"@searchable"},restrict:"A",link:o,controller:["$scope",function(t){t.pageHits=[],t.status={open:!1,value:"",displayValue:"",loading:!0},t.$watch("status.displayValue",function(e){t.status.open=e&&e.length>=1}),t.clear=function(){t.status.value="",t.status.displayValue=""},t.funcKeyup=function(e){t.status.displayValue=e.target.value,t.status.loading=!0},t.$watch("status.value",function(n){n&&t.searchForm.$valid&&e.get(t.searchPath,{cache:!1,params:{_s:t.status.value}}).success(function(e){t.pageHits=e.pages,t.status.loading=!1})})}]}}]),angular.module("artsy.common").directive("shareOn",["$window","$compile","$sce","Tween",function(e){function t(t,n,o){n.on("click",function(t){t.preventDefault(),e.open(o.href,"Share On Facebook","width="+(o.width||450)+",height="+(o.height||300))})}return{link:t,scope:!1}}]),angular.module("artsy.common").directive("spokeTo",["$window","$rootScope","SVG","Tween",function(e,t,n,o){function r(e){var t=e.nodes[0].getBoundingClientRect(),n=e.nodes[1].getBoundingClientRect(),o=t.width/2,r=n.width/2,a=t.left+o,i=t.top+o,s=n.left+r,c=n.top+r,l=Math.atan2(c-i,s-a),d=Math.atan2(i-c,a-s),g=+e.attrs.spokeOffset||m,f=o+g,S=r+g,k=e.spoke,b=a+f*Math.cos(l),$=i+f*Math.sin(l),M=s+S*Math.cos(d),T=c+S*Math.sin(d);return k?(k.plot(b,$,M,T),void 0):(e.spoke=u.line(b,$,b,$).stroke({width:+e.attrs.spokeWidth||h,linecap:"round",dasharray:"0.1,"+(e.attrs.spokeDistance||v),color:"#ffffff"}),e.spoke.animate(+e.attrs.spokeAnimationTime||p,e.attrs.spokeAnimationEase||y,+e.attrs.spokeAnimationDelay||w).during(function(e,t){this.attr({y2:t($,T),x2:t(b,M)})}),void 0)}function a(e,t,n){f.push({nodes:[t[0].querySelector("circle"),document.querySelector(n.spokeTo).querySelector("circle")],attrs:n}),d=!0}var i=document.body,s=document.documentElement,c=document.body.getBoundingClientRect().width,l=Math.max(i.scrollHeight,i.offsetHeight,s.clientHeight,s.scrollHeight,s.offsetHeight),u=n(document.body),d=!1,g=!1,f=[],m=5,h=2,v=10,p=700,w=0,y=">";return u.size(c,l).attr("class","spoke-canvas"),o.ticker.addEventListener("tick",function(){if(d||g){for(var e=0,t=f.length;t>e;e++)r.call(this,f[e]);console.log("_drawing_spokes_:)"),d=!1}}),angular.element(e).bind("scroll",function(){d=!0}),angular.element(e).bind("resize",function(){c=document.body.getBoundingClientRect().width,l=Math.max(i.scrollHeight,i.offsetHeight,s.clientHeight,s.scrollHeight,s.offsetHeight),u.size(c,l),d=!0}),t.$on("watchSpokes",function(e,t){g=t}),{link:a,scope:!1}}]);