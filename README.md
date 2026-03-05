# Sistema de Tickets

Sistema de gestão de tickets interno e externo que permite a **gestão centralizada de pedidos e comunicações**, segmentados por diferentes áreas da organização.

Este projeto foi desenvolvido no âmbito académico e tem como objetivo implementar um sistema funcional de suporte e comunicação entre clientes e operadores.

---

# 1. Estrutura do Sistema

O sistema organiza os tickets através de **Inboxes (Departamentos)** que representam diferentes áreas da organização.

Cada inbox possui:
- Operadores próprios
- Permissões específicas
- Sistema de notificações

### Inboxes disponíveis

- Comercial
- Apoio Técnico
- Recursos Humanos

Cada departamento consegue gerir os seus próprios tickets de forma independente.

---

# 2. Tipos de Utilizadores

## Operadores

Os operadores são responsáveis pela gestão dos tickets.

Podem:

- Criar tickets
- Responder a tickets
- Atribuir operadores responsáveis
- Alterar o estado do ticket
- Gerir tickets nas inboxes às quais têm acesso
- Receber notificações quando um ticket é atribuído ou atualizado

---

## Clientes

Os clientes podem interagir com o sistema para criar pedidos ou responder a tickets.

Podem:

- Criar tickets
- Responder a tickets existentes
- Visualizar apenas tickets associados à sua entidade

---


# 3. Funcionalidades Principais

## Criação de Tickets

Os tickets podem ser criados por **clientes ou operadores**.

Funcionalidades:

- Geração automática de número de ticket
- Formato: `TC-XXX`
- Associação a entidade e contacto
- Possibilidade de anexar ficheiros

### Notificações automáticas

Ao criar um ticket são enviadas notificações por email para:

- Criador do ticket
- Endereços em conhecimento (CC)
- Operador associado (se existir)

---

## Respostas

Cada ticket pode ter várias respostas associadas.

Funcionalidades:

- Texto formatado
- Upload de anexos
- Inserção de imagens

### Notificações

Cada resposta envia notificações para:

- Criador do ticket
- Contactos em conhecimento

---

## Gestão e Visualização

O sistema permite uma gestão eficiente através de filtros e pesquisa.

### Filtros disponíveis

- Inbox
- Estado
- Operador
- Tipo
- Entidade

### Pesquisa rápida

É possível pesquisar por:

- Nº do ticket
- Assunto
- Email
- Entidade

---

## Histórico

Cada ticket possui um **histórico completo de atividade**, incluindo:

- Mensagens enviadas
- Alterações de estado
- Mudanças de operador
- Registos de atividade

---

# 4. Notificações

O sistema inclui um módulo de **notificações por email** com templates configuráveis.

Estas notificações informam os utilizadores sobre:

- Criação de tickets
- Novas respostas
- Alterações de estado
- Atribuição de operador

---

# 5. Referências Visuais

A interface do sistema inspira-se no seguinte sistema de gestão de suporte:

**Kirridesk - Customer Service Management System**

---


# Autor

André Cainda
