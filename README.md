# StateMachine
StateMachine é uma biblioteca PHP para gerenciar máquinas de estados com a facilidade de configuração através de arquivos YAML. Com suporte adicional para a visualização da máquina de estados usando Graphviz.

## Instalação
Para instalar a biblioteca, você pode usar o composer:

```bash
composer require ananiaslitz/state-machine
```

## Uso Básico
#### 1- Defina suas regras e estados no state-machine.yaml:

Exemplo de state-machine.yaml:

```yaml 
states:
  - start
  - middle
  - end

transitions:
  - name: begin
    from: start
    to: middle
  - name: finish
    from: middle
    to: end
```

#### 2 - Utilize a biblioteca em seu código:

```php 
require 'vendor/autoload.php';

$loader = new StateMachineLoader();
$data = $loader->createStateMachines();
```

## Geração de Diagrama da Máquina de Estados
Para visualizar a máquina de estados, você pode gerar um diagrama utilizando o Graphviz.

### Pré-requisitos:
Instale o Graphviz:

Para sistemas baseados em Debian/Ubuntu:

```bash
sudo apt-get install graphviz
```

### Uso:
Para gerar o diagrama, execute:

```bash
php /vendor/bin/state-machine [formato]
```
#### Onde [formato] é opcional e pode ser png, svg, pdf, etc. Se nenhum formato for fornecido, será gerado um PNG por padrão.

Exemplo:

```bash
php /vendor/bin/state-machine [formato]
```

Após a execução, um arquivo de diagrama (por exemplo, state_machine.png) será gerado na raiz do seu projeto.

## Contribuição
Sinta-se à vontade para abrir issues ou enviar pull requests. Sua colaboração é bem-vinda!

## Licença
MIT License

