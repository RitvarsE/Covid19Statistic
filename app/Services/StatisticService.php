<?php


namespace App\Services;


use App\Models\Regions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class StatisticService
{
    public function search(Request $request): ?Regions
    {
        $region = $request->get('region');
        return Regions::where('region_name', $region)->orderBy('data_id', 'desc')->first();
    }

    public function regions(): Collection
    {
        return Regions::all()->unique('region_name');
    }

    //to update statistic use artisan console command: statistic:update
    public function update()
    {
        if (Regions::all()->isEmpty()) {
            $offset = 0;
        } else {
            $offset = Regions::orderBy('data_id', 'desc')->first()->data_id;
        }
        $content = 'https://data.gov.lv/dati/lv/api/3/action/datastore_search?resource_id=492931dd-0012-46d7-b415-76fe0ec7c216&offset=' . $offset;
        $allData = json_decode(file_get_contents($content), true)['result'];

        while (count($allData['records']) > 0) {
            $content = 'https://data.gov.lv/dati/lv/api/3/action/datastore_search?resource_id=492931dd-0012-46d7-b415-76fe0ec7c216&offset=' . $offset;
            $allData = json_decode(file_get_contents($content), true)['result'];
            $offset += 100;
            echo $offset;
            foreach ($allData['records'] as $data) {
                if ($data['AktivaCOVID19infekcija'] === '…' || $data['AktivaCOVID19infekcija'] === '...') {
                    $data['AktivaCOVID19infekcija'] = 0;
                }
                if ($data['AktivaCOVID19infekcija'] === 'no 1 līdz 5') {
                    $data['AktivaCOVID19infekcija'] = 3;
                }
                if ($data['14DienuKumulativaSaslimstiba'] === '...' || $data['14DienuKumulativaSaslimstiba'] === '…') {
                    $data['14DienuKumulativaSaslimstiba'] = 0;
                }
                if ($data['14DienuKumulativaSaslimstiba'] === 'no 1 līdz 5') {
                    $data['14DienuKumulativaSaslimstiba'] = 3;
                }
                if ($data['ApstiprinataCOVID19infekcija'] === '…' || $data['ApstiprinataCOVID19infekcija'] === '...') {
                    $data['ApstiprinataCOVID19infekcija'] = 0;
                }
                if ($data['ApstiprinataCOVID19infekcija'] === 'no 1 līdz 5') {
                    $data['ApstiprinataCOVID19infekcija'] = 3;
                }
                if ($data['ATVK'] !== 'Nav') {
                    Regions::updateOrCreate(
                        ['data_id' => $data["_id"]],
                        ['region_name' => $data["AdministrativiTeritorialasVienibasNosaukums"],
                            'ATVK' => $data['ATVK'],
                            'confirmed_infection' => $data["ApstiprinataCOVID19infekcija"],
                            'active_infection' => $data["AktivaCOVID19infekcija"],
                            '14_day_cumulative' => $data["14DienuKumulativaSaslimstiba"],
                            'registration_date' => $data["Datums"]]
                    );
                }

            }
        }
    }
}
