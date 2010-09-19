<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<link href="<?php echo $basepath; ?>assets/docs.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?php echo $basepath; ?>assets/jasmine.css" rel="stylesheet" type="text/css" media="screen" />

	<script src="<?php echo $basepath; ?>assets/jasmine.js"></script>
	<script src="<?php echo $basepath; ?>assets/jasmine-html.js"></script>
	<script src="<?php echo $basepath; ?>assets/Syn.js"></script>

	<title><?php echo $appName; ?> - <?php echo htmlentities(str_replace('_', ' ', $title)); ?></title>

	<script>

		var makeActions = function(tests){

			if (!$('actions')) new Element('dt', {
				id: 'actions'
			}).inject($('mt-content'), 'top');

			if (typeOf(tests)) tests = Object.values(tests);

			tests.each(function(test) {
				new Element('dt').adopt(
					new Element('a', {
						text: test.title,
						events: {
							click: test.fn
						}
					})
				).inject('actions');
				if (test.description) new Element('dd', {
					text: test.description
				}).inject('actions');
			});

		};

		window.onload = function(){

			var jasmineResults = document.getElementById('jasmineResults');

			document.getElementById('startJasmine').onclick = function(event){
				if (!event) event = window.event;
				event.preventDefault();

				jasmineResults.innerHTML = '';

				// Run the specs
				jasmine.getEnv().addReporter(new jasmine.TrivialReporter(null, jasmineResults));
				jasmine.getEnv().execute();
			};

		}

	</script>

</head>
<body>

<div id="header">
<h1>MooTools More 1.3 Test Runner</h1>
<h2>
	<?php if ($prevTest): ?><a href="<?php echo $baseurl.'/'.$prevTest; ?>" class="prevNext"> &#171; <?php echo substr($prevTest, strrpos($prevTest, '/', -1) + 1); ?></a><?php endif; ?>
	<?php echo htmlentities(str_replace('_', ' ', substr($title, strrpos($title, '/', -1) + 1))); ?>
	<?php if ($nextTest): ?><a href="<?php echo $baseurl.'/'.$nextTest; ?>" class="prevNext"><?php echo substr($nextTest, strrpos($nextTest, '/', -1) + 1); ?> &#187; </a><?php endif; ?>
</h2>
</div>

<div id="container1">

	<div id="jasmine-reporter">
		<a href="#" id="startJasmine">Start automatic Tests</a>
		<h2>Jasmine Results</h2>
		<div id="jasmineResults"></div>
	</div>


	<div id="menu">
		<ul>
		<?php foreach($menu as $category => $link): ?>
			<li><strong><?php echo $category; ?></strong><ul>
			<?php foreach($link as $text): ?>
			<li><a href="<?php echo $baseurl.'/'.$category.'/'.$text; ?>"><?php echo str_replace('_', ' ', $text); ?></a></li>
			<?php endforeach; ?>
		</ul></li>
		<?php endforeach; ?>
		</ul>
	</div>

	<div id="docs" class="doc">

		<div id="mt-content" class="content">
			<?php echo $content; ?>
		</div>

	</div>

</div>

</body>
</html>