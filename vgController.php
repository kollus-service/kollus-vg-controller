<!DOCTYPE html>
<html>
	<head>
		<title>Parent</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
		<script src="http://file.kollus.com/vgcontroller/vg-controller-client.1.1.9.min.js"></script>
		<script>
					var temp;
					var controller;
					var position;
		window.onload = function() {
			try {
				var bind_event = function(id, listener) {
						document.getElementById(id).onclick = listener;
					};

				var add_event_message = function(message) {
						var event_message = document.getElementById('event');

						event_message.value += message + "\n";
					};

				controller = new Kollus.VideogatewayController({
						target_window: document.getElementById('child').contentWindow
					});
				controller.set_playback_rates("[0.5, 0.8, 1.0, 1.2, 1.5, 1.8, 2.0, 2.5]");
				//video playback event binding
				controller
					.on('progress', function(percent, position, duration) {
						var progress = document.getElementById('progress-bar');
						if (progress.textContent) {
							progress.textContent = percent + '% (' + position + ' / ' + duration + ')';
						} else {
							progress.innerText = percent + '% (' + position + ' / ' + duration + ')';
						}
						progress.style.width = Math.max(5, percent) + '%';
						console.log(position);
					})
					.on('screenchange', function(screen) {
						add_event_message('screenchange: ' + screen);
					})
					.on('volumechange', function(volume) {
						document.getElementById('volume').value = volume;
						add_event_message('volumechange: ' + volume);
					})
					.on('muted', function(muted) {
						add_event_message('muted: ' + muted);
					})
					.on('play', function() {
						add_event_message('play');
					})
					.on('pause', function() {
						add_event_message('pause');
					})
					.on('done', function() {
						add_event_message('done');
						if(temp>60)	alert("done");
					})
					.on('ready', function() {
						add_event_message('ready');
						document.getElementById('speed').value = controller.get_speed();
					})
					.on('loaded', function() {
						add_event_message('loaded');
					})
					.on('jumpstepchange', function(jumpstep) {
						document.getElementById('jumpstep').value = jumpstep;
						add_event_message('jumpstepchange: ' + jumpstep);
					})
					.on('scalemode', function(scalemode) {
						add_event_message('scalemode: ' + scalemode);
					})
					.on('speedchange', function(speed) {
						document.getElementById('speed').value = speed;
					})
					.on('topmost', function(topmost) {
						add_event_message('topmost: ' + topmost);
					})
					.on('error', function(error_code) {
						add_event_message('error_code: ' + error_code);
					})
					.on('videosettingchange', function(videosetting) {
						add_event_message('videosettingchange');
					})
					.on('html5_video_supported', function(is_supported) {
						add_event_message((is_supported ? 'html5 supported' : 'html5 not supported'));
					});

				// command event binding
				bind_event('play', function() {
					controller.play();
				});

				bind_event('pause', function() {
					controller.pause();
				});

				bind_event('rw', function() {
					controller.rw();
				});

				bind_event('ff', function() {
					controller.ff();
				});

				bind_event('set_jumpstep', function() {
					controller.set_jumpstep(document.getElementById('jumpstep').value);
				});

				bind_event('get_jumpstep', function() {
					alert(controller.get_jumpstep());
				});

				bind_event('set_volume', function() {
					controller.set_volume(document.getElementById('volume').value);
				});

				bind_event('get_volume', function() {
					alert(controller.get_volume());
				});

				bind_event('mute', function() {
					controller.mute();
				});

				bind_event('set_screen', function() {
					controller.set_screen();
				});

				bind_event('get_screen', function() {
					alert(controller.get_screen());
				});

				bind_event('hide_control', function() {
					controller.set_control_visibility(false);
				});

				bind_event('show_control', function() {
					controller.set_control_visibility(true);
				});

				bind_event('get_control_visibility', function() {
					alert(controller.get_control_visibility());
				});

				bind_event('letterbox', function() {
					controller.set_scalemode('letterbox');
				});

				bind_event('stretch', function() {
					controller.set_scalemode('stretch');
				});

				bind_event('zoom', function() {
					controller.set_scalemode('zoom');
				});

				bind_event('none', function() {
					controller.set_scalemode('none');
				});

				bind_event('get_scalemode', function() {
					alert(controller.get_scalemode());
				});

				bind_event('speed_up', function() {
					controller.set_speed(controller.get_speed() + 0.1);
				});

				bind_event('speed_down', function() {
					controller.set_speed(controller.get_speed() - 0.1);
				});

				bind_event('set_topmost', function() {
					controller.set_topmost(controller.get_topmost() ? false : true);
				});

				bind_event('get_topmost', function() {
					// do nothing
				});

				bind_event('change_brightness', function() {
					controller.set_brightness(document.getElementById('brightness').value);
				});

				bind_event('change_contrast', function() {
					controller.set_contrast(document.getElementById('contrast').value);
				});

				bind_event('change_saturation', function() {
					controller.set_saturation(document.getElementById('saturation').value);
				});

				bind_event('set_repeat_start', function() {
					controller.set_repeat_start();
				});

				bind_event('set_repeat_end', function() {
					controller.set_repeat_end();
				});

				bind_event('unset_repeat', function() {
					controller.unset_repeat();
				});

				bind_event('seek', function() {
					controller.play(30);
				});

				bind_event('refresh_bookmark', function() {
					controller.refresh_bookmark();
				});

				bind_event('enable_fullscreen_button', function() {
					controller.enable_fullscreen_button();
				});

				bind_event('get_player_id', function() {
					alert(controller.get_player_id());
				});
				bind_event('get_current_time', function() {
					alert(temp);
				});
				bind_event('get_lms_data', function() {
					controller.get_lms_data(lms_data_callback_fn);
				});
			} catch(e) {
				if(e instanceof KollusPostMessageException && e.code === -99) {
					// browser does not support window.postMessage.
					// script won't work under this condition.
					alert('You can`t use video playback control.');
				} else {
					// some other errors
					console.log(e.message);
				}
			}
			var lms_data_callback_fn = function (data) {
                console.log(data);
                alert('get lms data complete!');
            };
}

