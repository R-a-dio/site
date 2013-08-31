<!-- Main Container
        ================ -->
        <div class="container main">

        	<div class="content">

				<div class="panel-group" id="accordion">
				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
				          Updates, Bug Fixes
				        </a>
				      </h4>
				    </div>
				    <div id="collapseOne" class="panel-collapse collapse in">
				      <div class="panel-body">
				        Note: If you experience any errors with the site in the next few days, do yourselves a favor and PM Hiroto on IRC instead of yelling in the channel and having people not actually tell me. <br>
						<br>
						The Stream is now on SSL<br>
						https://r-a-d.io/main.mp3 is the SSL mount. Please keep in mind that ports 8000, 1130 and 80 are not SSL, and don't start complaining that https://stream.r-a-d.io:8000/main.mp3 isn't working for you. (Yes, we do have a port 80 stream now) 
						<br>
						Please note that stream.r-a-d.io will NOT work on SSL. Our certificate is for r-a-d.io and www.r-a-d.io only <br>
						<br>
						We fixed that annoying-as-shit bug with the fallback.<br>
						You all know which one I mean. Wessie spent a few days adding song preloading to the streamer. The bug was caused due to a race condition with a window of about 1/10000th of a second (we'd looked at this for well over a year and determined that it should never happen, ignored it for ages, then had an epiphany and realized it was due to disk I/O). We'll be updating the streamer when we deem it stable enough. <br>
						<br>
						Also, the site now fully supports Forward Secrecy <br>
						This is a setting within TLS to prevent decryption of data unless you have access to both machines involved in a TLS session. Side-effect: the site doesn't work in IE6, and HTTPS on IE8 Windows XP fails a cipher check and aborts the connection 
						However, you can't even use this site on IE6, so that point is moot. The things we removed were deemed potentially broken in 1998, and were broken completely in 2003. 
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
				          Regarding Pending Songs
				        </a>
				      </h4>
				    </div>
				    <div id="collapseTwo" class="panel-collapse collapse">
				      <div class="panel-body">
				        Hi. 
				        <br>
						As some of you may have noticed, the list of pending songs has grown pretty large over the past few months. This is primarily because both people who used to accept songs (me and Kilim) are no longer doing so. Hence, we are looking for people who would like to go through the list regularly and accept songs into the database. 
						<br>
						Open the news post if you might be interested. 
						<br>
						I should probably have made this post months ago, before the list grew so huge, but I've had a fairly decent reason for not doing so. Basically, it's not worth the effort educating people on how to accept songs if they're going to stop doing it a week or two later. There are lots of people who are authorized to accept songs, but they all quit after a short while since a) it's pretty boring and b) takes up loads of time. 
						<br>
						So, I want to emphasize this: Unless you know that you have the time to accept songs and really, really want to do it, don't bother applying. Anything but that would be a waste of my time and yours. 
						<br>
						The whole process of accepting songs is this: You have a list of songs that need to be accepted, together with artist, title, album and filename. You can listen to the song to sample the quality or hear what song it is. Then, depending on various factors like whether or not you could locate the source, the quality of the song or if the song is in the database already you either accept the song or decline it. It's that simple. 
						<br>
						Of course, there are a bunch of other (unwritten) rules that apply to accepting, such as proper tags, (preferably) no moonrunes in tags, how to format the tags, etc etc. If you apply, I will explain all of that. 
						<br>
						If you have any questions about anything I have or have not mentioned above or wish to apply, post in the comments or send me a PM on IRC. Also, being on IRC is a requirement, since I won't be able to scold you for fucking up otherwise. 
						<Br>
						Thank you for reading this public service announcement.
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
				          Loopstream
				        </a>
				      </h4>
				    </div>
				    <div id="collapseThree" class="panel-collapse collapse">
				      <div class="panel-body">
				        Attention DJs, both r/a/dio and elsewhere! 
				        <br>
						The lack of good streaming software has been a long-term annoyance for many r/a/dio DJs. 
						I decided to do something about that. 
						<br>
						Loopstream is a generic approach to the problem. Instead of being yet another proprietary media player, it supports a wide range of existing and popular players, in addition to being extendable with support for new sources even while streaming. 
						<br>
						The software basically eavesdrops on your speakers, feeding everything you hear straight to an icecast server of your choice. Using the mixer panel, the DJ can use presets to automate source attenuation. At the press of a button, your music gradually fades down to -24dB and your mic is enabled for a quick voiceover. 
						<br>
						This is technically not a radio project, even though it was designed with r/a/dio in mind. As long as your radio server is (based on) icecast, this is a great drop-in replacement for your current icecast pipe. You may also broadcast the same stream to multiple formats, for instance ogg mp3. 
						<br>
						The user's manual (including download links) can be viewed on the link below. Please report problems on Rizon IRC, either by messaging ed or by joining #r/a/dio. 
						<br>
						Download: http://r-a-d.io/ed/loopstream/ 
						<br>
						EDIT: Patch for VirtualDJ v7.4: http://r-a-d.io/ed/VDJ2LS.html 
				      </div>
				    </div>
				  </div>
				</div>

        	</div>


        </div>