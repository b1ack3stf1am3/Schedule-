<div class="navbar">
 	<div class="navbar-inner">
 		<a class="brand"  href="./?p=class_sheet">Schedule+</a>
		<ul class="nav">
		<?php foreach($pages as $file => $text): ?>
			<li><a href="./?p=<?php echo $file ?>"><?php echo $text ?></a></li>
		<?php endforeach ?>
		</ul>
		<form method="get" class="form-inline pull-right">
		<input type="hidden" name="p" value="class_sheets" />
		</form>
	</div>
</div>