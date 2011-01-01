<?php

return array(
	'app-name' => 'MooTools More 1.3 Test Runner',
	'sources' => array(
		'../mootools-core',
		'../mootools-more',
//		'../mootools-element-behaviors'
	),
	'exclude-blocks' => array(
		'1.2compat'
	),
	'tests-path' => '../mootools-more/Tests',
	'tests' => array(
		'more' => '../mootools-more/Tests',
//		'Element.Behaviors' => '../mootools-element-behaviors/Tests'
	),
	'jasmine' => false,
	'fireBugLight' => false,
);
