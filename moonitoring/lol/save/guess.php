<?php include 'format/header.php'; ?>

<!--Extras-->
<!--End extras-->

<div id="sidebar">
<h3>Find the words</h3>
<p>Please find the words. It would be nice. If you do not, I condone you to a life in the caverns of the internet, constantly trapped, constantly falling <small>Falling, <small>Falling, <small>Falling.........</small></small> </small></p>
</div>

<div id='content'>
<p>Find all three words. All three - not one. </p>
<center>
<input type="text" id="first"><input type="text" id="second"><input type="text" id="third">
<br />
<button onclick="checkBoxes()">Check the words</button>
<script>
function checkBoxes() {
string word1 = document.getElementById("first").innerHTML;
string word2 = document.getElementById("second").innerHTML;
string word3 = document.getElementById("third").innerHTML;
if (word1 = 'lol')
{
	if (word2 = 'lol')
	{
		if (word3 = 'lol')
		{
		document.getElementById("demo").innerHTML = "HELLO";
		}
	}
}
}
</script>
<p id="demo"></p>
</center>
</div>

<?php include 'format/footer.php'; ?>