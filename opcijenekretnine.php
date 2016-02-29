<?php
require_once 'core/init.php';

$user = new User();
if(!$user->isLoggedIn())
{
	Redirect::to('index.php');
}
if(Input::exists())
{	
	if(!$idnekretnina = Input::get('nekretnina'))
	{
		Redirect::to('index.php');
	}

	$nekretnina = new Nekretnina($idnekretnina);
	$nekretnina->find($idnekretnina);
	if(Token::check(Input::get('token')))
	{
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'mjesec' => array(
				'required' => true
			),
			'struja' => array(
				'required' => true
			 ),
			'voda' => array(
				'required' => true
			 ),
			'telefon' => array(
				'required' => true
			 )
		));

		if($validation->passed())
		{
			//$nekretnina = new Nekretnina();
     
		     try
		     {
		          /*Proces kreiranja troska za pojedinu nekretninu*/
		         $nekretnina->create('troskovi', array(
		         	  'mjesec' => Input::get('mjesec'),		
		              'struja' => Input::get('struja'),
		              'voda' => Input::get('voda'),
		              'telefon' => Input::get('telefon'),
		              'id_nekretnine' => $nekretnina->data()->id
		            ));
		           
		         Session::flash('home', 'Uspjesno!');
		     }
		     catch(Exception $e)
		     {
		         die($e->getMessage());
		     }
		}
		else
		{
			foreach($validation->errors() as $error)
			{
				echo $error, '<br>';
			}
		}
	}
}
?>
<a href="index.php">Natrag</a>
<form action="" method="post">
	<div class="field">
		<label for="mjesec">Mjesec</label>
		<input type="text" name="mjesec" id="mjesec">
	</div>

	<div class="field">
		<label for="struja">Struja</label>
		<input type="text" name="struja" id="struja">
	</div>

	<div class="field">
		<label for="voda">Voda</label>
		<input type="text" name="voda" id="voda">
	</div>

	<div class="field">
		<label for="telefon">Telefon</label>
		<input type="text" name="telefon" id="telefon">
	</div>

	<input type="submit" value="Dodaj Troskove">
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>