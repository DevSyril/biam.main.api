<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRepositoryPattern extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Here we define make:repository-pattern as the command name,
     * with a required {name} argument and an optional --subfolder (short -s) flag.
     *
     * @var string
     */
    protected $signature = 'make:repository-pattern {name} {--s|subfolder=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate interface, repository, and provider for a model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = $this->argument('name');           // e.g. "TemplateField"
        $subfolder = $this->option('subfolder');         // e.g. "Admin" or null

        $modelClass = "App\\Models\\{$modelName}";

        // Vérifie si la classe du modèle existe
        if (!class_exists($modelClass)) {

            $this->warn("⚠  The model [{$modelClass}] does not exist.");

            // Demande confirmation à l'utilisateur
            if ($this->confirm("Would you like to create the model {$modelName} now?")) {

                // Liste des options disponibles pour make:model
                $availableOptions = [
                    '--migration' => 'Create a new migration file for the model',
                    '--controller' => 'Create a new controller for the model',
                    '--factory' => 'Create a new factory for the model',
                    '--policy' => 'Create a new policy for the model',
                    '--seed' => 'Create a new seeder for the model',
                    '--resource' => 'Indicate if the generated controller should be a resource controller',
                    '--pivot' => 'Indicate if the model should be a custom intermediate table model',
                    '--all' => 'Generate migration, seeder, factory, and controller',
                ];

                $this->info("\nSelect the options you want for the model creation:");

                // Sélection multiple interactive
                $selectedOptions = $this->choice(
                    'Choose the options (you can select multiple separated by comma):',
                    array_values($availableOptions),
                    null,
                    null,
                    true // permet multi-sélection
                );

                // Mapper les labels sélectionnés vers leurs clés Artisan
                $options = [];
                foreach ($availableOptions as $flag => $description) {
                    if (in_array($description, $selectedOptions)) {
                        $options[$flag] = true;
                    }
                }

                // Exécution de la commande make:model
                $this->call('make:model', array_merge([
                    'name' => "Models/{$modelName}",
                ], $options));

                $this->info("✅ Model {$modelName} successfully created!");
            } else {
                $this->warn("Skipping model creation...");
            }
        } else {
            $this->info("✅ Model {$modelName} already exists.");
        }

        // Ici tu pourras ensuite continuer avec la création des repositories/interfaces/providers
        $this->info("Continuing repository pattern generation...");

        $base = app_path();
        $subPath = $subfolder ? "/{$subfolder}" : '';

        // Directoties paths
        $interfaceDir = "{$base}/Interfaces{$subPath}";
        $repositoryDir = "{$base}/Repositories{$subPath}";
        $providerDir = "{$base}/Providers{$subPath}";

        // File paths
        $interfaceFile = "{$interfaceDir}/{$modelName}Interface.php";
        $repositoryFile = "{$repositoryDir}/{$modelName}Repository.php";
        $providerFile = "{$providerDir}/{$modelName}ServiceProvider.php";

        if (!is_dir($interfaceDir))
            mkdir($interfaceDir, 0755, true);
        if (!is_dir($repositoryDir))
            mkdir($repositoryDir, 0755, true);
        if (!is_dir($providerDir))
            mkdir($providerDir, 0755, true);


        //--------------------INTERFACES--------------------//

        $interfaceNamespace = 'App\\Interfaces' . ($subfolder ? "\\{$subfolder}" : "");
        $interfaceContent = "<?php

namespace {$interfaceNamespace};

interface {$modelName}Interface
{
    public function index(\$items = 10);
    public function store(array \$data);
    public function show(string \$id);
    public function update(string \$id, array \$data);
    public function destroy(string \$id);
}
        ";
        file_put_contents($interfaceFile, $interfaceContent);
        $this->info("Created interface: {$interfaceFile}");

        //--------------------REPOSITORY--------------------//

        $repositoryDir = "{$repositoryDir}/{$modelName}Repository.php";
        if (!file_exists($repositoryDir)) {
            $namespace = "App\\Repositories" . ($subfolder ? "\\{$subfolder}" : "");
            $ifaceNS = "App\\Interfaces" . ($subfolder ? "\\{$subfolder}" : "");
            $content = "<?php

namespace {$namespace};

use {$ifaceNS}\\{$modelName}Interface;
use App\\Models\\{$modelName};

class {$modelName}Repository implements {$modelName}Interface
{
    public function index(\$items = 10)
    {
        return {$modelName}::paginate(\$items);
    }

    public function store(array \$data)
    {
        return {$modelName}::create(\$data);
    }

    public function show(string \$id)
    {
        return {$modelName}::findOrFail(\$id);
    }

    public function update(string \$id, array \$data)
    {
        \$item = {$modelName}::findOrFail(\$id);
        \$item->update(\$data);
        return \$item;
    }

    public function destroy(string \$id)
    {
        \$item = {$modelName}::findOrFail(\$id);
        return \$item->delete();
    }
}";
            file_put_contents($repositoryFile, $content);
            $this->info("Created repository: {$repositoryFile}");
        }

        //--------------------REPOSITORY--------------------//

        $providerDir = "{$providerDir}/{$modelName}ServiceProvider.php";
        if (!file_exists($providerDir)) {
            $namespace = "App\\Providers" . ($subfolder ? "\\{$subfolder}" : "");
            $content = "<?php

namespace {$namespace};

use App\\Interfaces" . ($subfolder ? "\\{$subfolder}" : "") . "\\{$modelName}Interface;
use App\\Repositories" . ($subfolder ? "\\{$subfolder}" : "") . "\\{$modelName}Repository;
use Illuminate\\Support\\ServiceProvider;

class {$modelName}ServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        \$this->app->bind({$modelName}Interface::class, {$modelName}Repository::class);
    }

    public function boot(): void
    {
        // 
    }
}";
            file_put_contents($providerFile, $content);
            $this->info("Created provider: {$providerFile}");
        }
    }
}