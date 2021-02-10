<?php include 'format/header.php'; ?>
<!--Here is the code of the individual pages-->

<!--Extras-->
<script>
function init() {
	var h1 = document.getElementById('js'), delay = 10000;

	setTimeout(function() {
		h1.innerHTML = "This is taking a bit longer than planned. Stand by, please.";

		setTimeout(function() {
			h1.innerHTML = "Thank you for your patience.";

			setTimeout(function() {
				h1.innerHTML = "It is much appreciated.";

				setTimeout(function() {
					h1.innerHTML = "Just a little longer.";

					setTimeout(function() {
						h1.innerHTML = "Eeerh...";

						setTimeout(function() {
							h1.innerHTML = "So... how was your day so far ?";

							setTimeout(function() {
								h1.innerHTML = "We really apologize, this is seriously taking much longer than usual.";

								setTimeout(function() {
									h1.innerHTML = "You're still here ?";

									setTimeout(function() {
										h1.innerHTML = "You seriously have nothing better to do ?";

										setTimeout(function() {
											h1.innerHTML = "Well, we admire your patience.";

											setTimeout(function() {
												h1.innerHTML = "No, really.";

												setTimeout(function() {
													h1.innerHTML = "As they say, 'Patience is a virtue'.";

													setTimeout(function() {
														h1.innerHTML = "You know that you've been staring at this page for " + Math.round(((13 * delay) / 1000) / 60) + " minutes, right ?";

														setTimeout(function() {
															h1.innerHTML = "That's not freaking you out ?";

															setTimeout(function() {
																h1.innerHTML = "No ? Well, in that case...";

																setTimeout(function() {
																	window.location.href = 'http://24.media.tumblr.com/tumblr_m5jhpwrqmx1qii6tmo1_250.gif';
																}, delay);
															}, delay);
														}, delay);
													}, delay);
												}, delay);
											}, delay);
										}, delay);
									}, delay);
								}, delay);
							}, delay);
						}, delay);
					}, delay);
				}, delay);
			}, delay);
		}, delay);
	}, delay);
}
</script>
<!--End extras-->

<!--Sidebar-->
<div id="sidebar">
<h3>We must all learn the skill of patience</h3>
</div>

<!--Content-->

<div id='content'>
<br />
<br />
<center> 
<div id='loader'>
<p id='js'>Loading content, please wait...</p>
<img src='images/loader.gif' />
</div>
</center>
<script>
   init();
   
</script>
<!--End individual page code section-->
<?php include 'format/footer.php'; ?>