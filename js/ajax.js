/*****************************************************************
**											Biblioteca v1 													**		
*****************************************************************/
/*	--	Conceitos importantes Ajax	--
	1-	Aplicativos assíncronos fazem solicitações usando um objeto JavaScript e não um envio de formulário.
	2-	Suas solicitações e respostas serão manipuladas pelo navegador Web e não diretamente por seu código JavaScript.
	3-	Uma vez que o navegador Web receber uma resposta a sua solicitação assíncrona, "retornará a chamada" para seu código JavaScript com a resposta do servidor. 
*/

//	Novo objeto de solicitação Ajax 
var request = null;			//variável para o armazenamento do objeto de solicitação


//	Cria a requisição
function createRequest() 	
{
	try
	{
		request = new XMLHttpRequest();		//tenta criar um novo objeto de solicitação
	} catch (trymicrosoft) {
		try
		{
			request = new ActiveXObject("Msxml2.XMLHTTP");			//tenta criar um novo objeto de solicitação para o IE
		} catch (othermicrosoft) {
			try
			{
				request = new ActiveXObject("Microsoft.XMLHTTP");	//tenta criar um novo objeto de solicitação para o IE
			} catch (failed) {
				request = null;			//se algo der errado essa instrução assegurará que a variávewl de solicitação continuará configurada como nula
			}
		}
	}
	if (request == null)			//se a solicitação ainda for nula, exibe mensagem
		alert("Error creating request object!");
}	
	

// Utilizado para evitar de digitar: document.getElementById toda hora, tornando o processo mais prático
function gE(campo)
{
	return document.getElementById(campo);
}


// Utilizado para evitar de digitar: document.getElementsByTagName toda hora, tornando o processo mais prático
function gEs(tag) 
{
	return document.getElementsByTagName(tag);
}


//	Atribui um novo texto a um elemento HTML
function replaceText(el, text) 
{
  if (el != null) 
  {
    clearText(el);
    var newNode = document.createTextNode(text);
    el.appendChild(newNode);
  }
}


//	Limpa os atributos de um elemento HTML
function clearText(el) 
{
  if (el != null) 
  {
    if (el.childNodes) 
	{
      for (var i = 0; i < el.childNodes.length; i++) 
	  {
        var childNode = el.childNodes[i];
        el.removeChild(childNode);
      }
    }
  }
}


//	Obtem o texto de um elemento HTML
function getText(el) 
{
  var text = "";
  if (el != null) 
  {
    if (el.childNodes) 
	{
      for (var i = 0; i < el.childNodes.length; i++) 
	  {
        var childNode = el.childNodes[i];
        if (childNode.nodeValue != null) 
		{
          text = text + childNode.nodeValue;
        }
      }
    }
  }
  return text;
}



