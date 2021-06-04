<?PHP
// definition de variables
$a=2;
$b=3;
// affichage des variables
echo 'a = '.$a;
echo '<br/>';
echo 'a = '.$a. ' b = '.$b;
//codition Si
if($a<=4)
	echo 'toto';
	else echo 'titi';
//boucle	
while($a!=4) {
	$a++; // a=a+1
}
echo ' a = '.$a;
// faire ... jusqu'à
do{
	$a++; // a=a+1
}while($a!=8);
echo ' a = '.$a;

// pour
for($i=0; $i<10; $i++){
	$b++; echo '<br/>'.$i;
}
echo '<br/> b = '.$b;
// Création  tableau de 10 cellules
$tab[10];
for($i=0; $i<10; $i++){
	$tab[$i]=2;
}
// affichage du tableau
for($i=0; $i<10; $i++){
	echo ' '.$tab[$i];
}
echo '<br/>';
echo 'Exercice 2.1 <br/>';
$c=3;
$d=$c*$c;

echo ' d = '.$d. ' soit '.$c. ' au carré';	
?>