<?php

//Connectem amb la base de dades
include_once('inc/connecta.inc');

function getLang($lang) {
    if (isset($_REQUEST['lang'])) {
        $_SESSION['lang'] = $_REQUEST['lang'];
        return $_REQUEST['lang'];
    } else if (isset($_SESSION['lang'])) {
        return $_SESSION['lang'];
    }
    if (isset($lang) && !empty($lang))
        return $lang;
    return 'ca';
}


function getAllLanguages() {
    $sql = "SELECT * FROM 012_langs";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $values = array();
    while ($row = mysql_fetch_array($rs)) {
        $values[] = array('lang' => $row['lang'], 'name' => $row['name']);
    }
    return $values;
}


function getAllItems($args) {
    extract($args);
    ($validat == 0) ? $valida = "AND sul.valida=1" : $valida = "";
    $sql = "SELECT su.*, clics, sul.question AS pregunta, sul.valida AS valida_lang, sul.created AS created_lang, sul.modified AS modified_lang FROM 012_suport su LEFT JOIN 012_suport_lang sul ON su.sid=sul.sid AND sul.lang='$lang' WHERE su.tema='$id' $valida ORDER BY ordre";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $values = array();
    while ($row = mysql_fetch_array($rs)) {
        $question = (isset($row['question']) ? $row['question'] : $row['pregunta']);
        $valida = (isset($row['valida_lang']) ? $row['valida_lang'] : 0);
        $created = (isset($row['created_lang']) ? $row['created_lang'] : 0);
        $modified = (isset($row['modified_lang']) ? $row['modified_lang'] : 0);
        $values[] = array('sid' => $row['sid'], 'tid' => $row['tema'], 'clics' => $row['clics'], 'pregunta' => $question, 'tema' => $row['tema'], 'valida' => $valida, 'ordre' => $row['ordre'], 'created' => $created, 'modified' => $modified);
    }
    return $values;
}


function getAllComments($args) {
    extract($args);
    ($validat == 0) ? $valida = "AND validate=1" : $valida = "";
    $sql = "SELECT * from 012_comment WHERE question_id=$id $valida ORDER BY date DESC";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $values = array();
    while ($row = mysql_fetch_array($rs)) {
        $values[] = array('id' => $row['id'], 'comment' => $row['comment'], 'date' => $row['date'], 'author' => $row['author'], 'validate' => $row['validate']);
    }
    return $values;
}


function getAllNewComments() {
    $sql = "SELECT * from 012_comment WHERE validate=0 or validate=2 ORDER BY date DESC";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $values = array();
    while ($row = mysql_fetch_array($rs)) {
        $values[] = array('question_id' => $row['question_id']);
    }
    return $values;
}


function getAllChapters($args) {
    extract($args);
    ($validat == 0) ? $valida = " WHERE cl.valida=1 " : $valida = "";
    if (!isset($lang))
        $lang = getLang('');
    $sql = "SELECT c.*, cl.title AS titol, cl.valida AS valida_lang, cl.created AS created_lang, cl.modified AS modified_lang FROM 012_chapter c LEFT JOIN 012_chapter_lang cl ON c.cid=cl.cid AND cl.lang='$lang' $valida ORDER BY ordre";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $values = array();
    while ($row = mysql_fetch_array($rs)) {
        $title = (isset($row['title']) ? $row['title'] : $row['titol']);
        $valida = (isset($row['valida_lang']) ? $row['valida_lang'] : 0);
        $created = (isset($row['created_lang']) ? $row['created_lang'] : 0);
        $modified = (isset($row['modified_lang']) ? $row['modified_lang'] : 0);
        $values[] = array('cid' => $row['cid'], 'titol' => $title, 'valida' => $valida, 'ordre' => $row['ordre'], 'created' => $created, 'modified' => $modified);
    }
    return $values;
}


function getAllSections($args) {
    extract($args);
    ($validat == 0) ? $valida = "AND sl.valida=1" : $valida = "";
    if (!isset($lang))
        $lang = getLang('');
    $sql = "SELECT s.*, sl.title , sl.valida AS valida_lang, sl.created AS created_lang, sl.modified AS modified_lang FROM 012_section s LEFT JOIN 012_section_lang sl ON s.id=sl.sid AND sl.lang='$lang' WHERE s.cid=$cid $valida ORDER BY s.ordre";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $values = array();
    while ($row = mysql_fetch_array($rs)) {
        $title = (isset($row['title']) ? $row['title'] : $row['titol']);
        $valida = (isset($row['valida_lang']) ? $row['valida_lang'] : 0);
        $created = (isset($row['created_lang']) ? $row['created_lang'] : 0);
        $modified = (isset($row['modified_lang']) ? $row['modified_lang'] : 0);
        $values[] = array('id' => $row['id'], 'cid' => $row['cid'], 'titol' => $title, 'tid' => $row['id'], 'valida' => $valida, 'ordre' => $row['ordre'], 'created' => $created, 'modified' => $modified);
    }
    return $values;
}


