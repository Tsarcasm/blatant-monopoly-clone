<?php include 'format/header.php'; ?>

<!--Extras-->

<script>
function showDiv(a) {
   document.getElementById(a).style.display = "block";
}
</script>

<!--End extras-->

<div id="sidebar">
<h3>Have a nice oink</h3>
</div>

<div id='content'>

<p>Do you want to see a pig?</p>
<input type="button" name="answer" value="Yes" onclick="showDiv('first')" />

<div id="first"  style="display:none;" > Are you sure? <br /> <input type="button" name="answer" value="Yes" onclick="showDiv('second')" /></div>

<div id="second"  style="display:none;" > Are you sure you are sure? <br /><input type="button" name="answer" value="Yes" onclick="showDiv('third')" /></div>

<div id="third"  style="display:none;" > Are you sure you are sure you are sure? <br /> <input type="button" name="answer" value="Yes" onclick="showDiv('fourth')" /></div>

<div id="fourth"  style="display:none;" > Are you sure you are sure you are sure you are sure? <br /> <input type="button" name="answer" value="Yes" onclick="showDiv('fifth')" /></div>

<div id="fifth"  style="display:none;" > Are you sure you are sure you are sure you are sure sandwich <img src='images/sandwich.jpeg' height='20px'/>!? <br /> <input type="button" name="answer" value="Yes" onclick="showDiv('sixth')" /></div>

<div id="sixth"  style="display:none;" > Are you going to click yes no matter what this small line of text says? <br /> <input type="button" name="answer" value="Yes" onclick="showDiv('pig')" /></div>

<div id="pig"  style="display:none;" ><h1>OINK</h1><img src='images/pig.jpeg' /></div>

</div>

<?php include 'format/footer.php'; ?>