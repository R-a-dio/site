<div class="modal fade bs-modal-lg" id="preferences">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">r/a/dio user preferences</h3>
				<h4>
					<button class="btn-default" onclick="Array.from(document.getElementsByClassName('modal-body-preferences')).forEach(element => {element.style='display:none;'}); document.getElementById('mute-songs-body').style='display:block;'">Mute songs</button>
					<button class="btn-default" onclick="Array.from(document.getElementsByClassName('modal-body-preferences')).forEach(element => {element.style='display:none;'}); document.getElementById('theme-selection-body').style='display:block;'">Select theme</button>
				</h4>
			</div>
				<div class="modal-body modal-body-preferences" id="mute-songs-body">
					<h4>Mute songs</h4>
					<p>Add song tags below, separated by commas. Whenever a song with a tag listed below plays, the stream will be muted. The stream will automatically unmute whenever a song without any of the tags below starts playing. Songs played by DJs don't have tags, so <b>this will only work for songs played by Hanyuu</b>. You can see tags for the currently playing song by clicking on the song title on the main page. To see tags for other songs, click the header on the search page.</p>
					<p><input id="mute-tags-internal" class="form-control" type="text" placeholder="example, tags, the idolmaster, vtuber, touhou"></p>
					<p>Add artist or title tags below, separated by commas. Same thing as above, but the song will mute based on the artist and title tags instead. This works for all DJs, not just Hanyuu. <b>You'll want to be pretty specific with these, since e.g "idol" will mute both "THE IDOLM@STER" and "Miracle Idol Star".</b></p>
					<p><input id="mute-tags-title" class="form-control" type="text" placeholder="itoko, omaru polka, ganbara"></p>
					<p>Add links to songs below, separated by commas, if you want one of them to play instead whenever the stream is muted. One will be selected at random and the r/a/dio stream will stay muted until the song has finished playing. Plays whatever formats your browser supports, most likely at least mp3, flac, ogg, mp4 and webm.</p>
					<p><input id="mute-tags-play-instead" class="form-control" type="text" placeholder="https://files.catbox.moe/songtitlehere.mp3, https://files.catbox.moe/anothersong.mp3"></p>
					<p>Random song volume: <input id="custom-song-volume" type="text" 
style="width:40px;"><input id="mute-tags-stop-early" type="checkbox" style="margin-left:10px;"> Stop playing random song when muted song ends</input></p>
				</div>
				<div class="modal-body modal-body-preferences" id="theme-selection-body" style="display:none;">
					<h4>Select theme</h4>
					<p>Pressing any of the buttons below reloads the page; save other settings first, if you changed any.</p>
					<div>
                        <btn id="ravetoggle" class="btn btn-default" style="display: block;margin-bottom: 10px;">
                            <a href="/" style="">Enable cancer theme</a>
                        </btn>
                    </div>
                    @if (!$cur_theme)
                        <btn class="active btn btn-default"><a href="/set-theme/-1">Use DJ Theme</a></btn>
                    @else
                        <btn class="btn btn-default"><a href="/set-theme/-1">Use DJ Theme</a></btn>
                    @endif
                    @foreach ($themes as $t)
                        @if ($t->display_name != "")
                            @if ($t->name === $cur_theme)
                                <btn class="active btn btn-default"><a href="/set-theme/{{ $t->id }}">{{{ $t->display_name }}}</a></btn>
                            @else
                                <btn class="btn btn-default"><a href="/set-theme/{{ $t->id }}">{{{ $t->display_name }}}</a></btn>
                            @endif
                        @endif
                    @endforeach
				</div>
			<div class="modal-footer">
				<p><b style="font-size:1.3em;margin-right:4px;position:relative;top:4px;">Don't forget to</b> <button type="button" id="save-preferences" class="btn btn-default" data-dismiss="modal" onclick=location.reload()>Save & Close</button></p>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
