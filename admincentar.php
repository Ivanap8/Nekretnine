<?php
require_once 'core/init.php';
?>
<a href="index.php">Natrag</a><br>
<?php
$user = new User();
if(!$user->isLoggedIn())
{
	Redirect::to('index.php');
}
else if($user->hasPermission('admin'))
{
	$db = new DB();
	$i = 0;
	$aktivacija = array();
	//var_dump ( $db->getAll()->results() );
	$result = $db->getAll('users')->results();
	foreach($result as $res)
	{
		$res->id;
		$i++;
		$aktivacija = array($i => $res->id);
		echo $res->username .' ' .$res->activ;
		if($res->activ == 0 ) 
		{ 
			$valueActivText = 'Aktiviraj'; 
		} 
		else 
		{ 
			$valueActivText = 'Suspend';
		}
		echo '<form action="admincentar.php" method="post"><input type="hidden" name="' . $aktivacija[$i] . '" value="'. $res->id .'"/><input type="submit" name="" value="' . $valueActivText. '"></form> <br>';
		//echo '<a href="">Aktiviraj</a>'
		//var_dump(Input::get($aktivacija[$i]));
		if(Input::get($aktivacija[$i]) == $res->id)
		{
			if($res->activ == 1)
			{
				$user->update(array(
					'activ' => 0
				), $res->id);
				Redirect::to('admincentar.php');

			}
			else if($res->activ == 0)
			{
				$user->update(array(
					'activ' => 1
				), $res->id);
				Redirect::to('admincentar.php');
			}
		}
	}
} else echo 'Nemate pravo pristupa Admin Centru ! ';
?>