function test(){
	alert(temp);
}
		</script>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">
					<h1>VideoController Example</h1>
					<iframe id="child" width="100%" height="480" src="http://v.kr.kollus.com/3af0hJI4?debug_mode=true" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<h1>Controls</h1>

							<div class="row">
								<div class="col-md-12">
									<h3>Event</h3>

									<div class="row">
										<div class="col-md-3">
											<textarea id="event" style="width: 100%; height: 100px;"></textarea>
										</div>
										<div class="col-md-9">
											<div class="progress" style="height: 34px;">
												<div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 5%; line-height: 34px;">
													0% (0 / 0)
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h3>Playback</h3>

									<div class="row">
										<div class="col-md-3">
											<div class="btn-group" role="group" aria-label="Playback">
												<button type="button" class="btn btn-default" id="rw">
													<span class="glyphicon glyphicon-backward" aria-hidden="true"></span>
												</button>
												<button type="button" class="btn btn-default" id="play">
													<span class="glyphicon glyphicon-play" aria-hidden="true"></span>
												</button>
												<button type="button" class="btn btn-default" id="pause">
													<span class="glyphicon glyphicon-pause" aria-hidden="true"></span>
												</button>
												<button type="button" class="btn btn-default" id="ff">
													<span class="glyphicon glyphicon-forward" aria-hidden="true"></span>
												</button>
											</div>
										</div>
										<div class="col-md-3">
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn btn-default" type="button" id="speed_up" title="Speed up">
														<span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
													</button>
												</span>
												<input type="text" id="speed" class="form-control" readonly />
												<span class="input-group-btn">
													<button class="btn btn-default" type="button" id="speed_down" title="Speed down">
														<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
													</button>
												</span>
											</div>
										</div>
										<div class="col-md-3">
											<div class="btn-group" role="group" aria-label="Playback">
												<button type="button" class="btn btn-default" id="set_repeat_start" title="Set repeat start">
													<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
												</button>
												<button type="button" class="btn btn-default" id="unset_repeat" title="Unset repeat">
													<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
												</button>
												<button type="button" class="btn btn-default" id="set_repeat_end" title="Set repeat end">
													<span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>
												</button>
											</div>
										</div>
										<div class="col-md-3">
											<div class="input-group">
												<input type="text" id="jumpstep" class="form-control" placeholder="Jumpstep ex> 10, 20, 100..." />
												<div class="input-group-btn">
													<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
													<ul class="dropdown-menu dropdown-menu-right">
														<li><a href="#" id="set_jumpstep">Set jumpstep </a></li>
														<li><a href="#" id="get_jumpstep">Get jumpstep </a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h3>Volume</h3>

									<div class="row">
										<div class="col-md-8">
											<div class="input-group">
												<input type="text" id="volume" class="form-control" placeholder="Volume ex> 0 <= volume <= 100" />
												<div class="input-group-btn">
													<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
													<ul class="dropdown-menu dropdown-menu-right">
														<li><a href="#" id="set_volume">Set volume </a></li>
														<li><a href="#" id="get_volume">Get volume </a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<button class="btn btn-default" id="mute" role="button">
												<span class="glyphicon glyphicon-volume-off" aria-hidden="true"></span>
												Mute
											</button>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h3>Screen <small><span class="label label-danger">exclusive player</span></small></h3>

									<div class="row">
										<div class="col-md-6">
											<div class="btn-group" role="group" aria-label="Playback">
												<button type="button" class="btn btn-default" id="set_screen">
													<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
													Set Screensize
												</button>
												<button type="button" class="btn btn-default" id="get_screen">
													Get screen
												</button>
											</div>
										</div>
										<div class="col-md-6">
											<div class="btn-group" role="group" aria-label="Playback">
												<button type="button" class="btn btn-default" id="set_topmost">
													<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
													Set topmost
												</button>
												<button type="button" class="btn btn-default" id="get_topmost">
													Get topmost
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h3>Change video setting <small><span class="label label-danger">exclusive player</span></small></h3>

									<div class="row">
										<div class="col-md-4">
											<div class="input-group">
												<input type="text" class="form-control" id="brightness" placeholder="Brightness" />
												<span class="input-group-btn">
													<button class="btn btn-default" type="button" id="change_brightness">Change</button>
												</span>
											</div>
											<div class="input-group">
												<input type="text" class="form-control" id="contrast" placeholder="Contrast" />
												<span class="input-group-btn">
													<button class="btn btn-default" type="button" id="change_contrast">Change</button>
												</span>
											</div>
											<div class="input-group">
												<input type="text" class="form-control" id="saturation" placeholder="Saturation" />
												<span class="input-group-btn">
													<button class="btn btn-default" type="button" id="change_saturation">Change</button>
												</span>
											</div>
										</div>
										<div class="col-md-8"></div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h3>Control visibility</h3>

									<div class="row">
										<div class="col-md-12">
											<div class="btn-group" role="group" aria-label="Playback">
												<button type="button" class="btn btn-default" id="hide_control">
													Hide player controls
												</button>
												<button type="button" class="btn btn-default" id="show_control">
													Show player controls
												</button>
												<button type="button" class="btn btn-default" id="get_control_visibility">
													Get control visibility
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h3>Scalemode <small><span class="label label-primary">flash player</span></small></h3>

									<div class="row">
										<div class="col-md-12">
											<div class="btn-group" role="group" aria-label="Playback">
												<button type="button" class="btn btn-default" id="letterbox">
													letterbox
												</button>
												<button type="button" class="btn btn-default" id="stretch">
													stretch
												</button>
												<button type="button" class="btn btn-default" id="zoom">
													zoom
												</button>
												<button type="button" class="btn btn-default" id="none">
													none
												</button>
												<button type="button" class="btn btn-default" id="get_scalemode">
													Get scalemode
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h3>Etc</h3>

									<div class="row">
										<div class="col-md-12">
											<div class="btn-group" role="group" aria-label="Playback">
												<button type="button" class="btn btn-default" id="seek" title="Seek to 30s.">
													<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
													Seek to 30s
												</button>
												<button type="button" class="btn btn-default" id="refresh_bookmark">
													Refresh bookmark
												</button>
												<button type="button" class="btn btn-default" id="enable_fullscreen_button">
													Enable fullscreen button
												</button>
												<button type="button" class="btn btn-default" id="get_player_id">
													Get player id
												</button>
												<button type="button" class="btn btn-default" id="get_current_time">
													Get Current Play Time
												</button>
												<button type="button" class="btn btn-default" id="get_lms_data">
													Get Progress Data
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
