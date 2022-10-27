<?php

namespace MagedAhmad\Insular\Generators;

use Exception;
use MagedAhmad\Insular\Helpers\Str;

class TypeGenerator extends Generator
{
    /**
     * @throws Exception
     */
    public function generate(string $name, string $module): bool
    {
        $name = Str::type($name);
        $module = Str::module($module);

        $path = $this->findTypePath($module, $name);

        if (file_exists($path)) {
            return false;
        }

        $namespace = $this->findTypeNamespace($module);

        $content = file_get_contents($this->getStub());
        $content = str_replace(
             ['{{type}}', '{{namespace}}'],
             [$name, $namespace],
             $content
         );

        $this->createFile($path, $content);

        return true;
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/type.stub';
    }
}
