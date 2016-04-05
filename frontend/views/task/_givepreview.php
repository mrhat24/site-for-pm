<?php
use Netcarver\Textile;
$parser = new \Netcarver\Textile\Parser();

echo $parser->textileThis($task->text);