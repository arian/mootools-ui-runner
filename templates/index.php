<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<link href="<?php echo $basepath; ?>assets/runner.css" rel="stylesheet" type="text/css" media="screen" />

<?php if ($jasmine): ?>
	<link href="<?php echo $basepath; ?>assets/jasmine.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?php echo $basepath; ?>assets/runnerWithJasmine.css" rel="stylesheet" type="text/css" media="screen" />

	<script src="<?php echo $basepath; ?>assets/jasmine.js"></script>
	<script src="<?php echo $basepath; ?>assets/jasmine-html.js"></script>
	<script src="<?php echo $basepath; ?>assets/Syn.js"></script>
<?php endif; ?>

	<title><?php echo $appName; ?> - <?php echo htmlentities(str_replace('_', ' ', $title)); ?></title>

	<script>

		(function(){

			var addListener = function(type, fn){
				if (this.addEventListener) this.addEventListener(type, fn, false);
				else this.attachEvent('on' + type, fn);
			};

			var addAction = function(test, actions){
				var dt = document.createElement('dt'),
					a = document.createElement('a'),
					dd = document.createElement('dd');

				addListener.call(a, 'click', test.fn);
				a.innerHTML = test.title;
				dt.appendChild(a);

				actions.appendChild(dt);

				if (test.description){
					dd.innerHTML = test.description;
					actions.appendChild(dd);
				}
			};

			this.makeActions = function(tests){

				var actions = document.getElementById('actions');
				if (!actions){
					actions = document.createElement('dt');
					actions.setAttribute('id', 'actions');

					var element = document.getElementById('mt-content');
					element.insertBefore(actions, element.firstChild)
				}

				for (var name in tests) if (tests.hasOwnProperty(name)){
					addAction(tests[name], actions);
				}

			};

		})();

		<?php if ($jasmine): ?>
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
		<?php endif; ?>
	</script>

	<?php if ($fireBugLight): ?>
	<script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script>
	<?php endif; ?>

</head>
<body>

<div id="header">
<h1>MooTools More 1.3 Test Runner</h1>
<h2>
	<?php if ($prevTest): ?><a href="<?php echo $baseurl . '/' . $suite . '/' . $prevTest; ?>" class="buttons"> &#171; <?php echo substr($prevTest, strrpos($prevTest, '/', -1) + 1); ?></a><?php endif; ?>
	<?php echo htmlentities(str_replace('_', ' ', substr($title, strrpos($title, '/', -1) + 1))); ?>
	<?php if ($nextTest): ?><a href="<?php echo $baseurl . '/' . $suite . '/' . $nextTest; ?>" class="buttons"><?php echo substr($nextTest, strrpos($nextTest, '/', -1) + 1); ?> &#187; </a><?php endif; ?>
</h2>
</div>

<div id="container1">

	<?php if ($jasmine): ?>
	<div id="jasmine-reporter">
		<a href="#" id="startJasmine" class="buttons">Start automatic Tests</a>
		<h2>Jasmine Results</h2>
		<div id="jasmineResults"></div>
	</div>
	<?php endif; ?>

	<div id="menu">
		<ul>
			<li><a href="<?php echo $baseurl; ?>">Intro</a></li>
		</ul>
	<?php foreach ($menu as $suiteName => $suiteFiles): ?>
		<h2><?php echo $suiteName; ?></h2>
		<ul>
		<?php foreach($suiteFiles as $category => $link): ?>
			<li><strong><?php echo $category; ?></strong><ul>
			<?php foreach($link as $text): ?>
			<li><a href="<?php echo $baseurl . '/' . $suiteName .'/' . $category . '/' . $text; ?>"><?php echo str_replace('_', ' ', $text); ?></a></li>
			<?php endforeach; ?>
		</ul></li>
		<?php endforeach; ?>
		</ul>
	<?php endforeach; ?>
	</div>

	<div id="runner">

		<div id="mt-content" class="content">
			<?php echo $content; ?>
		</div>

	</div>

</div>

</body>
</html>