function getLastAutonumericId($table, $column) {
    $sql = "SELECT MAX($column) as $column FROM $table";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $row = mysql_fetch_array($rs);
    $value = $row[$column];
    return $value;
}


function getLastChapterId() {
    return getLastAutonumericId('012_chapter', 'cid');
}


function getLastSectionId() {
    return getLastAutonumericId('012_section', 'id');
}


function getLastQuestionId() {
    return getLastAutonumericId('012_suport', 'sid');
}


function getQuestion($args) {
    extract($args);
    $sql = "SELECT su.*, se.cid, sul.question AS pregunta, sul.response AS resposta, sul.other AS altres, sul.id, sul.valida FROM 012_section se, 012_suport su LEFT JOIN 012_suport_lang sul ON su.sid=sul.sid AND sul.lang='$lang' WHERE su.sid=$sid AND su.tema=se.id";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $values = array();
    while ($row = mysql_fetch_array($rs)) {
        $question = (!empty($row['question']) ? $row['question'] : $row['pregunta']);
        $response = (isset($row['response']) ? $row['response'] : $row['resposta']);
        $other = (isset($row['other']) ? $row['other'] : $row['altres']);
        $values = array('id' => $row['id'], 'sid' => $row['sid'], 'c' => $row['cid'], 't' => $row['tema'], 'pregunta' => $question, 'resposta' => $response, 'altres' => $other, 'valida' => $row['valida']);
    }
    return $values;
}


function getQuestionSid($args) {
    extract($args);
    $sql = "SELECT sid from 012_suport_lang WHERE id=$question_id";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $value = mysql_result($rs, 0);
    return $value;
}


function getComment($args) {
    extract($args);
    $sql = "SELECT comment from 012_comment WHERE id=$id";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    while ($row = mysql_fetch_array($rs)) {
        $value = array('comment' => $row['comment']);
    }
    return $value;
}


function getChapter($args) {
    extract($args);
    $sql = "SELECT c.*, cl.* , cl.title AS titol FROM 012_chapter c LEFT JOIN 012_chapter_lang cl ON c.cid=cl.cid AND cl.lang='$lang' WHERE c.cid=$cid ORDER BY ordre";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $value = '---';
    while ($row = mysql_fetch_array($rs)) {
        $title = (!empty($row['title']) ? $row['title'] : $row['titol']);
        $value = array('cid' => $row['cid'], 'titol' => $title, 'valida' => $row['valida'], 'created' => $row['created'], 'modified' => $row['modified'], 'lang' => $lang);
    }
    return $value;
}


function getSection($args) {
    extract($args);
    $sql = "SELECT s.*, sl.* FROM 012_section s LEFT JOIN 012_section_lang sl ON s.id=sl.sid AND sl.lang='$lang'  WHERE s.id=$id ORDER BY ordre";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $value = '---';
    while ($row = mysql_fetch_array($rs)) {
        $title = (!empty($row['title']) ? $row['title'] : $row['titol']);
        $value = array('id' => $row['id'], 'sid' => $row['sid'], 'titol' => $title, 'cid' => $row['cid'], 'valida' => $row['valida'], 'created' => $row['created'], 'modified' => $row['modified'], 'lang' => $lang);
    }
    return $value;
}


