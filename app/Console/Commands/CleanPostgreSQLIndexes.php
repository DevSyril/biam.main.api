<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class CleanPostgreSQLIndexes extends Command
{
    protected $signature = 'db:clean-indexes';
    protected $description = 'Clean problematic PostgreSQL indexes before migration generation';

    public function handle()
    {
        $this->info('Cleaning PostgreSQL indexes...');
        
        try {
            // Trouver les index avec des colonnes vides
            $problematicIndexes = DB::select("
                SELECT 
                    indexname,
                    tablename,
                    indexdef
                FROM pg_indexes 
                WHERE schemaname = 'public'
                AND indexdef ~ 'USING.*\\(\\s*\\)'
            ");
            
            foreach ($problematicIndexes as $index) {
                $this->warn("Dropping problematic index: {$index->indexname}");
                DB::statement("DROP INDEX IF EXISTS {$index->indexname}");
            }
            
            // Nettoyer les statistiques
            DB::statement('ANALYZE');
            
            $this->info('Index cleanup completed!');
            
        } catch (\Exception $e) {
            $this->error('Error during cleanup: ' . $e->getMessage());
        }
    }
}
