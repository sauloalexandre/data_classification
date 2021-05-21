<?php session_start();
#	Autoload classes
function __autoload($class){ require_once("../model/".$class.".class.php"); }
#	Controle
include_once("../control/comom.php");


$Obj= new Publication();
if (isset($_REQUEST["cd"]) ) {
    $Obj->set('cd', (int) $_REQUEST["cd"]);
}
$P= $Obj->getPublications();
$P= $P[0];
?>




<!--	Panel	-->
<div class="panel panel-info text-left">
	<div class="panel-heading">
		<h3 class="panel-title">Detalhes</h3>
	</div>
	

	<!--	Bt Voltar	-->
	<div class="row">
		<div class="col-md-2">
			<button type="button" class="btn btn-success btn-block" onClick="loadPage('view/publication_list.php', '');">Voltar</button>
		</div>
	</div>


	<!--	Tabs	-->
	<ul id="myTab1" class="nav nav-tabs nav-justified">
		<li class="active"><a href="#detalhes1" data-toggle="tab">Dados Gerais</a></li>
	</ul>

	<!--	Dados gerais	-->
	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade active in" id="detalhes1">
			<p>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th colspan="2" class="text-center"></</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="2"></td>
						</tr>
					</tfoot>

					<tbody class="text-left">
						<tr>
							<td class="info col-md-1">CD:</td>
							<td class="col-md-6"><?php echo $P->get("cd"); ?></td>
						</tr>
						<tr>
							<td class="info">Processo:</td>
							<td><?php echo $Obj->getProcess($P->get("ra_conteudo")); ?></td>
						</tr>
						<tr>
							<td class="info">Juíz:</td>
							<td><?php echo $Obj->getJudge($P->get("ra_conteudo")); ?></td>
						</tr>
                        <tr>
                            <td class="info">4ª Vara da Família e Sucessões:</td>
                            <td><?php echo ($P->isFamily()) ? "<span class='fa fa-users'></span>" : ""; ?></td>
                        </tr>
						<tr>
							<td class="info">Alimentos:</td>
							<td><?php echo ($P->isFoods()) ? "<span class='fa fa-birthday-cake'></span>" : ""; ?></td>
						</tr>
						<tr>
							<td class="info">Divórcio:</td>
							<td><?php echo ($P->isDivorce()) ? "<span class='fa fa-paw'></span>" : ""; ?></td>
						</tr>
                        <tr>
                            <td class="info">Investigação de Paternidade:</td>
                            <td><?php echo ($P->isPaternity()) ? "<span class='fa fa-child'></span>" : ""; ?></td>
                        </tr>
                        <tr>
                            <td class="info">Inventário:</td>
                            <td><?php echo ($P->isInventory()) ? "<span class='fa fa-archive'></span>" : ""; ?></td>
                        </tr>
                        <tr>
                            <td class="info">Outros:</td>
                            <td><?php echo ($P->isOthers()) ? "<span class='fa fa-question'></span>" : ""; ?></td>
                        </tr>
                        <tr>
                            <td class="info">Detalhes:</td>
                            <td><?php echo $P->get("ra_conteudo"); ?></td>
                        </tr>
					</tbody>
				</table>
			</p>
		</div>
	</div>

	<!--	Bt Voltar	-->
	<div class="row hidden">
		<div class="col-md-2">
			<button type="button" class="btn btn-success btn-block" onClick="loadPage('view/<?php echo strtolower(get_class($Obj)); ?>_list.php', '');">Voltar</button>
		</div>
		<?php //if($_SESSION["permissoes"]["contatos_permite_editar"]) { ?>
			<div class="col-md-2">
				<button type="button" class="btn btn-success btn-block" onClick="loadPage('view/<?php echo strtolower(get_class($Obj)); ?>_form.php?act=update&id=<?php echo $Obj->get("id"); ?>', '');">Editar</button>
			</div>
		<?php //} ?>
	</div>


</div><!--	fim Panel	-->