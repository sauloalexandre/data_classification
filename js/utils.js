// JavaScript Document
/*
	Function:	showlayer
	Parâmetros:	id
	Retorno:	void
	Descrição:	Mostra o elemento com o id do parâmetro
*/
function showLayer(id) {
	document.getElementById(id).style.display = 'block';
}


/*
	Function:	hidelayer
	Parâmetros:	id
	Retorno:	void
	Descrição:	Oculta o elemento com o id do parâmetro
*/
function hideLayer(id) {
	document.getElementById(id).style.display = 'none';
}



/*
	Function:	getChecados
	Parâmetros:	quem
	Retorno:	valores checados
	Descrição:	Obtem os valores dos checkbox checados e retorna separados por ;
*/
function getChecados(quem)
{
	
	var IDs=	"";
	objForm = document.getElementsByTagName('input');
	
	
	//	Loop pelos inputs do formul�rio
	for(x=0; x<objForm.length;x++)
	{

		//	Checkbox ou radio
		if( (objForm[x].getAttribute("type")=="checkbox") || (objForm[x].getAttribute("type")=="radio")	)
		{	
			
			//	Checado
			if(objForm[x].checked)
			{
				
				//	Nome do input = valor passado como par�metro
				if(objForm[x].name == quem)	
				{
					
					//	Pega elementos checados
					IDs+=	objForm[x].value + ";";
					
					
				}//	Fim input = par�metro
				
			}//	Fim checado
			
		}//	Fim checkbox ou radio

	}//	Fim tipo checkbox ou radio

	/*	Remove a última vírgula	*/
	IDs=	IDs.substring(0, IDs.length - 1);
	
	
	return IDs;

}//	Fim função




/*
	Function:	aproximaData
	Parâmetros:	data
	Retorno:	data
	Descrição:	Aproxima a data, tipo se o usuário escreve-se 40/20/2008 a função ajusta para 31/12/2008
*/
function aproximaData(data) {

	var arrayData = data.split('/');  

	//Os dias da data  
	var dia = Number(arrayData[0]);  
	//O mês da data  
	var mes = Number(arrayData[1]);  
	//O ano da data  
	var ano = Number(arrayData[2]);  
	//Para guardar o total de dias que tem no mês  
	var totalDiasMes;  

	//Nos primeiro 7 meses do ano os impares que são os meses que tem 31 dias  
	// depois do 7 primeiros os meses que tem 31 são os pares, seta o resultado  
	//que deve dar da operação MOD de acordo com esse padrão  
	var mod = (mes <= 7 ? 1 : 0);  

	//Se for fevereiro tem que saber se é bissexto ou não  
	if(mes == 2)  
	{  
		//Bissexto 29, senão 28  
		totalDiasMes = (isLeap(ano) == true ? 29 : 28);  
	
	} else {
		
		totalDiasMes = (mes%2==mod ? 31 : 30);  
	
	}

	//Se o dia for maior que o total de dias no mês, então ele será o ultimo  
	if(dia > totalDiasMes)  
		dia = totalDiasMes;  
	else if(dia <= 0)  
		dia = 1;  
		
	//Se o mês for maior que 12 então seta o mês para o ultimo mês  
	if(mes > 12)  
		mes = 12;  
	else if(mes <= 0)  
		mes = 1;  

	//	formata dd, mm e aaaa
	dia= padToN(dia, 2);
	mes= padToN(mes, 2);
	ano= padToN(ano, 4);
	
	return dia + '/' + mes + '/' + ano;  
}  


function isLeap(year) {  
	return (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0) );    
}



function padToN(number, n) {
	switch(n) {
   	case 2: number = ("0"+number).slice(-2); break;
    case 3: number = ("00"+number).slice(-3); break;
		case 4: number = ("000"+number).slice(-4); break;
		default: number = number;     
	} 
  return number;
}



