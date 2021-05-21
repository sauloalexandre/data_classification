<?php
class Publication
{

    /*    Atributos */
    public $cd           = null;
    public $ra_conteudo  = null;
    public $process      = null;
    public $judge        = null;
    public $isFamily     = null;
    public $isFood       = null;
    public $isDivorce    = null;
    public $isPaternity  = null;
    public $isInventory  = null;
    public $isOthers     = null;
    
    /*    Construtor */
    public function __construct()
    {}

    /**
     * Get publications
     *
     * @return $arr with the records
     */
    public function getPublications()
    {
        $mySQL  = new MySQL();
        $sql    = $this->getPublications_Sql();
        $rs     = $mySQL->runQuery($sql);
        $i      = 0;
        while ($row = mysqli_fetch_assoc($rs)) {
            $list[$i]               = new Publication();
            $list[$i]->cd           = $row["cd"];
            $list[$i]->ra_conteudo  = $row["ra_conteudo"];
            $i++;
        }
        return ($i > 0) ? $list : '';
    }

    /**
     * Get Publications SQL
     *
     * @return $sql with the command
     */
    public function getPublications_Sql()
    {
        $sql    ="SELECT 
                    cd
                    , ra_conteudo
                FROM
                    publicacoes_fila_2020_08_02
                WHERE 
                    1=1";
        $sql .= (null !== $this->get("cd")) ? " AND cd = {$this->get('cd')}" : "";
        //$sql .= " Limit 1000";
        return $sql;
    }

    public function getProcess($item)
    {
        $partes= explode('----------------------------------------------', $item);
        $partes_2 = explode(' - ', $partes[1]);
        $partes_3 = explode(';', $partes_2[0]);
        if(isset($partes_3[1])) {
            return str_replace("Nº ", "", str_replace("PROCESSO :","",str_replace("Processo ","",$partes_3[0])));
        }
        $partes_4 = explode(" - Processo Digital.", $partes[1]);
        if (isset($partes_4[1])) {
            return str_replace("Nº ", "", str_replace("PROCESSO :","",str_replace("Processo ","",$partes_4[0])));
        }
            
        return str_replace("Nº ", "", str_replace("PROCESSO :","",str_replace("Processo ","",$partes_2[0])));
    }

    public function getJudge($item)
    {
        $partes= explode('----------------------------------------------', $item);
        $partes_2 = explode("JUIZ(A) DE DIREITO", $partes[0]);
        if(isset($partes_2[1])) {
            $partes_3 = explode("ESCRIVÃ(O)", $partes_2[1]);
            return str_replace("Processo ","",$partes_3[0]);    
        }
        return;
    }

    public function isFamily()
    {
        return (strpos($this->get("ra_conteudo"), '4ª Vara da Família e Sucessões') > 0);
    }

    public function isFood()
    {
        return (strpos($this->get("ra_conteudo"), 'Alimentos') > 0);
    }

    public function isDivorce()
    {
        return (strpos($this->get("ra_conteudo"), 'Divórcio') > 0);
    }

    public function isPaternity()
    {
        return (strpos($this->get("ra_conteudo"), 'Investigação de Paternidade') > 0);
    }

    public function isInventory()
    {
        return (strpos($this->get("ra_conteudo"), 'Inventário') > 0);
    }

    public function isOthers()
    {
        return (
            (strpos($this->get("ra_conteudo"), '4ª Vara da Família e Sucessões') == 0)
            && (strpos($this->get("ra_conteudo"), 'Alimentos') == 0)
            && (strpos($this->get("ra_conteudo"), 'Divórcio') == 0)
            && (strpos($this->get("ra_conteudo"), 'Investigação de Paternidade') == 0)
            && (strpos($this->get("ra_conteudo"), 'Inventário') == 0)
        );
    }

    /**
     * Seta o atributo
     *
     * @param $atr com o atributo
     * @param $val com o valor
     */
    public function set($atr, $val)
    {
        $this->$atr = $val;
    }

    /**
     * Retorna o atributo
     *
     * @param   $atr        contendo o atributo a ser retornado
     * @return  $Obj->atr   com o valor do atributo
     */
    public function get($atr)
    {
        return $this->$atr;
    }

}