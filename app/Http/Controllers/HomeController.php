<?php

namespace App\Http\Controllers;

use App\Services\StatisticService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

    /**
     * @var StatisticService
     */
    private $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    public function home(): View
    {
        $data = 'home';
        $regions = $this->statisticService->regions()->all();
        return View('home', ['data' => $data, 'regions' => $regions]);
    }

    public function searchData(Request $request): View
    {
        $data = $this->statisticService->search($request);
        $regions = $this->statisticService->regions();
        return View('home', ['data' => $data, 'regions' => $regions]);
    }

    public function update(): View
    {
        $this->statisticService->update();
        return View('update');
    }

}
