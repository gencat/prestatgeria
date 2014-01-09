<?php

ini_set('max_execution_time', 86400);

require_once 'includes/pnAPI.php';
pnInit(PN_CORE_ALL);

// Security check
if (!SecurityUtil::checkPermission('books::', "::", ACCESS_ADMIN)) {
	die("<p><strong>No teniu autorització per dur a terme aquesta acció.</strong></p>
		<p><em>Cal que inicieu sessió com a administrador.</em></p>");
}

echo "<h1><strong>Modificació del path dels llibres.</strong></h1>";

// Description & Form
if ( !isset($_POST['confirm']) && !isset($_POST['check']) ) {
	
	echo "<p>A la Prestatgeria entenem com a path el fragment de l'URL que defineix l'arrel de l'aplicació. Per exemple, el path d'una Prestatgeria ubicada a http://llibres.xtec.cat és / i el d'una Prestatgeria ubicada a http://phobos.xtec.cat/llibres és /llibres/.</p>";
	echo "<p>Aquest script permet reemplaçar el path original pel path nou en el contingut del camp 'opentext' de la taula _config, del camp 'opentext' de la taula _contents i del camp 'comment' de la taula _words per a cada un dels llibres de la Prestatgeria. ";
	echo "<strong>Sigueu molt curosos a l'hora d'executar-lo ja que aquesta acció pot ser irreversible.</strong> ";
	echo "En cas que volgueu executar l'script completeu el següent formulari i seguiu les instruccions.</p>";
	echo "<br>";
	
	$bookSoftwareUri = pnModGetVar('books','bookSoftwareUri');
	if ($bookSoftwareUri == '/') { $currentpath = '/'; }
	else { $currentpath = $bookSoftwareUri . '/'; }
	
	echo 	'<div class="form">' .
				'<form action="" method="post">' .
					'<label for="oldpath"><strong>Path original:</strong></label><br/>' .
					'<input name="oldpath" id="oldpath" type="text" value="" /> ' .
					'<small><code>p.ex. /llibres/, /prestatgeria/, / </code></small><br/>' .
					'<label for="newpath"><strong>Path nou:</strong></label><br/>' .
					'<input name="newpath" id="newpath" type="text" value="'. $currentpath .'" /> ' .
					'<small><code>p.ex. /llibres/, /prestatgeria/, / </code></small><br/>' .
					'<br/>' .
					'<input type="submit" name="check" value="Verifica els paths"/>' .
				 '</form>' .
			'</div>';
}

// Checks & Confirmation
if ( isset($_POST['check']) ) {

	$back = "<a href='upgrader_books_path.php'>Torna enrere.</a>";
	
	if (isset($_POST['oldpath']) ) { $oldpath = $_POST['oldpath']; }
	else { die("<p>No s'ha especificat el path antic, 'oldpath'. $back</p>"); }
	
	if (isset($_POST['newpath']) ) { $newpath = $_POST['newpath']; }
	else { die("<p>No s'ha especificat el nou path, 'newpath'. $back</p>"); }
	
	if ( !check_path($oldpath) && !check_path($newpath) ) { die("<p>El <strong>path original</strong> <code><strong>'$oldpath'</code></strong> i el <strong>nou path</strong> <code><strong>'$newpath'</code></strong> són incorrectes. $back</p>"); }
	else {
		if ( !check_path($oldpath) ) { die("<p>El <strong>path original</strong> <code><strong>'$oldpath'</code></strong> és incorrecte. $back</p>"); }
		if ( !check_path($newpath) ) { die("<p>El <strong>path nou</strong> <code><strong>'$newpath'</code></strong> és incorrecte. $back</p>"); }
	}

	$bookSoftwareUri = pnModGetVar('books','bookSoftwareUri');
	
	echo "<p>Es modificaran totes les referències del path original <code><strong>'$oldpath'</strong></code> pel path nou <code><strong>'$newpath'</strong></code>.</p>";
	echo "<p><small><code>p.ex. src='" . $oldpath . "centres/llibres_1/llibres_006.png' => src='" . $newpath . "centres/llibres_1/llibres_006.png'</code></small></p>";
	
	echo 	'<div class="form">' .
				'<form action="" method="post">' .
					'<input name="oldpath" id="oldpath" type="hidden" value="' . $oldpath . '" />' .
					'<input name="newpath" id="newpath" type="hidden" value="' . $newpath . '" />' .
					'<input type="submit" name="confirm" value="Confirma i executa l\'script"/>' .
				 '</form>' .
			'</div>';
}

// Execution
else if ( isset($_POST['confirm']) ){
	
	if (isset($_POST['oldpath']) ) { $oldpath = $_POST['oldpath']; }
	else { die("<p>No s'ha especificat el path antic, 'oldpath'. $back</p>"); }
	
	if (isset($_POST['newpath']) ) { $newpath = $_POST['newpath']; }
	else { die("<p>No s'ha especificat el nou path, 'newpath'. $back</p>"); }
		
	echo "<p><strong>S'estan obtenint els llibres...</strong></p>";
	ob_flush();
	flush();
	$books = pnModAPIFunc('books','admin','getAllBooksByDatabase');
	if ( !$books ) { die("<p>Hi ha hagut algun problema, no s'han pogut obtenir els llibres.</p>"); }
	else { echo "<p>Fet!</p>"; }
	ob_flush();
	flush();
	
	foreach ($books as $i => $db_books) {
		if ($db_books != array()){
			echo "<p><strong>S'estan convertint els paths i les urls dels llibres de la base de dades $i.</strong></p>";
			ob_flush();
			flush();
			foreach ($db_books as $book) {
				$schoolCode = $book['schoolCode'];
				$bookId = $book['bookId'];
				$schoolId = $book['schoolId'];
				echo "<p>&nbsp&nbsp&nbsp&nbspS'està convertint el llibre amb codi de centre <strong><em>$schoolCode</em></strong> i codi de llibre <strong><em>$bookId</em></strong>.</p>";
				ob_flush();
				flush();
				$result = pnModAPIFunc('books','admin','changeBookPath',array('oldpath'=>$oldpath, 'newpath'=>$newpath, 'book_id'=>$bookId, 'book_schoolcode'=>$schoolCode, 'book_schoolId'=>$schoolId));
				if (!$result) { echo "<p>&nbsp&nbsp&nbsp&nbspHi ha hagut algun problema a l'hora de convertir el llibre.</p>"; }
				else { echo "<p>&nbsp&nbsp&nbsp&nbspFet!</p>"; }
				ob_flush();
				flush();
			}
		}
	}
	
	echo "<p>Fet!</p><p><strong>L'script ha finalitzat la seva execució. Veieu el registre de missatges de més amunt per veure'n el resultat.</strong></p>";
	ob_flush();
	flush();
}

function check_path($path)
{
	$starts = preg_match('/^\//', $path);
	$ends = preg_match('/\/$/', $path);
	return (($starts != 0) && ($ends != 0));	
}