<?php

namespace App\Module\Manager\Controllers;

use App\Http\Controllers\Controller;
use App\Module\Manager\Api\PlanRepositoryInterface;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * @var PlanRepositoryInterface
     */
    protected $repository;

    /**
     * PlanController constructor.
     * @param PlanRepositoryInterface $repository
     */
    public function __construct(PlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View
     */
    public function index()
    {
        $plans = $this->repository->getAll();

        return view('manager::plan_list', ['plans' => $plans]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     */
    public function createOrUpdate(Request $request, $id = '')
    {
        if ($id) {
            $plan = $this->repository->getById($id);
        } else {
            $plan = $this->repository->create();
        }
        if ($posts = $request->post()) {
            $plan->name = $posts['name'];
            $plan->price = $posts['price'];
            $plan->max_staff = $posts['max_staff'];
            $plan->trial_days = $posts['trial_days'];
            $this->repository->save($plan);

            return redirect()->route('manager_plan_list');
        }
        return view('manager::plan_create', ['plan' => $plan]);
    }

    /**
     * @param integer $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->repository->delete($this->repository->getById($id));

        return redirect()->route('manager_plan_list');
    }
}