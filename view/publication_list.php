<?php session_start();
header('Content-Type: text/html; charset=utf-8');

#	Autoload classes
function __autoload($class){ require_once("../model/".$class.".class.php"); }
#	Controle
include_once("../control/comom.php");


$Obj = new Publication();
$list= $Obj->getPublications();
$param["qtd"]= count($list);
//show($list);

//show($list[3]);
$list2 = array();
$list2["isFamily"] = array();
$list2["isFood"] = array();
$list2["isDivorce"] = array();
$list2["isPaternity"] = array();
$list2["isInventory"] = array();
$list2["isOthers"] = array();
$list2["all"] = array();
?>




<div class="panel panel-info text-left">
    <div class="panel-heading">
        <h3 class="panel-title">Listagem</h3>
    </div>
	
    <table class="table table-hover table-striped" border="2">
		
		<thead>
			<tr>
				<th>CD</th>
				<th>Conteúdo</th>
                <th>4ª Vara da Família e Sucessões</th>
                <th>Alimentos</th>
                <th>Divórcio</th>
                <th>Investigação de Paternidade</th>
                <th>Inventário</th>
                <th>Outros</th>
                <th>Número do processo</th>
                <th>Nome do juíz</th>
                <th></th>
			</tr>
		</thead>
		
        <tfoot>
            <tr class="text-center">
                <td colspan="11"><span class="badge badge-default"><?php echo $param["qtd"]." registros"; ?></span></td>
            </tr>
        </tfoot>

		<tbody>
            <?php foreach ($list as $P) { ?>

                <tr>
					<td><?php echo $P->get("cd"); ?></td>
					<td><?php echo substr($P->get("ra_conteudo"), 0, 60); ?></td>
                    <td class="text-center">
                        <?php echo ($P->isFamily()) ? "<span class='fa fa-users'></span>" : ""; ?>
                    </td>
                    <td class="text-center">
                        <?php echo ($P->isFood()) ? "<span class='fa fa-birthday-cake'></span>" : ""; ?>
                    </td>
                    <td class="text-center">
                        <?php echo ($P->isDivorce()) ? "<span class='fa fa-paw'></span>" : ""; ?>
                    </td>
                    <td class="text-center">
                        <?php echo ($P->isPaternity()) ? "<span class='fa fa-child'></span>" : ""; ?>
                    </td>
                    <td class="text-center">
                        <?php echo ($P->isInventory()) ? "<span class='fa fa-archive'></span>" : ""; ?>
                    </td>
                    <td class="text-center">
                        <?php echo ($P->isOthers()) ? "<span class='fa fa-question'></span>" : ""; ?>
                    </td>
                    <td>
                        <?php
                        echo $Obj->getProcess($P->get("ra_conteudo"));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $Obj->getJudge($P->get("ra_conteudo"));
                        ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Ações<span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" onclick="loadPage('view/<?php echo strtolower(get_class($Obj)); ?>_detail.php?cd=<?php echo $P->get("cd"); ?>', '');">Exibir detalhes</a></li>
                            </ul>                            
                        </div>
                    </td>
				</tr>

                <?php 
                $P->set("process", $Obj->getProcess($P->get("ra_conteudo")));
                $P->set("judge", $Obj->getJudge($P->get("ra_conteudo")));
                $P->set("isFamily", $P->isFamily());
                $P->set("isFood", $P->isFood());
                $P->set("isDivorce", $P->isDivorce());
                $P->set("isPaternity", $P->isPaternity());
                $P->set("isInventory", $P->isInventory());
                $P->set("isOthers", $P->isOthers());

                if($P->isFamily()) {
                    array_push($list2["isFamily"], $P);    
                }
                if($P->isFood()) {
                    array_push($list2["isFood"], $P);    
                }
                if($P->isDivorce()) {
                    array_push($list2["isDivorce"], $P);    
                }
                if($P->isPaternity()) {
                    array_push($list2["isPaternity"], $P);    
                }
                if($P->isInventory()) {
                    array_push($list2["isInventory"], $P);    
                }
                if($P->isOthers()) {
                    array_push($list2["isOthers"], $P);    
                }
                
                ?>
			<?php }//fim loop ?>
		</tbody>
		
	</table>
	
</div>

<?php
$types= array("isFamily", "isFood", "isDivorce", "isPaternity", "isInventory", "isOthers");

// 5.1 - Arquivos separados por cada tipo de ação, tendo como critério de ordenação o nome do juiz responsável;
foreach($types as $nm) {
    usort($list2[$nm], "cmpJudge");
    if(!empty($list2[$nm]))
        createFile('cinco1_'.$nm, $list2[$nm]);
}


//exit();
// 5.2 - Arquivos separados por cada tipo de ação e Juiz responsável, tendo como critério de ordenação o número do processo;
foreach($types as $nm) {

    $temp = "#START#";
    foreach($list2[$nm] as $item) {
        if($temp != $item->get("judge")) {

            if("#START#" != $temp) {
                usort($list2[$nm][$temp], "cmpProcess"); 
                foreach($list2[$nm][$temp] as $item2) {
                    echo "<br>[{$nm}] [".$temp."] - ".$item2->get("process");
                }

                if(!empty($list2[$nm][$temp]))
                    createFile('cinco2_'.$nm.'_'.str_replace(" ","_", trim(substr($temp, 0, 20))), $list2[$nm][$temp]);

            }

            $temp = str_replace("?","_", $item->get("judge"));
            $i= 0;
            $list2[$nm][$temp] = array();
        }
        $list2[$nm][$temp][$i] = $item;
        $i++;
    }

    if (!empty($list2[$nm][$temp])) {
        usort($list2[$nm][$temp], "cmpProcess"); 
        createFile('cinco2_'.$nm.'_'.str_replace(" ","_", trim(substr($temp, 0, 20))), $list2[$nm][$temp]);

        foreach($list2[$nm][$temp] as $item) {
            echo "<br>[{$nm}] [".$temp."] - ".$item->get("process");
        }    
    }

}
?>