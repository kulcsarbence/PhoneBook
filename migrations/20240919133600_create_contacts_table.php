<?php

use Phinx\Migration\AbstractMigration;

final class CreateContactsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('contacts');
        $table->addColumn('first_name', 'string', ['limit' => 100])
            ->addColumn('last_name', 'string', ['limit' => 100])
            ->addColumn('phone', 'string', ['limit' => 20])
            ->addColumn('email', 'string', ['limit' => 100])
            ->create();
    }
}