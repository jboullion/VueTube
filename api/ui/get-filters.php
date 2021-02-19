<?php
/**
 * Get Taxonomies
 */

require_once('../api-setup.php');

$styles_stmt = $pdo->query("SELECT style_id AS id, style_name AS `name` FROM styles");

$styles = [];
while ($row = $styles_stmt->fetch())
{
    $styles[] = $row;
}

$topic_stmt = $pdo->query("SELECT topic_id AS id, topic_name AS `name` FROM topics");


$topics = [];
while ($row = $topic_stmt->fetch())
{
	$topics[] = $row;
}

echo json_encode(
	array(
		'styles' => $styles,
		'topics' => $topics
		)
);
exit;