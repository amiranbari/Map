<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Lang;
use Spatie\Permission\Models\Permission;

class PermissionSync extends Command
{
    protected $signature = 'sync:permissions';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        foreach ($this->getRoutes() as $route)
            if(!Permission::whereName("{$route->methods[0]}-/$route->uri")->first())
            {
                $displayName = "";
                $array = explode('/', $route->uri);
                //delete Method name - we dont need it in translating
                unset($array[0]);
                //get Method name translation
                $displayName .= $this->getMethodName($route->methods[0]);
                foreach (array_reverse($array) as $word){

                    //if it was a block word continue
                    if ($this->checkBlockWords($word))
                        continue;

                    //if it was a special word then break the loop
                    if ($this->checkSpecialWords($word)){
                        $displayName .= $this->displayName(cleanString($word));
                        break;
                    }

                    $displayName .= $this->displayName($word);
                }
                Permission::create([
                    'name'          =>  "{$route->methods[0]}-/$route->uri",
                    'guard_name'    => 'web',
                    'display_name'  =>  $displayName
                ]);
            }

        $this->comment("All permissions are synced by routes");
    }

    private function getMethodName(string $method) {
        return (Lang::has("routes.methods.$method") ? Lang::get("routes.methods.$method") : '(-)') . ' ';
    }

    private function checkSpecialWords(string $word) {
        return containInString($word, Lang::get('routes.specials'));
    }

    private function checkBlockWords(string $word) {
        return in_array($word, Lang::get('routes.blocked'));
    }

    private function displayName(string $word) {
        return (Lang::has("routes.accepted.{$word}") ? Lang::get("routes.accepted.{$word}") : '(-)') . ' ';
    }

    private function getRoutes()
    {

        $routes = [];
        foreach (Route::getRoutes() as $route)
            if(startsWith($route->uri, "panel") && !(in_array($route->uri, Lang::get('routes.blocked'))))
                $routes[] = $route;
        return $routes;
    }
}
