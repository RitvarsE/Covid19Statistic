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
        return View('home',['data' => $data]);
    }

    public function searchData(Request $request): View
    {
        $data = $this->statisticService->search($request);
        return View('home', ['data' => $data]);
    }
    public function update(): View
    {
        $this->statisticService->update();
        return View('update');
    }

}
