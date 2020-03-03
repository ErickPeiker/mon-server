<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20181211182520 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $states = include 'Resources/States.php';
        $cities = include 'Resources/Cities.php';

        $this->addSql("INSERT INTO Country (id, name) VALUES ('585d1fa6-fce7-4ce0-ba1c-b83fb0bf7616', 'Brasil')");

        foreach ($states as $state) {
            $this->addSql($state);
        }

        foreach ($cities as $city) {
            $this->addSql($city);
        }

        /*
         * Company
         */
        $this->addSql("INSERT INTO Person (id, createdAt, updatedAt, deletedAt, type) VALUES ('8160f516-9b0b-4f22-9643-922441a7d5a3', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, 'LEGAL_PERSON')");
        $this->addSql("INSERT INTO LegalPerson (id, name, cnpj, ie) VALUES ('8160f516-9b0b-4f22-9643-922441a7d5a3', 'Owlmo', '55946955000128', '800217772')");
        $this->addSql("INSERT INTO Company (id, type, createdAt, updatedAt, deletedAt, legalPersonId) VALUES ('c88d4129-4763-47f5-9010-a734e19ea7da', 'COMPANY_MASTER', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, '8160f516-9b0b-4f22-9643-922441a7d5a3')");

        /*
         * Dashboard
         */
        $this->addSql("INSERT INTO Dashboard (id, name, createdAt, updatedAt, deletedAt, userId, companyId) VALUES ('85ea224c-549c-40fe-91fd-28baecf00c38', 'Dashboard', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, NULL, 'c88d4129-4763-47f5-9010-a734e19ea7da')");

        /*
         * Admin User
         */
        $this->addSql("INSERT INTO Person (id, createdAt, updatedAt, deletedAt, type) VALUES ('f4cfe7cf-72b1-4585-8b18-cec7cd9341cb', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, 'PHYSICAL_PERSON')");
        $this->addSql("INSERT INTO PhysicalPerson (id, name, cpf, rg, birthdate, gender, maritalStatus) VALUES ('f4cfe7cf-72b1-4585-8b18-cec7cd9341cb', 'Admin Owlmo', '71931175721', '588786527', '1981-09-28', 'MASCULINO', 'SOLTEIRO')");
        $this->addSql("INSERT INTO `User` (id, email, password, apiToken, roles, createdAt, updatedAt, deletedAt, physicalPersonId, companyId, dashboardId) VALUES ('e3d6dc00-638a-432f-bc4a-7b9e75727780', 'admin@owlmo.com.br', '$2y$13\$tuXyoWFQD.zG0qkppqYFyeDe.q9DMjTOzL/KQUcaG9PTn4uNn/gZ.', NULL, '[\"ROLE_ADMIN\"]', '2018-12-11 18:25:00', '2019-05-08 12:39:23.909688', NULL, 'f4cfe7cf-72b1-4585-8b18-cec7cd9341cb', 'c88d4129-4763-47f5-9010-a734e19ea7da', '85ea224c-549c-40fe-91fd-28baecf00c38')");
        $this->addSql("INSERT INTO UserCompany (userId, companyId) VALUES ('e3d6dc00-638a-432f-bc4a-7b9e75727780', 'c88d4129-4763-47f5-9010-a734e19ea7da')");

        /*
         * Items
         */
        $this->addSql("INSERT INTO EquipmentType (id, name, slug, createdAt, updatedAt, deletedAt) VALUES ('099a6e6e-e604-46d0-8208-83c3c971300d', 'Borda', 'borda', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO ItemType (id, name, slug, valueType, createdAt, updatedAt, deletedAt, equipmentTypeId) VALUES ('691c4399-ce06-4189-9133-c5455a0ec1c1', 'Portas', 'flow_portBytes', 'VALUE_INTEGER', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, '099a6e6e-e604-46d0-8208-83c3c971300d')");
        $this->addSql("INSERT INTO ItemType (id, name, slug, valueType, createdAt, updatedAt, deletedAt, equipmentTypeId) VALUES ('80cf31d6-77b8-404d-be03-2aff2fbf4334', 'Protocolos', 'flow_protocolBytes', 'VALUE_INTEGER', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, '099a6e6e-e604-46d0-8208-83c3c971300d')");
        $this->addSql("INSERT INTO ItemType (id, name, slug, valueType, createdAt, updatedAt, deletedAt, equipmentTypeId) VALUES ('e5419d6a-6ce7-4c83-9a85-331bfc3fab86', 'Origem', 'flow_inBytes', 'VALUE_INTEGER', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, '099a6e6e-e604-46d0-8208-83c3c971300d')");
        $this->addSql("INSERT INTO ItemType (id, name, slug, valueType, createdAt, updatedAt, deletedAt, equipmentTypeId) VALUES ('ac702049-d082-4738-8efb-6593dc7c8b3d', 'Destino', 'flow_outBytes', 'VALUE_INTEGER', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, '099a6e6e-e604-46d0-8208-83c3c971300d')");
        //$this->addSql("INSERT INTO ItemType (id, name, slug, valueType, createdAt, updatedAt, deletedAt, equipmentTypeId) VALUES ('7e955b73-1ea1-497e-a669-ce1952935b29', 'ASN em bytes', 'flow_asnBytes', 'VALUE_INTEGER', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, '099a6e6e-e604-46d0-8208-83c3c971300d')");

        /*
         * Routes
         */
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('064ac47e-6820-44f6-b2f8-56b7892f74a3', 'Alterar empresa', 'Altera a empresa atual do usuário', 'user-switch-company', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('f17ce05f-e89f-473f-9d57-40dd3a1038f5', 'Dashboard - Buscar', 'Buscar um único dashboard (usado para edição)', 'dashboard-show', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('bed92ebf-1384-48dd-bf8a-412c06897c10', 'Dashboard - Deletar', 'Deletar dashboard', 'dashboard-delete', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('6a7d56ed-c8af-4582-a594-39669853464e', 'Dashboard - Editar', 'Editar dashboard', 'dashboard-edit', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('b14ab211-f06b-47d2-b791-32cb77843e18', 'Dashboard - Listar', 'Listar todos os dashboards', 'dashboard-list', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('3c062b43-9466-4ec6-bc6d-07957cdb9be0', 'Dashboard - Novo', 'Criar dashboard', 'dashboard-new', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('8040b37d-5bbd-40cb-ba10-0ac62eeeab6b', 'Empresa - Buscar', 'Buscar uma única empresa (usado para edição)', 'company-show', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('04439f13-7500-498b-bd68-f25caeb73fee', 'Empresa - Deletar', 'Deletar empresa', 'company-delete', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('205a17f1-e675-43ff-bf2f-3272347601ef', 'Empresa - Editar', 'Editar empresa', 'company-edit', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('d1e1e5b2-25cf-43fc-9587-8df370290148', 'Empresa - Listar', 'Listar todas as empresa', 'company-list', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('a3a0eac3-20b0-4896-8b10-57ccac3bac3f', 'Empresa - Novo', 'Criar empresa', 'company-new', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('f503505a-53fe-4cf0-9884-457e9a55e7df', 'Equipamento - Buscar', 'Buscar um único equipamento (usado para edição)', 'equipment-show', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('a15a9ba1-25bb-48ef-9ef2-0a808109358b', 'Equipamento - Deletar', 'Deletar equipamento', 'equipment-delete', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('def6ceba-e13c-4dd8-9ef2-f0949ff924ba', 'Equipamento - Editar', 'Editar equipamento', 'equipment-edit', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('d050d029-f756-4b21-a699-459fcfa61752', 'Equipamento - Listar', 'Listar todos os equipamentos', 'equipment-list', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('e111fb60-7ea9-4257-950f-5bc7ec79cbf3', 'Grupo - Buscar', 'Buscar um único grupo (usado para edição)', 'group-show', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('1cbab40f-34b9-4da1-8f19-4e2bb5bb91b5', 'Grupo - Deletar', 'Deletar grupo', 'group-delete', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('bb48b589-e018-412c-b2ce-1368d79be125', 'Grupo - Editar', 'Editar grupo', 'group-edit', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('a95316ba-c4b0-4e26-9939-04446871fa81', 'Grupo - Listar', 'Listar todos os grupos', 'group-list', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('3831c54c-a3c9-4fd4-a636-cb3bafef5d6a', 'Grupo - Novo', 'Criar grupo', 'group-new', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('962fcfd0-d933-46b8-8702-5a8cd9935a83', 'Incidente - Listar', 'Listar todos os incidentes', 'incident-list', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('47b74b30-c781-4cd8-b201-601d5f103087', 'Incidente - Novo', 'Cria incidente', 'incident-new', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('fdfd9dd7-3ae9-4713-a576-db8ad0017fc7', 'Tipo de Item', 'Lista todos os tipos de itens', 'item-type-list', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('81294ec8-ef89-4b4d-bebf-4ddb549d46ab', 'Tipo de item - Items', 'Lista os items do tipo de item', 'item-type-item', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('c0ca8e32-e3d6-4435-ba23-08d4fc94a61c', 'Menu - Listar', 'Listar todos os menus (utilizado na tela de grupo)', 'menu-list', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('b896fc87-0f27-4dac-b179-13c701eb4bff', 'Rota - Listar', 'Listar todas as rotas (utilizado na tela de grupo)', 'route-list', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('e0a945ff-658c-4b29-9608-c158db9160f4', 'Usuário - Buscar', 'Buscar um único usuário (usado para edição)', 'user-show', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('cef5c60b-77b5-45e6-815f-2a0e93a872de', 'Usuário - Deletar', 'Deletar usuário', 'user-delete', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('2455d255-e353-4554-a9b4-d559baab1b7e', 'Usuário - Editar', 'Editar usuário', 'user-edit', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('9bc21be9-ce9f-423f-9867-502eb301764b', 'Usuário - Listar', 'Listar todos os usuários', 'user-list', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('aa1cdc12-e043-428e-a5a1-a3746095f855', 'Usuário - Novo', 'Criar usuário', 'user-new', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('0965b12f-e6ac-457e-af5e-23a0445d14bb', 'Widget - Buscar', 'Buscar um único widget (usado para edição)', 'widget-show', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('55c54fb3-4252-43bb-bc87-548010c3e9a2', 'Widget - Deletar', 'Deletar widget', 'widget-delete', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('fff9df5d-0c3a-45d5-a57a-bb74e58fb5a8', 'Widget - Editar', 'Editar widget', 'widget-edit', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('be4ed521-6820-4c67-a1a3-a17e469d48a5', 'Widget - Listar', 'Listar todos os widgets', 'widget-list', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('b730f836-e488-4c9e-bf79-d8277d0eb4e3', 'Widget - Novo', 'Criar widget', 'widget-new', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('211b2391-92c7-43b1-9708-36f8bb21e7e6', 'Widget - Dados de Gráfico', 'Buscar os dados de gráfico', 'widget-chart-data', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('20dd6aad-e091-49f7-9600-eb34c759265c', 'Relatório - Sintético', 'Gerar relatório sintético', 'report-synthetic', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");
        $this->addSql("INSERT INTO Route (id, name, description, path, createdAt, updatedAt, deletedAt) VALUES ('7e88d11f-e032-4c31-b3f7-515eaddbea01', 'Relatório - Analítico', 'Gerar relatório analítico', 'report-analytic', '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL)");

        /*
         * Menus
         */
        $this->addSql("INSERT INTO Menu (id, name, description, path, icon, sequence, createdAt, updatedAt, deletedAt, menuId) VALUES ('7fbe83a5-5469-4177-9a36-266cd805b102', 'Cadastros', 'Menus de cadastros', NULL, 'file-document', 3, '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, NULL)");
        $this->addSql("INSERT INTO Menu (id, name, description, path, icon, sequence, createdAt, updatedAt, deletedAt, menuId) VALUES ('acee8c65-e893-45fa-9b45-a1efcfe59cda', 'Dashboard', 'Tela inicial do sistema', '/dashboard', 'home', 1, '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, NULL)");
        $this->addSql("INSERT INTO Menu (id, name, description, path, icon, sequence, createdAt, updatedAt, deletedAt, menuId) VALUES ('9e3885d2-6cc6-4471-af22-be38d2757866', 'Permissões', 'Menus de permissões', NULL, 'account-multiple', 4, '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, NULL)");
        $this->addSql("INSERT INTO Menu (id, name, description, path, icon, sequence, createdAt, updatedAt, deletedAt, menuId) VALUES ('3102b192-edfa-483c-8f51-9036f3e82848', 'Empresas', 'Tela de Empresas', '/company', NULL, 1, '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, '7fbe83a5-5469-4177-9a36-266cd805b102')");
        $this->addSql("INSERT INTO Menu (id, name, description, path, icon, sequence, createdAt, updatedAt, deletedAt, menuId) VALUES ('bcfc6299-dee5-4972-8ef1-c040936bef98', 'Equipamentos', 'Tela de Equipamentos', '/equipment', NULL, 4, '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, '7fbe83a5-5469-4177-9a36-266cd805b102')");
        $this->addSql("INSERT INTO Menu (id, name, description, path, icon, sequence, createdAt, updatedAt, deletedAt, menuId) VALUES ('459f0062-5cb6-4236-91a6-1d7682598ff9', 'Grupos', 'Tela de Grupos', '/group', NULL, 1, '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, '9e3885d2-6cc6-4471-af22-be38d2757866')");
        $this->addSql("INSERT INTO Menu (id, name, description, path, icon, sequence, createdAt, updatedAt, deletedAt, menuId) VALUES ('aaa7c8f2-2541-40b0-8b9a-9e2c52e909ab', 'Usuários', 'Tela de Usuários', '/user', NULL, 2, '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, '9e3885d2-6cc6-4471-af22-be38d2757866')");
        $this->addSql("INSERT INTO Menu (id, name, description, path, icon, sequence, createdAt, updatedAt, deletedAt, menuId) VALUES ('f01593da-155a-405d-9e25-07a4d135503f', 'Relatórios', 'Tela de Relatórios', '/report', 'format-list-bulleted', 1, '2018-12-11 18:25:00', '2018-12-11 18:25:00', NULL, NULL)");
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        /*
         * Menus
         */
        $this->addSql("DELETE FROM Menu WHERE id='f01593da-155a-405d-9e25-07a4d135503f'");
        $this->addSql("DELETE FROM Menu WHERE id='aaa7c8f2-2541-40b0-8b9a-9e2c52e909ab'");
        $this->addSql("DELETE FROM Menu WHERE id='459f0062-5cb6-4236-91a6-1d7682598ff9'");
        $this->addSql("DELETE FROM Menu WHERE id='bcfc6299-dee5-4972-8ef1-c040936bef98'");
        $this->addSql("DELETE FROM Menu WHERE id='3102b192-edfa-483c-8f51-9036f3e82848'");
        $this->addSql("DELETE FROM Menu WHERE id='9e3885d2-6cc6-4471-af22-be38d2757866'");
        $this->addSql("DELETE FROM Menu WHERE id='acee8c65-e893-45fa-9b45-a1efcfe59cda'");
        $this->addSql("DELETE FROM Menu WHERE id='7fbe83a5-5469-4177-9a36-266cd805b102'");

        /*
         * Routes
         */
        $this->addSql("DELETE FROM Route WHERE id='7e88d11f-e032-4c31-b3f7-515eaddbea01'");
        $this->addSql("DELETE FROM Route WHERE id='20dd6aad-e091-49f7-9600-eb34c759265c'");
        $this->addSql("DELETE FROM Route WHERE id='211b2391-92c7-43b1-9708-36f8bb21e7e6'");
        $this->addSql("DELETE FROM Route WHERE id='b730f836-e488-4c9e-bf79-d8277d0eb4e3'");
        $this->addSql("DELETE FROM Route WHERE id='be4ed521-6820-4c67-a1a3-a17e469d48a5'");
        $this->addSql("DELETE FROM Route WHERE id='fff9df5d-0c3a-45d5-a57a-bb74e58fb5a8'");
        $this->addSql("DELETE FROM Route WHERE id='55c54fb3-4252-43bb-bc87-548010c3e9a2'");
        $this->addSql("DELETE FROM Route WHERE id='0965b12f-e6ac-457e-af5e-23a0445d14bb'");
        $this->addSql("DELETE FROM Route WHERE id='aa1cdc12-e043-428e-a5a1-a3746095f855'");
        $this->addSql("DELETE FROM Route WHERE id='9bc21be9-ce9f-423f-9867-502eb301764b'");
        $this->addSql("DELETE FROM Route WHERE id='2455d255-e353-4554-a9b4-d559baab1b7e'");
        $this->addSql("DELETE FROM Route WHERE id='cef5c60b-77b5-45e6-815f-2a0e93a872de'");
        $this->addSql("DELETE FROM Route WHERE id='e0a945ff-658c-4b29-9608-c158db9160f4'");
        $this->addSql("DELETE FROM Route WHERE id='b896fc87-0f27-4dac-b179-13c701eb4bff'");
        $this->addSql("DELETE FROM Route WHERE id='c0ca8e32-e3d6-4435-ba23-08d4fc94a61c'");
        $this->addSql("DELETE FROM Route WHERE id='81294ec8-ef89-4b4d-bebf-4ddb549d46ab'");
        $this->addSql("DELETE FROM Route WHERE id='fdfd9dd7-3ae9-4713-a576-db8ad0017fc7'");
        $this->addSql("DELETE FROM Route WHERE id='47b74b30-c781-4cd8-b201-601d5f103087'");
        $this->addSql("DELETE FROM Route WHERE id='962fcfd0-d933-46b8-8702-5a8cd9935a83'");
        $this->addSql("DELETE FROM Route WHERE id='3831c54c-a3c9-4fd4-a636-cb3bafef5d6a'");
        $this->addSql("DELETE FROM Route WHERE id='a95316ba-c4b0-4e26-9939-04446871fa81'");
        $this->addSql("DELETE FROM Route WHERE id='bb48b589-e018-412c-b2ce-1368d79be125'");
        $this->addSql("DELETE FROM Route WHERE id='1cbab40f-34b9-4da1-8f19-4e2bb5bb91b5'");
        $this->addSql("DELETE FROM Route WHERE id='e111fb60-7ea9-4257-950f-5bc7ec79cbf3'");
        $this->addSql("DELETE FROM Route WHERE id='d050d029-f756-4b21-a699-459fcfa61752'");
        $this->addSql("DELETE FROM Route WHERE id='def6ceba-e13c-4dd8-9ef2-f0949ff924ba'");
        $this->addSql("DELETE FROM Route WHERE id='a15a9ba1-25bb-48ef-9ef2-0a808109358b'");
        $this->addSql("DELETE FROM Route WHERE id='f503505a-53fe-4cf0-9884-457e9a55e7df'");
        $this->addSql("DELETE FROM Route WHERE id='a3a0eac3-20b0-4896-8b10-57ccac3bac3f'");
        $this->addSql("DELETE FROM Route WHERE id='d1e1e5b2-25cf-43fc-9587-8df370290148'");
        $this->addSql("DELETE FROM Route WHERE id='205a17f1-e675-43ff-bf2f-3272347601ef'");
        $this->addSql("DELETE FROM Route WHERE id='04439f13-7500-498b-bd68-f25caeb73fee'");
        $this->addSql("DELETE FROM Route WHERE id='8040b37d-5bbd-40cb-ba10-0ac62eeeab6b'");
        $this->addSql("DELETE FROM Route WHERE id='3c062b43-9466-4ec6-bc6d-07957cdb9be0'");
        $this->addSql("DELETE FROM Route WHERE id='b14ab211-f06b-47d2-b791-32cb77843e18'");
        $this->addSql("DELETE FROM Route WHERE id='6a7d56ed-c8af-4582-a594-39669853464e'");
        $this->addSql("DELETE FROM Route WHERE id='bed92ebf-1384-48dd-bf8a-412c06897c10'");
        $this->addSql("DELETE FROM Route WHERE id='f17ce05f-e89f-473f-9d57-40dd3a1038f5'");
        $this->addSql("DELETE FROM Route WHERE id='064ac47e-6820-44f6-b2f8-56b7892f74a3'");

        /*
         * Items
         */
        $this->addSql("DELETE FROM ItemType WHERE id='7e955b73-1ea1-497e-a669-ce1952935b29'");
        $this->addSql("DELETE FROM ItemType WHERE id='ac702049-d082-4738-8efb-6593dc7c8b3d'");
        $this->addSql("DELETE FROM ItemType WHERE id='e5419d6a-6ce7-4c83-9a85-331bfc3fab86'");
        $this->addSql("DELETE FROM ItemType WHERE id='80cf31d6-77b8-404d-be03-2aff2fbf4334'");
        $this->addSql("DELETE FROM ItemType WHERE id='691c4399-ce06-4189-9133-c5455a0ec1c1'");
        $this->addSql("DELETE FROM EquipmentType WHERE id='099a6e6e-e604-46d0-8208-83c3c971300d'");

        /*
         * Admin User
         */
        $this->addSql("DELETE FROM UserCompany WHERE userId='e3d6dc00-638a-432f-bc4a-7b9e75727780' AND companyId='c88d4129-4763-47f5-9010-a734e19ea7da'");
        $this->addSql("DELETE FROM [User] WHERE id='e3d6dc00-638a-432f-bc4a-7b9e75727780'");
        $this->addSql("DELETE FROM PhysicalPerson WHERE id='f4cfe7cf-72b1-4585-8b18-cec7cd9341cb'");
        $this->addSql("DELETE FROM Person WHERE id='f4cfe7cf-72b1-4585-8b18-cec7cd9341cb'");

        /*
         * Dashboard
         */
        $this->addSql("DELETE FROM Dashboard WHERE id='85ea224c-549c-40fe-91fd-28baecf00c38'");

        /*
         * Company
         */
        $this->addSql("DELETE FROM Company WHERE id='c88d4129-4763-47f5-9010-a734e19ea7da'");
        $this->addSql("DELETE FROM LegalPerson WHERE id='8160f516-9b0b-4f22-9643-922441a7d5a3'");
        $this->addSql("DELETE FROM Person WHERE id='8160f516-9b0b-4f22-9643-922441a7d5a3'");
    }
}
