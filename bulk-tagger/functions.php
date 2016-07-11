<?php

function drawResults()
{
	$locale = null;
?>
<form id="imageForm">
	<div class="imageOptionPanel">
		<label for="allImagesTop"><?php echo gettext("All") ?><input type="checkbox" id="allImagesTop" class="imageCheckbox" /></label>
	</div>
	<div class="imageOptionPanel">
		<label class="cancelSearch">Cancel</label>
	</div>
<?php
	$includes = $_GET["includes"];
	$excludes = $_GET["excludes"];
	$itemType = $_GET["itemType"];
	$itemId = 0;
	
	if ($itemType == 'albums' OR $itemType == 'images')
	{
		$sqlWhere  = "1=1";
		if (strlen($includes) > 0)
		{
			$sqlWhere .= " AND (title LIKE " . db_quote("%" . $includes . "%") . " OR `desc` LIKE " . db_quote("%" . $includes . "%") . ")";
		}
		if (strlen($excludes) > 0)
		{
			$sqlWhere .= " AND (IFNULL(title, '') NOT LIKE " . db_quote("%" . $excludes . "%") . " AND IFNULL(`desc`, '') NOT LIKE " . db_quote("%" . $excludes . "%") . ")";
		}
		
		$sql = "SELECT id, title, mtime, `desc`
				FROM " . prefix($itemType) . "
				WHERE " . $sqlWhere . "
				ORDER BY date DESC
				LIMIT 0, 20";
		$itemResults = query_full_array($sql);
		
		foreach ($itemResults as $item)
		{
			$itemId = $item['id'];
			$caption = get_language_string($item['title'], $locale);
			$description = get_language_string($item['desc'], $locale);
			
			if (strlen($description) > 0)
			{
				$caption = '<abbr title="' . $description . '">' . $caption .'</abbr>';
			}
	?>
		<div class="imageOptionPanel">
			<input type="checkbox" id="item<?php echo $itemId ?>" value="<?php echo $itemId ?>" class="imageCheckbox imageOption">
			<label for="item<?php echo $itemId ?>"><?php echo $caption ?></label>
		</div>
	<?php
		}
	}
	
	if ($itemId > 0) 
	{
?>
	<div class="imageOptionPanel">
		<label for="tags">Tag
			<select id="tags">
				<?php printTagOptions(); ?>
			</select>
		</label>
	</div>
	<p class="buttons">
		<input type="hidden" id="itemType" value="<?php echo $itemType ?>" />
		<button type="submit" id="tagItems" value="Tag selected items">Tag selected items</button>
	</p>
	<?php 
	}
	else
	{
?>
	<p class="buttons">
		<button type="submit" class="cancelSearch" value="Return">Return</button>
	</p>
<?
	}
	?>
</form>
<?php
}

function printTagOptions()
{
	$tagsSql = "SELECT * FROM " . prefix('tags') . "
			ORDER BY name";
	$tagResults = query_full_array($tagsSql);
	
	foreach($tagResults as $tagResult)
	{
		echo "<option value=\"" . $tagResult['id'] . "\">" . $tagResult['name'] . "</option>";
	}	
}

function processRequest()
{
	$itemIds = $_POST["itemIds"];
	$tagId = $_POST["tagId"];
	$itemType = $_POST["itemType"];
	
	if ($itemType == 'albums' OR $itemType == 'images')
	{
		foreach($itemIds as $itemId)
		{
			$existingTagsSql = "SELECT COUNT(tagid) AS tagCount FROM " . prefix('obj_to_tag') . "
				WHERE type = '" . $itemType . "' 
				AND objectid = " . $itemId . "
				AND tagid = " . $tagId ;
			$existingTagResults = query_single_row($existingTagsSql);
			
			if ($existingTagResults['tagCount'] == 0)
			{
				$sql = "INSERT INTO " . prefix('obj_to_tag') . " (type, objectid, tagid) VALUES ('" . $itemType . "', " . $itemId . ", " . $tagId . ")";
				query($sql);
			}
		}
	}
}

?>