function editQuestion($args) {
    extract($args);
    $pregunta = mysql_escape_string($pregunta);
    $resposta = mysql_escape_string($resposta);
    $altres = mysql_escape_string($altres);

    if ($tema != "") {
        $quintema = ",tema=" . $tema;
    }
    $modified = time();
    // Afegim la pregunta a la taula d'idiomes
    $lang = getLang($lang);
    $sql = "SELECT * FROM 012_suport_lang WHERE sid=$sid AND lang='$lang' ";
    $rs = mysql_query($sql);
    if (mysql_num_rows($rs) > 0) {
        $sql = "UPDATE 012_suport_lang SET question='$pregunta',response='$resposta',other='$altres',modified='$modified' WHERE sid=$sid AND lang='$lang'";
    } else {
        $sql = "INSERT INTO 012_suport_lang (sid, lang, question, response, other,created) VALUES ($sid, '$lang','$pregunta','$resposta','$altres','$modified')";
    }
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    //Canviem la pregunta de tema
    $sql = "UPDATE 012_suport SET tema='$tema' WHERE sid=$sid";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


function editSection($args) {
    extract($args);
    $modified = time();
    foreach (getAllLanguages() as $lang) {
        $arg_title = 'titol_' . $lang['lang'];
        $title = $$arg_title;
        if (isset($title)) {
            $sql = "SELECT * FROM 012_section_lang WHERE id=$id AND lang='" . $lang['lang'] . "'";
            $rs = mysql_query($sql);
            $arg_validation = 'valida_' . $lang['lang'];
            $validation = $$arg_validation;
            if (mysql_num_rows($rs) > 0) {
                $sql = "UPDATE 012_section_lang SET title='$title', valida=$validation, modified='$modified' WHERE id=$id AND lang='" . $lang['lang'] . "' ";
            } else {
                $sql = "INSERT INTO 012_section_lang (sid, lang, title,valida,created) VALUES ($sid, '" . $lang['lang'] . "','$title','$validation','$modified')";
            }
            $rs = mysql_query($sql);
            if (!$rs) {
                die($sql);
                return false;
            }
        }
    }
    $sql = "UPDATE 012_section SET cid='$cid' WHERE id='$sid' ";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


function editChapter($args) {
    extract($args);

    $title = mysql_escape_string($title);

    $modified = time();
    foreach (getAllLanguages() as $lang) {
        $arg_title = 'titol_' . $lang['lang'];
        $title = $$arg_title;
        if (isset($title)) {
            $sql = "SELECT * FROM 012_chapter_lang WHERE cid=$cid AND lang='" . $lang['lang'] . "' ";
            $rs = mysql_query($sql);
            $arg_validation = 'valida_' . $lang['lang'];
            $validation = $$arg_validation;
            if (mysql_num_rows($rs) > 0) {
                $sql = "UPDATE 012_chapter_lang SET title='$title',valida='$validation',modified='$modified' WHERE cid=$cid AND lang='" . $lang['lang'] . "' ";
            } else {
                $sql = "INSERT INTO 012_chapter_lang (cid, lang, title,valida,created) VALUES ($cid, '" . $lang['lang'] . "','$title','$validation','$modified')";
            }
            $rs = mysql_query($sql);
            if (!$rs) {
                die($sql);
                return false;
            }
        }
    }
    return true;
}


function createSection($args) {
    extract($args);
    $modified = time();
    $sql = "INSERT INTO 012_section (cid) VALUES ($cid)";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $sid = getLastSectionId();
    foreach (getAllLanguages() as $lang) {
        $arg_title = 'titol_' . $lang['lang'];
        $title = $$arg_title;
        if (isset($title)) {
            $arg_validation = 'valida_' . $lang['lang'];
            $validation = $arg_validation;
            $sql = "INSERT INTO 012_section_lang (sid, lang, title, valida, created) VALUES ($sid, '" . $lang['lang'] . "','$title','$validation','$modified')";
            $rs = mysql_query($sql);
            if (!$rs) {
                die($sql);
                return false;
            }
        }
    }

    return true;
}


function createChapter($args) {
    extract($args);
    $modified = time();
    $sql = "INSERT INTO 012_chapter (ordre) VALUES (0)";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $cid = getLastChapterId();

    foreach (getAllLanguages() as $lang) {
        $arg_title = 'titol_' . $lang['lang'];
        $title = $$arg_title;

        if (isset($title)) {
            $arg_validation = 'valida_' . $lang['lang'];
            $validation = $$arg_validation;
            $sql = "INSERT INTO 012_chapter_lang (cid, lang, title, valida, created) VALUES ($cid, '" . $lang['lang'] . "','$title','$validation','$modified')";

            $rs = mysql_query($sql);
            if (!$rs) {
                die($sql);
                return false;
            }
        }
    }

    return true;
}


function createQuestion($args) {
    extract($args);
    $modified = time();
    $sql = "INSERT INTO 012_suport (tema) VALUES ($tema)";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $sid = getLastQuestionId();
    foreach (getAllLanguages() as $lang) {
        $arg_question = 'pregunta_' . $lang['lang'];
        $question = $$arg_question;
        if (isset($question)) {
            $arg_validation = 'valida_' . $lang['lang'];
            $validation = $$arg_validation;
            $sql = "INSERT INTO 012_suport_lang (sid, lang, question, valida, created) VALUES ('$sid','" . $lang['lang'] . "','$question',$validation,'$modified')";
            $rs = mysql_query($sql);
            if (!$rs) {
                die($sql);
                return false;
            }
        }
    }

    return true;
}


function nova($args) {
    extract($args);
    $pregunta = mysql_escape_string($pregunta);
    $resposta = mysql_escape_string($resposta);
    $altres = mysql_escape_string($altres);

    $time = time();
    $sql = "INSERT INTO 012_suport (tema) VALUES (0)";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $sid = getLastQuestionId();
    $sql = "INSERT INTO 012_suport_lang (sid, lang, question, valida, created,response,other) VALUES ('$sid','$lang','$pregunta',0,'$time','$resposta','$altres')";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


function getAllSections1($args) {
    extract($args);
    (isset($validat) && $validat == 0) ? $valida = "WHERE valida=1" : $valida = "";
    if (!isset($lang))
        $lang = getLang('');
    $sql = "SELECT s.*, sl.title AS titol FROM 012_section s LEFT JOIN 012_section_lang sl ON s.id=sl.sid AND sl.lang='$lang' $valida ORDER BY s.id";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $values = array();
    while ($row = mysql_fetch_array($rs)) {
        $title = (isset($row['title']) ? $row['title'] : $row['titol']);
        $values[] = array('id' => $row['id'], 'titol' => $title, 'tid' => $row['id']);
    }
    return $values;
}


function valida($args) {
    extract($args);
    ($a == 1) ? $created = time() : $created = "";
    switch ($q) {
        case "c":
            $sql = "UPDATE 012_chapter_lang SET valida=$a,created='$created' WHERE cid=$id AND lang='$lang'";
            break;
        case "t":
            $sql = "UPDATE 012_section_lang SET valida=$a,created='$created' WHERE sid=$id AND lang='$lang'";
            break;
        case "p":
            $sql = "UPDATE 012_suport_lang SET valida=$a,created='$created' WHERE sid=$id AND lang='$lang'";
            break;
    }
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


function delItem($args) {
    extract($args);
    $sql = "DELETE FROM 012_suport WHERE sid=$sid";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


function delSection($args) {
    extract($args);
    $sql = "SELECT * FROM 012_suport WHERE tema=$id";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    while ($row = mysql_fetch_array($rs)) {
        $sql2 = "DELETE FROM 012_suport_lang WHERE sid=" . $row['sid'];
        $rs2 = mysql_query($sql2);
        if (!$rs2) {
            die($sql);
            return false;
        }
    }
    $sql = "DELETE FROM 012_suport WHERE tema=$id";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }

    $sql = "DELETE FROM 012_section_lang WHERE sid=$id";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $sql = "DELETE FROM 012_section WHERE id=$id";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


function delChapter($args) {
    extract($args);
    $sql = "SELECT * FROM	012_section WHERE cid=$cid";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    while ($row = mysql_fetch_array($rs)) {
        delsection(array('id' => $row['id']));
    }
    //Implementar l'esborrat de temes i preguntes
    $sql = "DELETE FROM 012_chapter_lang WHERE cid=$cid";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $sql = "DELETE FROM 012_chapter WHERE cid=$cid";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


function delComment($args) {
    extract($args);
    $sql = "DELETE FROM 012_comment WHERE id=$id";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


function clics($args) {
    extract($args);
    //Només compta els clics si no s'està administran
    if ($validat == 1) {
        return true;
    }
    $sql = "UPDATE 012_suport_lang SET clics=clics+1 WHERE sid=$sid AND lang='$lang'";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


function ordre($args) {
    extract($args);
    //Agafem tots els registres segons retorni el paràmetre q
    switch ($q) {
        case 'c':
            $valors = getAllChapters(array('validat' => 1));
            break;
        case 't':
            $valors = getAllSections(array('cid' => $cid, 'validat' => 1));
            break;
        case 'p':
            $valors = getAllItems(array('id' => $tid, 'validat' => 1, 'lang' => $lang));
            break;
    }


    //recorrem els registres i els modifiquem l'ordre
    $i = 0;
    foreach ($valors as $valor) {
        switch ($q) {
            case 'c':
                $sql = "UPDATE 012_chapter SET ordre=$i WHERE cid=" . $valor['cid'];
                break;
            case 't':
                $sql = "UPDATE 012_section SET ordre=$i WHERE id=" . $valor['id'];
                break;
            case 'p':
                $sql = "UPDATE 012_suport SET ordre=$i WHERE sid=" . $valor['sid'];
                break;
        }
        $i+=10;
        $rs = mysql_query($sql);
    }

    //Al registre que correspon a la id li sumem o restem 15 segons s'hi ha de pujar a l'ordre per canviar-lo de posici�
    switch ($q) {
        case 'c':
            $sql = "update 012_chapter set ordre=ordre+$ordre where cid=$id";
            break;
        case 't':
            $sql = "update 012_section set ordre=ordre+$ordre where id=$id";
            break;
        case 'p':
            $sql = "update 012_suport set ordre=ordre+$ordre where sid=$id";
            break;
    }
    $rs = mysql_query($sql);
    return true;
}


function no_na($args) {
    extract($args);
    switch ($val) {
        case 1:
            $created = time();
            $modified = '';
            break;
        case 2:
            $created = '';
            $modified = time();
            break;
        default:
            $created = '';
            $modified = '';
            break;
    }
    switch ($q) {
        case "c":
            $sql = "UPDATE 012_chapter_lang SET created='$created',modified='$modified' WHERE cid=$id";
            break;
        case "t":
            $sql = "UPDATE 012_section_lang SET created='$created',modified='$modified' WHERE sid=$id";
            break;
        case "p":
            $sql = "UPDATE 012_suport_lang SET created='$created',modified='$modified' WHERE sid=$id";
            break;
    }
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


function filtersString($text) {
    $filtered = trim(strtolower($text));
    $filtered = str_replace("á", "&aacute;;", $filtered);
    $filtered = str_replace("à", "&agrave;", $filtered);
    $filtered = str_replace("é", "&eacute;", $filtered);
    $filtered = str_replace("è", "&egrave;", $filtered);
    $filtered = str_replace("í", "&iacute;", $filtered);
    $filtered = str_replace("ó", "&oacute;", $filtered);
    $filtered = str_replace("ò", "&ograve;", $filtered);
    $filtered = str_replace("ú", "&uacute;", $filtered);
    return $filtered;
}


function getAllSearch($args) {
    extract($args);
    ($validat == 0) ? $valida = "and 012_suport_lang.valida=1" : $valida = "";

    //seperem les paraules a buscar
    $words = explode(' ', $words);

    //Creem la sentencia de cerca
    $search = '';
    foreach ($words as $word) {
        if (!empty($word)) {
            $search.=" LCASE(012_suport_lang.question) like '%" . filtersString($word) . "%' OR ";
            $search.=" LCASE(012_suport_lang.response) like '%" . filtersString($word) . "%' OR ";
            $search.=" LCASE(012_suport_lang.other) like '%" . filtersString($word) . "%' OR ";
            $have = true;
        }
    }
    if (!$have) {
        return $values;
    }
    $search = substr($search, 1, -3);
    $search.=')';
    $sql = "select 012_suport_lang.sid,012_suport.tema,012_suport_lang.question,012_suport_lang.lang,012_suport_lang.valida,012_suport_lang.created,012_suport_lang.modified from 012_suport_lang,012_chapter,012_section,012_suport where (" . $search . " $valida and 012_suport.tema=012_section.id and 012_section.cid=012_chapter.cid and 012_suport.sid=012_suport_lang.sid order by 012_chapter.ordre,012_section.ordre";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    $values = array();
    while ($row = mysql_fetch_array($rs)) {
        $values[] = array('sid' => $row['sid'], 'tid' => $row['tema'], 'pregunta' => $row['question'], 'lang' => $row['lang'], 'valida' => $row['valida'], 'created' => $row['created'], 'modified' => $row['modified']);
    }
    return $values;
}


function comment($args) {
    extract($args);
    
    $author = mysql_escape_string($author);
    $comment = mysql_escape_string($comment);

    $sql = "INSERT INTO 012_comment (comment,question_id,author,date) VALUES ('$comment',$question_id,'$author','$date')";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


function val_comment($args) {
    extract($args);
    $sql = "UPDATE 012_comment SET validate=$a WHERE id=$id";
    $rs = mysql_query($sql);
    if (!$rs) {
        die($sql);
        return false;
    }
    return true;
}


// Funció per reemplaçar cadenes tant numeriques com literals
function unhtmlentities($cadena) {
    // reemplaçar entitats numeriques
    $cadena = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $cadena);
    $cadena = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $cadena);
    // reemplaçar entitats literals
    $trans_tbl = get_html_translation_table(HTML_ENTITIES);
    $trans_tbl = array_flip($trans_tbl);
    return strtr($cadena, $trans_tbl);
}
