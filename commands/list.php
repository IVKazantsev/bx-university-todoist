<?php

function listCommand(array $arguments): void
{
	$todos = getTodosOrFail();

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