/*
	Function:	comparaDatas
	Parâmetros:	data1 e data2
	Retorno:	int
	Descrição:	Compara 2 datas e retorna 
					1 se a primeira data for maior
					2 se a segunda data for maior
					0 se ambas forem iguais
*/
function comparaDatas(data1, data2) {
	var nova_data1 = parseInt(data1.split("/")[2].toString() + data1.split("/")[1].toString() + data1.split("/")[0].toString());
	var nova_data2 = parseInt(data2.split("/")[2].toString() + data2.split("/")[1].toString() + data2.split("/")[0].toString());
 
	if (nova_data2 > nova_data1)
		return 2;

	if (nova_data1 == nova_data2)
		return 0;

	return 1;
}



/*
	Function:		loadPage
	Parâmetros:	url, onde
	Retorno:		void
	Descrição:	Chama função Ajax para carregar página na div
*/
function loadPage(url, onde){

	parametros= url.indexOf("?");
	if(parametros >= 0){
		url= url + "&nocache="+Math.random();
	} else {
		url= url + "?nocache="+Math.random();
	}
	
	
	if(onde == "")
		onde= "main";
	el= document.getElementById(onde);
	el.innerHTML= "";
	ajaxGet(url, el, true);

}


/*
	Function:		postPage
	Parâmetros:	url, onde
	Retorno:		void
	Descrição:	Chama função Ajax para carregar página na div act
*/
function postPage(url, onde)
{
	parametros= url.indexOf("?");
	if(parametros >= 0){
		url= url + "&nocache="+Math.random();
	} else {
		url= url + "?nocache="+Math.random();
	}
	
	if(onde == "")
		onde= "retorno";
	el= document.getElementById(onde);
	el.innerHTML= "";
	ajaxGet(url, el, true);

}

/*
	Function:		apagaPlaceholder
	Parâmetros:	
	Retorno:		void
	Descrição:	Apaga os placeholder dos inputs
*/
function apagaPlaceholder() {
	
	//	Loop apagando os placeholder dos inputs
	var inputs = document.getElementsByTagName('input');
	for(var i = 0; i < inputs.length; i++){

		var input = inputs[i];
		input.setAttribute('placeholder', '');

	}
	
	//	Loop apagando os placeholder dos textarea
	var textareas= document.getElementsByTagName('textarea');
	for(var i = 0; i < textareas.length; i++){

		var textarea = textareas[i];
		textarea.setAttribute('placeholder', '');

	}
	
}

/*
	Function:		validaForm_required
	Parâmetros:	form
	Retorno:		boolean
	Descrição:	Valida o preenchimento dos campos obrigatórios no formulário
*/
function validaForm_js() {

	var el=	form;
	var inputs= el.elements;
	
	//	Loop pelos campos do Form
	for(i = 0; i < inputs.length; ++i) {

		var input = inputs[i];

		if(input.getAttribute("required")=="true" && input.value=='') {

			alert("Preencha o campo " + input.getAttribute("name") );
			campoErro = input.id;
			input.focus();
			return false;

		}

	}

	return true;

}


/*
	Function:		validaForm_jGrowl
	Parâmetros:	form
	Retorno:		boolean
	Descrição:	Valida o preenchimento dos campos obrigatórios do formulário com jGrowl
*/
function validaForm_jGrowl(form) {

	var idCampos = [];
	var erro = 0;
	var cont = 0;
	var str= "";

	// Verifica se os campos obrigatórios estão preenchidos...
	$(form).find(':input').each(function() {


		if($(this).attr("name") !== undefined)
			str = str + "{"+$(this).attr("name")+"="+$(this).attr("value")+"},";
		
		//	Preenchimento Obrigatório
		if ( ($(this).attr("required") == 'required') && ($(this).val() == '') ) {

			$(this).addClass("formErro");
			idCampos[cont] = $(this).attr("name");
			cont++;
			erro++;

		} else {

			$(this).removeClass("formErro");

		}

	});

	if (erro > 0) {

		$.jGrowl("Preencha os campos em vermelho.", { life: 3500 });
		document.getElementById(idCampos[0]).focus();
		return false;

	} else {

		//	Aproxima a data_nascimento para evitar erro de data inválida
		/*
		var data=	gE("data_nascimento").value;
		if(data != "")
			gE("data_nascimento").value=	aproximaData(data);
		*/
		str = str.substring(0,(str.length - 1));
		//alert(str);
		
		return true;

	}

}

