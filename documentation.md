### 1. Checklist de Implementação (Ordem Sugerida)

-   [ ] **Fase 1: Setup do Ambiente e Estrutura Base**
    -   [x] 1.1. Iniciar projeto Laravel 12 e configurar o Docker.
        -   [x] 1.1.1. Fix no docker-composer.
    -   [x] 1.2. Configurar conexão com o banco de dadps PostgreSQL (`.env`).
    -   [x] 1.3. Publicar rotas, controllers e views de login padrão Breeze.
    -   [x] 1.4. Migrar frontend de Tailwind Css para Bootstrap.
    -   [x] 1.5. Instalar pacote de tradução pt_BR.

-   [x] **Fase 2: Estrutura Tema Principal**
    -   [x] 1.1. Views de botões utilitários.
    -   [x] 1.2. Pacote de ícones do Bootstrap 5.
    -   [x] 1.3. View estrututal base e autenticação.
    -   [x] 1.4. Desenvolver e estruturar sidebar, footer e topnav principal.
        -   [x] 1.4.1. Sidebar
            -   [x] 1.4.1.1. Layout.
            -   [x] 1.4.1.2. Configurar para que os menus da sidebar fiquem separados no arquivo config/mainTheme.php.
            -   [x] 1.4.1.3. Configurar para que o título do sistema na sidebar fiquem separados no arquivo config/mainTheme.php.
        -   [x] 1.4.2. Footer
            -   [x] 1.4.2.1. Layout.
            -   [x] 1.4.2.2. Configurar para que o parãmetro de nome do sistema fiqum separado no arquivo config/mainTheme.php.
        -   [x] 1.4.3. Topnav
            -   [x] 1.4.3.1. Layout.
            -   [x] 1.4.3.2. Configurar para que o botão Perfil esteja no topnav.
            -   [x] 1.4.3.3. Configurar para que os menus do topnav fiquem separados no arquivo config/mainTheme.php.

-   [ ] **Fase 3: Autenticação básica**
    -   [x] 1.1. Tabela Users.
        -   [x] 1.1.1. Adicionar campos: `string:cpf`, `string:cnpj`, `bool:admin`, `bool:administrativo`, `bool:lojista`, `bool:colaborador`, `bool:cliente` com default false 
    -   [x] 1.1. Tela de Login.
    -   [x] 1.2. Tela de Cadastro.