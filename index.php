<?php session_start();
#	Mostrar erros
set_time_limit(0);
ini_set('memory_limit','-1');
ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
//phpinfo();

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('arg_separator.output','&amp;');
date_default_timezone_set('Brazil/East');

#	Cabeçalho
header("Content-Type: text/html;  charset=utf-8",true);
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header('Pragma: no-cache');
header('Expires: 0');
//header('Last Modified: '. gmdate('D, d M Y H:i:s') .' GMT');

#	Autoload classes
function __autoload($class){ require_once("model/".$class.".class.php"); }
?>



<!DOCTYPE html>
<html>
	<head>
        <!--	metatags	-->
        <meta charset="utf-8">
        <title>.:: Publicacoes on-line ::.</title>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="shortcut icon" href="img/favicon.ico"/>
        <link rel="bookmark" href="img/favicon.ico"/>
        
        <!-- site css -->
        <link rel="stylesheet" href="dist/css/site.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.1/jquery.jgrowl.min.css" />
        <style type="text/css">
            /**		Template **/
            body,td,th { 
				font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
			}
			h1,h2,h3,h4,h5,h6 {
				font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
			}
			/**		form Erro jGrowl **/
			.formErro { background-color: #FCC; }
			/**		Input radio **/
			input[type="radio"] {
				visibility: hidden;
			}
			label {
				display: block;
				width: 100%;
				float: left;
			}
			input[type="radio"]:checked+label {
				color: white;
				border-radius:7px;
				background-color: #3c763d;
				font-weight: bold;
			}
			/**		Back to the top 	*/
			#back2Top {
				width: 40px;
				line-height: 40px;
				overflow: hidden;
				z-index: 999;
				display: none;
				cursor: pointer;
				-moz-transform: rotate(270deg);
				-webkit-transform: rotate(270deg);
				-o-transform: rotate(270deg);
				-ms-transform: rotate(270deg);
				transform: rotate(270deg);
				position: fixed;
				bottom: 50px;
				right: 0;
				background-color: #DDD;
				color: #555;
				text-align: center;
				font-size: 30px;
				text-decoration: none;
			}
			#back2Top:hover {
				background-color: #DDF;
				color: #000;
			}
			/**		Colors		*/
			.yellow { color:#FFA400; }
			.red { color:#8F1D21; }
			.green { color:#006442; }
            /**  */
            .actionButtons { width: 6%;  }
        </style>
        
        <!--	Js	-->
        <script type="text/javascript" src="dist/js/site.min.js"></script>
        
        <!--	Google	-->
        <!--script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script-->
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB8jrIe_04BOGR7uxyZiVI5e9FBJDx48d4"></script>
        
        <!--	jQuery	-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.1/jquery.jgrowl.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
        
        <!--	HighCharts	-->
        <script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
        <script type="text/javascript" src="https://code.highcharts.com/modules/exporting.js"></script>
    
        <!--	mySelf	-->
        <script type="text/javascript" src="js/ajax.js"></script>
        <script type="text/javascript" src="js/utils.js"></script>
        <script type="text/javascript">
                //	Botões com JQuery
			$(function() {
				//	Data
				/* Brazilian initialisation for the jQuery UI date picker plugin. */
				/* Written by Leonildo Costa Silva (leocsilva@gmail.com). */
				jQuery(function($){
					$.datepicker.regional['pt-BR'] = {
						closeText: 'Fechar',
						prevText: '&#x3c;Anterior',
						nextText: 'Pr&oacute;ximo&#x3e;',
						currentText: 'Hoje',
						monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho', 'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
						monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun', 'Jul','Ago','Set','Out','Nov','Dez'],
						dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
						dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
						dayNamesMin: ['D','S','T','Q','Q','S','S'],
						weekHeader: 'Sm',
						dateFormat: 'dd/mm/yy',
						firstDay: 0,
						isRTL: false,
						showMonthAfterYear: false,
						yearSuffix: ''};
					$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
				});
				
				//	calendário
				$( ".datepicker" ).datepicker({
					yearRange: "-100:+100",
					changeMonth: true,
					changeYear: true

				});
				
				//	links ativos
				$('li').click(function(){
					$("li").removeClass("active");
					$(this).toggleClass('active');     
				});
				
				//	sobe a tela
				$("#back2Top").click(function(event) {
					event.preventDefault();
					$("html, body").animate({ scrollTop: 0 }, "slow");
					return false;
				});
				
				
			});
			
			
			/*Scroll to top when arrow up clicked BEGIN*/
			$(window).scroll(function() {
				var height = $(window).scrollTop();
				if (height > 100) {
						$('#back2Top').fadeIn();
				} else {
						$('#back2Top').fadeOut();
				}
			});
			 
			 
			/*Search*/
			function buscar() {
				var search= document.getElementById("search").value.trim();
				var n= search.length;
				if(n >= 3)
					loadPage('view/contatos_lista.php?search='+search, '');
			 }
		</script>
	</head>
	<body>
  
        <!--	Back to the top	-->
        <a id="back2Top" title="Back to top" href="#">&#10148;</a>
    
        <!--nav-->
        <nav role="navigation" class="navbar navbar-custom">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button data-target="#bs-content-row-navbar-collapse-5" data-toggle="collapse" class="navbar-toggle" type="button">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a href="index.php" class="navbar-brand">Publicações</a>
              </div>
    
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div id="bs-content-row-navbar-collapse-5" class="collapse navbar-collapse">
              </div>
            </div><!-- /.container-fluid -->
        </nav>
        
    
        <!--header-->
        <div class="container-fluid">
                <!--documents-->
                <div class="row row-offcanvas row-offcanvas-left">
                    
                    
                    <!--	menu left	-->
                    <div class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
                        <ul class="list-group panel">
                            <li class="list-group-item">
                                <i class="glyphicon glyphicon-user"></i>
                                <b>Olá Visitante!</b>
                            </li>
                            <li class="list-group-item"><a href="#" onclick="loadPage('view/publication_list.php', '');"><i class="fa fa-book"></i>Publicações</a></li>
                        </ul>
                    </div>
                    
                    
              <div class="col-xs-12 col-sm-9 content">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a></h3>
                  </div>
                                
                                
                    <!--	Main-->
                    <div class="panel-body" id="main">
                          
                    </div>
    
                    
                    
                  </div><!-- panel body -->
                                
                                
                </div>
            </div><!-- content -->
          
        
        <!--footer-->
        <div class="site-footer">
          <?php include("view/rodape.php"); ?>
        </div>
	

        <script>
            loadPage('view/publication_list.php', '');
        </script>
	</body>
</html>