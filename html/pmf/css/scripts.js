// JavaScript Document
function recarrega(wid){
	document.rec.wid.value=wid;		
	document.rec.submit();
}
function edita(id){
	document.rec.edita.value=id;
	document.rec.submit();		
}
function valida(id){
	document.rec.valida.value=id;
	document.rec.submit();		
}
function enviar(){
	var error=false;
	var validRegExp = /^[^@]+@[^@]+.[a-z]{2,}$/i;
	strCorreu = document.f.contacte.value;
	if(document.f.centre.value=="" && !error){
		alert("No heu indicat el nom del centre o entitat educativa!");
		error=true;
		
	}
	if(document.f.url.value=="" && !error){
		alert("No heu indicat la URL de la web dinàmica!");
		error=true;
	}
	if(document.f.localitat.value=="" && !error){
		alert("No heu indicat el municipi!");
		error=true;
	}
	if(document.f.contacte.value=="" && !error){
		alert("No heu indicat el correu electrònic de contacte!");
		error=true;
	}
	// search email text for regular exp matches
	if (strCorreu.search(validRegExp) == -1 && !error){
		alert('Cal indicar una adreça de correu vàlida!');
		error=true;
	} 
			
	if(document.f.obs.value.length>255 && !error){
		alert("La descripció té massa caràcters!\nCom a màxim en pots posar 255.");
		error=true;
	}

	if((document.f.newPass.value.length<6 && document.f.newPass.value.length>0) && !error){
		alert("La contrasenya d'edició nova té massa pocs caràcters. Com a mínim n'ha de tenir 6.");
		error=true;
	}

	if(!error && eval("document.f.file").value!="" && ".jpg".indexOf(eval("document.f.file").value.substring(eval("document.f.file").value.length-3,eval("document.f.file").value.length))==-1){
		alert("L'extensió de la imatge no és correcte. Les imatges han de tenir l'extensió jpg.");
		error=true;
	}

	if(!error){
		var confirmacio=confirm("Vols enviar el registre?")
		if(confirmacio){
			document.f.submit();
		}
	}
}

function validar(){
	var error=false;
	var validRegExp = /^[^@]+@[^@]+.[a-z]{2,}$/i;
	strCorreu = document.f.contacte.value;
	if(document.f.centre.value=="" && !error){
		alert("No heu indicat el nom del centre o entitat educativa!");
		error=true;
		
	}
	if(document.f.url.value=="" && !error){
		alert("No heu indicat la URL de la web dinàmica!");
		error=true;
	}
	if(document.f.localitat.value=="" && !error){
		alert("No heu indicat el municipi!");
		error=true;
	}
	if(document.f.contacte.value=="" && !error){
		alert("No heu indicat el correu electrònic de contacte!");
		error=true;
	}
	// search email text for regular exp matches
	if (strCorreu.search(validRegExp) == -1 && !error){
		alert('Cal indicar una adreça de correu vàlida!');
		error=true;
	} 
			
	if(document.f.obs.value.length>255 && !error){
		alert("La descripció té massa caràcters!\nCom a màxim en pots posar 255.");
		error=true;
	}

	if((document.f.newPass.value.length<6 && document.f.newPass.value.length>0) && !error){
		alert("La contrasenya d'edició nova té massa pocs caràcters. Com a mínim n'ha de tenir 6.");
		error=true;
	} 
	if(document.f.tipusID.selectedIndex==0 && !error){
		alert("Has d'escollir un tipus de centre.");
		error=true;
	}

	if(!error && eval("document.f.file").value!="" && ".jpg".indexOf(eval("document.f.file").value.substring(eval("document.f.file").value.length-3,eval("document.f.file").value.length))==-1){
		alert("L'extensió de la imatge no és correcte. Les imatges han de tenir l'extensió jpg.");
		error=true;
	}
	
	if(!error){
		var confirmacio=confirm("Vols enviar el registre?")
		if(confirmacio){
			document.f.submit();
		}
	}
}