/*
	Function:		save
	Parâmetros:	form
	Retorno:		boolean
	Descrição:	Validar o preenchimento dos campos orbigatórios do formulário,
							busca os dados do form no formato jSon e envia requisição Ajax para controle processar a act
*/
function save(form) {

	var action= form.action;
	var string= "";
	var validou= validaForm_jGrowl(form);
	
	//	se validou o form, então pega o jSon dos campos e salva
	if(validou === true) {
	
		string= getJson(form);
		string= JSON.stringify(string);
		url= action+"&json="+string;
		postPage(url, '');
		
	}
		
	return false;
	
}

/*
	Function:		getJson
	Parâmetros:	form
	Retorno:		string
	Descrição:	Prepara string jSon com os dados do formulário
*/
function getJson(form) {
	
	var el=	form;
	var inputs= el.elements;
	var atributo;
	var valor;
	//	pega o nome do objeto, do nome do form
	temp= form.name.split("-");
	var objeto= temp[0];
	//	Prepara string jSon
	var string= '{';


	//	Loop pelos campos do Form
	for(i = 0; i < inputs.length; ++i) {

		input= inputs[i];
		atributo= input.name;
		valor= input.value;
		
		
		//	se input não tem name, é radio e não está checado ou é do tipo file, então vai pro próximo
		if(input.name == "" ||  (input.type == 'radio' && input.checked != true) || input.type == 'file')
			continue;
		
		//	radio
		if(input.type == 'radio' && input.checked == true) {

			valor = input.value;

		}// fim radio


		//	checkbox
		if(input.type == 'checkbox') {

			valor= 0;	
			//	se o checkbox está checado, então pega o valor
			if(input.checked == true) {

				valor= input.value;

			}//	pega o valor checado

		}//	fim checkbox


		//	incrementa string jSon
		string = string+'"'+atributo+'":"'+valor+'",';
			

	}//	fim loop inputs

	//	remove o ultimo caracter da string e fecha o jSon
	string= string.slice(0, -1);
	string= string + '}';
	return string;
		
}
	
/*
	Function:		replaceAll
	Parâmetros:	string, token, novo token
	Retorno:		string
	Descrição:	Substitui em todas os caracteres da string o token pelo novo token
*/	
function replaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
		string = string.replace(token, newtoken);
	}
	return string;
}
	
/*
	Function:		removeAcentos
	Parâmetros:	string
	Retorno:		string
	Descrição:	Substitui todos os acentos por caracteres não acentuados
*/
function removeAcento(text) {
	text = text.toLowerCase();                                                         
	text = text.replace(new RegExp('[ÁÀÂÃ]','gi'), 'a');
	text = text.replace(new RegExp('[ÉÈÊ]','gi'), 'e');
	text = text.replace(new RegExp('[ÍÌÎ]','gi'), 'i');
	text = text.replace(new RegExp('[ÓÒÔÕ]','gi'), 'o');
	text = text.replace(new RegExp('[ÚÙÛ]','gi'), 'u');
	text = text.replace(new RegExp('[Ç]','gi'), 'c');
return text;                 
}
	
/*
	Function:		getData
	Parâmetros:	input
	Retorno:		data
	Descrição:	Pega a data atual e insere no campo input informado
*/
function getData(input) {

	//cria um objeto do tipo date
  var data = new Date();

  // obtem o dia, mes e ano
  dia = data.getDate();
  mes = data.getMonth() + 1;
  ano = data.getFullYear();

  //	converte o dia e o mes para string
  str_dia = new String(dia);
  str_mes = new String(mes);

  //	se tiver menos que 2 digitos, acrescenta o 0
  if (str_dia.length < 2) str_dia = 0 + str_dia;
  if (str_mes.length < 2) str_mes = 0 + str_mes;

  //	formata a data para exibir dd/mm/YYYY
  data = str_dia + '/' + str_mes + '/' + ano;
  
	//	exibe a string no input
  input.value = data;

}
