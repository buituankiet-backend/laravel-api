<?php

namespace App\Helpers\Routes;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class RouteHelper
{
    public  static function includeRouteFiles($folder): void{
        //loop dir in file

        //get path
        $dirIterator = new RecursiveDirectoryIterator($folder);
        /** @var RecursiveDirectoryIterator | RecursiveIteratorIterator $it */
        $it = new RecursiveIteratorIterator($dirIterator);

        //loop dir in file
        while ($it->valid()) {
            if (!$it->isDot()
                && $it->isFile()
                && $it->isReadable()
                && $it->current()->getExtension() === 'php')
            {
                require $it->key();
//                require $it->current()->getPathname();
            }
            $it->next();
        }
    }
}
