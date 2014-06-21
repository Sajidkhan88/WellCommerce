<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Core\DependencyInjection\Schema;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Dumper
 *
 * @package WellCommerce\Core\DependencyInjection\Schema
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Dumper
{
    private $containerBuilder;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    private function getAllColumns()
    {
        $connection = $this->containerBuilder->get('database_manager')->connection();

        $sql = $this->compileColumnExists();

        $database = $connection->getDatabaseName();

        $results = $connection->select($sql, [$database]);

        $schema = [];
        foreach ($results as $result) {
            $schema[$result['table_name']][] = $result['column_name'];
        }

        return $schema;
    }

    /**
     * Returns SQL statement to execute on database to fetch column and table info
     *
     * @return string
     */
    private function compileColumnExists()
    {
        return "select table_name, column_name from information_schema.columns where table_schema = ?";
    }

    private function generateColumns()
    {
        $allColumns = $this->getAllColumns();

        $columns = "[\n";
        foreach ($allColumns as $table => $info) {
            $columns .= sprintf("        '%s' => ['%s'],\n", $table, implode('\',\'', $info));
        }
        $columns .= '    ]';

        return $columns;
    }

    public function dump(array $options = [])
    {
        return <<<EOF
<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace {$options['namespace']};

/**
 * Class {$options['class']}
 *
 * This helper class was auto-generated. Please do not remove it.
 *
 * @package WellCommerce\Core\Helper
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class {$options['class']}
{
    private static \$columns  = {$this->generateColumns()};

    public static function getColumns(\$table)
    {
        if(!isset(self::\$columns[\$table])){
            throw new \InvalidArgumentException(sprintf('Table %s does not exists in schema information', \$table));
        }

        return self::\$columns[\$table];
    }

}

EOF;
    }
} 