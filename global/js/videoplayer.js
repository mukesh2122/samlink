/* 
 * Used for playing a video.
 * To have full support of all browsers the video must be available as both a .mp4 and a .ogg file.
 * Both of these files must be placed together, the player will choose which file to load depending on the users browser.
 * 
 * This script accepts parameters.
 * 
 * Accepted parameters are:
 * alt - A path to an image that will be used if the users browser does not support HTML5.
 * video - The path to the video. Don't include the file extension.
 * fps - Defaults to 30, The fps to use for the playback of the video.
 * container - The id(s) of the container DOM element. You can display the same video in multiple containers by adding the IDs seperated by a comma.
 * autoplay - Defaults to true, if set to false will stop video from playing on page load.
 * 
 * Example:
 * <head>
 *     <script type="text/javascript" src="videoplayer.js?alt=images/videoPreview.png&video=videos/myAwesomeVideo&fps=30&container=myVideoContainer,mySecondVideoContainer"></script>
 * </head>
 * <body>
 *     <div id="myVideoContainer" style="width:200px;height:120px"></div>
 * </body>
 */

var VideoPlayer = {
	//CONFIG.
	VIDEO_LOAD_WAITING_TIME: consts.videoPlayWait, // 1000
	fps: consts.videoPlayFPS, // 33
	autoPlay: consts.videoPlayAuto, // true - initialized from viewc/head, so it can be controlled from admin pages/DB
	params: null,
	altImage: new Array(),
	video: null,
	container: new Array(),
	canvas: new Array(),
	c: new Array(),
	canPlay: false,
	unsupported: false,
	initialized: false,

	init: function() {
		//Parse the src attribute to get the parameters.
		var scripts = document.getElementsByTagName("script"), params = this._getParameters(scripts[scripts.length - 1].getAttribute("src"));
		if(params !== null) { this.params = params; };
		window.addEventListener("load", VideoPlayer._onload, false);
	},
	play: function() {
		if(!this.unsupported) {
			if(this.canPlay && this.video.paused) {
				//Starts the video.
				this.video.currentTime = 0;
				this.video.play();
				this._updateVideo();
			} else { setTimeout(VideoPlayer.play, VideoPlayer.VIDEO_LOAD_WAITING_TIME); }; //Try again.
		} else { console.error("HTML5 is not supported in this browser."); };
	},
	_displayImage: function() {
		if(this.container !== null) { for(var i = 0, len = this.container.length; i < len; ++i) { this.container[i].appendChild(this.altImage[i]); }; }; //Displays the static image instead of the video.
	},
	_updateVideo: function() {
		//Draw the current frame to the canvas.
		for(var i = 0, len = VideoPlayer.c.length; i < len; ++i) { VideoPlayer.c[i].drawImage(VideoPlayer.video, 0, 0, VideoPlayer.canvas[i].width, VideoPlayer.canvas[i].height); };
		if(!VideoPlayer.video.ended && !VideoPlayer.video.paused) { setTimeout(VideoPlayer._updateVideo, this.fps); }; //Video is not done playing.
	},
	_onload: function() {
		if(VideoPlayer.params['alt'] !== consts.undefined && VideoPlayer.params['alt'] !== null && VideoPlayer.params['video'] !== consts.undefined && VideoPlayer.params['video'] !== null && VideoPlayer.params['container'] !== consts.undefined && VideoPlayer.params['container'] !== null){	
			if(VideoPlayer.params['fps'] !== consts.undefined && VideoPlayer.params['fps'] !== null) { VideoPlayer.fps = Math.round(1000 / VideoPlayer.params['fps']); };
			//Get the container and autoplay parameters.
			for(var i = 0, len = VideoPlayer.params['container'].length; i < len; ++i){
				VideoPlayer.container.push(document.getElementById(VideoPlayer.params['container'][i]));
				//Load the alternative image.
				var image = new Image();
				image.src = VideoPlayer.params['alt'] || "";
				image.style.width = image.style.height = "100%";
				VideoPlayer.altImage.push(image);
			};
			//Autoplay parameter.
			if(VideoPlayer.params['autoplay'] !== consts.undefined && VideoPlayer.params['autoplay'] !== null) { VideoPlayer.autoPlay = (VideoPlayer.params['autoplay'] === "true"); };
			if(VideoPlayer._checkSupport()) {					
				//Load the video.
				var video = document.createElement("video");
				video.autoplay = video.controls = video.loop = false;
				//Determine the format to use.
				var videoPath = VideoPlayer.params['video'];
				videoPath += (video.canPlayType("video/mp4")) ? ".mp4" : ".ogv";
				video.src = videoPath;
				video.addEventListener("canplay", VideoPlayer._ready, false);
				//Load the video.
				video.load();
				VideoPlayer.video = video;
			} else { VideoPlayer._displayImage(); }; // HTML5 not supported, Just display the image instead.
		} else { console.error("VideoPlayer requires the \"alt\", \"video\" and \"container\" parameter."); };
	},
	_getParameters: function(src) {
		if(src !== consts.undefined && src !== null && src !== "") {
			var paramStr = src.split("?")[1];
			paramStr = paramStr.split("&");
			var params = {};
			for(var i = paramStr.length; --i;) {
				var keyValuePair = paramStr[i].split("=");
				params[keyValuePair[0]] = keyValuePair[1];
			};
			//Parse the container into an array.
			params['container'] = params['container'].split(",");
			return params;
		};
		return null;
	},
	_checkSupport: function() {
		var canvas = document.createElement("canvas"), video = document.createElement("video");
		if(canvas !== consts.undefined && canvas !== null && video !== consts.undefined && video !== null) { return (!!(canvas.getContext && canvas.getContext('2d')) && !!(video.canPlayType)); };
		return false;
	},
	_ready: function() {
		//Add the video to the DOM.
		if(!VideoPlayer.initialized) {			
			for(var i = 0, len = VideoPlayer.container.length; i < len; ++i) {
				VideoPlayer.canvas.push(document.createElement("canvas"));
				//VideoPlayer.canvas[i].style.width = VideoPlayer.canvas[i].style.height = "100%";
				VideoPlayer.canvas[i].width = VideoPlayer.container[i].offsetWidth;
				VideoPlayer.canvas[i].height = VideoPlayer.container[i].offsetHeight;
				VideoPlayer.c.push(VideoPlayer.canvas[i].getContext('2d'));
				VideoPlayer.container[i].appendChild(VideoPlayer.canvas[i]);
			};
			VideoPlayer.canPlay = true;
			VideoPlayer.initialized = true;
			if(VideoPlayer.autoPlay) { VideoPlayer.play(); }
			else { VideoPlayer._updateVideo(); };
		};
	}
};

VideoPlayer.init();