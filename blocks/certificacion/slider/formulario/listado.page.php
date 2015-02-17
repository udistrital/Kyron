<?php
if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
?>
<ul>
	<li><a href="#cube"><img src="<?php echo $directorio?>/001.jpg" class="cube" /> </a>
		<div class="label_text">
			<p>cube</p>
		</div></li>
	<li><a href="#cubeRandom"><img src="<?php echo $directorio?>/002.jpg" class="cubeRandom" />
	</a>
		<div class="label_text">
			<p>cubeRandom</p>
		</div></li>
	<li><a href="#block"><img src="<?php echo $directorio?>/003.jpg" class="block" /> </a>
		<div class="label_text">
			<p>block</p>
		</div></li>
	<li><a href="#cubeStop"><img src="<?php echo $directorio?>/004.jpg" class="cubeStop" /> </a>
		<div class="label_text">
			<p>cubeStop</p>
		</div></li>	
</ul>
