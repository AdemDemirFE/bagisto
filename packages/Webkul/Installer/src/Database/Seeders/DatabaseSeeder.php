<?php

namespace Webkul\Installer\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webkul\Installer\Database\Seeders\Attribute\DatabaseSeeder as AttributeSeeder;
use Webkul\Installer\Database\Seeders\Category\DatabaseSeeder as CategorySeeder;
use Webkul\Installer\Database\Seeders\CMS\DatabaseSeeder as CMSSeeder;
use Webkul\Installer\Database\Seeders\Core\DatabaseSeeder as CoreSeeder;
use Webkul\Installer\Database\Seeders\Customer\DatabaseSeeder as CustomerSeeder;
use Webkul\Installer\Database\Seeders\Inventory\DatabaseSeeder as InventorySeeder;
use Webkul\Installer\Database\Seeders\RMA\DatabaseSeeder as RMASeeder;
use Webkul\Installer\Database\Seeders\Shop\SectionTableSeeder as ShopSeeder;
use Webkul\Installer\Database\Seeders\SocialLogin\DatabaseSeeder as SocialLoginSeeder;
use Webkul\Installer\Database\Seeders\User\DatabaseSeeder as UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @param  array  $parameters
     * @return void
     */
    public function run($parameters = [])
    {
        $this->syncSequences();

        $this->call(AttributeSeeder::class, false, ['parameters' => $parameters]);

        $this->syncSequences();

        $this->call(CategorySeeder::class, false, ['parameters' => $parameters]);

        $this->syncSequences();

        $this->call(InventorySeeder::class, false, ['parameters' => $parameters]);

        $this->syncSequences();

        $this->call(CoreSeeder::class, false, ['parameters' => $parameters]);

        $this->syncSequences();

        $this->call(CustomerSeeder::class, false, ['parameters' => $parameters]);

        $this->syncSequences();

        $this->call(CMSSeeder::class, false, ['parameters' => $parameters]);

        $this->syncSequences();

        $this->call(SocialLoginSeeder::class, false, ['parameters' => $parameters]);

        $this->syncSequences();

        $this->call(ShopSeeder::class, false, ['parameters' => $parameters]);

        $this->syncSequences();

        $this->call(UserSeeder::class, false, ['parameters' => $parameters]);

        $this->syncSequences();

        $this->call(RMASeeder::class, false, ['parameters' => $parameters]);
    }

    /**
     * Sync PostgreSQL sequences with the current maximum id of each table.
     *
     * MySQL auto-increments on explicit id inserts, PostgreSQL does not. This
     * aligns the sequences so follow-up inserts that rely on auto-increment
     * do not hit unique constraint violations.
     *
     * @return void
     */
    private function syncSequences(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $sequences = DB::select("
            SELECT
                c.relname AS table_name,
                n.nspname AS schema_name,
                s.relname AS sequence_name
            FROM pg_class AS c
            JOIN pg_namespace AS n ON n.oid = c.relnamespace
            JOIN pg_depend AS d ON d.refobjid = c.oid AND d.refclassid = 'pg_class'::regclass
            JOIN pg_class AS s ON s.oid = d.objid AND s.relkind = 'S'
            JOIN pg_depend AS dd ON dd.objid = s.oid AND dd.classid = 'pg_class'::regclass
            JOIN pg_attribute AS a ON a.attrelid = c.oid AND a.attnum = dd.refobjsubid
            WHERE c.relkind = 'r'
                AND c.relname <> 'schema_migrations'
                AND s.relname LIKE '%_id_seq%'
        ");

        foreach ($sequences as $sequence) {
            $maxId = DB::selectOne(
                'SELECT COALESCE(MAX(id), 0) AS max_id FROM "'.$sequence->table_name.'"'
            );

            if (! $maxId) {
                continue;
            }

            DB::statement('SELECT setval(?, ?)', [
                '"'.$sequence->schema_name.'"."'.$sequence->sequence_name.'"',
                (int) $maxId->max_id + 1,
            ]);
        }
    }
}
