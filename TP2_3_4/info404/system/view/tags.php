<?php
	if (isset($_SESSION['user'])) {
		$tags = [];
		foreach(recupere_tag() as $tag) {
			$tags[$tag] = null;
		}
?>
<script type="text/javascript">
	var TAGS = <?php echo json_encode($tags); ?>;
</script>
<?php
	} else {
?>
<script type="text/javascript">
	var TAGS = {};
</script>
<?php
	}