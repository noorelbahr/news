<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CategorySubmitRequest;
use App\Http\Resources\Api\V1\CategoryResource;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * CategoryController constructor.
     * - - -
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return CategoryResource::collection(
            $this->categoryRepository->getPaginated($request->limit)
        );
    }

    /**
     * @param $id
     * @return CategoryResource
     */
    public function show($id)
    {
        return new CategoryResource(
            $this->categoryRepository->findOrFail($id)
        );
    }

    /**
     * @param CategorySubmitRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorySubmitRequest $request)
    {
        $this->categoryRepository->create(
            $request->name,
            Str::slug($request->name),
            Auth::id()
        );

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findOrFail($id);
        $category->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
