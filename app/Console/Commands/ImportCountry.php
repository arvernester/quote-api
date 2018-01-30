<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Unirest\Request;
use App\Country;
use Carbon\Carbon;
use App\Language;
use Illuminate\Support\Facades\DB;

class ImportCountry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import country data from restcountry.eu';

    /**
     * Create a new command instance.
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
        $this->line('Importing data...');

        $response = Request::get($url = 'https://restcountries.eu/rest/v2/all');

        if ($response->code == 200) {
            DB::transaction(function () use ($response) {
                $now = Carbon::now();

                $bar = $this->output->createProgressBar(count($response->body));

                $countries = [];
                foreach ($response->body as $country) {
                    $countryModel = Country::firstOrNew([
                        'code' => $country->alpha3Code,
                    ]);

                    $countryModel->code = $country->alpha3Code;
                    $countryModel->name = $country->name;
                    $countryModel->native_name = $country->nativeName;
                    $countryModel->save();

                    foreach ($country->languages as $language) {
                        $lang = Language::firstOrNew(['code' => $language->iso639_2]);
                        $lang->country_id = $countryModel->id;
                        $lang->code_alternate = $language->iso639_1;
                        $lang->name = $language->name;
                        $lang->native_name = $language->nativeName;
                        $lang->save();

                        $bar->advance();
                    }
                }

                $bar->finish();
            });
        } else {
            $this->error(sprintf('Failed to request to %s.', $url));
        }
    }
}
