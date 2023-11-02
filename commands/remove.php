<?php

function removeCommand(array $arguments): void
{
	$todos = getTodosOrFail();

	$todos = mapTodos($todos, $arguments, fn($todo) => null);

	storeTodos($todos);
}