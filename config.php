<?php

return array(
	'app-name' => 'MooTools More 1.3 Test Runner',
	'sources' => array(
		'../mootools-core',
		'../mootools-more',
	),
	'exclude-blocks' => array(
		'1.2compat'
	),
	'tests' => array(
		'more' => '../mootools-more/Tests/Interactive',
//		'Element.Behaviors' => '../mootools-element-behaviors/Tests'
	),
	'jasmine' => false,
	'fireBugLight' => false,
);
