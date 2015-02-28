<div id="guaranteeBox" style="background-color:<?php echo $backgroundColor; ?>">
	<div id="guaranteeBoxHeadline"><?php echo $headline; ?></div>
	<div id="guaranteeBoxLeft">
		
		<?php
			if($image){
		?>
		<div id="guaranteeBoxImage"><img src="<?php echo $image; ?>" /></div>
		<?php
			} //end if($image)
		?>
	</div>
	<div id="guaranteeBoxMessage"><?php echo wpautop($message); ?></div>
</div>