<!DOCTYPE html>
<html lang="en">

	<head>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Convert tab separated result sets to Redmine tables</title>
	</head>

	<body>
		<div class="container">

			<h1>Convert tab separated result sets to Redmine tables</h1>

			<form role="form" method="post">

				<div class="form-group">

					<label for="tab-separated-results">&quot;Copy with Column Names&quot; from Sequel Pro</label>

					<textarea id="tab-separated-results" class="form-control" name="content" cols="76" rows="20"><?php echo htmlspecialchars($_POST["content"])?></textarea><br>

				</div>

				<button type="submit" class="btn btn-success">Convert to a Redmine table</button>
			</form>

			<?php

			if ($_SERVER["REQUEST_METHOD"] == "POST")
			{
				$lines = explode("\n", $_POST["content"]);
				$table = "";

				foreach ($lines as $line_index => $line)
				{
					$cols = explode("\t", trim($line));

					foreach ($cols as &$column)
					{
						if ($line_index == 0)
						{
							$column = "_.{$column}";
						}

						if (looks_like_float($column))
						{
							$column = ">. {$column}";
						}
					}


					$table .= "|". implode("|", $cols) . "|" . PHP_EOL;
				}

				$table .= PHP_EOL;
			}

			echo "<br><pre>" . htmlspecialchars($table) . "</pre>";

			/**
			 * Does the string look like a float / integer?
			 *
			 * @param $string
			 * @return bool
			 */
			function looks_like_float ($string)
			{
				return (bool) preg_match("!^-?[\\d.]+$!", $string);
			}

			?>

		</div>

	</body>

</html>