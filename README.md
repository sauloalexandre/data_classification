PHP 7.x que atenda os seguintes requisitos:

1 - Carregar todas as publicações em memória;
2 - Identificar as publicações pertencentes a 4ª Vara da Família e Sucessões;
3 - Identificar as publicações referentes as ações de Alimentos, Divórcio, Investigação de Paternidade, Inventário, Outros;
3 - Cada documento deverá receber um atributo contendo o número do processo da publicação extraído do texto;
4 - Cada documento deverá receber um atributo contendo o nome do juiz responsável pelo processo extraído do texto;
5 - Como arquivo de saída, deverão ser criados dois conjuntos de arquivos json:
	5.1 - Arquivos separados por cada tipo de ação, tendo como critério de ordenação o nome do juiz responsável;
	5.2 - Arquivos separados por cada tipo de ação e Juiz responsável, tendo como critério de ordenação o número do processo;
	5.3 - Arquivo contendo as publicações não pertencentes a 4a Vara da Família e Sucessões.

O que desejamos receber:
Link do GitHub contendo o repositório da atividade.
Nele, deverão ser contemplados o código-fonte, log de processamento contendo data/hora de início/término 
e os arquivos com o resultado do desafio;

Observações:
Os filtros de classificação não poderão ser feitos através de script SQL.
Vídeo de até 5 minutos explicando a lógica utilizada para a resolução do desafio;
