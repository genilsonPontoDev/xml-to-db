<?php

include __DIR__ . '/Emit.php';

class Nfe
{
    private $xml;
    private $tagMap;
    public $emit;

    public function __construct($xmlContent)
    {        
        $this->emit = new Emit($xmlContent);
        var_dump($this->emit);

        if (empty($xmlContent)) {
            throw new Exception("XML vazio ou inválido.");
        }

        $this->xml = simplexml_load_string($xmlContent);

        if (!$this->xml) {
            throw new Exception("Erro ao processar o XML.");
        }

        // Mapeia todas as tags no XML para acesso direto
        $this->tagMap = [];
        $this->mapTags($this->xml);
    }

    /**
     * Método recursivo para mapear todas as tags e suas posições no XML
     */
    private function mapTags($element, $path = [])
    {
        foreach ($element->children() as $child) {
            $tagName = $child->getName();
            $currentPath = array_merge($path, [$tagName]);

            // Armazena o elemento completo no mapa, com a tag como chave
            if (!isset($this->tagMap[$tagName])) {
                $this->tagMap[$tagName] = new NfeTag($child);
            }

            // Continua a mapear recursivamente
            $this->mapTags($child, $currentPath);
        }
    }

    /**
     * Método mágico __get para acessar qualquer tag do XML dinamicamente
     */
    public function __get($name)
    {
        // Verifica se a tag está mapeada
        if (isset($this->tagMap[$name])) {
            return $this->tagMap[$name];
        }

        // Caso a tag não exista, retorna uma instância da NfeTag com mensagem padrão
        return new NfeTag(null); // Retorna uma tag vazia, ou podemos retornar um aviso
    }

    /**
     * Método mágico __call para tratar chamadas de métodos não existentes
     */
    public function __call($name, $arguments)
    {
        // Se o método não existir, podemos decidir o que retornar.
        return "Método '{$name}' não encontrado na classe Nfe.";
    }
}

/**
 * Classe auxiliar para representar uma tag do XML da NFe
 */
class NfeTag
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Retorna o conteúdo da tag
     * - Se for um valor simples, retorna o valor.
     * - Se tiver subelementos, retorna um array associativo dos elementos filhos.
     */
    public function getContent()
    {
        if ($this->content === null) {
            return "dado não existe no XML";
        }

        if ($this->content->count() > 0) {
            $result = [];
            $childCount = [];

            foreach ($this->content->children() as $child) {
                $childName = $child->getName();

                // Se não existe contador, inicializamos
                if (!isset($childCount[$childName])) {
                    $childCount[$childName] = 0;
                }
                $childCount[$childName]++;

                // Lógica para múltiplas ocorrências
                if ($childCount[$childName] > 1) {
                    if (!isset($result[$childName]) || !is_array($result[$childName])) {
                        $result[$childName] = [$result[$childName]] ?? [];
                    }
                    $result[$childName][] = (new NfeTag($child))->getContent();
                } else {
                    $result[$childName] = (new NfeTag($child))->getContent();
                }
            }

            return $result;
        }

        // Para elementos simples (sem filhos)
        return (string)$this->content;
    }


    /**
     * Retorna uma subtag específica, se existir
     * Se a subtag não for encontrada, retorna "dado não existe no XML"
     */
    public function __get($name)
    {
        if (isset($this->content->$name)) {
            return new NfeTag($this->content->$name);
        }

        // Retorno de valor nulo quando a subtag não é encontrada
        return new NfeTag(null); // Retorna uma tag vazia ou mensagem padrão
    }

    /**
     * Método mágico __call para tratar chamadas de métodos não existentes nas tags
     */
    public function __call($name, $arguments)
    {
        // Se o método não existir na tag, podemos decidir o que retornar.
        return "Método '{$name}' não encontrado na tag.";
    }
}
