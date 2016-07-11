<?php

printAdminHeader('overview', gettext('Bulk tagger'));
?>
<script src="bulk-tagger.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="bulk-tagger.css" />
<?php
echo '</head>';
?>
<body>
	<?php printLogoAndLinks(); ?>
	<div id="main">
		<?php printTabs(); ?>
		<div id="content">
			<ul style="width: 10em" class="subnav">
				<li class="current"><a>Bulk tagger</a></li>
			</ul>
			<div class="tabbox">
				<h1>Bulk tag images and albums</h1>
				<form id="searchForm">
					<div id="searchPanel">
						<div id="actionMessage"></div>
						<label for="includes">Includes</label><input type="text" id="includes" />
						<label for="excludes">Excludes</label><input type="text" id="excludes" />
						<label>Item type:</label>
						<label for="images">Images</label><input type="radio" name="itemType" id="images" value="images" />
						<label for="albums">Albums</label><input type="radio" name="itemType" id="albums" value="albums" />
						<br style="clear:both" />
					</div>
					<p class="buttons">
						<button type="submit" id="search" value="Search for items">Search for items</button>
					</p>
				</form>
				<div id="searchResults" style="display:none"></div>
				<br style="clear:both" />
			</div><!-- content -->
		</div><!-- content -->
	</div><!-- main -->
	<?php printAdminFooter(); ?>
</body>
<?php
echo "</html>";
?>