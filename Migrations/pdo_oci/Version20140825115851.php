<?php

namespace Claroline\CoreBundle\Migrations\pdo_oci;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/08/25 11:58:53
 */
class Version20140825115851 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE claro_content2type 
            ADD (
                collapse NUMBER(1) NOT NULL
            )
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE claro_content2type 
            DROP (collapse)
        ");
    }
}