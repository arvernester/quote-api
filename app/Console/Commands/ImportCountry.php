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
        $response = Request::get($url = 'https://restcountries.eu/rest/v2/all');

        if ($response->code == 200) {
            DB::transaction(function () use ($response) {
                $now = Carbon::now();

                $countries = [];
                foreach ($response->body as $country) {
                    $countryModel = Country::create([
                        'code' => $country->alpha3Code,
                        'name' => $country->name,
                        'native_name' => $country->nativeName,
                        'flag' => $country->flag,
                    ]);

                    foreach ($country->languages as $language) {
                        $lang = Language::firstOrNew(['code' => $language->iso639_2]);
                        $lang->country_id = $countryModel->id;
                        $lang->name = $language->name;
                        $lang->native_name = $language->nativeName;
                        $lang->save();
                    }
                }
            });
        } else {
            $this->error(sprintf('Failed to request to %s.', $url));
        }
    }
}
