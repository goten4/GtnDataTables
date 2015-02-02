<?php
namespace GtnDataTablesTest;

use Zend\Loader\AutoloaderFactory;

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{
    public static function init()
    {
        error_reporting(E_ALL | E_STRICT);

        static::initAutoloader();
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (file_exists($vendorPath . '/autoload.php')) {
            include $vendorPath . '/autoload.php';
        }

        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    'GtnDataTables' => dirname(dirname(__DIR__)) . '/src/GtnDataTables',
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

Bootstrap::init();