/****** 
* ajaxGet - Coloca o retorno de uma url em um elemento qualquer
* Use a vontade mas coloque meu nome nos créditos. Dúvidas, me mande um email.
* Versão: 1.2 - 20/04/2006
* Autor: Micox - Náiron José C. Guimarães - micoxjcg@yahoo.com.br
* Parametros:
* url: string; elemento_retorno: object||string; exibe_carregando:boolean
*  - Se elemento_retorno for um elemento html (inclusive inputs e selects),
*	exibe o retorno no innerHTML / value / options do elemento
*  - Se elemento_retorno for o nome de uma variavel
*	(o nome da variável deve ser declarado por string, pois será feito um eval)
*	a função irá atribuir o retorno à variável ao receber a url.
*******/
function ajaxGet(url, elemento_retorno, exibe_carregando){
	
	var ajax1 = pegaAjax();
	if(ajax1){
		url = antiCacheRand(url)
		ajax1.onreadystatechange = ajaxOnReady
		ajax1.open("GET", url ,true);
		//ajax1.setRequestHeader("Content-Type", "text/html; charset=iso-8859-1");//"application/x-www-form-urlencoded");
		ajax1.setRequestHeader("Cache-Control", "no-cache");
		ajax1.setRequestHeader("Pragma", "no-cache");
		if(exibe_carregando){ 
			//put("Carregando ...")
			wait(true, elemento_retorno.id);
		}
		ajax1.send(null)
		return true;
	}else{
		return false;
	}
	
	function ajaxOnReady(){
		if (ajax1.readyState==4){
			if(ajax1.status == 200){
				var texto=ajax1.responseText;
				if(texto.indexOf(" ")<0) texto=texto.replace(/\+/g," ");
				wait(false);
				//texto=unescape(texto); //descomente esta linha se tiver usado o urlencode no php ou asp
				put(texto);
				extraiScript(texto);
			}else{
				if(exibe_carregando){put("Falha no carregamento. " + httpStatus(ajax1.status));}
			}
			ajax1 = null
		}else if(exibe_carregando){//para mudar o status de cada carregando
				//put("Carregando ..." )
				wait(true, elemento_retorno.id);
		}
	}
	
	function put(valor){ //coloca o valor na variavel/elemento de retorno
		if((typeof(elemento_retorno)).toLowerCase()=="string"){ //se for o nome da string
			if(valor!="Falha no carregamento"){ 
				eval(elemento_retorno + '= unescape("' + escape(valor) + '")')
			}
		}else if(elemento_retorno.tagName.toLowerCase()=="input"){
			valor = escape(valor).replace(/\%0D\%0A/g,"")
			elemento_retorno.value = unescape(valor);
		}else if(elemento_retorno.tagName.toLowerCase()=="select"){		
			select_innerHTML(elemento_retorno,valor)
		}else if(elemento_retorno.tagName){
			elemento_retorno.innerHTML = valor;
			//alert(elemento_retorno.innerHTML)
		}	
	}
	
	function pegaAjax(){ //instancia um novo xmlhttprequest
		//baseado na getXMLHttpObj que possui muitas cópias na net e eu nao sei quem é o autor original
		if(typeof(XMLHttpRequest)!='undefined'){return new XMLHttpRequest();}
		var axO=['Microsoft.XMLHTTP','Msxml2.XMLHTTP','Msxml2.XMLHTTP.6.0','Msxml2.XMLHTTP.4.0','Msxml2.XMLHTTP.3.0'];
		for(var i=0;i<axO.length;i++){ try{ return new ActiveXObject(axO[i]);}catch(e){} }
		return null;
	}
	
	function httpStatus(stat){ //retorna o texto do erro http
		switch(stat){
			case 0: return "Erro desconhecido de javascript";
			case 400: return "400: Solicita&ccedil;&atilde;o incompreensível"; break;
			case 403: case 404: return "404: N&atilde;o foi encontrada a URL solicitada"; break;
			case 405: return "405: O servidor n&atilde;o suporta o m&eacute;todo solicitado"; break;
			case 500: return "500: Erro desconhecido de natureza do servidor"; break;
			case 503: return "503: Capacidade m&aacute;xima do servidor alcançada"; break;
			default: return "Erro " + stat + ". Mais informa&ccedil;&otilde;es em http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html"; break;
		}
	}
	
	function antiCacheRand(aurl){
		var dt = new Date();
		if(aurl.indexOf("?")>=0){// já tem parametros
			return aurl + "&" + encodeURI(Math.random() + "_" + dt.getTime());
		}else{ return aurl + "?" + encodeURI(Math.random() + "_" + dt.getTime());}
	}
}



