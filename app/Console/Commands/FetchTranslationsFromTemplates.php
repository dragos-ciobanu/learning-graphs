<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class FetchTranslationsFromTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:extract {language=en : Generate fore specific language use two letter codes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tries to extract translatable strings from templates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $language = $this->argument('language');
        $strings = [];
        $oldstrings = [];
        $translationfile = base_Path("resources/lang/{$language}.json");
        if (File::isFile($translationfile)) {
            $oldstrings = json_decode(File::get($translationfile), true);
        };
        $this->info("Extracting to {$translationfile}");
        $search = [
            "__(\"",
            "\")",
            "__( \"",
            "\" )",
            "__('",
            "')",
            "__( '",
            "' )",
            "@trans(\"",
            "@trans( \""
        ];
        $path = base_path('resources/views');
        $strings = [];
        $templates = File::allFiles($path);
        $this->info('Getting templates');
        $bar = $this->output->createProgressBar(count($templates));
        $bar->start();
        File::put(base_Path('resources/lang/generated_en.json'), '');
        foreach ($templates as $key => $template) {
            $bar->advance();
            if ($template->getExtension() == 'php') {
                $content = file_get_contents($template->getPathname());
                preg_match_all('((@trans|__)\((\'|")(.*?)(\'|")\))', $content, $out);
                foreach ($out[0] as $result) {
                    $string = str_replace($search, "", $result);
                    $strings[$string] = $string;
                }
            }
        }
        $bar->finish();
        $this->info("\n Extracting and writing strings to file");
        $result = array_merge($strings, $oldstrings);
        File::put($translationfile, json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->info("\n Done!");
    }
}
