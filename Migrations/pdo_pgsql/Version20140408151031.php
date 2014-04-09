<?php

namespace Claroline\CoreBundle\Migrations\pdo_pgsql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/04/08 03:10:32
 */
class Version20140408151031 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE claro_admin_tools (
                id SERIAL NOT NULL, 
                name VARCHAR(255) NOT NULL, 
                class VARCHAR(255) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_C10C14EC5E237E06 ON claro_admin_tools (name)
        ");
        $this->addSql("
            CREATE TABLE claro_admin_tool_role (
                tool_id INT NOT NULL, 
                role_id INT NOT NULL, 
                PRIMARY KEY(tool_id, role_id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_940800698F7B22CC ON claro_admin_tool_role (tool_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_94080069D60322AC ON claro_admin_tool_role (role_id)
        ");
        $this->addSql("
            ALTER TABLE claro_admin_tool_role 
            ADD CONSTRAINT FK_940800698F7B22CC FOREIGN KEY (tool_id) 
            REFERENCES claro_admin_tools (id) 
            ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
        $this->addSql("
            ALTER TABLE claro_admin_tool_role 
            ADD CONSTRAINT FK_94080069D60322AC FOREIGN KEY (role_id) 
            REFERENCES claro_role (id) 
            ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE claro_admin_tool_role 
            DROP CONSTRAINT FK_940800698F7B22CC
        ");
        $this->addSql("
            DROP TABLE claro_admin_tools
        ");
        $this->addSql("
            DROP TABLE claro_admin_tool_role
        ");
    }
}