/****** 
* select_innerHTML - altera o innerHTML de um select independente se é FF ou IE
* Corrige o problema de não ser possível usar o innerHTML no IE corretamente
* Veja o problema em: http://support.microsoft.com/default.aspx?scid=kb;en-us;276228
* Use a vontade mas coloque meu nome nos créditos. Dúvidas, me mande um email.
* Versão: 1.0 - 06/04/2006
* Autor: Micox - Náiron José C. Guimarães - micoxjcg@yahoo.com.br
* Parametros:
* objeto(tipo object): o select a ser alterado
* innerHTML(tipo string): o novo valor do innerHTML
*******/
function select_innerHTML(objeto,innerHTML){

	objeto.innerHTML = ""
	var selTemp = document.createElement("micoxselect")
	var opt;
	selTemp.id="micoxselect1"
	document.body.appendChild(selTemp)
	selTemp = document.getElementById("micoxselect1")
	selTemp.style.display="none"
	
	if(innerHTML.toLowerCase().indexOf("<option")<0){//se não é option eu converto
		innerHTML = "<option>" + innerHTML + "</option>"
	}
	
	innerHTML = innerHTML.replace(/<option/g,"<span").replace(/<\/option/g,"</span")
	selTemp.innerHTML = innerHTML
	
	for(var i=0;i<selTemp.childNodes.length;i++){
		
		if(selTemp.childNodes[i].tagName){
			
			opt = document.createElement("OPTION")
			
			for(var j=0;j<selTemp.childNodes[i].attributes.length;j++){
				
				opt.setAttributeNode(selTemp.childNodes[i].attributes[j].cloneNode(true))
				
			}
			
			opt.value = selTemp.childNodes[i].getAttribute("value")
			opt.text = selTemp.childNodes[i].innerHTML
			
			if(document.all){ //IEca
			
				objeto.add(opt)
				
			}else{
				
				objeto.appendChild(opt)
				
			}
							
		}
	
	}
	
	document.body.removeChild(selTemp)
	selTemp = null
	
}



function extraiScript(texto){
	//Maravilhosa função feita pelo SkyWalker.TO do imasters/forum
	//http://forum.imasters.com.br/index.php?showtopic=165277&
	// inicializa o inicio ><
	var ini = 0;
	
	// loop enquanto achar um script
	while (ini!=-1){
		
		// procura uma tag de script
		ini = texto.indexOf('<script', ini);
		
		// se encontrar
		if (ini >=0){
			
			// define o inicio para depois do fechamento dessa tag
			ini = texto.indexOf('>', ini) + 1;
			// procura o final do script
			var fim = texto.indexOf('</script>', ini);
			// extrai apenas o script
			codigo = texto.substring(ini,fim);
			// executa o script
			//eval(codigo);
			/**********************
			* Alterado por Micox - micoxjcg@yahoo.com.br
			* Alterei pois com o eval não executava funções.
			***********************/
			novo = document.createElement("script")
			novo.text = codigo;
			document.body.appendChild(novo);
			
		}
		
	}
	
}




/*
	Function:	showlayer
	Parâmetros:	opt, onde
	Retorno:	void
	Descrição:	Cria o efeito de loading na página no elemento onde
*/
function wait(opt, onde) {

	if (opt == true) {

		// A tag que receberá a img de loading
		var refer = gE(onde);
		// O tamanho da referida tag
		var referHeight = refer.offsetHeight;
		// Dizemos que os elementos dentro dela será alinhado ao centro
		refer.style.textAlign = 'center';
		
		// Criamos uma imagem, img.
		var img = document.createElement('img');
		// Informamos o caminho da img
		img.setAttribute('src','img/imgLoading.gif');
		// Setamos um atributo ID na img criada
		img.setAttribute('id','loading');
		// Definimos seu tamanho
		img.setAttribute('width','126');
		// Dizemos que o margin-top será a metada do tamanho da div
		img.style.marginTop = (referHeight /2) + 'px';
		
		// Evita que seja criada duas ou mais img de loading
		if (!document.getElementById('loading')) {

			// Insere a img na tag informada na variável refer
			refer.insertBefore(img, refer.firstChild);

		}

	} else if (opt == false) {

		// Referenciamos a img de login através de seu ID
		var imgLoading = gE('loading');
		// Removemos a img de loading
		if (imgLoading) {

			imgLoading.parentNode.removeChild(imgLoading);

		}

	}//fim else

}
