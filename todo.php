<?php

// php todo.php list
// php todo.php list 2022-10-12
// php todo.php list today yesterday tomorrow
// php todo.php add "Wake up"
// php todo.php add "Drink coffee"
// php todo.php complete 1 2
// php todo.php remove 1 2 (rm)
// php todo.php report

function main(array $arguments): void
{
	array_shift($arguments);

	$command = array_shift($arguments);

	switch ($command)
	{
		case 'list':
			listCommand($arguments);
			break;
		case 'add':
			addCommand($arguments);
			break;
		case 'complete':
			completeCommand($arguments);
			break;
		case 'remove':
		case 'rm':
			removeCommand($arguments);
			break;

		default:
			echo 'Unknown command';
			exit(1);
	}

	exit(0);
}

function addCommand(array $arguments): void
{
	$title = array_shift($arguments);

	$todo = [
		'id' => uniqid('', true),
		'title' => $title,
		'completed' => false,
	];

	$fileName = date('Y-m-d') . '.txt';
	$filePath = __DIR__ . "\data\\" . $fileName;

	if (file_exists($filePath))
	{
		$content = file_get_contents($filePath);
		$todos = unserialize($content, [
			'allowed_classes' => false, // Делается для безопасности
		]);
		$todos[] = $todo;
	}
	else
	{
		$todos = [$todo];
	}
	file_put_contents($filePath, serialize($todos));
}

function listCommand(array $arguments)
{
	$fileName = date('Y-m-d') . '.txt';
	$filePath = __DIR__ . "\data\\" . $fileName;

	if (!file_exists($filePath))
	{
		echo 'Nothing to do here';

		return;
	}

	$content = file_get_contents($filePath);
	$todos = unserialize($content, [
		'allowed_classes' => false, // Делается для безопасности
	]);

	if (empty($todos))
	{
		echo 'Nothing to do here';

		return;
	}

	$result = array_map(function($todo) {
		return $todo['title'];
	}, $todos);

	foreach ($todos as $index => $todo)
	{
		echo sprintf(
			"%s. [%s] %s \n",
			($index + 1),
			$todo['completed'] ? 'x' : ' ',
			$todo['title'],
		);
	}
}

function completeCommand(array $arguments)
{

}

function removeCommand(array $arguments)
{

}

main($argv);