<?PHP/

$destinataire = 'eric@eric-bossu.fr';
$copie = 'oui';
$form_action = '';
$message_envoye = "Votre message nous est bien parvenu !"; header('Location: index.html');
$message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
$message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.";

function Rec($text)
{
	$text = htmlspecialchars(trim($text), ENT_QUOTES);
	if (1 === get_magic_quotes_gpc())
	{
		$text = stripslashes($text);
	}

	$text = nl2br($text);
	return $text;
};

function IsEmail($email)
{
	$value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
	return (($value === 0) || ($value === false)) ? false : true;
}

$nom     = (isset($_POST['nom']))     ? Rec($_POST['nom'])     : '';
$email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
$objet   = (isset($_POST['objet']))   ? Rec($_POST['objet'])   : '';
$message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';

$email = (IsEmail($email)) ? $email : ''; 
$err_formulaire = false; 

if (isset($_POST['envoi']))
{
	if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'From:'.$nom.' <'.$email.'>' . "\r\n" .
				'Reply-To:'.$email. "\r\n" .
				'Content-Type: text/plain; charset="utf-8"; DelSp="Yes"; format=flowed '."\r\n" .
				'Content-Disposition: inline'. "\r\n" .
				'Content-Transfer-Encoding: 7bit'." \r\n" .
				'X-Mailer:PHP/'.phpversion();

		if ($copie == 'oui')
		{
			$cible = $destinataire.';'.$email;
		}
		else
		{
			$cible = $destinataire;
		};

		$message = str_replace("&#039;","'",$message);
		$message = str_replace("&#8217;","'",$message);
		$message = str_replace("&quot;",'"',$message);
		$message = str_replace('<br>','',$message);
		$message = str_replace('<br/>','',$message);
		$message = str_replace("&lt;","<",$message);
		$message = str_replace("&gt;",">",$message);
		$message = str_replace("&amp;","&",$message);

		$num_emails = 0;
		$tmp = explode(';', $cible);
		foreach($tmp as $email_destinataire)
		{
			if (mail($email_destinataire, $objet, $message, $headers))
				$num_emails++;
		}

		if ((($copie == 'oui') && ($num_emails == 2)) || (($copie == 'non') && ($num_emails == 1)))
		{
			echo '<p>'.$message_envoye.'</p>';
		}
		else
		{
			echo '<p>'.$message_non_envoye.'</p>';
		};
	}
	else
	{
		echo '<p>'.$message_formulaire_invalide.'</p>';
		$err_formulaire = true;
	};
}; 

if (($err_formulaire) || (!isset($_POST['envoi'])))
{
	echo '
	<form id="contact" method="post" action="'.$form_action.'">
	<fieldset><legend>Vos coordonnées</legend>
		<p><label for="nom">Nom :</label><input type="text" id="nom" name="nom" value="'.stripslashes($nom).'" tabindex="1" /></p>
		<p><label for="email">Email :</label><input type="text" id="email" name="email" value="'.stripslashes($email).'" tabindex="2" /></p>
	</fieldset>

	<fieldset><legend>Votre message :</legend>
		<p><label for="objet">Objet :</label><input type="text" id="objet" name="objet" value="'.stripslashes($objet).'" tabindex="3" /></p>
		<p><label for="message">Message :</label><textarea id="message" name="message" tabindex="4" cols="30" rows="8">'.stripslashes($message).'</textarea></p>
	</fieldset>

	<div style="text-align:center;"><input type="submit" name="envoi" value="Envoyer le formulaire !" /></div>
	</form>';
};
?>