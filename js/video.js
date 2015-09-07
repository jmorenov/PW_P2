function show_video(video_file) {
	main = document.body;
	
	video_panel = document.createElement("div");
	video_panel.id = "video_panel";
	video_panel.addEventListener('mouseover', show_bar, false);
	video_panel.addEventListener('mouseout', hide_bar, false);
	
	close_video = document.createElement("div");
	close_video.id = "close_video";
	close_video_button = document.createElement("button");
	close_video_button.id = "close_video_button";
	close_video_button.addEventListener('click', close2, false);
	close_video.appendChild(close_video_button);
	
	video_source = document.createElement("video");
	video_source.id = "video_source";
	source = document.createElement("source");
	source.src = video_file;
	source.type = "video/mp4";
	video_source.appendChild(source);
	
	video_bar = document.createElement("nav");
	video_bar.id = "video_bar";
	buttons = document.createElement("div");
	buttons.id = "buttons";
	playButton = document.createElement("button");
	playButton.id = "playButton";
	playButton.innerHTML='Play';
	playButton.addEventListener('click', playOrPause, false);
	buttons.appendChild(playButton);
	video_bar.appendChild(buttons);
	defaultBar = document.createElement("div");
	defaultBar.id = "defaultBar";
	defaultBar.addEventListener('click', clickedBar, false);
	progressBar = document.createElement("div");
	progressBar.id = "progressBar";
	defaultBar.appendChild(progressBar);
	video_bar.appendChild(defaultBar);
	
	
	video_panel.appendChild(close_video);
	video_panel.appendChild(video_source);
	video_panel.appendChild(video_bar);
	main.appendChild(video_panel);
	
	hide_main = document.createElement("div");
	hide_main.id = "hide_main";
	hide_main.addEventListener('click', close, false);
	main.appendChild(hide_main);
	
	document.getElementById("video_panel").style.display = "block";
	document.getElementById("hide_main").style.display = "block";
	barSize=400;
}

function playOrPause() {
	if (!video_source.paused && !video_source.ended){
		video_source.pause();
		playButton.innerHTML='Play';
		window.clearInterval(updateBar);
	} else {
		video_source.play();
		playButton.innerHTML='Pause';
		updateBar=setInterval(update, 500);
	}
}

function update() {
	if (!video_source.ended) {
		var size=parseInt(video_source.currentTime*barSize/video_source.duration);
		progressBar.style.width=size+'px';
	} else {
		progressBar.style.width='0px';
		playButton.innerHTML='Play';
		window.clearInterval(updateBar);
	}
}

function clickedBar(e){
	if(!video_source.paused && !video_source.ended){
		var mouseX=e.pageX-defaultBar.offsetLeft;
		var newtime=mouseX*video_source.duration/barSize;
		video_source.currentTime=newtime;
		progressBar.style.width=mouseX+'px';
	}
}

function close2() {
	main.removeChild(video_panel);
	main.removeChild(hide_main);
}

function close() {
	main.removeChild(video_panel);
	main.removeChild(hide_main);
}	

function show_bar() {
	video_bar.style.visibility="visible";
	close_video.style.visibility="visible";
}
	
function hide_bar() {
	video_bar.style.visibility="hidden";
	close_video.style.visibility="hidden";
}