<?php
use Netcarver\Textile;
$parser = new \Netcarver\Textile\Parser();
foreach($exersices as $l)
{
echo "Упражнение#".$l->id;
echo $parser->textileThis($l->text);
}