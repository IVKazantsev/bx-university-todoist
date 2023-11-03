<?php

function reportCommand(array $arguments = []): void
{
	$allTodos = prepareTodosData();

	$totalDays = count($allTodos);

	$totalTaskCount = array_reduce($allTodos, function($prev, $todos) {
		return $prev + count($todos);
	},                             0);

	$totalCompletedTaskCount = array_reduce($allTodos, function($prev, $todos) {
		$completed = array_filter($todos, fn($todo) => $todo['completed']);

		return $prev + count($completed);
	},                                      0);

	$dailyTasksCounts = array_map(function($todos) {
		return count($todos);
	}, $allTodos);

	$minTasksCount = min($dailyTasksCounts);
	$maxTasksCount = max($dailyTasksCounts);

	$averageTasksCount = 0;
	$averageCompletedTasksCount = 0;
	if ($totalDays > 0)
	{
		$averageTasksCount = floor($totalTaskCount / $totalDays);
		$averageCompletedTasksCount = floor($totalCompletedTaskCount / $totalDays);
	}

	$report = [
		"Total days: $totalDays",
		"Total tasks: $totalTaskCount",
		"Total completed tasks: $totalCompletedTaskCount",
		"Min tasks in a day: $minTasksCount",
		"Max tasks in a day: $maxTasksCount",
		"Average tasks in a day: $averageTasksCount",
		"Average completed tasks in a day: $averageCompletedTasksCount",
	];

	echo implode(PHP_EOL, $report) . PHP_EOL;
}

function prepareTodosData(): array
{
	$files = scandir(ROOT . "\data\\");

	$allTodos = [];

	foreach ($files as $file)
	{
		if (!preg_match('/^\d{4}-\d{2}-\d{2}\.txt$/', $file))
		{
			continue;
		}

		$content = file_get_contents(ROOT . "\data\\$file");
		$todos = unserialize($content, [
			'allowed_classes' => false,
		]);

		$todos = is_array($todos) ? $todos : [];

		[$date] = explode('.', $file);

		$allTodos[$date] = $todos;
	}

	return $allTodos;
}