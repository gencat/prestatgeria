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
		alert("No heu indicat la URL de la web din�mica!");
		error=true;
	}
	if(document.f.localitat.value=="" && !error){
		alert("No heu indicat el municipi!");
		error=true;
	}
	if(document.f.contacte.value=="" && !error){
		alert("No heu indicat el correu electr�nic de contacte!");
		error=true;
	}
	// search email text for regular exp matches
	if (strCorreu.search(validRegExp) == -1 && !error){
		alert('Cal indicar una adre�a de correu v�lida!');
		error=true;
	} 
			
	if(document.f.obs.value.length>255 && !error){
		alert("La descripci� t� massa car�cters!\nCom a m�xim en pots posar 255.");
		error=true;
	}

	if((document.f.newPass.value.length<6 && document.f.newPass.value.length>0) && !error){
		alert("La contrasenya d'edici� nova t� massa pocs car�cters. Com a m�nim n'ha de tenir 6.");
		error=true;
	}

	if(!error && eval("document.f.file").value!="" && ".jpg".indexOf(eval("document.f.file").value.substring(eval("document.f.file").value.length-3,eval("document.f.file").value.length))==-1){
		alert("L'extensi� de la imatge no �s correcte. Les imatges han de tenir l'extensi� jpg.");
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
		alert("No heu indicat la URL de la web din�mica!");
		error=true;
	}
	if(document.f.localitat.value=="" && !error){
		alert("No heu indicat el municipi!");
		error=true;
	}
	if(document.f.contacte.value=="" && !error){
		alert("No heu indicat el correu electr�nic de contacte!");
		error=true;
	}
	// search email text for regular exp matches
	if (strCorreu.search(validRegExp) == -1 && !error){
		alert('Cal indicar una adre�a de correu v�lida!');
		error=true;
	} 
			
	if(document.f.obs.value.length>255 && !error){
		alert("La descripci� t� massa car�cters!\nCom a m�xim en pots posar 255.");
		error=true;
	}

	if((document.f.newPass.value.length<6 && document.f.newPass.value.length>0) && !error){
		alert("La contrasenya d'edici� nova t� massa pocs car�cters. Com a m�nim n'ha de tenir 6.");
		error=true;
	} 
	if(document.f.tipusID.selectedIndex==0 && !error){
		alert("Has d'escollir un tipus de centre.");
		error=true;
	}

	if(!error && eval("document.f.file").value!="" && ".jpg".indexOf(eval("document.f.file").value.substring(eval("document.f.file").value.length-3,eval("document.f.file").value.length))==-1){
		alert("L'extensi� de la imatge no �s correcte. Les imatges han de tenir l'extensi� jpg.");
		error=true;
	}
	
	if(!error){
		var confirmacio=confirm("Vols enviar el registre?")
		if(confirmacio){
			document.f.submit();
		}
	}
}
