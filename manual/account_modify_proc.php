<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$a = htmlspecialchars(addslashes($_REQUEST['a']));
$b = htmlspecialchars(addslashes($_REQUEST['b']));
$c = htmlspecialchars(addslashes($_REQUEST['c']));
$d = htmlspecialchars(addslashes($_REQUEST['d']));
$e = htmlspecialchars(addslashes($_REQUEST['e']));
$f = htmlspecialchars(addslashes($_REQUEST['f']));
$g = htmlspecialchars(addslashes($_REQUEST['g']));
$h = htmlspecialchars(addslashes($_REQUEST['h']));
$i = htmlspecialchars(addslashes($_REQUEST['i']));
$j = htmlspecialchars(addslashes($_REQUEST['j']));
$k = htmlspecialchars(addslashes($_REQUEST['k']));
$l = htmlspecialchars(addslashes($_REQUEST['l']));
$m = htmlspecialchars(addslashes($_REQUEST['m']));
$n = htmlspecialchars(addslashes($_REQUEST['n']));
$o = htmlspecialchars(addslashes($_REQUEST['o']));
$p = htmlspecialchars(addslashes($_REQUEST['p']));
$q = htmlspecialchars(addslashes($_REQUEST['q']));
$r = htmlspecialchars(addslashes($_REQUEST['r']));
$s = htmlspecialchars(addslashes($_REQUEST['s']));
$t = htmlspecialchars(addslashes($_REQUEST['t']));


$query = "update account set 

a = '{$a}',
b = '{$b}',
c = '{$c}',
d = '{$d}',
e = '{$e}',
f = '{$f}',
g = '{$g}',
h = '{$h}',
i = '{$i}',
j = '{$j}',
k = '{$k}',
l = '{$l}',
m = '{$m}',
n = '{$n}',
o = '{$o}',
p = '{$p}',
q = '{$q}',
r = '{$r}',
s = '{$s}',
t = '{$t}'

";


sql_query($query);

?>
{
	"isSuc":"success"
}
